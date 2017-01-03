<?php
namespace App\Interfaces;

use App\Models\SecretModel;
use App\Sign\Encrypt as BaseEncrypt;
use Log;
use Core\Exceptions\NoticeException;

class Encrypt {
	public $request;
	
	public function sign(){
		Log::debug('签名接口请求数据', $this->request->all());
		$app = $this->request->get('product_app_id');
		$signType = $this->request->get('product_sign_type');
	
		$waitingSignData = $this->request->all();
		unset($waitingSignData['product_app_id']);
		unset($waitingSignData['product_sign_type']);
		unset($waitingSignData['interface']);
		
		$conditions['product_app_id'] = $app;
		$conditions['product_sign_type'] = $signType;
		log::debug('签名查询条件', $conditions);
		$secretModel = SecretModel::getSecretModelByAppAndSecretType($conditions);
		Log::debug('签名数据', $waitingSignData);
		$response = BaseEncrypt::DataSign($waitingSignData, $secretModel->getAttribute('secret'), $secretModel->getAttribute('sign_type'));
		Log::debug('签名结果',[$response]);
		return ['sign'=>$response];
	}
	public function verify(){
		Log::debug('验证接口请求数据', $this->request->all());
		$app = $this->request->get('verify_app_id');
		$sign = $this->request->get('verify_sign');
		$signType = $this->request->get('verify_sign_type');
		
		$verifyData = $this->request->all();
		unset($verifyData['verify_app_id']);
		unset($verifyData['verify_sign']);
		unset($verifyData['verify_sign_type']);
		unset($verifyData['interface']);
		
		$conditions['product_app_id'] = $app;
		$conditions['product_sign_type'] = $signType;
		$secretModel = SecretModel::getSecretModelByAppAndSecretType($conditions);
		Log::debug('验证数据', $verifyData);
		if(BaseEncrypt::DataVerify($verifyData, $sign, $secretModel->getAttribute('secret'), $secretModel->getAttribute('sign_type'))){
			return ['verfiy_msg'=>'签名验证成功'];
		}
		throw new NoticeException('签名验证失败');
	}
}