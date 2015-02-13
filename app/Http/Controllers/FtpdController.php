<?php namespace HabitatFTP\Http\Controllers;

use HabitatFTP\Http\Requests;
use HabitatFTP\Http\Controllers\Controller;
use HabitatFTP\Ftpd;
use Request;

class FtpdController extends Controller {
	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct()
	{
		$this->middleware('auth');
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$accounts = Ftpd::paginate(10);

		return view('ftpd/index', ['accounts' => $accounts]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('ftpd/create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$account = new Ftpd;
		$account->userid = Request::input('userid');
		$account->passwd = crypt(Request::input('passwd'), 'mboyhabitatftpd');
		$account->uid = 1004;
		$account->gid = 1002;
		$account->homedir = Request::input('homedir');

		$account->save();

		return redirect('/')->with('message', 'The FTP account '.Request::input('userid').' was successfully created.')->with('message-type', 'success');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$account = Ftpd::find($id);

		if(empty($account))
		{
			abort(404);
		}

		return view('ftpd/edit', ['account' => $account]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$account = Ftpd::find($id);
		$account->userid = Request::input('userid');

		if(!empty(Request::input('passwd')))
		{
			$account->passwd = crypt(Request::input('passwd'), 'mboyhabitatftpd');
		}

		if(Request::input('active') != 1)
		{
			$account->homedir_copy = Request::input('homedir');
			$account->homedir = null;
		} else {
			$account->homedir = Request::input('homedir');
			$account->homedir_copy = null;
		}

		$account->save();

		return redirect('/')->with('message', 'The FTP account '.Request::input('userid').' was successfully updated.')->with('message-type', 'success');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
