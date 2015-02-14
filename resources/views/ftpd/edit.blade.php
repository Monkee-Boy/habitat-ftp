@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Edit Account &raquo; {{ $account->userid }}</div>

				<div class="panel-body">
					{!! Form::model($account, array('route' => array('ftpd.update', $account->id), 'method' => 'PUT', 'class' => 'form-horizontal', 'role' => 'form')) !!}
						<div class="form-group{{ !empty($errors->first('userid')) ? ' has-error' : '' }}">
							<label for="input-userid" class="col-sm-2 control-label">Username</label>
							<div class="col-sm-10">
								<input type="text" name="userid" class="form-control" id="input-userid" value="{{ $account->userid }}">
								@if (!empty($errors->first('userid')))<span class="help-block">{{ $errors->first('userid') }}</span>@endif
							</div>
						</div>

						<div class="form-group{{ !empty($errors->first('passwd')) ? ' has-error' : '' }}">
							<label for="input-passwd" class="col-sm-2 control-label">Password</label>
							<div class="col-sm-10">
								<input type="password" name="passwd" class="form-control" id="input-passwd" aria-describedby="passwdHelpBlock">
								@if (!empty($errors->first('passwd')))<span class="help-block">{{ $errors->first('passwd') }}</span>@endif

								<span id="passwdHelpBlock" class="help-block">Leave blank to keep the current password.</span>
							</div>
						</div>

						<div class="form-group{{ !empty($errors->first('homedir')) ? ' has-error' : '' }}">
							<label for="input-homedir" class="col-sm-2 control-label">Home Directory</label>
							<div class="col-sm-10">
								<input type="text" name="homedir" class="form-control" id="input-homedir" aria-describedby="homedirHelpBlock" value="{{ !empty($account->homedir) ? $account->homedir : $account->homedir_copy }}">
								@if (!empty($errors->first('homedir')))<span class="help-block">{{ $errors->first('homedir') }}</span>@endif

								<span id="homedirHelpBlock" class="help-block">Keep in mind how this FTP account will affect Capistrano deployments for this domain.</span>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="active" value="1"@if (!empty($account->homedir)) checked="checked"@endif> Active
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Save Account</button>
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
