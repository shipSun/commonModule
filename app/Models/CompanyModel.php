<?php
/**
 * @author ship
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Core\Exceptions\SystemException;

class CompanyModel extends Model{
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
	const UPDATED_AT = 'update_time';
	/**
	 * {@inheritDoc}
	 */
	protected $table = 'company';
	
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
	protected $guarded = ['create_time','update_time'];
	
	public function updateCompanyID($id){
		$this->user_id = $id;
		if(!$this->save()){
			throw new SystemException('公司ID更新失败');
		}
		return true;
	}
	
	/**
	 * @return CompanyModel
	 */
	public static function create(array $data=[]){
		return parent::create($data);
	}
	/**
	 * @return CompanyModel
	 */
	public static function getCompanyModelByProductType($productType){
		$query = CompanyModel::query();
		$query->where('product_type', $productType);
		$model = self::getCompanyModelByQuery($query);
		if(empty($model)){
			throw new SystemException('公司不存在');
		}
		return $model;
	}
	/**
	 * @return CompanyModel
	 */
	protected static function getCompanyModelByQuery($query){
		return $query->first();
	}
}