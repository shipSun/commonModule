<?php
namespace App\Interfaces;

use App\Models\PayTypeModel;
use Core\Exceptions\NoticeException;
use Log;

class PayType {
	public $request;

	public function lists(){
		$client = $this->request->get('client');
		Log::debug('进入支付类型查询接口', $this->request->all());
		$model = PayTypeModel::getPayTypeModelShowByClient($client);
		$data = [];
		foreach($model as $val){
			$data[] = $val->getAttributes();
		}
		if(empty($data)){
			throw new NoticeException('没有对应支付类型');
		}
		return $data;
	}
}