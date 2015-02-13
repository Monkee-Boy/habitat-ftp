@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			@if (Session::has('message'))
				<div class="alert alert-{{ Session::get('message-type') }} alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					{{ Session::get('message') }}
				</div>
			@endif

			<div class="panel panel-default">
				<div class="panel-heading">Page Not Found</div>

				<div class="panel-body">
					<p>The page you are looking for could not be found. Your best bet is to go back and avoid clicking on whatever you clicked on that got you here. <strong>/endwitty404</strong></p>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
