<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'chats';
	/**
	 * insert new chat in db
	 *
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function addChat(array $data) 
	{
		return DB::table($this->table)->insert($data);
	}
	/**
	 * select all chats
	 *
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function selectAll() 
	{
		return DB::table($this->table)->select('*')->get();
	}
	/**
	 * select chats
	 *
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function select(array $data) 
	{
		return DB::table($this->table)->where($data)->get();
	}
	/**
	 * select chats by slug
	 *
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function selectChatBySlug($slug) 
	{
		return DB::table($this->table)->where(['slug' => $slug])->first();
	}
}
