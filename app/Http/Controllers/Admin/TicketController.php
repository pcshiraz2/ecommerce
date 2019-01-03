<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $tickets = Ticket::with(['user', 'category'])->orderBy('created_at', 'desc')->paginate(config('platform.file-per-page'));
        return view('admin.ticket.index', ['tickets' => $tickets]);
    }
}
