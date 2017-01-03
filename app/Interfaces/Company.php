<?php
/**
 * @author ship
 */
namespace App\Interfaces;

use App\Models\CompanyModel;

class Company {
	public $request;
	
	public function id(){
		$productType = $this->request->get('product_type');
		$companyModel = CompanyModel::getCompanyModelByProductType($productType);
		return $companyModel->getAttributes();
	}
}