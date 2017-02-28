@extends('layouts.app')

@section('content')
<div class="container">
	@include('alert/alert')

	<div class="row">

		<div class="col-md-3">
			
		    <div class="panel panel-primary">
		        <div class="panel-heading">TOTAL TICKETS</div>

		        <div class="panel-body">
		            {{ App\Ticket::count() }}
		        </div>
		    </div>

		</div>

		<div class="col-md-3">

		    <div class="panel panel-info">
		        <div class="panel-heading">OPEN TICKETS</div>

		        <div class="panel-body">
		            {{ App\Ticket::where('status_id', '=', App\Status::where('name', '=', 'Open')->first()->id)->count() }}
		        </div>
		    </div>
			
		</div>

		<div class="col-md-3">

		    <div class="panel panel-danger">
		        <div class="panel-heading">CLOSE TICKETS</div>

		        <div class="panel-body">
		            {{ App\Ticket::where('status_id', '=', App\Status::where('name', '=', 'Close')->first()->id)->count() }}
		        </div>
		    </div>
			
		</div>

		<div class="col-md-3">

		    <div class="panel panel-success	">
		        <div class="panel-heading">REPLIED TICKET</div>

		        <div class="panel-body">
		            {{ App\Reply::select('ticket_id')->distinct()->get()->count() }}
		        </div>
		    </div>
			
		</div>

	</div>

    <div class="panel panel-default">
        <div class="panel-heading">Dashboard</div>

        <div class="panel-body">
            You are logged in!
        </div>
    </div>
</div>
@endsection
