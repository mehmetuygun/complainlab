@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-user" aria-hidden="true"></i>
            <strong>{{ $ticket->user->first_name .' '. $ticket->user->last_name }}</strong>
            <i class="fa fa-clock-o" aria-hidden="true"></i>
            {{ $ticket->created_at }}
            @if ($ticket->status->name == 'Open')
                <span class="label label-success">Open</span>
            @elseif ($ticket->status->name == 'Close')    
                <span class="label label-d0efault">Close</span>
            @endif
        </div>        
        <div class="panel-body">
            <i class="fa fa-comment-o" aria-hidden="true"></i>
            <span class="ticket-subject">{{ $ticket->subject }}</span>
            <hr>
            {!! $ticket->description !!}
        </div>
    </div>
</div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/css/complainlab.css">
@endsection

@section('script')
	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  	<script>tinymce.init({ selector:'textarea', menubar:false });</script>
@endsection