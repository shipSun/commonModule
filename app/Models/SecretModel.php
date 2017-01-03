<?php
/**
 * @author ship
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Core\Exceptions\NoticeException;

class SecretModel extends Model{
	/**
	 * The name of the "created at" column.
	 *
	 * @var string
	 */
	const CREATED_AT = 'create_time';
	
	/**
	 * The name of the "updated at" column.
	 *
	 * @var string
	 */
	const UPDATED_AT = 'update_secret_time';
	/**
	 * {@inheritDoc}
	 */
	protected $table = 'secret';
	
	/**
	 * {@inheritDoc}
	 */
	protected $primaryKey = 's_id';
	
	/**
	 * {@inheritDoc}
	 */
	public $timestamps = true;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['create_time', 'update_secret_time'];
	
	public function updateSecret($secret){
		$this->secret = $secret;
		if(!$this->save()){
			throw new NoticeException('更新密钥错误');
		}
		return true;
	}
	
	/**
	 * @return SecretModel
	 */
	public static function create(array $data=[]){
		$createData['app_id'] = $data['app_id'];
		$createData['secret_type'] = $data['secret_type'];
		$createData['secret'] = $data['secret'];
		return parent::create($createData);
	}
	/**
	 * @return SecretModel
	 */
	public static function getSecretModelByAppAndSecretType($conditions){
		$query = self::query();
		if(!isset($conditions['product_app_id'])){
			throw new NoticeException('product_app_id不能为空');
		}
		if(!isset($conditions['product_sign_type'])){
			throw new NoticeException('product_sign_type不能为空');
		}
		$query->where('app_id', $conditions['product_app_id']);
		$query->where('sign_type', $conditions['product_sign_type']);
		$model = self::getSecretModelByQuery($query);
		if(empty($model)){
			throw new NoticeException('应用密钥没有设置');
		}
		return $model;
	}
	/**
	 * @return SecretModel
	 */
	protected static function getSecretModelByQuery($query){
		return $query->first();
	}
}