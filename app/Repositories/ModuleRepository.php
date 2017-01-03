<?php
/**
 * @author ship
 */
namespace App\Repositories;

use App\Exceptions\SystemException;
use App\Exceptions\ParamException;
use App\Models\ModuleModel;

class ModuleRepository{
	
	public static function getModuleModelByKeyword($keyword){
		$query = self::getQuery();
		$query->where('keyword', $keyword);
		$model = self::getModelByQuery($query);
		if(empty($model)){
			throw new ParamException('应用配置不存在');
		}
		return $model;
	}
	public static function getModuleModelLists(){
		$query = self::getQuery();
		return self::getModelListsByQuery($query);
	}
	/**
	 * 
	 * @param unknown $query
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public static function getModelListsByQuery($query){
		return $query->get();
	}
	/**
	 * @return ModuleModel
	 */
	public static function getModelByQuery($query){
		return self::getQuery()->first();
	}
	
	public static function getQuery(){
		return ModuleModel::query();
	}
}