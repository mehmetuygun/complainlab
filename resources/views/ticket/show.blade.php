@extends('layouts.app')

@section('content')
{{ csrf_field() }}
<div class="container">
<div class="row">
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-user" aria-hidden="true"></i>
                <strong>{{ $ticket->user->first_name .' '. $ticket->user->last_name }}</strong>
                <i class="fa fa-clock-o" aria-hidden="true"></i>
                {{ $ticket->created_at }}
                <div class="btn-group pull-right panel-heading-btn">
                    <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-cog" aria-hidden="true"></i> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="fa fa-edit" aria-hidden="true"></i>  Edit</a></li>
                        <li><a href="#"><i class="fa fa-remove" aria-hidden="true"></i>  Delete</a></li>
                    </ul>
                </div>             
            </div>        
            <div class="panel-body">
                <i class="fa fa-comment-o" aria-hidden="true"></i>
                <span class="ticket-subject">{{ $ticket->subject }}</span>
                <hr>
                {!! $ticket->description !!}
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-user" aria-hidden="true"></i>
                <strong>{{ Auth::user()->first_name .' '. Auth::user()->last_name }}</strong>
            </div>        
            <div class="panel-body" id="reply_body">
                <textarea class="form-control" id="enter_to_reply" placeholder="Enter to reply." rows="1"></textarea>
            </div>
        </div>

        @foreach ($ticket->replies as $reply)
            <div class="panel panel-default">
{{--                 <div class="panel-heading">
                </div>         --}}
                <div class="panel-body">
                    {{-- <i class="fa fa-user" aria-hidden="true"></i> --}}
                    <strong>{{ $reply->ticket->user->first_name .' '. $reply->ticket->user->last_name }}</strong> Replied
{{--                     <i class="fa fa-clock-o" aria-hidden="true"></i>
                    {{ $reply->created_at }} --}}
                    <hr class="reply-hr">
                    {!! $reply->description !!}
                </div>
            </div>
        @endforeach

        <div id="replied"></div>

    </div>
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                Details
            </div>
            <div class="panel-body">


<form class="form-horizontal">
  <div class="form-group">
    <label class="col-sm-4 control-label">Status</label>
    <div class="col-sm-8">
      <p class="form-control-static">
                          @if ($ticket->status->name == 'Open')
                    <span class="label label-success">Open</span>
                @elseif ($ticket->status->name == 'Close')    
                    <span class="label label-d0efault">Close</span>
                @endif
      </p>
    </div>
  </div>  

  <div class="form-group">
    <label class="col-sm-4 control-label">Priority</label>
    <div class="col-sm-8">
      <p class="form-control-static">
                @if ($ticket->priority->name == 'low')
                    <span class="label label-success">Low</span>
                @elseif ($ticket->priority->name == 'Medium')    
                    <span class="label label-default">Medium</span>
                @elseif ($ticket->priority->name == 'High')    
                    <span class="label label-danger">High</span>
                @endif
      </p>
    </div>
  </div>

</form>

            </div>
        </div>
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
        //set csrf-token for every ajax request
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //show reply editor when textbox is clicked
        $( "#enter_to_reply" ).click(function() {
            tinymce.init({ selector:'textarea', menubar:false, themes: "inlite" });
            var buttons = '<div class="buttons-reply">';
            buttons += '<button class="btn btn-default btn-md pull-right" id="reply_cancel" type="button">Cancel</button>';
            buttons += '<button class="btn btn-success btn-md pull-right" id="reply" type="button">Reply</button>';
            buttons += '</div>';
            $( "#reply_body" ).append(buttons);
        });
        
        //add new reply for ticket
        $(document).on('click', '#reply', function() {
            $.ajax({
                method: "POST",
                url: "/app/reply",
                data: { description: tinyMCE.activeEditor.getContent(), ticket_id: {{ $ticket->id }} }
            })
            .done(function( data ) {
                //if reply is added succesfully
                if (data.success) {
                    var html = '<div class="panel panel-info">';
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
                }

            });
        });

        //hide reply editor when cancel is clicked
        $(document).on('click', '#reply_cancel', function() {
            cancelReply();
        });

        //hide reply editor and buttons 
        function cancelReply()
        {
            tinyMCE.remove();
            $( "#enter_to_reply" ).val('');
            $( ".buttons-reply" ).remove();
        }
    </script>
@endsection