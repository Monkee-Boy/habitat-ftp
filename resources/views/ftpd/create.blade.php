@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Create FTP Account</div>

				<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="/ftpd">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label for="input-userid" class="col-sm-2 control-label">Username</label>
							<div class="col-sm-10">
								<input type="text" name="userid" class="form-control" id="input-userid">
							</div>
						</div>

						<div class="form-group">
							<label for="input-passwd" class="col-sm-2 control-label">Password</label>
							<div class="col-sm-10">
								<input type="password" name="passwd" class="form-control" id="input-passwd">
							</div>
						</div>

						<div class="form-group">
							<label for="input-homedir" class="col-sm-2 control-label">Home Directory</label>
							<div class="col-sm-10">
								<input type="text" name="homedir" class="form-control" id="input-homedir" placeholder="/var/www/domain.com/_/public_html/downloads" aria-describedby="homedirHelpBlock">

								<span id="homedirHelpBlock" class="help-block">Keep in mind how this FTP account will affect Capistrano deployments for this domain.</span>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Create Account</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
