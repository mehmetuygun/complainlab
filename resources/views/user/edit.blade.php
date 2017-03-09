@extends('layouts.app')

@section('content')
<div class="container">
    @include('alert/alert')
    <div class="panel panel-default">
        <div class="panel-heading">User <small>Edit a user</small></div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/app/user').'/'.$user->id }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label for="first_name" class="col-md-4 control-label">First Name</label>

                        <div class="col-md-6">
                            <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') ? old('first_name') : $user->first_name }}" required autofocus>

                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label for="last_name" class="col-md-4 control-label">Last Name</label>

                        <div class="col-md-6">
                            <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') ? old('last_name') : $user->last_name }}" required autofocus>

                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') ? old('email') : $user->email }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                        <label for="role" class="col-md-4 control-label">Role</label>

                        <div class="col-md-6">
                            @foreach ($roles as $role)
                                @php
                                    $checked = false
                                @endphp
                                @if (old('role') == $role->id || $user->hasRole($role->name))
                                    @php
                                        $checked = true
                                    @endphp
                                @endif
                                @if ($checked)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="role" class="form-control" name="role[]" checked="checked"  value="{{ $role->id }}"> {{ $role->display_name }}
                                        </label>
                                    </div>
                                @else
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="role" class="form-control" name="role[]"  value="{{ $role->id }}"> {{ $role->display_name }}
                                        </label>
                                    </div>
                                @endif
                            @endforeach

                            @if ($errors->has('role'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('role') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i> Save Changes
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection
