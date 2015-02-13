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
											<a href="#" title="Delete {{ $account->userid }}" class="btn btn-default"><i class="glyphicon glyphicon-trash"></i></a>
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
