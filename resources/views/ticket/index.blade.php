@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Ticket</div>
            <div class="panel-body">
                @include('alert/alert')
                <a href="{{ url('/ticket/create') }}" class="btn btn-primary">Create</a>
                </br>
                </br>
                @foreach ($tickets as $ticket)
                    {{ $ticket->subject }}
                    {{ $ticket->priority->name }}
                    {{ $ticket->status->name }}
                    </br>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

