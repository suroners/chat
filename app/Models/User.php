<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	/**
	 * select sms
	 *
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function select(array $data) 
	{
		return DB::table($this->table)->where($data)->get();
	}
}
