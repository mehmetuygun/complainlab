@extends('layouts.app')

@section('content')
{{ csrf_field() }}
<div class="container">
<div class="row">
    <div class="col-md-8">
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-user" aria-hidden="true"></i>
                <strong>{{ $ticket->user->first_name .' '. $ticket->user->last_name }}</strong>
                <i class="fa fa-clock-o" aria-hidden="true"></i>
                {{ $ticket->created_at }}

                <div class="btn-toolbar  pull-right" role="toolbar" aria-label="...">
                    <div class="btn-group" role="group" aria-label="...">
                        <button class="btn btn-default btn-sm">Reply</button>
                    </div>
                    <div class="btn-group" role="group" aria-label="...">
                        <div class="dropdown">
                            <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                Action
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </div>
                        
                    </div>
                </div>

            </div>        
            <div class="panel-body">
                <i class="fa fa-comment-o" aria-hidden="true"></i>
                <span class="ticket-subject">{{ $ticket->subject }}</span>
                <hr>
                {!! $ticket->description !!}
            </div>
        </div>

        @foreach ($ticket->replies as $reply)
            <div class="panel panel-info">
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

        <div class="panel panel-info">
            <div class="panel-heading">
                <i class="fa fa-user" aria-hidden="true"></i>
                <strong>{{ Auth::user()->first_name .' '. Auth::user()->last_name }}</strong>
            </div>        
            <div class="panel-body" id="reply_body">
                <textarea class="form-control" id="enter_to_reply" placeholder="Enter to reply." rows="1"></textarea>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                Details
            </div>
            <div class="panel-body">


<form class="form-horizontal">
  <div class="form-group">
    <label class="col-sm-2 control-label">Status</label>
    <div class="col-sm-10">
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
    <label class="col-sm-2 control-label">Priority</label>
    <div class="col-sm-10">
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
            tinymce.init({ selector:'textarea', menubar:false, themes: "modern" });
            var buttons = '<div class="buttons-reply">';
            buttons += '<button class="btn btn-primary btn-sm" id="reply" type="button">Reply</button>';
            buttons += '<button class="btn btn-default btn-sm" id="reply_cancel" type="button">Cancel</button>';
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