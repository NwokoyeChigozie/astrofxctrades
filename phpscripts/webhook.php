<?php
include('variables.php');
$cp_merchant_id = $merchant_id;
    $cp_ipn_secret = $ipn_secret;
    $cp_debug_email = $debug_email;
//echo "$cp_merchant_id ; $cp_ipn_secret ; $cp_debug_email;";

if(isset($_POST)){
    
    include('connection.php');
    $sql= "INSERT INTO `payment_errors`(`debug_email`,`report`) VALUES ('Gregoflash05@gmail.com','Initial Post request Received')";

    
        if(mysqli_query($link, $sql)){
            
        }
    
    function errorAndDie($error){
        include('connection.php');
    $sql= "INSERT INTO `payment_errors`(`debug_email`,`report`) VALUES ('Gregoflash05@gmail.com','$error')";

    
        if(mysqli_query($link, $sql)){
            
        }
    }
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') {
        errorAndDie('IPN Mode is not HMAC');
    }

    if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
        errorAndDie('No HMAC signature sent.');
    }

    $request = file_get_contents('php://input');
    if ($request === FALSE || empty($request)) {
        errorAndDie('Error reading POST data');
    }

    if (!isset($_POST['merchant']) || $_POST['merchant'] != trim($cp_merchant_id)) {
        errorAndDie('No or incorrect Merchant ID passed');
    }

    $hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret));
    if (!hash_equals($hmac, $_SERVER['HTTP_HMAC'])) {
    //if ($hmac != $_SERVER['HTTP_HMAC']) { <-- Use this if you are running a version of PHP below 5.6.0 without the hash_equals function
        errorAndDie('HMAC signature does not match');
    }
    
   ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $ipn_type = $_POST['ipn_type'];
    $txn_id = $_POST['txn_id'];
    $item_name = $_POST['item_name'];
    $item_number = $_POST['item_number'];
    $amount1 = floatval($_POST['amount1']);
    $amount2 = floatval($_POST['amount2']);
    $currency1 = $_POST['currency1'];
    $currency2 = $_POST['currency2'];
    $status = intval($_POST['status']);
    $status_text = $_POST['status_text'];
    
//    errorAndDie("ipn_type: $ipn_type -- txn_id: $txn_id -- item_name: $item_name -- item_number: $item_number -- amount1: $amount1 -- amount2: $amount2 -- currency1: $currency1 -- currency2: $currency2 -- status: $status -- status_text: $status_text");
   ///////////////////////////////////////////////////////////////////////////////////////////////////////////// 
     $sql = "SELECT * FROM payments WHERE gateway_id='$txn_id'";
$result = mysqli_query($link, $sql);
$payment = mysqli_fetch_array($result, MYSQLI_ASSOC);

//$order_currency = $payment->to_currency; //BTC
//$order_total = $payment->amount;

$p_id = $payment['id']; //BTC
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
    
    errorAndDie("p_id: $p_id ; order_currency: $order_currency ; order_total: $order_total");
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
//    if ($ipn_type != 'button') { // Advanced Button payment
//        die("IPN OK: Not a button payment");
//    }

    //depending on the API of your system, you may want to check and see if the transaction ID $txn_id has already been handled before at this point

    // Check the original currency to make sure the buyer didn't change it.
    if ($currency1 != $order_currency) {
        errorAndDie('Original currency mismatch!');
    }

    // Check amount against order total
    if ($amount1 < $order_total) {
        errorAndDie('Amount is less than order total!');
    }
    
 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
    
  if ($status >= 100 || $status == 2) {
 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      
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
                                            errorAndDie("Error Updating Referral commission");
                                            
                                        }
                            }
                        
                            
                            
                        
                    }else{
                        errorAndDie("Error inserting into history list table"); 
                    }
                }else{
                    
                    errorAndDie("Error inserting into deposit list table"); 

                }
                                            
                                            
                                        }else{
                                            errorAndDie("Error updating payments table"); 
                                        }     
      
      
      
      
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      
      
        // payment is complete or queued for nightly payout, success
    } else if ($status < 0) {
        //payment error, this is usually final but payments will sometimes be reopened if there was no exchange rate conversion or with seller consent
      
      $sql_t = "UPDATE `payments` SET `status`='error' WHERE `id`= '$p_id'";    
                                        if(mysqli_query($link, $sql_t)){
                                            $set = "ok";
                                        }else{
                                            $set = "false"; 
                                        }

    } else {
        //payment is pending, you can optionally add a note to the order page
      
      $sql_t = "UPDATE `payments` SET `status`='pending' WHERE `id`= '$p_id'";    
                                        if(mysqli_query($link, $sql_t)){
                                            $set = "ok";
                                        }else{
                                             $set = "false"; 
                                        }
    }
    die('IPN OK');
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    
    
    
    
    
    
    
    
    
    
    
}elseif(isset($_GET)){
    include('connection.php');
    $sql= "INSERT INTO `payment_errors`(`debug_email`,`report`) VALUES ('Gregoflash05@gmail.com','Get request Received')";

    
        if(mysqli_query($link, $sql)){
            
        }
}else{
    include('connection.php');
    $sql= "INSERT INTO `payment_errors`(`debug_email`,`report`) VALUES ('Gregoflash05@gmail.com','Random request Received')";

    
        if(mysqli_query($link, $sql)){
            
        }
}

?>