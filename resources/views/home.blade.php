@extends('layouts.app')

@section('content')
<div class="container">
	@include('alert/alert')

	<div class="row">

		<div class="col-md-3">
			
		    <div class="panel panel-primary text-center">
		        <div class="panel-heading">TOTAL TICKETS</div>

		        <div class="panel-body">
		            <p class="text-primary text-number">{{ App\Ticket::count() }}</p>
		        </div>
		    </div>

		</div>

		<div class="col-md-3">

		    <div class="panel panel-info text-center">
		        <div class="panel-heading">OPEN TICKETS</div>

		        <div class="panel-body text-number">
		            <p class="text-info text-number">{{ App\Ticket::where('status_id', '=', App\Status::where('name', '=', 'Open')->first()->id)->count() }}</p>
		        </div>
		    </div>
			
		</div>

		<div class="col-md-3">

		    <div class="panel panel-danger text-center">
		        <div class="panel-heading">CLOSE TICKETS</div>

		        <div class="panel-body text-number">
		            <p class="text-danger text-number">{{ App\Ticket::where('status_id', '=', App\Status::where('name', '=', 'Close')->first()->id)->count() }}</p>
		        </div>
		    </div>
			
		</div>

		<div class="col-md-3">

		    <div class="panel panel-success	text-center">
		        <div class="panel-heading">REPLIED TICKET</div>

		        <div class="panel-body text-number">
		            <p class="text-success text-number">{{ App\Reply::select('ticket_id')->distinct()->get()->count() }}</p>
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
