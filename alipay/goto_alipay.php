<?php
/*
  $Id: alipay.php  12/01/2021 $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2008 osCommerce
  Released under the GNU General Public License

  alipay for osCommerce designed by Ismail Sanan , Francesco Rossi
*/

require_once("alipay_service.php");

//Non Global Variables are initialized and defined  Before the Array 

$sign_type = $_POST['sign_type'];
$product_code = $_POST['product_code'];
$trade_information = $_POST['trade_information'];
$sign = $_POST['sign'];


// initializing the array 
$parameter = array();

// posting Requred Parameters 
// Global Variavbles are sent Directly By the parameter Arrays 
$parameter = array(




      "service" => $_POST['service'],

      "partner"=>$_POST['partner'],

      "_input_charset" =>  $_POST['_input_charset'],

      "sign_type" => $sign_type,

      "currency" => $_POST['currency'],

      "product_code" => "NEW_OVERSEAS_SELLER",

      "subject" => $_POST['subject'],

      "out_trade_no" =>  $_POST['out_trade_no'],

       "total_fee" => $_POST['total_fee'], 

       "trade_information" => $_POST['trade_information'],
 
       "sign" => $sign


         //"return_url" => $_POST['return_url'],
        //"notify_url"  => $_POST['notify_url'].


);
// creating Object of type alipay_service with Sign as securtiy Code 
$alipay = new alipay_service($parameter,$sign,$sign_type);
$sign = $alipay->Get_Sign();
$link=$alipay->create_url();
echo "<script>window.location =\"$link\";</script>";

?>
