<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\Invoice;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;
use App\Models\Category;
use App\Models\Article;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        return view('admin.dashboard.index');
    }

    public function expenses()
    {
        $expense_data = array();
        $expense_label = array();
        $expense_color = array();
        $categories = Category::findType('Expense');
        foreach ($categories as $category) {
            if ($category->getInventory() != 0) {
                $expense_label[] = $category->title;
                $expense_data[] = abs($category->getInventory());
                $expense_color[] = $category->color;
            }
        }
        return response()->json(['expense_data' => $expense_data, 'expense_label' => $expense_label, 'expense_color' => $expense_color]);
    }

    public function incomes()
    {
        $income_data = array();
        $income_label = array();
        $income_color = array();
        $categories = Category::findType('Income');
        foreach ($categories as $category) {
            if ($category->getInventory() != 0) {
                $income_label[] = $category->title;
                $income_data[] = abs($category->getInventory());
                $income_color[] = $category->color;
            }
        }
        return response()->json(['income_data' => $income_data, 'income_label' => $income_label, 'income_color' => $income_color]);
    }

    public function tickets()
    {
        $tickets = Ticket::select(['title', 'id'])->limit(5)->orderBy('created_at', 'desc')->get();
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

    public function news()
    {
        $url = "https://shirazsoft.com/article/json";
        $json = file_get_contents($url);
        $json = json_decode($json);
        return response()->json($json);
    }

    public function tiles()
    {
        $accounts = Account::all();
        $total_of_accounts = 0;
        foreach ($accounts as $account) {
            $total_of_accounts += $account->getInventory();
        }
        $y = jdate('now')->format('Y');
        $m = jdate('now')->format('m');
        $start = CalendarUtils::toGregorian($y, $m, 1);
        if ($m <= 6) {
            $finish = CalendarUtils::toGregorian($y, $m, 31);
        } else if ($m == 12) {
            $finish = CalendarUtils::toGregorian($y, $m, 29);
        } else {
            $finish = CalendarUtils::toGregorian($y, $m, 30);
        }
        $start = $start[0] . '-' . $start[1] . '-' . $start[2] . ' 00:00:00';
        $finish = $finish[0] . '-' . $finish[1] . '-' . $finish[2] . ' 11:59:59';
        $month_income = Transaction::whereBetween('transaction_at', [$start, $finish])->where('amount', '>', 0)->sum('amount');
        $month_expense = Transaction::whereBetween('transaction_at', [$start, $finish])->where('amount', '<', 0)->sum('amount');
        $num_of_dues = 0;
        return response()->json([
            'total_of_accounts' => number_format($total_of_accounts) . " تومان",
            'num_of_dues' => number_format($num_of_dues) . " عدد",
            'month_income' => number_format($month_income) . " تومان",
            'month_expense' => number_format(abs($month_expense)) . " تومان"
        ]);
    }
}
