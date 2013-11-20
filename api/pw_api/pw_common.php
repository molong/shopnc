<?php
!defined('P_W') && exit('Forbidden');

//pw函数

function Pcv($fileName, $ifCheck = true) {
	return S::escapePath($fileName, $ifCheck);
}

function pwConvert($str, $toEncoding, $fromEncoding, $ifMb = true) {
	if (strtolower($toEncoding) == strtolower($fromEncoding)) {return $str;}
	if (is_array($str)) {
		foreach ($str as $key => $value) {
			$str[$key] = pwConvert($value, $toEncoding, $fromEncoding, $ifMb);
		}
		return $str;
	} else {
		return mb_convert_encoding($str, $toEncoding, $fromEncoding);
	}
}

function pwCreditNames($creditType = null) {
	static $sCreditNames = null;
	if (!isset($sCreditNames)) {
	    $sCreditNames['credit'] = getGBK('积分');
	}
	return isset($creditType) ? $sCreditNames[$creditType] : $sCreditNames;
}

function getGBK($key){
	/**
	 * 转码
	 */
	if (strtoupper(UC_CHARSET) == 'GBK' && !empty($key)){
		if (is_array($key)){
			$result = var_export($key, true);//变为字符串
			$result = iconv('UTF-8','GBK',$result);
			eval("\$result = $result;");//转换回数组
		} else {
			$result = iconv('UTF-8','GBK',$key);
		}
		return $result;
	} else {
		return $key;
	}
}

?>