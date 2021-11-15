<?php
if($_GET){
    echo "Access Denied";
}
else{
require "init.php";
include('variables.php');
include('connection.php');
$basicInfo = $coin->GetBasicProfile();
//$username = $basicInfo['result']['public_name'];

$amount = $_POST['de_amount'];
$email = $_POST['de_email'];
$u_id = $_POST['u_id'];
$username = $_POST['username'];
$type = $_POST['type'];
    
if(empty($email)){
    $message = array("error"=>"Please Enter E-mail");
                     
            echo json_encode($message);
            die();
}

$scurrency = "USD";
//$rcurrency = "LTCT";
$rcurrency = "BTC";

$request = [
    'amount' => $amount,
    'currency1' => $scurrency,
    'currency2' => $rcurrency,
    'buyer_email' => $email,
    'item' => "Investment in AstroForex",
    'address' => "",
    'ipn_url' => $ipn_urlm
];
//$message = array("error"=>"ok",
//                             "amount"=> '0.09765',
//                             "to_currency"=>$rcurrency,
//                             "gateway_url"=>"bduvbvubuequbnubvqeure");
//
//            echo json_encode($message);

$result = $coin->CreateTransaction($request);

if ($result['error'] == "ok") {
    $main_amount = $result['result']['amount'];
    $gateway_id = $result['result']['txn_id'];
    $gateway_url = $result['result']['status_url'];
    
    
    
//    $payment = new Payment;
//    $payment->email = $email;
//    $payment->entered_amount = $amount;
//    $payment->amount = $result['result']['amount'];
//    $payment->from_currency = $scurrency;
//    $payment->to_currency = $rcurrency;
//    $payment->status = "initialized";
//    $payment->gateway_id = $result['result']['txn_id'];
//    $payment->gateway_url = $result['result']['status_url'];
//    $payment->save();
//    $registered_at = date("M-d-Y h:i:s A", time());
                $sql= "INSERT INTO `payments`(`u_id`,`username`, `type`,`from_currency`, `entered_amount`,`to_currency`,`amount`, `gateway_id`,`gateway_url`,`status`) VALUES ('$u_id','$username','$type','$scurrency','$amount','$rcurrency','$main_amount','$gateway_id','$gateway_url','initialized')";
    
        if(mysqli_query($link, $sql)){
            
            $message = array("error"=>"ok",
                             "amount"=> $main_amount,
                             "to_currency"=>$rcurrency,
                             "gateway_url"=>$gateway_url);

            echo json_encode($message);
            
            
        }else{
            $message = array("error"=>"Error Saving data",
                             "amount"=> $main_amount,
                             "to_currency"=>$rcurrency,
                             "gateway_url"=>$gateway_url);

            echo json_encode($message);
        }
    
    
} else {
    $message = array("error"=> 'Error: ' . $result['error'] . "\n");

            echo json_encode($message);
//    echo 'Error: ' . $result['error'] . "\n";
    die();
}
}
?>