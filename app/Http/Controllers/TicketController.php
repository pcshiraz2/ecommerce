<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketReplay;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TicketReplied;
use App\Notifications\TicketCreated;


class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {

        if (Auth::user()->level == 'admin') {
            $tickets = Ticket::with(['user', 'category'])->orderBy('created_at', 'desc')->paginate(config('platform.file-per-page'));
        } else {
            $tickets = Ticket::ofUser(Auth::user()->id)->with(['user', 'category'])->orderBy('created_at', 'desc')->paginate(config('platform.file-per-page'));
        }
        return view('ticket.index', ['tickets' => $tickets]);
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        if (Auth::user()->level == 'admin') {
            if ($request->keyword == 'any') {
                $tickets = Ticket::where('title', 'LIKE', '%' . $keyword . '%')->with(['user', 'category'])->orderBy('created_at', 'desc')->paginate(config('platform.file-per-page'));
            } else {
                $tickets = Ticket::OfStatus($request->status)->where('title', 'LIKE', '%' . $keyword . '%')->with(['user', 'category'])->orderBy('created_at', 'desc')->paginate(config('platform.file-per-page'));
            }

        } else {
            if ($request->keyword == 'any') {
                $tickets = Ticket::where('title', 'LIKE', '%' . $keyword . '%')->ofUser(Auth::user()->id)->with(['user', 'category'])->orderBy('created_at', 'desc')->paginate(config('platform.file-per-page'));
            } else {
                $tickets = Ticket::OfStatus($request->status)->where('title', 'LIKE', '%' . $keyword . '%')->ofUser(Auth::user()->id)->with(['user', 'category'])->orderBy('created_at', 'desc')->paginate(config('platform.file-per-page'));
            }
        }
        return view('ticket.search', ['tickets' => $tickets, 'keyword' => $keyword, 'status' => $request->status]);
    }

    public function replay($id, Request $request)
    {

        $request->validate([
            'text' => 'required|string',
        ]);
        $ticket = Ticket::findOrFail($id);
        if (Auth::user()->id != $ticket->user_id && Auth::user()->level != 'admin' && Auth::user()->level != 'staff') {
            abort(404);
        }
        $replay = new TicketReplay();
        $replay->user_id = Auth::user()->id;
        $replay->text = $request->text;
        $replay->ticket_id = $ticket->id;
        $replay->ip = request()->ip();
        $replay->save();


        if (Auth::user()->id == $ticket->user_id) {
            $ticket->status = 'user';
            $user = User::findOrFail(config('platform.main-admin-user-id'));
            try {
                Notification::send($user, new TicketReplied($ticket, $user));
            } catch (\Exception $e) {
            }
        } else {
            $ticket->status = 'staff';
            $user = User::findOrFail($ticket->user_id);
            try {
                Notification::send($user, new TicketReplied($ticket, $user));
            } catch (\Exception $e) {
            }
        }
        $ticket->save();


        flash('پاسخ شما با موفقیت ثبت شد.')->success();
        return redirect()->route('ticket.view', ['id' => $ticket->id]);
    }

    public function create()
    {
        $users = User::all();
        $categories = Category::findType('Ticket');
        return view('ticket.create', ['categories' => $categories, 'users' => $users]);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'title' => 'required|max:191|string',
            'text' => 'required|string',
            'category_id' => 'numeric|required',
        ]);
        $ticket = new Ticket();
        $ticket->category_id = $request->category_id;
        $ticket->priority = $request->priority;
        $ticket->text = $request->text;
        if (Auth::user()->level == 'user') {
            $ticket->user_id = Auth::user()->id;
        } else {
            $ticket->user_id = $request->user_id;
        }
        $ticket->ip = request()->ip();
        $ticket->title = $request->title;
        $ticket->password = uniqid();
        $ticket->save();

        $user = User::findOrFail(config('platform.main-admin-user-id'));
        try {
            Notification::send($user, new TicketCreated($ticket, $user));
        } catch (\Exception $e) {
        }

        flash('تیکت با موفقیت ثبت شد.')->success();
        return redirect()->route('ticket.view', ['id' => $ticket->id]);
    }

    public function view($id)
    {
        $ticket = Ticket::with('user', 'category')->findOrFail($id);

        if (Auth::user()->level == 'admin' || Auth::user()->id == $ticket->user_id) {
            $replays = TicketReplay::with('user')->where('ticket_id', $id)->orderBy('created_at', 'desc')->paginate(config('platform.file-per-page'));
            return view('ticket.view', ['ticket' => $ticket, 'replays' => $replays]);
        } else {
            abort(404);
        }
    }

    public function done($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->status = 'done';
        $ticket->save();
        flash('وضعیت جدید تیکت ثبت شد.')->success();
        return redirect()->route('ticket.view', ['id' => $ticket->id]);
    }

    public function close($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->status = 'close';
        $ticket->save();
        flash('وضعیت جدید تیکت ثبت شد.')->success();
        return redirect()->route('ticket.view', ['id' => $ticket->id]);
    }

    public function waiting($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->status = 'waiting';
        $ticket->save();
        flash('وضعیت جدید تیکت ثبت شد.')->success();
        return redirect()->route('ticket.view', ['id' => $ticket->id]);
    }


    public function lock($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->status = 'lock';
        $ticket->save();
        flash('وضعیت جدید تیکت ثبت شد.')->success();
        return redirect()->route('ticket.view', ['id' => $ticket->id]);
    }

}
