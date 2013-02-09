<?php

//**********************************************************
//***************** EasyCrypt Version 1.0 ******************
//**********************************************************
//
//                                       作者: @To_aru_User
//
// ******  概　要  ******
// 
// 暗号化と復号化を簡単に行えるクラスです。
// 
// $dataに処理する文字列、$saltに秘密鍵を指定します。
// 
// string EasyCrypt::encrypt(string $data, string $salt)
// string EasyCrypt::decrypt(string $data, string $salt)
//

class EasyCrypt {
    
	const DELIMITER = '-';
	
	private $key;
	private $mc;
	
	public static function encrypt($data,$salt) {
		$className = __CLASS__;
		$obj = new $className($salt);
		return $obj->_encrypt($data);
	}
	
	public static function decrypt($data,$salt) {
		$className = __CLASS__;
		$obj = new $className($salt);
		return $obj->_decrypt($data);
	}
	
	public function __construct($salt) {
		$this->mc = mcrypt_module_open('rijndael-256','','cbc','');
		$this->key = substr(md5($salt),0,mcrypt_enc_get_key_size($this->mc));
	}
	
	public function __destruct() {
		mcrypt_generic_deinit($this->mc);
		mcrypt_module_close($this->mc);
	}
	
	private function _encrypt($data) {
		if (PHP_OS==='WIN32' || PHP_OS==='WINNT') {
			srand();
			$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($this->mc),MCRYPT_RAND);
		} else {
			$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($this->mc),MCRYPT_DEV_URANDOM);
		}
		mcrypt_generic_init($this->mc,$this->key,$iv);
		$data = mcrypt_generic($this->mc,$data);
		return base64_encode($iv).self::DELIMITER.base64_encode($data);
	}
	
	private function _decrypt($data) {
		$arr = explode(self::DELIMITER,$data);
		if (!isset($arr[1]))
			return '';
		list($iv,$data) = $arr;
		mcrypt_generic_init($this->mc,$this->key,base64_decode($iv));
		return rtrim(mdecrypt_generic($this->mc,base64_decode($data)),'\0');
	}

}