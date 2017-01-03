<?php
/**
 * @author ship
 */
namespace App\Repositories;

use App\Models\ProductPayTypeModel;
use App\Exceptions\SystemException;

class ProductPayTypeRepository{
	/**
	 * @return ProductPayTypeModel
	 */
	public static function getProductPayTypeModelByProductType($productType){
		$query = ProductPayTypeModel::query();
		$query->where('product_type', $productType);
		$model = self::getProductPayTypeModelByQuery($query);
		if(empty($model)){
			throw new SystemException('产品的支付类型不存在');
		}
		return $model;
	}
	/**
	 * @return CompanyModel
	 */
	protected static function getProductPayTypeModelByQuery($query){
		return $query->first();
	}
}