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
				<div class="panel-heading">Manage FTP Accounts</div>

				<div class="panel-body">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>Username</th>
								<th>Home Dir</th>
								<th>Count</th>
								<th>Last Accessed</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($accounts as $account)
								<tr>
									<td>{{ $account->id }}</td>
									<td>{{ $account->userid }} @if (empty($account->homedir))<span class="label label-danger">inactive</span>@endif</td>
									<td>@if (!empty($account->homedir)) {{ $account->homedir }} @else {{ $account->homedir_copy }} @endif</td>
									<td class="text-center"><span class="badge">{{ $account->count }}</span></td>
									<td>{{ $account->accessed }}</td>
									<td>
										<div class="btn-group" role="group" aria-label="Actions">
											<a href="/ftpd/{{ $account->id }}/edit" title="Edit {{ $account->userid }}" class="btn btn-default"><i class="glyphicon glyphicon-edit"></i></a>
											<button type="button" class="btn btn-default" data-toggle="modal" data-target="#destroy-{{ $account->id }}" aria-label="Delete {{ $account->userid }}"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
										</div>

										<!-- Modal -->
										<div class="modal fade" id="destroy-{{ $account->id }}" tabindex="-1" role="dialog" aria-labelledby="Delete {{ $account->userid }}" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													{!! Form::model($account, array('route' => array('ftpd.destroy', $account->id), 'method' => 'DELETE', 'class' => 'btn-group', 'role' => 'group', 'aria-label' => 'Actions')) !!}
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
															<h4 class="modal-title">Delete FTP Account</h4>
														</div>
														<div class="modal-body">
															<p>Are you sure you want to delete the FTP account <strong>{{ $account->userid }}</strong>? Considering marking the account as inactive instead to avoid permanently destroying.</p>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
															<button type="submit" class="btn btn-danger" aria-label="Delete {{ $account->userid }}">Delete Account</button>
														</div>
													{!! Form::close() !!}
												</div>
											</div>
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>

					{!! $accounts->render() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
