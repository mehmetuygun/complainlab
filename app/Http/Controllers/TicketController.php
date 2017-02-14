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
        return view('ticket/index', ['tickets' => Ticket::paginate(10)]);
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

        return redirect('app/ticket')
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

        return redirect('app/ticket')
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
        if (Ticket::destroy($id)) {
            return response()->json([
                    'status' => 'success',
                    'id' => $id,
                    'msg' => 'The '.$id.' ticket is deleted.'
                ]);
        }

        return response()->json(['status' => 'error']);
    }

    /**
     * Send ticket list for ajax request
     * @return json array
     */
    public function getDataTable(Request $request)
    {
        $data = array();

        $tickets = Ticket::orderBy('created_at', 'desc')
                            ->skip($request->input('start'))
                            ->take($request->input('length'))
                            ->get();

        foreach ($tickets as $ticket) {
            $data[] = [
                'id' => (string) $ticket->id,
                'subject' => (string) $ticket->subject,
                'created_by' => (string) $ticket->user->first_name.' '.$ticket->user->last_name,
                'status' => (string) $ticket->status->name,
                'priority' => (string) $ticket->priority->name,
                'created_at' => (string) $ticket->created_at,
            ];
        }

        return response()
            ->json([
                "draw" => $request->input('draw'),
                "recordsTotal"=> Ticket::count(),
                "recordsFiltered"=> Ticket::count(),
                'data' => $data
            ]);
    }
}
