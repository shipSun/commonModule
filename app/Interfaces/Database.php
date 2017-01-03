<?php
namespace App\Interfaces;

use App\Models\DatabaseModel;

class Database {
	public $request;
	
	public function query() {
		$app = $this->request->get('app');
		$model = DatabaseModel::getDatabaseModelByApp($app);
		return $model->getAttributes();
	}
	public function create(){
		$data['host'] = $this->request->get('host');
		$data['user_name'] = $this->request->get('user_name');
		$data['password'] = $this->request->get('password');
		$data['port'] = $this->request->get('port');
		$data['app'] = $this->request->get('app');
		$data['database'] = $this->request->get('database');
		$model = DatabaseModel::create($data);
		return $model->getAttributes();
	}
}