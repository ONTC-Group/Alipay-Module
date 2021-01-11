<?php
/*
  $Id: alipay.php 12/01/2021 $
 
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2008 osCommerce
  Released under the GNU General Public License

  alipay for osCommerce designed by Ismail Sanan , Francesco Rossi
*/


//All parameters that need to be passed
class alipay_service {

	var $gateway = "https://intlmapi.alipay.com/gateway.do?";         //Gateway	URL var $parameter;    
	var $security_code;   //Security check code
	var $mysign;          //signature

	//Construct Alipay external service interface control
	function alipay_service($parameter,$security_code,$sign_type = "MD5",$transport= "https") {
		$this->parameter      = $this->para_filter($parameter);
		$this->security_code  = $security_code;
		$this->sign_type      = $sign_type;
		$this->mysign         = '';
		$this->transport      = $transport;
		if($parameter['_input_charset'] == "")
		$this->parameter['_input_charset']='GBK';
		if($this->transport == "https") {
			$this->gateway = "https://intlmapi.alipay.com/gateway.do?";
		} else $this->gateway = "http://intlmapi.alipay.com/gateway.do?";
		$sort_array  = array();
		$arg         = "";
		$sort_array  = $this->arg_sort($this->parameter);
		while (list ($key, $val) = each ($sort_array)) {
			$arg.=$key."=".$this->charset_encode($val,$this->parameter['_input_charset'],$this->parameter['_input_charset'])."&";
		}
		$prestr = substr($arg,0,count($arg)-2);  //Remove the last question mark
		$this->mysign = $this->sign($prestr.$this->security_code);
	}

	//If you use GET to pass, please use the create_url function to get the complete URL link
	function create_url() {
		$url         = $this->gateway;
		$sort_array  = array();
		$arg         = "";
		$sort_array  = $this->arg_sort($this->parameter);
		while (list ($key, $val) = each ($sort_array)) {
			$arg.=$key."=".urlencode($this->charset_encode($val,$this->parameter['_input_charset'],$this->parameter['_input_charset']))."&";
		}
		$url.= $arg."sign=" .$this->mysign ."&sign_type=".$this->sign_type;
		return $url;
	}
	
	//If you use POST to pass, please use Get_Sign function to get the encrypted result string
	function Get_Sign() {
		$url = $this->gateway;
		$sort_array = array();
		$arg = "";
		$sort_array = $this->arg_sort($this->parameter);
		while (list ($key, $val) = each ($sort_array)) {
			$arg.=$key."=".urlencode($this->charset_encode($val,$this->parameter['_input_charset'],$this->parameter['_input_charset']))."&";
		}
		return $this->mysign;
	}

	function arg_sort($array) {
		ksort($array);
		reset($array);
		return $array;
	}

	function sign($prestr) {
		$mysign = "";
		if($this->sign_type == 'MD5') {
			$mysign = md5($prestr);
		}elseif($this->sign_type =='DSA') {
			//DSA Signature method to be developed later
			die("DSA 签名方法待后续开发，请先使用MD5签名方式");
		}else {
			die("支付宝暂不支持".$this->sign_type."类型的签名方式");
		}
		return $mysign;
	}
	function para_filter($parameter) { //Remove empty values and signature patterns in the array
		$para = array();
		while (list ($key, $val) = each ($parameter)) {
			if($key == "sign" || $key == "sign_type" || $val == "")continue;
			else	$para[$key] = $parameter[$key];
		}
		return $para;
	}
	//Realize multiple character encoding methods
	function charset_encode($input,$_output_charset ,$_input_charset ) {
		$output = "";
		if(!isset($_output_charset) )$_output_charset  = $this->parameter['_input_charset'];
		if($_input_charset == $_output_charset || $input ==null) {
			$output = $input;
		} elseif (function_exists("mb_convert_encoding")){
			$output = mb_convert_encoding($input,$_output_charset,$_input_charset);
		} elseif(function_exists("iconv")) {
			$output = iconv($_input_charset,$_output_charset,$input);
		} else die("sorry, you have no libs support for charset change.");
		return $output;
	}
}
?>