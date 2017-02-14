@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Ticket <small>Edit a ticket</small></div>
            <div class="panel-body">
        		<form class="form-horizontal" role="form" method="POST" action="/app/ticket/{{ $ticket->id }}">
                    <input type="hidden" name="_method" value="PUT">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="id" class="col-md-3 control-label">ID</label>
                        <div class="col-md-6">
                            <p class="form-control-static">{{ $ticket->id }}</p>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                        <label for="subject" class="col-md-3 control-label">Subject</label>

                        <div class="col-md-6">
                            <input id="subject" type="text" class="form-control" name="subject" value="{{ old('subject') ? old('subject') : $ticket->subject }}" required autofocus>

                            @if ($errors->has('subject'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('subject') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description" class="col-md-3 control-label">Description</label>

                        <div class="col-md-6">
                            <textarea id="description" class="form-control" name="description">
                            	{{ old('description') ? old('description') : $ticket->description }}
                            </textarea>

                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group{{ $errors->has('priority_id') ? ' has-error' : '' }}">
                        <label for="priority_id" class="col-md-3 control-label">Priority</label>

                        <div class="col-md-6">
                            {{-- <input id="status" type="text" class="form-control" name="status" value="{{ old('status') ? old('status') : Auth::user()->status }}" required autofocus> --}}

                            <select id="priority_id" class="form-control" name="priority_id">
                            	@foreach ($prioritys as $priority)
                                    @if (old('priority_id') && old('priority_id') == $priority->id)
                                        <option value="{{ $priority->id }}" selected="selected">{{ $priority->name }}</option>
                            		@elseif ($ticket->priority->id == $priority->id)
                                        <option value="{{ $priority->id }}" selected="selected" >{{ $priority->name }}</option>
                                    @else
                                        <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                                    @endif
                            	@endforeach
                            </select>

                            @if ($errors->has('priority_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('priority_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">
                        <label for="status_id" class="col-md-3 control-label">Status</label>

                        <div class="col-md-6">
                            {{-- <input id="status" type="text" class="form-control" name="status" value="{{ old('status') ? old('status') : Auth::user()->status }}" required autofocus> --}}

                            <select id="status_id" class="form-control" name="status_id">
                            	@foreach ($statuss as $status)
                                    @if (old('status_id') && old('status_id') == $status->id)
                                        <option value="{{ $status->id }}" selected="selected">{{ $status->name }}</option>
                                    @elseif ($ticket->status->id == $status->id)
                                        <option value="{{ $status->id }}" selected="selected">{{ $status->name }}</option>
                                    @else
                            		    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endif
                            	@endforeach
                            </select>

                            @if ($errors->has('status_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('status_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <a href=" {{ URL::previous() }} " class="btn btn-default">Go Back</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  	<script>tinymce.init({ selector:'textarea' });</script>
@endsection