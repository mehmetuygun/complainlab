@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Ticket</div>
            <div class="panel-body">
                @include('alert/alert')
                <a href="{{ url('/ticket/create') }}" class="btn btn-primary btn-sm">Create</a>
                </br>
                </br>
                <table class="table table-bordered">
                    <th>#</th>
                    <th>Subject</th>
                    <th>Created by</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Created at</th>
                    <th>Action</th>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->subject }}</td>
                            <td>{{ $ticket->user->first_name }} {{ $ticket->user->last_name }}</td>
                            <td>{{ $ticket->status->name }}</td>
                            <td>{{ $ticket->priority->name }}</td>
                            <td>{{ $ticket->created_at }}</td>
                            <td>
                                <a href="{{ url('ticket').'/'.$ticket->id.'/edit' }}" class="btn btn-default" role="button">Edit</a>
                            </td>
                        </tr>
                    @endforeach 
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

