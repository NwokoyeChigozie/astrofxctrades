<?php

if(isset($_GET)){
    echo "Access Denied";
    die();
}else{
include('connection.php');
require "init.php";
include('variables.php');
function edie($error_msg)
{
    global $debug_email;
    $report =  "ERROR : " . $error_msg . "\n\n";
    $report.= "POST DATA\n\n";
    foreach ($_POST as $key => $value) {
        $report .= "|$key| = |$value| \n";
    }
    $headers .= "CC: $debug_email\r\n";
//          $from = "gregoflash05@gmail.com"  
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= 'From: Error Report <support@astroforextrading.com>' . "\r\n";
    
    if(mail($debug_email, "Payment Error", $report,$headers)){
        die($error_msg);
    }else{
        include('connection.php');
        $sql= "INSERT INTO `payment_errors`(`debug_email`,`report`) VALUES ('$debug_email','$report')";
                if(mysqli_query($link, $sql)){}
      die($error_msg);  
    }
    
}
    
if(isset($_POST)){
    include('connection.php');
        $sql= "INSERT INTO `payment_errors` (`debug_email`,`report`) VALUES ('$debug_email','Post Request Received')";
                if(mysqli_query($link, $sql)){}
}

$merchant_id = $merchant_id;
$ipn_secret = $ipn_secret;
$debug_email = $debug_email;

$txn_id = $_POST['txn_id'];
//$payment = Payment::where("gateway_id", $txn_id)->first();


 $sql = "SELECT * FROM payments WHERE gateway_id='$txn_id'";
$result = mysqli_query($link, $sql);
$payment = mysqli_fetch_array($result, MYSQLI_ASSOC);

//$order_currency = $payment->to_currency; //BTC
//$order_total = $payment->amount;

$order_currency = $payment['to_currency']; //BTC
$order_total = $payment['amount']; //BTC
$u_id = $payment['u_id']; //BTC
$username = $payment['username']; //BTC
$type = $payment['type']; //BTC
$entered_amount = $payment['entered_amount']; //BTC

  $u_sql = "SELECT * FROM users WHERE id='$u_id'";
$user_result = mysqli_query($link, $u_sql);
$user_data = mysqli_fetch_array($user_result, MYSQLI_ASSOC);
    $u_registered_at = $user_data['registered_at']; 
    
    
    


if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') {
    edie("IPN Mode is not HMAC");
}

if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
    edie("No HMAC Signature Sent.");
}

$request = file_get_contents('php://input');
if ($request === false || empty($request)) {
    edie("Error in reading Post Data");
}

if (!isset($_POST['merchant']) || $_POST['merchant'] != trim($merchant_id)) {
    edie("No or incorrect merchant id.");
}

$hmac =  hash_hmac("sha512", $request, trim($ipn_secret));
if (!hash_equals($hmac, $_SERVER['HTTP_HMAC'])) {
    edie("HMAC signature does not match.");
}

$amount1 = floatval($_POST['amount1']); //IN USD
$amount2 = floatval($_POST['amount2']); //IN BTC
$currency1 = $_POST['currency1']; //USD
$currency2 = $_POST['currency2']; //BTC
$status = intval($_POST['status']);

if ($currency2 != $order_currency) {
    edie("Currency Mismatch");
}

if ($amount2 < $order_total) {
    edie("Amount is lesser than order total");
}

if ($status >= 100 || $status == 2) {
    
    
    
    ////
    $history_amount = $entered_amount;
    $reg_d = explode(' ', $u_registered_at);   
    $reg_d =  $reg_d[0];
    $rd_split = explode('-', $reg_d);
    $reg_stamp = strtotime($rd_split[1] . '-' . $rd_split[0] . '-' . $rd_split[2] . ' ' . $reg_d[1]);
    if(time() - $reg_stamp < 86400){
        $entered_amount = $entered_amount + 200;
    }
    // Payment is complete
//    $payment->status = "success";
//    $payment->save();
    $sql_t = "UPDATE `payments` SET `status`='success' WHERE `id`= '$p_id'";    
                                        if(mysqli_query($link, $sql_t)){
                                            $created_time = time();
                                            $created_at = date("d/m/Y", $created_time);
                $sql= "INSERT INTO `deposit_list`(`u_id`,`username`, `type`,`amount`, `total_amount`,`date`,`create_timestamp`, `last_update_timestamp`,`status`) VALUES ('$u_id','$username','$type','$entered_amount','$entered_amount','$created_at','$created_time','$created_time','pending')";
                if(mysqli_query($link, $sql)){
                    $w_date = date("d-m-Y", $created_time);
                    $sql= "INSERT INTO `history`(`u_id`,`username`, `type`,`amount`, `date`,`status`) VALUES ('$u_id','$username','Deposit','$history_amount','$w_date','completed')";
                    if(mysqli_query($link, $sql)){
                            $sql = "SELECT * FROM users WHERE id = '$u_id'";
                            $result = mysqli_query($link, $sql);
                            $rows = mysqli_fetch_array($result, MYSQLI_ASSOC); 
                            $ref = $rows['ref'];
                            if($ref != ""){
                               $sql = "SELECT * FROM users WHERE username = '$ref'";
                                $result = mysqli_query($link, $sql);
                                $rows = mysqli_fetch_array($result, MYSQLI_ASSOC); 
                                $total_referal_commission_o = $rows['total_referal_commission'];
                                if($total_referal_commission_o == '' || empty($total_referal_commission_o)){
                                    $total_referal_commission_o = 0;
                                }
                                $ref_amount = (5/100) * $entered_amount; 
                                $total_referal_commission_n = $total_referal_commission_o + $ref_amount;
                                $sql_t = "UPDATE `users` SET `total_referal_commission`='$total_referal_commission_n' WHERE `username`= '$ref'";    
                                        if(mysqli_query($link, $sql_t)){
                                        }else{
                                            edie("Error Updating Referral commission");
                                            
                                        }
                            }
                        
                            
                            
                        
                    }else{
                        edie("Error inserting into history list table"); 
                    }
                }else{
                    
                    edie("Error inserting into deposit list table"); 

                }
                                            
                                            
                                        }else{
                                            edie("Error updating payments table"); 
                                        }
} else if ($status < 0) {
    // Payment Error
//    $payment->status = "error";
//    $payment->save();
        $sql_t = "UPDATE `payments` SET `status`='error' WHERE `id`= '$p_id'";    
                                        if(mysqli_query($link, $sql_t)){
                                            $set = "ok";
                                        }else{
                                            $set = "false"; 
                                        }
} else {
    // Payment Pending
//    $payment->status = "pending";
//    $payment->save();
        $sql_t = "UPDATE `payments` SET `status`='pending' WHERE `id`= '$p_id'";    
                                        if(mysqli_query($link, $sql_t)){
                                            $set = "ok";
                                        }else{
                                             $set = "false"; 
                                        }
}
die("IPN OK");
    
    
}

?>