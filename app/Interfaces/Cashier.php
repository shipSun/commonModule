<?php
/**
 * @author ship
 */
namespace App\Interfaces;

use App\Models\CashierUrlModel;
use Core\Exceptions\ParamException;
use Log;

class Cashier {
	public $request;

	public function url(){
		$cashier = $this->request->get('cashier');
		Log::debug('查询参数', ['cashier'=>$cashier]);
		$query = CashierUrlModel::where('cashier', $cashier);
		$model = CashierUrlModel::getModel($query);
		if(empty($model)){
			throw new ParamException('收银台配置不存在');
		}
		Log::debug('结果', $model->getAttributes());
		$model->setAttribute('is_redirect', $model->formatReDirectCodeToEn());
		$model->setAttribute('is_use', $model->formatUseCodeToEn());
		return $model->getAttributes();
	}
}