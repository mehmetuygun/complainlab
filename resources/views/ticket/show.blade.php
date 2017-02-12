@extends('layouts.app')

@section('content')
{{ csrf_field() }}
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

    @foreach ($ticket->replies as $reply)
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-user" aria-hidden="true"></i>
                <strong>{{ $reply->ticket->user->first_name .' '. $reply->ticket->user->last_name }}</strong>
                <i class="fa fa-clock-o" aria-hidden="true"></i>
                {{ $reply->created_at }}
            </div>        
            <div class="panel-body">
                {!! $reply->description !!}
            </div>
        </div>
    @endforeach

    <div id="replied"></div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-user" aria-hidden="true"></i>
            <strong>{{ Auth::user()->first_name .' '. Auth::user()->last_name }}</strong>
        </div>        
        <div class="panel-body" id="reply_body">
            <textarea class="form-control" id="enter_to_reply" placeholder="Enter to reply." rows="1"></textarea>
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
  	<script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $( "#enter_to_reply" ).click(function() {
            tinymce.init({ selector:'textarea', menubar:false, themes: "modern" });
            var buttons = '<div class="buttons-reply">';
            buttons += '<button class="btn btn-primary btn-sm" id="reply" type="button">Reply</button>';
            buttons += '<button class="btn btn-default btn-sm" id="reply_cancel" type="button">Cancel</button>';
            buttons += '</div>';
            $( "#reply_body" ).append(buttons);
        });
        
        $(document).on('click', '#reply', function() {
            alert("test");
            $.ajax({
                method: "POST",
                url: "/reply",
                data: { description: tinyMCE.activeEditor.getContent(), ticket_id: {{ $ticket->id }} }
            })
            .done(function( data ) {
                var html = '<div class="panel panel-default">';
                html += '<div class="panel-heading">';
                html += '<i class="fa fa-user" aria-hidden="true"></i> ';
                html += '<strong>'+data.full_name+'</strong> ';
                html += '<i class="fa fa-clock-o" aria-hidden="true"></i> ';
                html += data.created_at.date;
                html += '</div>';        
                html += '<div class="panel-body">';
                html += data.description;
                html += '</div>';
                html += '</div>';
                $( "#replied" ).append(html);

                cancelReply();
            });
        });

        $(document).on('click', '#reply_cancel', function() {
            cancelReply();
        });

        function cancelReply()
        {
            tinyMCE.remove();
            $( "#enter_to_reply" ).val('');
            $( ".buttons-reply" ).remove();
        }
    </script>
@endsection