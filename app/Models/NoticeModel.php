<?php
/**
 * @author ship
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoticeModel extends Model{
	const NOTICE_EVENT_DATABASE = 'database';
	const NOTICE_EVENT_MODULE = 'module';
	
	/**
	 * The name of the "created at" column.
	 *
	 * @var string
	 */
	const CREATED_AT = 'create_time';

	/**
	 * The name of the "updated at" column.
	 *
	 * @var string
	 */
	const UPDATED_AT = 'update_time';
	/**
	 * {@inheritDoc}
	 */
	protected $table = 'notice';

	/**
	 * {@inheritDoc}
	 */
	protected $primaryKey = 'id';
	
	protected $keyType = 'int';

	/**
	 * {@inheritDoc}
	 */
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [''];
}