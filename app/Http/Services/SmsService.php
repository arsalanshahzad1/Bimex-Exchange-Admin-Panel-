<?php
namespace App\Http\Services;

use Aloha\Twilio\Twilio;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected $twilio;

    public function __construct()
    {
        $sid = "AC1d25b63f9d2cda9ffb894e24b1cbd495";
        $token = "c9afdbd458c28c338875f2fc4c60e374";
        $from = "+13613016204";

        $this->twilio = new Twilio($sid, $token, $from);
    }

    public function send($number, $message)
    {
        try {
            $this->twilio->message($number, $message);
        } catch (\Exception $e) {
            Log::info('sms send problem -- '.$e);
            return false;
        }

        return true;
    }
}
