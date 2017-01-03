<?php
/**
 * @author ship
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Core\Exceptions\NoticeException;
use Core\Exceptions\SystemException;

class ProductPayTypeModel extends Model{
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
	protected $table = 'product_pay_type';

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

	public function updatePayType($key){
		$this->product_type = $key;
		if(!$this->save()){
			throw new NoticeException('公司ID更新失败');
		}
		return true;
	}
	
	/**
	 * @return ProductPayTypeModel
	 */
	public static function getProductPayTypeModelByProductType($productType){
		$query = self::query();
		$query->where('product_type', $productType);
		$model = self::getProductPayTypeModelByQuery($query);
		if(empty($model)){
			throw new SystemException('产品的支付类型不存在');
		}
		return $model;
	}
	/**
	 * @return CompanyModel
	 */
	protected static function getProductPayTypeModelByQuery($query){
		return $query->first();
	}
}