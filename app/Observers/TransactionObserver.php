<?php

namespace App\Observers;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;

class TransactionObserver
{
    /**
     * Handle the transaction "created" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        if($transaction->user_id) {
            $user = User::findOrFail($transaction->user_id);
            $credit = Transaction::ofUser($transaction->user_id)->balance()->paid()->sum('amount');
            $user->credit = $credit;
            $user->save();
        }

        if($transaction->account_id) {
            $account = Account::findOrFail($transaction->account_id);
            $balance = Transaction::ofAccount($transaction->account_id)->paid()->sum('amount');
            $balance = $account->initial_balance + $balance;
            $account->balance = $balance;
            $account->save();
        }

        return true;
    }

    /**
     * Handle the transaction "updated" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function updated(Transaction $transaction)
    {
        if($transaction->user_id) {
            $user = User::findOrFail($transaction->user_id);
            $credit = Transaction::ofUser($transaction->user_id)->balance()->paid()->sum('amount');
            $user->credit = $credit;
            $user->save();
        }

        if($transaction->account_id) {
            $account = Account::findOrFail($transaction->account_id);
            $balance = Transaction::ofAccount($transaction->account_id)->paid()->sum('amount');
            $balance = $account->initial_balance + $balance;
            $account->balance = $balance;
            $account->save();
        }

        return true;
    }

    /**
     * Handle the transaction "deleted" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function deleted(Transaction $transaction)
    {
        if($transaction->user_id) {
            $user = User::findOrFail($transaction->user_id);
            $credit = Transaction::ofUser($transaction->user_id)->balance()->paid()->sum('amount');
            $user->credit = $credit;
            $user->save();
        }

        if($transaction->account_id) {
            $account = Account::findOrFail($transaction->account_id);
            $balance = Transaction::ofAccount($transaction->account_id)->paid()->sum('amount');
            $balance = $account->initial_balance + $balance;
            $account->balance = $balance;
            $account->save();
        }

        return true;
    }

    /**
     * Handle the transaction "restored" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function restored(Transaction $transaction)
    {
        if($transaction->user_id) {
            $user = User::findOrFail($transaction->user_id);
            $credit = Transaction::ofUser($transaction->user_id)->balance()->paid()->sum('amount');
            $user->credit = $credit;
            $user->save();
        }

        if($transaction->account_id) {
            $account = Account::findOrFail($transaction->account_id);
            $balance = Transaction::ofAccount($transaction->account_id)->paid()->sum('amount');
            $balance = $account->initial_balance + $balance;
            $account->balance = $balance;
            $account->save();
        }

        return true;
    }

    /**
     * Handle the transaction "force deleted" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function forceDeleted(Transaction $transaction)
    {

        if($transaction->user_id) {
            $user = User::findOrFail($transaction->user_id);
            $credit = Transaction::ofUser($transaction->user_id)->balance()->paid()->sum('amount');
            $user->credit = $credit;
            $user->save();
        }

        if($transaction->account_id) {
            $account = Account::findOrFail($transaction->account_id);
            $balance = Transaction::ofAccount($transaction->account_id)->paid()->sum('amount');
            $balance = $account->initial_balance + $balance;
            $account->balance = $balance;
            $account->save();
        }


        return true;
    }
}
