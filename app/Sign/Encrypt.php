<?php
/**
 * @author ship
 */
namespace App\Sign;
use Log;
class Encrypt {
	/**
	 * 签名数据
	 * @param array $para
	 * @param string $key
	 * @param string $signType
	 * @return string
	 */
	public static function DataSign($para, $key, $signType='MD5'){
		log::debug('开始签名数据', $para);
		$para = self::paraFilter($para);
		$para = self::argSort($para);
		$prestr = self::createLinkstring($para);
		$secret = self::getSecret($signType);
		return $secret->sign($prestr, $key);
	}
	/**
	 * 验证签名数据
	 * @param array $para
	 * @param string $sign
	 * @param string $key
	 * @param string $signType
	 * @return bool
	 */
	public static function DataVerify($para, $sign, $key, $signType='MD5'){
		log::debug('开始验证签名', $para);
		$para = self::paraFilter($para);
		$para = self::argSort($para);
		$prestr = self::createLinkstring($para);
		$secret = self::getSecret($signType);
		return $secret->verify($prestr, $sign, $key);
	}
	/**
	 * 除去数组中的空值和签名参数
	 * @param $para 签名参数组
	 * return 去掉空值与签名参数后的新签名参数组
	 */
	protected static function paraFilter($para) {
		$para_filter = array();
		while (list ($key, $val) = each ($para)) {
			if($key == "sign" || $key == "signType" || $val == "")continue;
			else	$para_filter[$key] = $para[$key];
		}
		return $para_filter;
	}
	/**
	 * 对数组排序
	 * @param $para 排序前的数组
	 * return 排序后的数组
	 */
	protected static function argSort($para) {
		ksort($para);
		reset($para);
		return $para;
	}
	/**
	 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
	 * @param $para 需要拼接的数组
	 * return 拼接完成以后的字符串
	 */
	protected static function createLinkstring($para) {
		Log::debug('拼接连接',$para);
		$arg  = "";
		while (list ($key, $val) = each ($para)) {
			$arg.=$key."=".$val."&";
		}
		//去掉最后一个&字符
		$arg = substr($arg,0,count($arg)-2);
	
		//如果存在转义字符，那么去掉转义
		if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
	
		return $arg;
	}
	/**
	 * 构建加密类
	 * @param string $signType
	 * @return Secret
	 */
	protected static function getSecret($signType){
		$className = __NAMESPACE__.'\\'.ucwords($signType).'\Secret';
		return new $className();
	}
}