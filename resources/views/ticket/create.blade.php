@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Ticket <small>Create a new ticket.</small></div>
            <div class="panel-body">
        		<form class="form-horizontal" role="form" method="POST" action="{{ url('/ticket/') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                        <label for="subject" class="col-md-3 control-label">Subject</label>

                        <div class="col-md-6">
                            <input id="subject" type="text" class="form-control" name="subject" value="{{ old('subject') ? old('subject') : Auth::user()->subject }}" required autofocus>

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
                            	{{ old('description') ? old('description') : Auth::user()->description }}
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
                            		<option value="{{ $priority->id }}">{{ $priority->name }}</option>
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
                            		<option value="{{ $status->id }}">{{ $status->name }}</option>
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
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Create
                            </button>
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