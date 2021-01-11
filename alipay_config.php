<?php
/*
  $Id: alipay.php 12/01/2021  $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2008 osCommerce
  Released under the GNU General Public License

  alipay for osCommerce designed by Ismail Sanan , Francesco Rossi
*/

//////////////////////////////////

$partner        = "xxxxxxxxxxxxxxxx" ;   // Insert the partener ID here 16 Integers
$security_code  = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";      // Insert the Securirity Code String[32] 32 Cha
$seller_email   = "x@x.com";      //Insert The Seller Email
$_input_charset = "utf-8";  // Character encoding format
$sign_type      = "MD5";    //Signature
$transport      = "http";  //Transport method http or https
$notify_url     = "http://localhost/alipay/notify_url.php"; //Path of your local host http:// or https://
$return_url     = "http://Website/checkout_success.php"; // URL of the return value where checkout_success.php is located  in the public server 
$show_url       = "http://Website.com"        //Website URL

?>
