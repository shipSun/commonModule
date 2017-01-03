<?php
/**
 * @author ship
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Core\Exceptions\NoticeException;

class ConfigModel extends Model{
	/**
	 * {@inheritDoc}
	 */
	protected $table = 'config';
	
	/**
	 * {@inheritDoc}
	 */
	protected $primaryKey = 'c_key';
	
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
	
	/**
	 * @return ConfigModel
	 */
	public static function getConfigModelByKey($key){
		$query = ConfigModel::query();
		$query->where('c_key', $key);
		$model = self::getConfigModelByQuery($query);
		if(empty($model)){
			throw new NoticeException('配置不存在');
		}
		return $model;
	}
	/**
	 * @return ConfigModel
	 */
	protected static function getConfigModelByQuery($query){
		return $query->first();
	}
}