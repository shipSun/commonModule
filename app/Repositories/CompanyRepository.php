<?php
/**
 * @author ship
 */
namespace App\Repositories;

use App\Models\CompanyModel;
use App\Exceptions\SystemException;

class CompanyRepository{
	/**
	 * @return CompanyModel
	 */
	public static function create($data){
		return CompanyModel::create($data);
	}
	/**
	 * @return CompanyModel
	 */
	public static function getCompanyModelByProductType($productType){
		$query = CompanyModel::query();
		$query->where('product_type', $productType);
		$model = self::getCompanyModelByQuery($query);
		if(empty($model)){
			throw new SystemException('公司不存在');
		}
		return $model;
	}
	/**
	 * @return CompanyModel
	 */
	protected static function getCompanyModelByQuery($query){
		return $query->first();
	}
}