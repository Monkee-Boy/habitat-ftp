<?php namespace HabitatFTP\Http\Controllers;

use HabitatFTP\Http\Requests;
use HabitatFTP\Http\Controllers\Controller;
use Validator;
use HabitatFTP\Ftpd;
use Illuminate\Http\Request;

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
	public function store(Request $request)
	{
		$validator = Validator::make(
			$request->all(),
			[
				'userid' => 'required|unique:ftpuser,userid|min:4',
				'passwd' => 'required|min:8',
				'homedir' => 'required',
			],
			[
				'userid.required' => 'You must specify a username.',
				'userid.unique' => 'That username already exists.',
				'userid.min' => 'We require a FTP username to be at least four characters.',
				'passwd.required' => 'You must specify a password.',
				'passwd.min' => 'We require a FTP password to be at least eight characters. You know, security and all.',
				'homedir.required' => 'You must specify a home directory.',
			]
		);
		$validator->getPresenceVerifier()->setConnection('ftpd');

		if ($validator->fails())
		{
				return redirect()->back()->withInput()->withErrors($validator->errors());
		}

		$account = new Ftpd;
		$account->userid = $request->input('userid');
		$account->passwd = crypt($request->input('passwd'), 'mboyhabitatftpd');
		$account->uid = 1004;
		$account->gid = 1002;
		$account->homedir = $request->input('homedir');

		$account->save();

		return redirect('/')->with('message', 'The FTP account '.$request->input('userid').' was successfully created.')->with('message-type', 'success');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		abort(404, 'Ftpd.show is not a valid route.');
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
			abort(404, 'We were unable to find a user that matched this id.');
		}

		return view('ftpd/edit', ['account' => $account]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$validator_rules = [
			'userid' => 'required|min:4',
			'homedir' => 'required',
		];

		if(!empty($request->input('passwd')))
		{
			$validator_rules = array_add($validator_rules, 'passwd', 'required|min:8');
		}

		$validator = Validator::make(
			$request->all(),
			$validator_rules,
			[
				'userid.required' => 'You must specify a username.',
				'userid.unique' => 'That username already exists.',
				'userid.min' => 'We require a FTP username to be at least four characters.',
				'passwd.required' => 'You must specify a password.',
				'passwd.min' => 'We require a FTP password to be at least eight characters. You know, security and all.',
				'homedir.required' => 'You must specify a home directory.',
			]
		);
		$validator->getPresenceVerifier()->setConnection('ftpd');

		if ($validator->fails())
		{
				return redirect()->back()->withInput()->withErrors($validator->errors());
		}

		$account = Ftpd::find($id);
		$account->userid = $request->input('userid');

		if(!empty($request->input('passwd')))
		{
			$account->passwd = crypt($request->input('passwd'), 'mboyhabitatftpd');
		}

		if($request->input('active') != 1)
		{
			$account->homedir_copy = $request->input('homedir');
			$account->homedir = null;
		} else {
			$account->homedir = $request->input('homedir');
			$account->homedir_copy = null;
		}

		$account->save();

		return redirect('/')->with('message', 'The FTP account '.$request->input('userid').' was successfully updated.')->with('message-type', 'success');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$account = Ftpd::find($id);
		$userid = $account->userid;
		$account->delete();

		return redirect('/')->with('message', 'The FTP account '.$userid.' was successfully deleted.')->with('message-type', 'warning');
	}

}
