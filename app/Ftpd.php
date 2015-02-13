<?php namespace HabitatFTP;

use Illuminate\Database\Eloquent\Model;

class Ftpd extends Model {
	protected $connection = 'ftpd';
	public $timestamps = false;

	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'ftpuser';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = ['userid', 'passwd', 'uid', 'gid', 'homedir', 'homedir_copy'];

	/**
	* The attributes excluded from the model's JSON form.
	*
	* @var array
	*/
	protected $hidden = ['passwd'];

	//

}
