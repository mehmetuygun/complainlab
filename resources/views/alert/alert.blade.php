@if (session('alert_message'))
<div class="alert alert-{{ session('alert_type') }} alert-dismissible" role="alert">
  	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	{{ session('alert_message') }}
</div>
@endif
