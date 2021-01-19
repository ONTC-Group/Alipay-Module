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


///////////Page function description///////////////
//When creating the page file, please note that there is no HTML code or spaces in the page file.
//When Alipay’s order status changes, the Alipay server will automatically call this page, so please do a good job of synchronizing your website order information with the order on Alipay
//This page cannot be tested on the local computer, please test on the server, that is, the page can be accessed by the Internet.
//Please use the text writing function log_result for this page debugging tool, which has been enabled by default, see the function notify_verify in alipay_notify.php
///////////////////////////////////////////////////

require_once("alipay_notify.php");
require_once("alipay_config.php");
$alipay = new alipay_notify($partner,$security_code,$sign_type,$_input_charset,$transport);
$verify_result = $alipay->notify_verify();
if($verify_result) {   //Certified
 //Get Alipay's feedback parameters
    $dingdan  = $_POST['out_trade_no'];	//Get the order number passed by Alipay
    $total    = $_POST['price'];		//Get the total price passed by Alipay
	
/*
	Get the status feedback from Alipay, and update the database according to different status
WAIT_BUYER_PAY (means waiting for buyer to pay);
TRADE_FINISHED (indicating that the transaction has ended successfully);
*/

//If you have applied for Alipay's shopping coupon function, please do not judge the amount in the returned information, otherwise the verification will fail and the order cannot be updated. If you need to get the amount of shopping coupons used by buyers,
//Please get the value of the discount field of the returned information, the absolute value is the amount of the buyer's payment discount. That is, the total amount of the original order = total_fee + |discount|.

	if($_POST['trade_status'] == 'WAIT_BUYER_PAY') {         //Transaction status: waiting for buyer to pay
//The put transaction status is the code of the database update program that the order transaction creates and has not been paid, or it does not need to put any code.
		echo "success";
		//log_result("verify_success");
	}
	else if($_POST['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {    //Transaction status: the buyer has paid and is waiting for the seller to ship
         //Put in the database update program code after the order transaction is completed, please make sure that the information from echo is only success
		echo "success";

		//log_result("verify_success");
	}	
	else if($_POST['trade_status'] == 'WAIT_BUYER_CONFIRM_GOODS') {    //Transaction status: the seller has shipped and is waiting for the buyer to confirm receipt
         //Put in the database update program code after the order transaction is completed, please make sure that the information from echo is only success
		echo "success";

		//log_result("verify_success");
	}	
	else if($_POST['trade_status'] == 'TRADE_FINISHED') {    //Transaction status: transaction ended successfully
         //Put in the database update program code after the order transaction is completed, please make sure that the information from echo is only success
		echo "success";

		//log_result("verify_success");
	}	
	else {//Place more transaction status, see http://club.alipay.com/read-htm-tid-8681385-fpage-2.html
		echo "success";
		//log_result ("verify_failed");
	}
}
else {    //认证不合格3

	echo "fail";
	//log_result ("verify_failed");
}
?>