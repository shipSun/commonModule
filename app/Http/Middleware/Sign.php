<?php
/**
 * @author ship
 */
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Log;
use Core\Middleware\Sign as BaseSign;
use App\Sign\Encrypt as BaseEncrypt;
use App\Models\SecretModel;
use Core\Exceptions\SystemException;
use Core\Exceptions\ParamException;
use Core\Exceptions\NoticeException;

class Sign {
	
	public function handle(Request $request, Closure $next){
		$product_app_id = $request->get('product_app_id');
		$product_sign = $request->get('product_sign');
		$product_sign_type = $request->get('product_sign_type');
		
		if($request->get('interface')!='encrypt.sign'){
			$request->request->remove('product_app_id');
			$request->query->remove('product_app_id');
			$request->request->remove('product_sign');
			$request->query->remove('product_sign');
			$request->request->remove('product_sign_type');
			$request->query->remove('product_sign_type');
		}
		if(config('app.sign', false) && $request->get('interface')!='encrypt.sign'){
			$data = $request->all();
			Log::debug('common签名验证', $data);
			
			$appName = $this->getAppName();
			$this->diffAppName($appName, $product_app_id);
			
			$conditions['product_app_id'] = $product_app_id;
			
			$conditions['product_sign_type'] = $product_sign_type;
			
			$secretModel = SecretModel::getSecretModelByAppAndSecretType($conditions);
			
			$signData = $request->all();
			
			unset($signData['interface']);
			$cashier = BaseEncrypt::DataVerify($signData, $product_sign, $secretModel->getAttribute('secret'), $secretModel->getAttribute('sign_type'));
			if(!$cashier){
				throw new SystemException($appName.'签名验证失败');
			}
		}
		return $next($request);
	}
	protected function getAppName(){
		$appName = config('app.app_name','');
		if(empty($appName)){
			throw new SystemException('开启签名功能,模块名称不能为空');
		}
		return $appName;
	}
	protected function diffAppName($appName, $diffAppName){
		if($appName!=$diffAppName){
			throw new NoticeException('模块名称不匹配');
		}
		return true;
	}
}