<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\Discussion;
use App\Models\Invoice;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.index');
    }

    public function tickets()
    {
        $tickets = Ticket::where('user_id', Auth::user()->id)->select(['title', 'id'])->limit(5)->orderBy('created_at', 'desc')->get();
        $tickets_array = array();
        $i = 0;
        foreach ($tickets as $ticket) {
            $tickets_array[$i]['title'] = $ticket->title;
            $tickets_array[$i]['id'] = $ticket->id;
            $tickets_array[$i]['url'] = route('ticket.view', [$ticket->id]);
            $i++;
        }
        return response()->json($tickets_array);
    }

    public function discussions()
    {
        $discussions = Discussion::where('user_id', Auth::user()->id)->select(['title', 'id'])->limit(5)->orderBy('created_at', 'desc')->get();
        $discussions_array = array();
        $i = 0;
        foreach ($discussions as $discussion) {
            $discussions_array[$i]['title'] = $discussion->title;
            $discussions_array[$i]['id'] = $discussion->id;
            $discussions_array[$i]['url'] = route('ticket.view', [$discussion->id]);
            $i++;
        }
        return response()->json($discussions_array);
    }

    public function invoices()
    {
        $invoices = Invoice::where('user_id', Auth::user()->id)->select(['total', 'id'])->limit(5)->orderBy('created_at', 'desc')->get();
        $invoices_array = array();
        $i = 0;
        foreach ($invoices as $invoice) {
            $invoices_array[$i]['title'] = "فاکتور شماره:" . $invoice->id . " با مبلغ:" . $invoice->total;
            $invoices_array[$i]['id'] = $invoice->id;
            $invoices_array[$i]['url'] = route('invoice.view', [$invoice->id]);
            $i++;
        }
        return response()->json($invoices_array);
    }

    public function transactions()
    {
        $transactions = Transaction::where('user_id', Auth::user()->id)->select(['amount', 'id'])->limit(5)->orderBy('created_at', 'desc')->get();
        $transactions_array = array();
        $i = 0;
        foreach ($transactions as $transaction) {
            $transactions_array[$i]['title'] = "تراکنش شماره:" . $transaction->id . " با مبلغ:" . $transaction->amount;
            $transactions_array[$i]['id'] = $transaction->id;
            $transactions_array[$i]['url'] = route('transaction.view', [$transaction->id]);
            $i++;
        }
        return response()->json($transactions_array);
    }

    public function tiles()
    {

        $total_of_accounts = Transaction::ofUser(Auth::user()->id)->balance()->sum('amount');
        $num_of_tickets = Ticket::ofUser(Auth::user()->id)->open()->count();
        $num_of_dues = Invoice::OfUser(Auth::user()->id)->due()->where('due_at', '<=', date('Y-m-d') . ' 00:00:00')->count();
        return response()->json([
            'total_of_accounts' => number_format($total_of_accounts) . " تومان",
            'num_of_dues' => number_format($num_of_dues) . " عدد",
            'num_of_tickets' => number_format($num_of_tickets) . " عدد"
        ]);
    }
}
