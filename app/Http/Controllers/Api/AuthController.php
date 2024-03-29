<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EmailVerifyRequest;
use App\Http\Requests\Api\ForgotPasswordRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Http\Requests\Api\ResendVerificationEmailCodeRequest;
use App\Http\Requests\Api\SignUpRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Services\AuthService;
use App\Http\Services\Binance\BrokerService;
use App\Http\Services\Logger;
use App\Http\Services\MyCommonService;
use App\Http\Services\User2FAService;
use App\Http\Services\UserService;
use App\Model\UserVerificationCode;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use PharIo\Version\Exception;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\RateLimiter;
use League\Uri\Http;

class AuthController extends Controller
{
    public $service;
    public $myCommonService;
    public $logger;
    public $user_service;
    public function __construct()
    {
        $this->service = new AuthService;
        $this->myCommonService = new MyCommonService;
        $this->logger = new Logger();
        $this->user_service = new UserService();
    }
    // sign up api
    public function signUp(SignUpRequest $request)
    {
        try {
            if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
                $response = ['success' => false, 'message' => __('Invalid email address'), 'data' =>(object)[]];
                return response()->json($response);
            }

            // $brokerService = new BrokerService();

            // $subAccountData = $brokerService->createSubAccount();
            // $apiKeyData = $brokerService->createSubAccountApiKey([
            //     "subAccountId" => $subAccountData['subaccountId'],
            //     "canTrade" => true
            // ]);

            // $request['sub_account_id'] = $subAccountData['subaccountId'];
            // $request['broker_email'] = $subAccountData['email'];
            // $request['api_key'] = $apiKeyData['apiKey'];
            // $request['secret_key'] = $apiKeyData['secretKey'];

            $request['sub_account_id'] = 'test';
            $request['broker_email'] = 'test@gmail.com';
            $request['api_key'] = 'test';
            $request['secret_key'] = 'test';

            $result = $this->service->signUpProcess($request);
            return response()->json($result);
        } catch (\Exception $e) {
            $this->logger->log('signUp', $e->getMessage());
            $response = ['success' => false, 'message' => $e->getMessage(), 'data' =>(object)[]];
            return response()->json($response);
        }
    }
    public function googleAuth(Request $req){
        try {
            $data['success'] = false;
            $data['message'] = '';
            $data['user'] = (object)[];
            $url = 'https://www.googleapis.com/oauth2/v3/userinfo?access_token='.$req->access_token;
            $json = file_get_contents($url); //,FALSE,$ctx);
            $jasondata = json_decode($json, TRUE);
            $google_user = (object)$jasondata;
            $password_start = "Bimex";
            $user = User::where('email', $google_user->email)->first();
            if(!$user){
                $user = new User;
                $user->first_name = $google_user->given_name;
                $user->last_name = $google_user->family_name;
                $user->email = $google_user->email;
                $user->is_verified = STATUS_SUCCESS;
                // $user->is_google = '1';
                $user->password = Hash::make($password_start.$google_user->sub);
                $user->save();
                $data['request_type'] = 'register';
                $data['email'] = $google_user->email;
                $data['message'] = 'User successfully registered.';
                $data['success'] = true;
            }
            else{
                $data['request_type'] = 'login';
                $data['message'] = __('Login successful');
                $data['success'] = true;
                if (Auth::loginUsingId($user->id)) {
                    $token = $user->createToken($user->email)->accessToken;
                    $data['email_verified'] = $user->is_verified;
                    $data['access_token'] = $token;
                    $data['access_type'] = 'Bearer';
                    $data['user'] = User::find($user->id);
                    $data['user']->photo = show_image_path($user->photo,IMG_USER_PATH);
                    if($user->is_verified){
                        if ($user->g2f_enabled == STATUS_ACTIVE) {
                            $data['g2f_enabled'] = $user->g2f_enabled;
                            $data['message'] = __('Please verify two factor authentication to get access ');
                        }
                        createUserActivity(Auth::user()->id, USER_ACTIVITY_LOGIN);
                    }
                    else{
                        $data['success'] = false;
                        $data['message'] = __('Please verify your account.');
                        Auth::logout();
                    }
                }
            }
            return response()->json($data);
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' =>$e->getMessage(), 'data' =>(object)[]];
            return response()->json($response);
        }
    }
    // verify email
    public function verifyEmail(EmailVerifyRequest $request)
    {
        try {
            if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
                $response = ['success' => false, 'message' => __('Invalid email address'), 'data' =>(object)[]];
                return response()->json($response);
            }
            $result = $this->service->verifyEmailProcess($request);
            return response()->json($result);
        } catch (\Exception $e) {
            $this->logger->log('verifyEmail', $e->getMessage());
            $response = ['success' => false, 'message' => __('Something went wrong'), 'data' =>(object)[]];
            return response()->json($response);
        }
    }

    // login process
    public function signIn(LoginRequest $request)
    {
        try {
            $data['success'] = false;
            $data['message'] = '';
            $data['user'] = (object)[];
            $user = User::where('email', $request->email)->first();

            if (!empty($user)) {
                if($user->role == USER_ROLE_USER) {
                    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                        $token = $user->createToken($request->email)->accessToken;
                        //Check email verification
                        if ($user->status == STATUS_SUCCESS) {
                            if (!empty($user->is_verified)) {
                                $data['success'] = true;
                                $data['message'] = __('Login successful');
                                $data['email_verified'] = $user->is_verified;

                                if ($user->g2f_enabled == STATUS_ACTIVE) {
                                    $data['g2f_enabled'] = $user->g2f_enabled;
                                    $data['message'] = __('Please verify two factor authentication to get access ');
                                }
                                if ($user->email_enabled == STATUS_ACTIVE) {
                                    $data['email_enabled'] = $user->email_enabled;
                                    $data['message'] = __('Please verify two factor authentication to get access ');
                                }
                                if ($user->phone_enabled == STATUS_ACTIVE) {
                                    $data['phone_enabled'] = $user->phone_enabled;
                                    $data['message'] = __('Please verify two factor authentication to get access ');
                                }
                                if ($user->g2f_enabled == STATUS_DEACTIVE && $user->email_enabled == STATUS_DEACTIVE && $user->phone_enabled == STATUS_DEACTIVE){
                                    $data['access_token'] = $token;
                                    $data['access_type'] = 'Bearer';
                                }

                                $data['user'] = $user;
                                $data['user']->photo = show_image_path($user->photo,IMG_USER_PATH);
                                createUserActivity(Auth::user()->id, USER_ACTIVITY_LOGIN);

                                return response()->json($data);
                            } else {
                                $existsToken = User::join('user_verification_codes','user_verification_codes.user_id','users.id')
                                    ->where('user_verification_codes.user_id',$user->id)
                                    ->whereDate('user_verification_codes.expired_at' ,'>=', Carbon::now()->format('Y-m-d'))
                                    ->first();
                                if(!empty($existsToken)) {
                                    $mail_key = $existsToken->code;
                                } else {
                                    $mail_key = randomNumber(6);
                                    UserVerificationCode::create(['user_id' => $user->id, 'code' => $mail_key, 'status' => STATUS_PENDING, 'expired_at' => date('Y-m-d', strtotime('+15 days'))]);
                                }
                                try {
                                    $data['email_verified'] = $user->is_verified;
                                    $this->service->sendVerifyemail($user, $mail_key);
                                    $data['success'] = false;
                                    $data['message'] = __('Your email is not verified yet. Please verify your mail.');
                                    Auth::logout();

                                    return response()->json($data);
                                } catch (\Exception $e) {
                                    $data['email_verified'] = $user->is_verified;
                                    $data['success'] = false;
                                    $data['message'] = $e->getMessage();
                                    Auth::logout();

                                    return response()->json($data);
                                }
                            }
                        } elseif ($user->status == STATUS_SUSPENDED) {
                            $data['email_verified'] = $user->is_verified;
                            $data['success'] = false;
                            $data['message'] = __("Your account has been suspended. please contact support team to active again");
                            Auth::logout();
                            return response()->json($data);
                        } elseif ($user->status == STATUS_DELETED) {
                            $data['email_verified'] = $user->is_verified;
                            $data['success'] = false;
                            $data['message'] = __("Your account has been deleted. please contact support team to active again");
                            Auth::logout();
                            return response()->json($data);
                        } elseif ($user->status == STATUS_PENDING) {
                            $data['email_verified'] = $user->is_verified;
                            $data['success'] = false;
                            $data['message'] = __("Your account has been pending for admin approval. please contact support team to active again");
                            Auth::logout();
                            return response()->json($data);
                        }
                    } else {
                        $data['success'] = false;
                        $data['message'] = __("Email or Password doesn't match");
                        return response()->json($data);
                    }
                } else {
                    $data['success'] = false;
                    $data['message'] = __("You have no login access");
                    Auth::logout();
                    return response()->json($data);
                }
            } else {
                $data['success'] = false;
                $data['message'] = __("You have no account,please register new account");
                return response()->json($data);
            }
        } catch (\Exception $e) {
            $this->logger->log('signIn', $e->getMessage());
            $response = ['success' => false, 'message' => __('Something went wrong'), 'data' =>[]];
            return response()->json($response);
        }

    }

    // forgot password
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $response = $this->service->sendForgotMailProcess($request);
            return response()->json($response);
        } catch (\Exception $e) {
            $this->logger->log('forgotPassword', $e->getMessage());
            $response = ['success' => false, 'message' => __('Something went wrong'), 'data' =>(object)[]];
            return response()->json($response);
        }
    }
    public function sendPhoneOtp(Request $request)
    {
        try {
            $user = User::where('email',$request->email)->first();
            $response = $this->user_service->sendPhoneVerificationSms($user);
            return response()->json($response);
        } catch (\Exception $e) {
            $this->logger->log('sendPhoneVerificationSms', $e->getMessage());
            $response = ['success' => false,'message' => __('Something went wrong'), 'data' => ''];
        }
        return response()->json($response);
    }
    public function verifyEmailAndPhone(Request $request)
    {
        $response['success'] = false;
        $response['message'] = __('Invalid Request');
        try {
            if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
                $response = ['success' => false, 'message' => __('Invalid email address'), 'data' =>(object)[]];
                return response()->json($response);
            }
            $user = User::where('email',$request->email)->first();
            $phone_response = $this->user_service->phoneVerifyProcess($request, $user);
            if(!$phone_response['success']){
                return response()->json($phone_response);
            }
            $request->verify_code = $request->email_code;
            $email_response = $this->service->verifyEmailProcess($request);
            if(!$email_response['success']){
                return response()->json($email_response);
            }
            if($phone_response['success'] && $email_response['success']){
                if(Auth::loginUsingId($user->id)){
                $token = $user->createToken($user->email)->accessToken;
                $response['success'] = true;
                $response['access_token'] = $token;
                $response['access_type'] = 'Bearer';
                $response['message'] = 'Two step verification completed.';
                $response['user'] = User::find($user->id);
                $response['user']->photo = show_image_path($user->photo,IMG_USER_PATH);
                createUserActivity(Auth::user()->id, USER_ACTIVITY_LOGIN);
                return response()->json($response);
                }
        }
        } catch (\Exception $e) {
            $this->logger->log('verifyEmailAndPhone', $e->getMessage());
            $response = ['success' => false,'message' => __('Something went wrong'), 'data' => ''];
        }
        return response()->json($response);
    }
    //verfiy email resend code
    public function resendVerifyEmailCode(ResendVerificationEmailCodeRequest $request)
    {
        try{
            $executed = RateLimiter::attempt(
                'send-message:'.$request->ip(),
                $perMinute = 5,
                function(){

                }
            );

            if (! $executed) {

                $response = ['success' => false, 'message' => __('You requested too many times, please wait a minute!')];

            }else{
                $response = $this->service->resendVerifyEmailCode($request);
            }

        }catch (\Exception $e) {
            $this->logger->log('resendVerifyEmailCode', $e->getMessage());
            $response = ['success' => false, 'message' => __('Something went wrong')];
        }

        return response()->json($response);
    }

    // update phone by email

    public function updatePhone(Request $req)
    {
        try {
            $user = User::where('email',$req->email)->first();
            $user->phone = $req->phone;
            $user->save();
            $response = ['success' => true, 'message' => __('Success'), 'data' =>$user];
            return response()->json($response);
        } catch (\Exception $e) {
            $this->logger->log('updatePhone', $e->getMessage());
            $response = ['success' => false, 'message' => __('Something went wrong'), 'data' =>(object)[]];
            return response()->json($response);
        }
    }

    // reset password
    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $response = $this->service->passwordResetProcess($request);
            return response()->json($response);
        } catch (\Exception $e) {
            $this->logger->log('resetPassword', $e->getMessage());
            $response = ['success' => false, 'message' => __('Something went wrong'), 'data' =>(object)[]];
            return response()->json($response);
        }
    }

    // verify g2fa code
    public function g2fVerify(Request $request)
    {
        try {
            $response = $this->service->g2fVerifyProcess($request);
            return response()->json($response);
        } catch (\Exception $e) {
            $this->logger->log('g2fVerify', $e->getMessage());
            $response = ['success' => false, 'message' => __('Something went wrong'), 'data' =>(object)[]];
            return response()->json($response);
        }
    }

    public function twoFactorList(){
        $twoFactor = new User2FAService();
        $response = $twoFactor->twoFactorList(Auth::user());
        return response()->json($response);
    }

    public function twoFactorSave(Request $request){
        try{
            $two_factor = new User2FAService();
            $response = $two_factor->updateTwoFactor($request,Auth('api')->user());
            return response()->json($response);
        }catch (\Exception $e){
            $response = ['success' => false, 'message' => __('Something went wrong'), 'data' =>(object)[]];
            storeException("twoFactorSave : ",$e->getMessage());
            return response()->json($response);
        }
    }

    public function twoFactorGoogleSetup(Request $request){
        try{
            if($request->isMethod("post")){
                $two_factor = new User2FAService();
                $response = $two_factor->g2fSecretSave($request);
                return response()->json($response);
            }
            $google2fa = new Google2FA();
            $google2fa->setAllowInsecureCallToGoogleApis(true);
            $data['google2fa_secret'] = $google2fa->generateSecretKey();
            $default = settings();
            $google2fa_url = $google2fa->getQRCodeGoogleUrl(
                isset($default['app_title']) && !empty($default['app_title']) ? $default['app_title'] : 'Tredexpro',
                isset(Auth::user()->email) && !empty(Auth::user()->email) ? Auth::user()->email : 'admin@email.com',
                $data['google2fa_secret']
            );
            $data['qrcode'] = $google2fa_url;
            return response()->json(["success" => true, "message" => __("Google authentication setup get successfully"), "data" => $data]);
        }catch (\Exception $e){
            storeException("twoFactorSave : ",$e->getMessage());
            return response()->json(["success" => false, "message" => __("Something went wrong"), "data" => []]);
        }
    }

    public function twoFactorSend(Request $request){
        try{
            if (isset($request->type) && !empty($request->type)) {
                $otp = new User2FAService();
                if($request->type == EMAIL_AUTH){
                    if($otp->sendOtpCodeEmail())
                        return response()->json(["success" => true, "message" => __("Email sent successfully"), "data" => []]);
                    else
                        return response()->json(["success" => false, "message" => __("Email send failed"), "data" => []]);
                }else if($request->type == PHONE_AUTH){
                    if($otp->sendOtpCode())
                        return response()->json(["success" => true, "message" => __("SMS sent successfully"), "data" => []]);
                    else
                        return response()->json(["success" => false, "message" => __("SMS send failed"), "data" => []]);
                }else{
                    return response()->json(["success" => false, "message" => __("Type is invalid"), "data" => []]);
                }
            }else{
                return response()->json(["success" => false, "message" => __("Type is required"), "data" => []]);
            }
        }catch (\Exception $e){
            storeException("twoFactorSend : ",$e->getMessage());
            return response()->json(["success" => false, "message" => __("Something went wrong"), "data" => []]);
        }
    }

    public function twoFactorCheck(Request $request){
        try{
            if(!isset($request->code) || empty($request->code))
                return response()->json(["success" => false, "message" => __("Code is required")]);
            if(!isset($request->code_type) || empty($request->code_type))
                return response()->json(["success" => false, "message" => __("Code Type is required")]);

            $two_factor = new User2FAService();
            $response = $two_factor->userOtpVerification($request,Auth::guard('api')->user());
            return response()->json($response);
        }catch (\Exception $e){
            storeException("twoFactorCheck : ",$e->getMessage());
            return response()->json(["success" => false, "message" => __("Something went wrong")]);
        }
    }

    public function logOutApp()
    {
        Session::forget('g2f_checked');
        Session::flush();
        Cookie::queue(Cookie::forget('accesstokenvalue'));
        $user = Auth::user()->token();
        $user->revoke();
        return response()->json(['success' => true, 'data' => [], 'message' => __('Logout successfully!')]);
    }
}
