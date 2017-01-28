@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-4">
			<div class="list-group">
  				<a href="{{ url('settings/account') }}" class="list-group-item">Account</a>
			  	<a href="{{ url('settings/password') }}" class="list-group-item active">Password</a>
			</div>
		</div>
		<div class="col-md-8">
		    <div class="panel panel-default">
		        <div class="panel-heading">Password</div>


		        <div class="panel-body">
				        @include('alert/alert')

		        	    <form class="form-horizontal" role="form" method="POST" action="{{ url('settings/password') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('npassword') ? ' has-error' : '' }}">
                            <label for="npassword" class="col-md-4 control-label">New Password</label>

                            <div class="col-md-6">
                                <input id="npassword" type="password" class="form-control" name="npassword" value="" required autofocus>

                                @if ($errors->has('npassword'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('npassword') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('npassword_confirmation') ? ' has-error' : '' }}">
                            <label for="npassword_confirmation" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="npassword_confirmation" type="password" class="form-control" name="npassword_confirmation" value="" required autofocus>

                                @if ($errors->has('npassword_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('npassword_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Current Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" value="" required autofocus>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
		        </div>
		    </div>
		</div>
	</div>
</div>
@endsection

