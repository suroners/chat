<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sms';
	/**
	 * insert new sms in db
	 *
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function addSms(array $data) 
	{
		return DB::table($this->table)->insert($data);
	}
	/**
	 * select all sms
	 *
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function selectAll() 
	{
		return DB::table($this->table)->select('*')->get();
	}
	/**
	 * select sms
	 *
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function select(array $data) 
	{
		return DB::table($this->table)->where($data)->get();
	}
	/**
	 * select sms with user
	 *
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function smsWithUser(array $data) 
	{
		return DB::table($this->table)
				->leftJoin('users', 'users.id', '=', $this->table.'.user_id')
				->where($data)
				->get();
	}
}
