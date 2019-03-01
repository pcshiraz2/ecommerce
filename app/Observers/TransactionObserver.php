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
            $credit = $user->transactions()->sum('amount');
            $user->credit = $credit;
            $user->save();
        }
        if($transaction->account_id) {
            $account = Account::findOrFail($transaction->account_id);
            $balance = $account->initial_balance + $account->transactions()->sum('amount');
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
            $credit = $user->transactions()->sum('amount');
            $user->credit = $credit;
            $user->save();
        }
        if($transaction->account_id) {
            $account = Account::findOrFail($transaction->account_id);
            $balance = $account->initial_balance + $account->transactions()->sum('amount');
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
            $credit = $user->transactions()->sum('amount');
            $user->credit = $credit;
            $user->save();
        }
        if($transaction->account_id) {
            $account = Account::findOrFail($transaction->account_id);
            $balance = $account->initial_balance + $account->transactions()->sum('amount');
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
            $credit = $user->transactions()->sum('amount');
            $user->credit = $credit;
            $user->save();
        }
        if($transaction->account_id) {
            $account = Account::findOrFail($transaction->account_id);
            $balance = $account->initial_balance + $account->transactions()->sum('amount');
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
            $credit = $user->transactions()->sum('amount');
            $user->credit = $credit;
            return $user->save();
        }
        if($transaction->account_id) {
            $account = Account::findOrFail($transaction->account_id);
            $balance = $account->initial_balance + $account->transactions()->sum('amount');
            $account->balance = $balance;
            return $account->save();
        }
    }
}
