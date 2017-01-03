<?php
/**
 * @author ship
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Core\Exceptions\NoticeException;
use Carbon\Carbon;

class DatabaseModel	extends Model{
	/**
	 * {@inheritDoc}
	 */
	protected $table = 'database_config';
	
	/**
	 * {@inheritDoc}
	 */
	protected $primaryKey = 'app';
	
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
	 
	 public static function create(array $data=[]){
	 	$createData['host'] = encrypt(empty($data['host'])? 'host' : $data['host']);
	 	$createData['user_name'] = encrypt(empty($data['user_name']) ? 'root' : $data['user_name']);
	 	$createData['password'] = encrypt(empty($data['password']) ? '' : $data['password']);
	 	$createData['port'] = empty($data['port']) ? 3306 : $data['port'];
	 	$createData['app'] = empty($data['app']) ? 'app' : $data['app'];
	 	$createData['database_name'] = empty($data['database']) ? 'database' : $data['database'];
	 	$createData['create_time'] = Carbon::now()->format('Y-m-d H:i:s');
	 	$model = parent::create($createData);
	 	$model->setAttribute('app', $createData['app']);
	 	$model->syncOriginal();
	 	return $model;
	 }
	 /**
	  * @return DatabaseModel
	  */
	 public static function getDatabaseModelByApp($app){
	 	$query = self::query();
	 	$query->where('app', $app);
	 	$model = self::getDatabaseModelByQuery($query);
	 	if(empty($model)){
	 		throw new NoticeException('数据库配置不存在');
	 	}
	 	$model->setAttribute('host', decrypt($model->getAttribute('host')));
	 	$model->setAttribute('user_name', decrypt($model->getAttribute('user_name')));
	 	$model->setAttribute('password', decrypt($model->getAttribute('password')));
	 	return $model;
	 }
	 /**
	  * @return DatabaseModel
	  */
	 protected static function getDatabaseModelByQuery($query){
	 	return $query->first();
	 }
}