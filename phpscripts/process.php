<?php
include('connection.php');
if($_GET){
    echo "Access Denied";
}elseif(isset($_POST['de_submit'])){
include('cryptofunctions.php');

//////////////////////////////////////////////////////////////////////////////////    
  $sql = "SELECT * FROM `admin` WHERE `id` = 1" ;
          if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){ 
    $bitcoin_address =$row['bitcoin_address'];  
    $ethereum_address =$row['ethereum_address'];  
    $bnb_address =$row['bnb_address'];  
    $ada_address =$row['ada_address'];  
    $xrp_address =$row['xrp_address'];  
    $doge_address =$row['doge_address'];  
        }
        mysqli_free_result($result);

    }else{

         }
}else{ 
            
}    
/////////////////////////////////////////////////////////////////////////////////////////    
    
    
    
    
    
$amount = $_POST['de_amount'];
$pay_currency = $_POST['pay_currency'];
$email = $_POST['de_email'];
$u_id = $_POST['u_id'];
$username = $_POST['username'];
$type = $_POST['type'];
    
if(empty($email)){
    $message = array("error"=>"Please Enter E-mail");
                     
            echo json_encode($message);
            die();
} 
    
if(empty($pay_currency)){
    $message = array("error"=>"Please Select Currency");
                     
            echo json_encode($message);
            die();
}
//////////////////////////////////////////////////////////////////    
//$url='https://bitpay.com/api/rates';
//$json=json_decode( file_get_contents( $url ) );
//$dollar=$btc=0;
//$btc_to_next_rate=0;
////print_r($json);
//foreach( $json as $obj ){
//    if( $obj->code=='USD' ){
//        $btc_to_usd_rate=$obj->rate;
//    }elseif($obj->code==$pay_currency){
//        $btc_to_next_rate=$obj->rate;
//        break;
//    }
//    
//}
/////////////////////////////////////////////////////////////
$scurrency = "USD";
//$rcurrency = "BTC";

//$main_amount = converting($amount, $btc_to_usd_rate, $btc_to_next_rate, $pay_currency);  
$main_amount = converting($amount, $pay_currency);  

    $wallet_address = $bitcoin_address;
if($pay_currency == "BTC"){
    $wallet_address = $bitcoin_address;
}elseif($pay_currency == "ETH"){
    $wallet_address = $ethereum_address;
}elseif($pay_currency == "BNB"){
    $wallet_address = $bnb_address;
}elseif($pay_currency == "ADA"){
    $wallet_address = $ada_address;
}elseif($pay_currency == "XRP"){
    $wallet_address = $xrp_address;
}elseif($pay_currency == "DOGE"){
    $wallet_address = $doge_address;
}
    
    
                $sql= "INSERT INTO `payments`(`u_id`,`username`, `type`,`from_currency`, `entered_amount`,`to_currency`,`amount`,`status`) VALUES ('$u_id','$username','$type','$scurrency','$amount','$pay_currency','$main_amount','initialized')";
    
        if(mysqli_query($link, $sql)){
            
            $last_id = $link->insert_id;
            
            $message = array("error"=>"ok",
                             "amount"=> $main_amount,
                             "to_currency"=>$pay_currency,
                             "last_id"=>$last_id,
                             "wallet_address"=>$wallet_address);

            echo json_encode($message);
            
            
        }else{
            $message = array("error"=>"Error Saving data",
                             "amount"=> $main_amount,
                             "to_currency"=>$rcurrency,
                             "wallet_address"=>$wallet_address);

            echo json_encode($message);
        }
    
    

}elseif(isset($_POST['hashcode_button'])){
    $hashcode = mysqli_real_escape_string($link, $_POST['hashcode']);
    $u_id = $_POST['u_id'];
    $payment_id = $_POST['payment_id'];
   
    if(empty($hashcode)){
        $message = array("error"=>"Enter Hashcode");
                     
            echo json_encode($message);
//    echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Enter Hashcode</div>';
        die();
    } 
    
    
    $sql = "UPDATE `payments` SET `hashcode`='$hashcode',`status`='pending' WHERE `id`= '$payment_id'";  
    
        if(mysqli_query($link, $sql)){
            
            $message = array("error"=>"ok");

            echo json_encode($message);
            
        }else{
            $message = array("error"=>"Error Occurred");
                     
            echo json_encode($message);
//            echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Error Occurred</div>';
        }
  
}
?>