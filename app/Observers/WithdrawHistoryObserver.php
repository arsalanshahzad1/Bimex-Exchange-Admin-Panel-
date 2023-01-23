<?php

namespace App\Observers;

use App\User;
use App\Jobs\MailSend;
use App\Model\WithdrawHistory;
use App\Http\Services\MyCommonService;

class WithdrawHistoryObserver
{
    /**
     * Handle the WithdrawHistory "created" event.
     *
     * @param  \App\WithdrawHistory  $withdrawHistory
     * @return void
     */
    public function created(WithdrawHistory $withdrawHistory): void
    {
        //ADDRESS_TYPE_INTERNAL
        //ADDRESS_TYPE_EXTERNAL
        try{
            $user = User::findOrFail($withdrawHistory->user_id);
            $title = __("Withdraw request");
            $body = '';
            if ($withdrawHistory->status == STATUS_ACCEPTED) {
                $body = __("Your withdraw is successfully processed. \nWithdrawal transaction hash is $withdrawHistory->transaction_hash.");
            }
            if ($withdrawHistory->status == STATUS_PENDING) {
                $body = __("Your withdraw is successfully processed.\nThis withdraw is on admin review. So, wait for admin approval.
                    \nWithdrawal transaction hash is $withdrawHistory->transaction_hash.");
            }
            $this->sendEmailAndNotification($title, $body, $user);
        }catch(\Exception $e){
            storeException('WithdrawHistoryObserver created err',$e->getMessage());
        }
    }

    /**
     * Handle the WithdrawHistory "updated" event.
     *
     * @param  \App\WithdrawHistory  $withdrawHistory
     * @return void
     */
    public function updated(WithdrawHistory $withdrawHistory)
    {
        $user = User::findOrFail($withdrawHistory->user_id);
        if($withdrawHistory->isDirty('status')){
            $status = $withdrawHistory->status; 
            $old_status = $withdrawHistory->getOriginal('status');
            $title = __("Withdraw request");
            if($old_status == STATUS_PENDING && $status == STATUS_ACCEPTED){
                $body =  __("Your withdrawal request is approved by ADMIN. \nWithdrawal transaction hash is $withdrawHistory->transaction_hash.");
                $this->sendEmailAndNotification($title, $body, $user);
            }

            if($status == STATUS_REJECTED){
                $body =  __("Your withdrawal request is reject by ADMIN. \nWithdrawal transaction hash is $withdrawHistory->transaction_hash.");
                $this->sendEmailAndNotification($title, $body, $user);
            }
            
        }
    }

    /**
     * Handle the WithdrawHistory "deleted" event.
     *
     * @param  \App\WithdrawHistory  $withdrawHistory
     * @return void
     */
    public function deleted(WithdrawHistory $withdrawHistory)
    {
        //
    }

    /**
     * Handle the WithdrawHistory "restored" event.
     *
     * @param  \App\WithdrawHistory  $withdrawHistory
     * @return void
     */
    public function restored(WithdrawHistory $withdrawHistory)
    {
        //
    }

    /**
     * Handle the WithdrawHistory "force deleted" event.
     *
     * @param  \App\WithdrawHistory  $withdrawHistory
     * @return void
     */
    public function forceDeleted(WithdrawHistory $withdrawHistory)
    {
        //
    }

    private function sendEmailAndNotification($title, $message, $user)
    {
        (new MyCommonService())->sendNotificationToUserUsingSocket(
            $user->id,
            $title,
            $message
        );
        $emailData = [
            'to' => $user->email,
            'name' => $user->first_name.' '.$user->last_name,
            'subject' => $title,
            'email_header' => $title,
            'email_message' => $message,
            'mailTemplate' => 'email.genericemail'
        ];
        dispatch(new MailSend($emailData))->onQueue('send-mail');
    }
}
