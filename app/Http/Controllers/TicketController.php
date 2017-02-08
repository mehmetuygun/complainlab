<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;
use App\Http\Requests\CreateTicketRequest;
use App\Ticket;
use App\Priority;
use Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ticket/index', ['tickets' => Ticket::paginate(5)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ticket/create', ['statuss' => Status::all(), 'prioritys' => Priority::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTicketRequest $request)
    {
        $ticket = new Ticket();
        $ticket->subject = $request->subject;
        $ticket->description = $request->description;
        $ticket->status_id = $request->status_id;
        $ticket->priority_id = $request->priority_id;
        $ticket->user_id = Auth::user()->id;

        $ticket->save();

        return redirect('ticket')
            ->with('alert_message', 'Your ticket has been created.')
            ->with('alert_type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);

        return view('ticket/show', ['ticket' => $ticket]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);

        return view('ticket/edit', ['ticket' => $ticket, 'statuss' => Status::all(), 'prioritys' => Priority::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateTicketRequest $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->subject = $request->subject;
        $ticket->description = $request->description;
        $ticket->status_id = $request->status_id;
        $ticket->priority_id = $request->priority_id;

        $ticket->save();

        return redirect('ticket')
            ->with('alert_message', 'Your ticket has been updated.')
            ->with('alert_type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
