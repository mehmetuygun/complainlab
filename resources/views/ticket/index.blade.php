@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Ticket</div>
            <div class="panel-body">
                @include('alert/alert')
                <a href="{{ url('/ticket/create') }}" class="btn btn-default">Create a New Ticket</a>
                </br>
                </br>
                <table class="table table-bordered" style="margin-bottom: 0">
                    <th>#</th>
                    <th>Subject</th>
                    <th>Created by</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>Action</th>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td><a href="/ticket/{{ $ticket->id }}">{{ $ticket->subject }}</a> </td>
                            <td>{{ $ticket->user->first_name }} {{ $ticket->user->last_name }}</td>
                            <td>{{ $ticket->status->name }}</td>
                            <td>{{ $ticket->priority->name }}</td>
                            <td>{{ $ticket->created_at }}</td>
                            <td>{{ $ticket->updated_at }}</td>
                            <td>
                                <a href="{{ url('ticket').'/'.$ticket->id.'/edit' }}" class="btn btn-default btn-sm" role="button">Edit</a>
                            </td>
                        </tr>
                    @endforeach 
                </table>
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

