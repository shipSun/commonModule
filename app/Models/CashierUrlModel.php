<?php
/**
 * @author ship
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CashierUrlModel extends Model{
	const CASHIER_URL_USE_NO = 2;
	const CASHIER_URL_USE_YES = 1;
	const CASHIER_URL_REDIRECT_NO = 2;
	const CASHIER_URL_REDIRECT_YES = 1;
	
	/**
	 * The name of the "created at" column.
	 *
	 * @var string
	 */
	const CREATED_AT = 'create_datetime';
	
	/**
	 * The name of the "updated at" column.
	 *
	 * @var string
	 */
	const UPDATED_AT = 'update_datetime';
	/**
	 * {@inheritDoc}
	 */
	protected $table = 'cashier_url';
	
	/**
	 * {@inheritDoc}
	 */
	protected $primaryKey = 'id';
	
	/**
	 * {@inheritDoc}
	 */
	public $timestamps = true;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['create_datetime','update_datetime'];
	
	public function formatUseCodeToEn(){
		switch($this->is_use){
			case self::CASHIER_URL_USE_YES:
				return 'yes';
			case self::CASHIER_URL_USE_NO:
				return 'no';
		}
	}
	public static function formatUseEnToCode($str){
		switch($str){
			case 'yes':
				return self::CASHIER_URL_USE_YES;
			case 'no':
				return self::CASHIER_URL_USE_NO;
		}
	}
	public function formatReDirectCodeToEn(){
		switch($this->is_redirect){
			case self::CASHIER_URL_REDIRECT_NO:
				return 'no';
			case self::CASHIER_URL_USE_YES:
				return 'yes';
		}
	}
	public static function formatRedirectEnToCode($str){
		switch($str){
			case 'yes':
				return self::CASHIER_URL_USE_YES;
			case 'no':
				return self::CASHIER_URL_REDIRECT_NO;
		}
	}
	public function updateInfo($data, $note='信息变更失败'){
		foreach($data as $key=>$val){
			$this->$key = $val;
		}
		if(!$this->save()){
			throw new ParamException($note);
		}
		return $this;
	}
	public static function getModelLists($query, $limit=false, $offset=0, $isPage=false){
		if($limit){
			$query->skip($offset)->take($limit);
		}
		$data = $query->get();
		if($isPage){
			$total = $query->count();
			return ['total'=>$total, 'lists'=>$data];
		}
		return $data;
	}
	/**
	 * @return CashierUrlModel
	 */
	public static function getModel($query){
		return $query->first();
	}
}