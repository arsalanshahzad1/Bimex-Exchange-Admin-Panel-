<?php

namespace App\Observers;

use App\User;
use App\Model\Wallet;
use App\Jobs\MailSend;
use App\Http\Services\MyCommonService;
use App\Model\DepositeTransaction;

class DepositeTransactionObserver
{
    /**
     * Handle the DepositeTransaction "created" event.
     *
     * @param  \App\DepositeTransaction  $depositeTransaction
     * @return void
     */
    public function created(DepositeTransaction $depositeTransaction): void
    {
        try {
            //$sernderWallet = Wallet::whereUserId($depositeTransaction->sender_wallet_id)->first();
            //$sender = User::findOrFail($sernderWallet->user_id ?? 0);
            $recivererWallet = Wallet::whereId($depositeTransaction->receiver_wallet_id)->first();
            $receiver = User::findOrFail($recivererWallet->user_id ?? 0);
            $title = __("New Deposit");
            $body = __("You recived $depositeTransaction->amount $depositeTransaction->coin_type deposit. \n
            From address : $depositeTransaction->from_address \n
            Deposit transaction id : $depositeTransaction->transaction_id.");
            $this->sendEmailAndNotification($title, $body, $receiver);
        } catch (\Exception $e) {
            storeException('DepositeTransactionObserver err', $e->getMessage());
        }
    }

    /**
     * Handle the DepositeTransaction "updated" event.
     *
     * @param  \App\DepositeTransaction  $depositeTransaction
     * @return void
     */
    public function updated(DepositeTransaction $depositeTransaction)
    {
        //
    }

    /**
     * Handle the DepositeTransaction "deleted" event.
     *
     * @param  \App\DepositeTransaction  $depositeTransaction
     * @return void
     */
    public function deleted(DepositeTransaction $depositeTransaction)
    {
        //
    }

    /**
     * Handle the DepositeTransaction "restored" event.
     *
     * @param  \App\DepositeTransaction  $depositeTransaction
     * @return void
     */
    public function restored(DepositeTransaction $depositeTransaction)
    {
        //
    }

    /**
     * Handle the DepositeTransaction "force deleted" event.
     *
     * @param  \App\DepositeTransaction  $depositeTransaction
     * @return void
     */
    public function forceDeleted(DepositeTransaction $depositeTransaction)
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
