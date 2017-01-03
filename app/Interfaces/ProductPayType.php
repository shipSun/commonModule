<?php
/**
 * @author ship
 */
namespace App\Interfaces;

use App\Models\ProductPayTypeModel;

class ProductPayType {
	public $request;

	public function payType(){
		$productType = $this->request->get('product_type');
		$productPayTypeModel = ProductPayTypeModel::getProductPayTypeModelByProductType($productType);
		return $productPayTypeModel->getAttributes();
	}
}