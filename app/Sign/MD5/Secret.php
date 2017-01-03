<?php
/**
 * @author ship
 */
namespace App\Sign\MD5;

use App\Sign\AbstractSecret;

class Secret extends AbstractSecret{
	
	public function sign($prestr, $key){
		$prestr = $prestr . $key;
		return md5($prestr);
	}
	
	public function verify($prestr, $sign, $key){
		$prestr = $prestr . $key;
		$mysgin = md5($prestr);
		
		if($mysgin == $sign) {
			return true;
		}
		else {
			return false;
		}
	}
}