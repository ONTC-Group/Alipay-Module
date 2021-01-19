<?php
/**
*  alipay.php 12/01/2021
*
*  osCommerce, Open Source E-Commerce Solutions
*  http://www.oscommerce.com
*  Copyright (c) 2008 osCommerce
*  Released under the GNU General Public License
*	
* @author Ismail Sanan <ismail@carmimari.com>
* @author Francesco Rossi <fra@ontc.eu>
*
* https://github.com/ONTC-Group/Alipay-Module

*/
////////////Page function description////////////////

//This page can be tested on the local computer
//This page is called the "return page", which is synchronously called by the Alipay server, and can be regarded as a prompt information page after the payment is completed, such as "Your order, how much has been successfully paid".
//Can be put into HTML and other beautification page code, database update program code after the order transaction is completed
//The page debugging tool can use the breakpoint debugging tool Zend Studio owned by PHP, or use the text writing function log_result, which has been turned off by default, see the function return_verify in alipay_notify.php

//////////////////////////////////////////////////////

require_once("alipay_notify.php");
require_once("alipay_config.php");
$alipay = new alipay_notify($partner,$security_code,$sign_type,$_input_charset,$transport);
$verify_result = $alipay->return_verify();

//Get Alipay's feedback parameters
   $dingdan	= $_GET['out_trade_no'];	//Get the order number passed by Alipay
    $total = $_GET['price']; //Get the total price passed by Alipay 

if($verify_result) {    //Certified
	if($_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS') //Transaction status: the buyer has paid and is waiting for the seller to ship
	{
		//log_result("verify_success"); 
		
		//If you have applied for Alipay's shopping coupon function, please do not judge the amount in the returned information, otherwise the verification will fail and the order cannot be updated. If you need to get the amount of shopping coupons used by buyers,
//Please get the value of the discount field in the returned information, the absolute value is the amount of the buyer's payment discount. That is, the total amount of the original order = total_fee + |discount|.

		echo "支付成功<br>订单号是：".$dingdan."<br>订单金额是：".$total;
	}
	else
	{
		echo "fail";
	}
}
else {    //Unqualified certification
	echo "fail";
	//log_result ("verify_failed");
}
?>