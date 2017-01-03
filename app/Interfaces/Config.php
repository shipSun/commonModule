<?php
namespace App\Interfaces;

use App\Models\ConfigModel;

class Config {
	public $request;
	
	public function run(){
		$key = $this->request->get('key');
		$model = ConfigModel::getConfigModelByKey($key);
		return $model->getAttributes();
	}
}