<?php
/**
 * @author ship
 */
namespace App\Repositories;

use App\Models\PayTypeModel;
use Log;
class PayTypeRepository{
	
	public static function getPayTypeModelShowByClient($client){
		Log::debug('支付类型', [$client]);
		$query = PayTypeModel::query();
		$query->where('client', 'like', '%'.$client.'%');
		return self::getPayTypeModelShowAllByQuery($query);
	}
	protected static function getPayTypeModelShowAllByQuery($query){
		$query->where('is_show', PayTypeModel::PAY_TYPE_SHOW_YES);
		return self::getPayTypeModelAllByQuery($query);
	}
	/**
	 * @return PayTypeModel
	 */
	protected static function getPayTypeModelAllByQuery($query){
		return $query->get();
	}
}