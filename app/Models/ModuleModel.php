<?php
/**
 * @author ship
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleModel extends Model{
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
	protected $table = 'module';

	/**
	 * {@inheritDoc}
	 */
	protected $primaryKey = 'keyword';
	
	protected $keyType = 'varchar';

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

	public function updateUrl($url){
		return $this->updateInfo($this->app_name, $url);
	}
	public function updateAppName($appName){
		return $this->updateInfo($appName, $this->url);
	}
	public function updateInfo($appName, $url){
		$this->app_name = $appName;
		$this->url = $url;
		if(!$this->save()){
			throw new SystemException('更新失败');
		}
		return $this;
	}
}