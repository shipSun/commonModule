<?php
/**
 * @author ship
 */
namespace App\Repositories;

use App\Models\ConfigModel;

class ConfigRepository{
	/**
	 * @return ConfigModel
	 */
	public static function getConfigModelByKey($key){
		$query = ConfigModel::query();
		$query->where('c_key', $key);
		$model = self::getConfigModelByQuery($query);
		if(empty($model)){
			throw new \ErrorException('配置不存在');
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