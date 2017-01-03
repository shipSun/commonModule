<?php
/**
 * @author ship
 */
namespace App\Repositories;

use Carbon\Carbon;
use App\Models\SecretModel;

class SecretRepository{
	/**
	 * @return SecretModel
	 */
	public static function create($data){
		$createData['app_id'] = $data['app_id'];
		$createData['secret_type'] = $data['secret_type'];
		$createData['secret'] = $data['secret'];
		return SecretModel::create($createData);
	}
	/**
	 * @return SecretModel
	 */
	public static function getSecretModelByAppAndSecretType($conditions){
		$query = SecretModel::query();
		if(!isset($conditions['verify_app_id'])){
			throw new \ErrorException('verify_app_id不能为空');
		}
		if(!isset($conditions['verify_sign_type'])){
			throw new \ErrorException('verify_sign_type不能为空');
		}
		$query->where('app_id', $conditions['verify_app_id']);
		$query->where('sign_type', $conditions['verify_sign_type']);
		$model = self::getSecretModelByQuery($query);
		if(empty($model)){
			throw new \ErrorException('应用密钥没有设置');
		}
		return $model;
	}
	/**
	 * @return SecretModel
	 */
	protected static function getSecretModelByQuery($query){
		return $query->first();
	}
}