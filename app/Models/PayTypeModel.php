<?php
/**
 * @author ship
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Log;

class PayTypeModel extends Model{
	const PAY_TYPE_USE_YES = 'yes';
	const PAY_TYPE_USE_NO = 'no';
	
	const PAY_TYPE_SHOW_YES = 'yes';
	const PAY_TYPE_SHOW_NO = 'no';
	/**
	 * {@inheritDoc}
	 */
	protected $table = 'pay_type';
	
	/**
	 * {@inheritDoc}
	 */
	protected $primaryKey = 'p_id';
	
	/**
	 * {@inheritDoc}
	 */
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [''];
	
	public static function getPayTypeModelShowByClient($client){
		Log::debug('支付类型', [$client]);
		$query = self::query();
		$query->where('client', 'like', '%'.$client.'%');
		return self::getPayTypeModelShowAllByQuery($query);
	}
	public static function getPayTypeModelShowAllByQuery($query){
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