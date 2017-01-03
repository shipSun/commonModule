<?php
/**
 * @author ship
 */
namespace App\Repositories;

use App\Exceptions\SystemException;
use App\Exceptions\ParamException;
use App\Models\NoticeModel;

class NoticeRepository{
	
	public static function getDataBaseNoticeModelLists(){
		return self::getNoticeModelListByEvent(NoticeModel::NOTICE_EVENT_DATABASE);
	}
	public static function getModuleNoticeModelLists(){
		return self::getNoticeModelListByEvent(NoticeModel::NOTICE_EVENT_MODULE);
	}
	public static function getNoticeModelListByEvent($event){
		$query = self::getQuery();
		$query->where('event', $event);
		$model = self::getModelListsByQuery($query);
		return $model;
	}
	public static function getDatabaseNoticeModelByApp($app){
		return self::getNoticeModelListByEventAndApp(NoticeModel::NOTICE_EVENT_DATABASE, $app);
	}
	public static function getModuleNoticeModelByApp($app){
		return self::getNoticeModelListByEventAndApp(NoticeModel::NOTICE_EVENT_MODULE, $app);
	}
	public static function getNoticeModelListByEventAndApp($event, $app){
		$query = self::getQuery();
		$query->where('event', $event);
		$query->where('app', $app);
		$model = self::getModelByQuery($query);
		if(empty($model)){
			throw new ParamException('通知不存在');
		}
		return $model;
	}
	/**
	 * 
	 * @param unknown $query
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public static function getModelListsByQuery($query){
		return $query->get();
	}
	/**
	 * @return NoticeModel
	 */
	public static function getModelByQuery($query){
		return $query->first();
	}
	
	public static function getQuery(){
		return NoticeModel::query();
	}
}