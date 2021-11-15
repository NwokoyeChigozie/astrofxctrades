<!DOCTYPE html>
<?php
session_start();
include('phpscripts/connection.php');
include('phpscripts/functions.php');
if(isset($_GET['ref'])){
    $_SESSION['ref'] = $_GET['ref'];
}
?>

<?php 
$forgot_passsword_v = 'false';
if(isset($_GET['sr']) && isset($_GET['pri']) && isset($_GET['email']) && isset($_GET['et'])){
    $get_email = $_GET['email'];
    $get_sr = $_GET['sr'];
    $get_pri = $_GET['pri'];
    $get_et = $_GET['et'];
 $sql = "SELECT * FROM password_recovery WHERE email='$get_email' AND elapse_time='$get_et'";
        $result = mysqli_query($link, $sql);
        $count = mysqli_num_rows($result);
        if($count == 1){
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $main_sr = $row['sr'];
            $main_et = $row['elapse_time'];
            $main_count = $row['count'];
            
            if(time() < $main_et && $get_sr == $main_sr && $main_count == 0){
               $forgot_passsword_v = 'true'; 
            }
        }
}
?>


<?php

if(isset($_SESSION['id'])){
    $base_id = $_SESSION['id'];
    $plan_duration = array(0, 259200,432000,604800,864000);
    $plan_percentage = array(0, 0.1,0.3,0.45,0.55);
    $depos = [];
    $all_depos = [];
    $all_withd = [];
       $sql = "SELECT * FROM `deposit_list` WHERE u_id = '$base_id' AND status = 'pending'" ;
          if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $depos[] = $row;
            
        }
    }
          }
    if(!empty($depos) && $depos[0] != ""){
        foreach($depos as $depo){
            $depo_id = $depo['id'];
            $depo_type = $depo['type'];
            $depo_amount = $depo['amount'];
            $depo_total_amount = $depo['total_amount'];
            $depo_create_timestamp = $depo['create_timestamp'];
            $depo_last_update_timestamp = $depo['last_update_timestamp'];
            $new_last_update_timestamp = time();
            
            if(time() - $depo_last_update_timestamp > $plan_duration[$depo_type]){
                $n_time = time() - $depo_last_update_timestamp;
            $int_day = $n_time / (24 * 3600);
            $int_day = $int_day / ($plan_duration[$depo_type]/(24 * 3600));
                
                $new_total_amount = $depo_total_amount + ($plan_percentage[$depo_type] * $depo_amount * $int_day);
                
                $sql_t = "UPDATE `deposit_list` SET `total_amount`='$new_total_amount', `last_update_timestamp`='$new_last_update_timestamp' WHERE `id`= '$depo_id'";    
                                        if(mysqli_query($link, $sql_t)){
                                        }
                
            }
            
            
        }
    }
 
      $sql = "SELECT * FROM `users` WHERE `id` = '$base_id'" ;
          if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $total_referal_commission_1 =$row['total_referal_commission'];
            if($total_referal_commission_1 == "" || empty($total_referal_commission_1)){
                $total_referal_commission_1 = 0;
            }
        }
    }
          }
            
                     
        $sql = "SELECT * FROM `deposit_list` WHERE u_id = '$base_id'" ;
          if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $all_depos[] = $row;
            
        }
    }
          }  
    
        $sql = "SELECT * FROM `history` WHERE u_id = '$base_id'" ;
          if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $all_withd[] = $row;
            
        }
    }
          }  
    $last_investment_v = 0;
    $account_balance_v = $total_referal_commission_1;
    $total_earnings_v = $total_referal_commission_1;
    $all_time_investments = 0;
//    print_r($all_depos);
    if(!empty($all_depos) && !empty($all_depos[0])){
        $de_counter = 0;
        foreach($all_depos as $all_depo){
            $all_depo_id = $all_depo['id'];
            $all_depo_type = $all_depo['type'];
            $all_depo_amount = $all_depo['amount'];
            $all_depo_total_amount = $all_depo['total_amount'];
            $all_depo_status = $all_depo['status'];
            $de_counter = $de_counter + 1;
            
            $all_time_investments = $all_time_investments + $all_depo_amount;
            
            if($de_counter == 0){
                $last_investment_v = $all_depo_amount;
            }
            if($all_depo_status == "pending"){
                $account_balance_v = $account_balance_v + $all_depo_total_amount;
                $total_earnings_v = $total_earnings_v + ($all_depo_total_amount - $all_depo_amount);
            }
            
            
            
        }
    }
    
    $last_withdrawal_v = 0;
    $pending_withdrawal_v = 0;
    $total_withdrawal_v = 0;
//    print_r($all_withd);
        if(!empty($all_withd) && !empty($all_withd[0])){
        $wi_counter = 0;
        foreach($all_withd as $all_with){
            $all_with_id = $all_depo['id'];
            $all_with_amount = $all_depo['amount'];
            $all_with_status = $all_depo['status'];
            $wi_counter = $wi_counter + 1;
            
            $total_withdrawal_v = $total_withdrawal_v + $all_with_amount;
            
            if($wi_counter == 0){
                $last_withdrawal_v = $all_with_amount;
            }
            if($all_depo_status == "pending"){
                $pending_withdrawal_v = $pending_withdrawal_v + $all_with_amount;
            }
            
            
            
        }
    }
//    echo "<br>Depo id: $depo_id<br>";
    $sql_t = "UPDATE `users` SET `account_balance`='$account_balance_v', `earned_total`='$total_earnings_v', `total_withdrawal`='$total_withdrawal_v', `last_withdrawal`='$last_withdrawal_v', `pending_withdrawal`='$pending_withdrawal_v', `last_deposit`='$last_investment_v', `total_deposit`='$all_time_investments' WHERE `id`= '$base_id'";    
                                        if(mysqli_query($link, $sql_t)){
//                                            echo "<br> updated";
                                        }
    
    
    



}

?>






 <?php
if(isset($_SESSION['id'])){   
    $id= $_SESSION['id'];
    
  $sql = "SELECT * FROM `users` WHERE `id` = '$id'" ;
          if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            
                     $id = $row['id'];//
    $full_name =$row['full_name']; 
    $username =$row['username']; 
    $email =$row['email']; 
    $phone =$row['phone']; 
    $password =$row['password']; 
    $country =$row['country']; 
    $ip_address =$row['ip_address']; 
    $ref =$row['ref']; 
    $account_status =$row['account_status']; 
    $login_count =$row['login_count']; 
    $registered_at =$row['registered_at']; 
    $reg_d = explode(' ', $registered_at);   
    $reg_d =  $reg_d[0];
    $rd_split = explode('-', $reg_d);
    $reg_stamp = strtotime($rd_split[1] . '-' . $rd_split[0] . '-' . $rd_split[2] . ' ' . $reg_d[1]);
//    echo $reg_stamp;
    $c_time = time();
    $elapse_time = $reg_stamp + 86400;
//    $regt_diff = $c_time - $reg_stamp;
    $regt_diff = $elapse_time - $c_time;
//    if(($c_time - $reg_stamp) > 86400){
//        echo "Exceeds";
//    }else{
//        echo "Does not exceed";
//    }
    $account_balance =$row['account_balance']; 
    $earned_total =$row['earned_total']; 
    $total_withdrawal =$row['total_withdrawal']; 
    $last_withdrawal =$row['last_withdrawal']; 
    $pending_withdrawal =$row['pending_withdrawal']; 
    $active_deposit =$row['active_deposit']; 
    $last_deposit =$row['last_deposit']; 
    $total_deposit =$row['total_deposit']; 
    $bitcoin_wallet_address =$row['bitcoin_wallet_address']; 
//    $ethereum_wallet_address =$row['ethereum_wallet_address']; 
    $detect_ip =$row['detect_ip']; 
    $detect_browser =$row['detect_browser']; 
    $no_of_referals =$row['no_of_referals']; 
    $active_referals =$row['active_referals']; 
    $total_referal_commission =$row['total_referal_commission']; 
    $count_down =$row['count_down']; 
    $last_seen =$row['last_seen']; 
    $new_seen = date("M-d-Y h:i:s A", time());
            
        $sql_t = "UPDATE `users` SET `last_seen`='$new_seen' WHERE `email`= '$email'";    
    if(mysqli_query($link, $sql_t)){
    }
        
        }
        //close the result set
        mysqli_free_result($result);

    }
}  
    if($login_count == 0){
            $new_login_count = $login_count + 1;
     $sql_t = "UPDATE `users` SET `login_count`='$new_login_count' WHERE `id`= '$id'";    
                                        if(mysqli_query($link, $sql_t)){

                                        } 
    }

    
    
}

  $sql = "SELECT * FROM `admin` WHERE `id` = 1" ;
          if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $support_email =$row['support_email']; //
    $support_phone =$row['support_phone']; //
        
        }
        //close the result set
        mysqli_free_result($result);

    }
}  
?> 
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="stylesheets/bootstrap.min.css">
    <link rel="stylesheet" href="stylesheets/owl.carousel.min.css">
    <link rel="stylesheet" href="stylesheets/styles.css">
    <title>AstroFXC</title>

</head>

<body>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5fe260c2a8a254155ab59eaa/1eq64k3c2';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
    <svg class="svgSprite" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
            <linearGradient id="linear-gradient-chekmark" x1="235.02" y1="158.14" x2="247.31" y2="158.14" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#ffce6c" />
                <stop offset="1" stop-color="#ffc04a" />
            </linearGradient>
            <linearGradient id="linear-gradient-profit-home" x1="140.21" y1="240.33" x2="284.44" y2="240.33" gradientTransform="matrix(0.86, 0.51, -0.51, 0.86, 151.97, -63.26)" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#9f95ed" />
                <stop offset="1" stop-color="#a567a3" />
            </linearGradient>
            <linearGradient id="linear-gradient-profit-home-2" x1="157.49" y1="208.57" x2="340.67" y2="208.57" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#ff6873" />
                <stop offset="1" stop-color="#ff896c" />
            </linearGradient>
            <linearGradient id="linear-gradient-profit-home-3" x1="157.49" y1="234.53" x2="271.6" y2="234.53" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#69d2cd" />
                <stop offset="1" stop-color="#44a5d5" />
            </linearGradient>
            <linearGradient id="linear-gradient-affiliate" x1="247.85" y1="194.41" x2="265.41" y2="194.41" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#44a5d5" />
                <stop offset="1" stop-color="#69d2cd" />
            </linearGradient>
            <linearGradient id="linear-gradient-affiliate-2" x1="172.55" y1="160.18" x2="200.05" y2="160.18" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#ff6873" />
                <stop offset="1" stop-color="#ff896c" />
            </linearGradient>
            <linearGradient id="linear-gradient-affiliate-3" x1="241.13" y1="259.4" x2="265.12" y2="259.4" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#ffce6c" />
                <stop offset="1" stop-color="#ffc04a" />
            </linearGradient>
            <linearGradient id="linear-gradient-affiliate-4" x1="152.47" y1="223.86" x2="182.69" y2="223.86" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#9f95ed" />
                <stop offset="1" stop-color="#a567a3" />
            </linearGradient>
            <linearGradient id="linear-gradient-calculate" x1="57" y1="434.67" x2="57" y2="252.28" gradientTransform="matrix(-1, 0, 0, 1, 418.88, -171.45)" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#44a5d5" />
                <stop offset="1" stop-color="#69d2cd" />
            </linearGradient>
            <linearGradient id="linear-gradient-calculate-2" x1="159.33" y1="434.67" x2="159.33" y2="329.18" xlink:href="#linear-gradient-calculate" />
            <linearGradient id="linear-gradient-calculate-3" x1="261.67" y1="434.67" x2="261.67" y2="257.16" xlink:href="#linear-gradient-calculate" />
            <linearGradient id="linear-gradient-calculate-4" x1="364" y1="434.67" x2="364" y2="300.47" xlink:href="#linear-gradient-calculate" />
            <linearGradient id="linear-gradient-calculate-5" x1="15.98" y1="248.76" x2="413.63" y2="248.76" gradientTransform="matrix(-1, 0, 0, 1, 418.88, -171.45)" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#ff6873" />
                <stop offset="1" stop-color="#ff896c" />
            </linearGradient>
            <linearGradient id="linear-gradient-about" x1="856.9" y1="409" x2="937.27" y2="409" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#ff535d" />
                <stop offset="1" stop-color="#ff7555" />
            </linearGradient>
            <linearGradient id="linear-gradient-star" y1="412.19" x2="476.14" y2="412.19" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#44a5d5" />
                <stop offset="1" stop-color="#69d2cd" />
            </linearGradient>
            <linearGradient id="linear-gradient-star-2" x1="1298.49" y1="225.69" x2="1721.37" y2="225.69" xlink:href="#linear-gradient-star" />
            <linearGradient id="linear-gradient-star-3" x1="156.97" y1="214.76" x2="319.17" y2="214.76" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#ff6873" />
                <stop offset="1" stop-color="#ff896c" />
            </linearGradient>
            <linearGradient id="linear-gradient-grow" x1="859.12" y1="411.16" x2="933.57" y2="411.16" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#ff6873" />
                <stop offset="1" stop-color="#ff896c" />
            </linearGradient>
            <linearGradient id="linear-gradient-grow-2" x1="910.94" y1="382.25" x2="932.91" y2="382.25" gradientTransform="matrix(0.99, 0.13, -0.13, 0.99, -788.33, -480.07)" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#ffce6c" />
                <stop offset="1" stop-color="#ffc04a" />
            </linearGradient>
            <linearGradient id="linear-gradient-grow-3" x1="846.01" y1="384" x2="866.63" y2="384" gradientTransform="matrix(0.99, -0.17, 0.17, 0.99, -899.41, -209.73)" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#9f95ed" />
                <stop offset="1" stop-color="#a567a3" />
            </linearGradient>
            <linearGradient id="linear-gradient-grow-4" x1="870.66" y1="443.77" x2="891.46" y2="443.77" gradientTransform="translate(-686.46 -592.2) rotate(16.26)" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#44a5d5" />
                <stop offset="1" stop-color="#69d2cd" />
            </linearGradient>
            <linearGradient id="linear-gradient-intro" x1="130.68" y1="75.64" x2="154.58" y2="75.64" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#44a5d5" />
                <stop offset="1" stop-color="#69d2cd" />
            </linearGradient>
            <linearGradient id="linear-gradient-intro-2" x1="105.21" y1="143.23" x2="129.21" y2="143.23" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#ffce6c" />
                <stop offset="1" stop-color="#ffc04a" />
            </linearGradient>
            <linearGradient id="linear-gradient-intro-3" x1="154.81" y1="112.74" x2="172" y2="112.74" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#ff6873" />
                <stop offset="1" stop-color="#ff896c" />
            </linearGradient>
            <linearGradient id="linear-gradient-intro-4" x1="50.78" y1="24.68" x2="72.71" y2="24.68" xlink:href="#linear-gradient-intro-2" />
            <linearGradient id="linear-gradient-intro-5" x1="47.31" y1="54.24" x2="62.61" y2="54.24" xlink:href="#linear-gradient-intro" />
            <linearGradient id="linear-gradient-intro-6" x1="101.95" y1="48.78" x2="118.56" y2="48.78" xlink:href="#linear-gradient-intro-3" />
            <linearGradient id="linear-gradient-intro-7" x1="77.72" y1="131.52" x2="89.84" y2="131.52" xlink:href="#linear-gradient-intro-2" />
            <linearGradient id="linear-gradient-intro-8" x1="114.19" y1="108.57" x2="126.93" y2="108.57" xlink:href="#linear-gradient-intro-3" />
            <linearGradient id="linear-gradient-intro-9" x1="14.68" y1="143.21" x2="29.59" y2="143.21" xlink:href="#linear-gradient-intro-3" />
            <linearGradient id="linear-gradient-intro-10" x1="9.58" y1="65.36" x2="39.8" y2="65.36" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#9f95ed" />
                <stop offset="1" stop-color="#a567a3" />
            </linearGradient>
            <linearGradient id="linear-gradient-intro-11" x1="136.24" y1="34.56" x2="152.97" y2="34.56" xlink:href="#linear-gradient-intro-10" />
            <linearGradient id="linear-gradient-intro-12" x1="78.01" y1="158.33" x2="95.87" y2="158.33" xlink:href="#linear-gradient-intro" />
            <linearGradient id="linear-gradient-intro-13" x1="40.42" y1="124.13" x2="64.82" y2="124.13" xlink:href="#linear-gradient-intro" />
            <linearGradient id="linear-gradient-intro-14" x1="19.11" y1="104.47" x2="35.38" y2="104.47" xlink:href="#linear-gradient-intro-2" />
            <linearGradient id="linear-gradient-news" x1="867.6" y1="409.9" x2="931.05" y2="409.9" gradientTransform="translate(701.25 -555.89) rotate(53.88)" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#44a5d5" />
                <stop offset="1" stop-color="#69d2cd" />
            </linearGradient>
            <linearGradient id="linear-gradient-helpcenter" x1="864.82" y1="410.54" x2="925.19" y2="410.54" gradientTransform="translate(701.25 -555.89) rotate(53.88)" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#44a5d5" />
                <stop offset="1" stop-color="#69d2cd" />
            </linearGradient>
            <linearGradient id="linear-gradient-paymetnProofs" x1="867.72" y1="412.74" x2="930.92" y2="412.74" gradientTransform="translate(701.25 -555.89) rotate(53.88)" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#44a5d5" />
                <stop offset="1" stop-color="#69d2cd" />
            </linearGradient>
        </defs>
        <g id="about-services" viewBox="0 0 48.92 37.25">
            <path d="M449.14,355.08H426.05a7.46,7.46,0,0,0-4.33,1.38l-7.91,5.6a2.27,2.27,0,0,1-3.59-1.85v-25a7.5,7.5,0,0,1,7.5-7.5h31.42a7.5,7.5,0,0,1,7.5,7.5v12.35A7.5,7.5,0,0,1,449.14,355.08Z" transform="translate(-408.97 -326.48)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
            <circle cx="14.53" cy="11.59" r="2.4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
            <path d="M419.38,348.32a4.13,4.13,0,0,1,8.25,0" transform="translate(-408.97 -326.48)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
            <line x1="24.03" y1="11.79" x2="38.65" y2="11.79" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
            <line x1="24.46" y1="17.51" x2="30.9" y2="17.51" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
            <line x1="15.76" y1="36" x2="17.15" y2="36" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
            <line x1="21.29" y1="36" x2="24.86" y2="36" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
            <line x1="29.01" y1="36" x2="29.98" y2="36" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
        </g>
        <g id="about-security" viewBox="0 0 48.92 37.25">
            <rect x="1.25" y="1.25" width="46.42" height="34.75" rx="8.33" ry="8.33" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
            <circle cx="20.08" cy="18.32" r="6.95" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
            <path d="M528.83,341.91h.33a2,2,0,0,1,2,2v3.77a0,0,0,0,1,0,0H526.8a0,0,0,0,1,0,0v-3.77A2,2,0,0,1,528.83,341.91Z" transform="translate(374.73 -510.67) rotate(90)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
            <path d="M507.11,341.91h4.38a0,0,0,0,1,0,0v3.6a2.19,2.19,0,0,1-2.19,2.19h0a2.19,2.19,0,0,1-2.19-2.19v-3.6A0,0,0,0,1,507.11,341.91Z" transform="translate(355.04 -490.98) rotate(90)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
            <path d="M516.79,332.07h4.71a0,0,0,0,1,0,0v3.8a2,2,0,0,1-2,2h-.72a2,2,0,0,1-2-2v-3.8a0,0,0,0,1,0,0Z" transform="translate(539.23 343.44) rotate(-180)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
            <path d="M17.73,25.27h4.71a0,0,0,0,1,0,0v3.8a2,2,0,0,1-2,2h-.72a2,2,0,0,1-2-2v-3.8a0,0,0,0,1,0,0Z" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
            <path d="M543.42,335.35h0a2.54,2.54,0,0,1,2.54,2.54V342a0,0,0,0,1,0,0h-5.08a0,0,0,0,1,0,0v-4.09a2.54,2.54,0,0,1,2.54-2.54Z" transform="translate(-294.32 555.6) rotate(-90)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
            <path d="M543.42,347.39h0a2.54,2.54,0,0,1,2.54,2.54V354a0,0,0,0,1,0,0h-5.08a0,0,0,0,1,0,0v-4.09a2.54,2.54,0,0,1,2.54-2.54Z" transform="translate(-306.36 567.64) rotate(-90)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
            <path d="M517.15,344.54a2,2,0,0,1,4,0" transform="translate(-499.07 -326.48)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
        </g>
        <g id="about-guid" viewBox="0 0 35.64 47.89">
            <path d="M469.2,361.38V335.93a8.19,8.19,0,0,1,8.19-8.2h21.77a3.17,3.17,0,0,1,3.17,3.18V358" transform="translate(-467.95 -326.48)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
            <path d="M474.36,368.33a5.16,5.16,0,0,1-5.16-5.16h0a5.16,5.16,0,0,1,5.16-5.17h28v7.44a2.89,2.89,0,0,1-2.89,2.89H487.67" transform="translate(-467.95 -326.48)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
            <polygon points="11.93 36.68 18.43 36.68 18.43 46.64 15.18 44.77 11.93 46.64 11.93 36.68" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
            <circle cx="18.02" cy="16.75" r="8.33" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
            <polyline points="14.92 17.1 17.18 19.37 21.8 14.75" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
        </g>
        <g id="chekmark" viewBox="0 0 12.29 12.06">
            <path d="M242.54,153.05l0,.09a1.46,1.46,0,0,0,1.8.87l.1,0a1.48,1.48,0,0,1,1.71,2.15l-.05.09a1.48,1.48,0,0,0,.45,1.95l.08.06a1.47,1.47,0,0,1-.61,2.67l-.1,0a1.48,1.48,0,0,0-1.25,1.56v.11a1.47,1.47,0,0,1-2.47,1.19l-.08-.07a1.48,1.48,0,0,0-2,0l-.08.07a1.47,1.47,0,0,1-2.47-1.19v-.11a1.48,1.48,0,0,0-1.25-1.56l-.1,0a1.47,1.47,0,0,1-.61-2.67l.08-.06a1.48,1.48,0,0,0,.45-1.95l-.06-.09a1.48,1.48,0,0,1,1.72-2.15l.09,0a1.47,1.47,0,0,0,1.81-.87l0-.09A1.47,1.47,0,0,1,242.54,153.05Z" transform="translate(-235.02 -152.11)" fill="url(#linear-gradient-chekmark)" />
            <polyline points="4.14 6.11 5.66 7.63 8.27 5.01" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" />
        </g>
        <g id="investIcon" viewBox="0 0 22.74 22.02">
            <path d="M723.53,423.21a9.92,9.92,0,0,1-3.86.72c-3.32,0-6-1.38-6-3.08V417.1" transform="translate(-712.67 -407.5)" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></path>
            <path d="M725.67,425.62c0,1.7-2.69,2.9-6,2.9s-6-1.38-6-3.09v-3.75" transform="translate(-712.67 -407.5)" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></path>
            <ellipse cx="7" cy="4.08" rx="6" ry="3.08" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></ellipse>
            <path d="M723,418.8a10.52,10.52,0,0,1-3.32.51c-3.32,0-6-1.38-6-3.08v-3.75" transform="translate(-712.67 -407.5)" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></path>
            <line x1="13" y1="4.08" x2="13" y2="7.69" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></line>
            <circle cx="16.03" cy="13.29" r="5.71" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></circle>
            <line x1="13.96" y1="13.29" x2="18.25" y2="13.29" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></line>
            <line x1="16.1" y1="11.14" x2="16.1" y2="15.43" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></line>
        </g>
        <g id="btcIcon" viewBox="0 0 7.51 13.67">
            <path d="M526.21,407v1.82h-2.59v4.26h3.58a2.14,2.14,0,0,0,2.13-2.13h0a2.13,2.13,0,0,0-2.13-2.13h-1" transform="translate(-522.72 -406.14)" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
            <path d="M523.62,417.37v-4.25h3.58a2.13,2.13,0,0,1,2.13,2.12h0a2.13,2.13,0,0,1-2.13,2.13h-.32v1.54" transform="translate(-522.72 -406.14)" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
        </g>
        <g id="ethIcon" viewBox="0 0 12.13 14.72">
            <polygon points="6.19 0.75 0.75 7.62 6.1 13.97 11.38 7.69 6.19 0.75" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
            <polyline points="1.75 7.62 6.07 9.92 10.38 7.69" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
        </g>
        <g id="investColor" viewBox="0 0 49.05 57.09">
            <g opacity="0.1">
                <path d="M694.23,432.21c.65,2.23-1.93,6.76-4.76,8.35-1.67.94-4.24,1.75-6.09,1.37-10.31-.41-19.53-3.75-25.72-11.09a21.21,21.21,0,0,1-4.17-7.72,25,25,0,0,1-.88-4.33c-.18-13.58,3.71-33.93,19.67-33.82,8.47-.46,14.81,4,22.38,8.76a19.91,19.91,0,0,1,3.83,4,15.49,15.49,0,0,1,3.15,10.6,36.21,36.21,0,0,1-2.42,11,29.69,29.69,0,0,1-2.13,3.85C696.27,424.45,693,428.05,694.23,432.21Z" transform="translate(-652.61 -384.93)" fill="#ff866e" />
            </g>
            <path d="M677.67,418.18a10,10,0,0,1-3.87.72c-3.31,0-6-1.38-6-3.08v-3.75" transform="translate(-652.61 -384.93)" fill="none" stroke="#ff846d" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
            <path d="M679.8,420.59c0,1.7-2.68,2.9-6,2.9s-6-1.38-6-3.09v-3.75" transform="translate(-652.61 -384.93)" fill="none" stroke="#ff846d" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
            <ellipse cx="21.2" cy="21.62" rx="6" ry="3.08" fill="none" stroke="#ff846d" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
            <path d="M677.13,413.77a10.59,10.59,0,0,1-3.33.51c-3.31,0-6-1.38-6-3.08v-3.75" transform="translate(-652.61 -384.93)" fill="none" stroke="#ff846d" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
            <line x1="27.2" y1="21.62" x2="27.2" y2="25.23" fill="none" stroke="#ff846d" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
            <circle cx="30.23" cy="30.82" r="5.71" fill="none" stroke="#ff846d" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
            <line x1="28.16" y1="30.82" x2="32.45" y2="30.82" fill="none" stroke="#ff846d" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
            <line x1="30.3" y1="28.68" x2="30.3" y2="32.97" fill="none" stroke="#ff846d" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
        </g>
        <g id="withdrawColor" viewBox="0 0 58.58 50.99">
            <g opacity="0.1">
                <path d="M621.14,396.78a33.08,33.08,0,0,1,6.27,17.94c0,.91,0,1.84,0,2.76a32.46,32.46,0,0,1-3.68,13.46,19.65,19.65,0,0,1-1.91,2.29,18.19,18.19,0,0,1-2.16,1.65,18.45,18.45,0,0,1-2.26,1.23c-8.52,3.76-17.46,0-25.38-1.43l-2.64-.44a79,79,0,0,1-10.63-2.43,17.85,17.85,0,0,1-9.6-13.59,22.2,22.2,0,0,1-.25-4.6,20,20,0,0,1,.75-4.53,18.33,18.33,0,0,1,1.06-2.84c4.68-7,12-10.91,19.25-15.54a18.46,18.46,0,0,1,4.6-2.57c6.52-2.53,14.37-1.56,20.69,2.25.59.5,1.15,1.05,1.72,1.63s1.13,1.19,1.71,1.83,1.19,1.32,1.82,2A10.16,10.16,0,0,1,621.14,396.78Z" transform="translate(-568.84 -386.74)" fill="#9f93ea" />
            </g>
            <circle cx="39.54" cy="29.71" r="5.71" fill="none" stroke="#a184d1" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
            <polyline points="37.4 28.57 39.66 30.84 41.81 28.68" fill="none" stroke="#a184d1" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
            <path d="M602.91,418.65l-10,3.3a3.75,3.75,0,0,1-4.74-2.39l-1.77-5.39a3.74,3.74,0,0,1,2.39-4.73l13.79-4.54a3.74,3.74,0,0,1,4.73,2.39l1.13,3.44" transform="translate(-568.84 -386.74)" fill="none" stroke="#a184d1" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
            <circle cx="28.44" cy="26.61" r="3.01" fill="none" stroke="#a184d1" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
            <path d="M591.3,422.14l2.2,1a7.68,7.68,0,0,0,5.36.3l5.87-1.82" transform="translate(-568.84 -386.74)" fill="none" stroke="#a184d1" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
        </g>
        <g id="depositIcon" viewBox="0 0 23.26 23.93">
            <polyline points="5.07 6.83 6.41 8.17 8.33 5.61" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></polyline>
            <line x1="11.65" y1="7" x2="16.27" y2="7" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></line>
            <polyline points="5.07 11.79 6.41 13.13 8.33 10.57" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></polyline>
            <line x1="11.65" y1="12.17" x2="18.87" y2="12.17" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></line>
            <polyline points="5.07 17.11 6.41 18.45 8.33 15.9" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></polyline>
            <line x1="11.65" y1="17.29" x2="16.96" y2="17.29" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></line>
            <rect x="1" y="1" width="21.26" height="21.93" rx="4.87" ry="4.87" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></rect>
        </g>
        <g id="earningHistory" viewBox="0 0 23.13 27.23">
            <path d="M5.32,5.1H18a4.14,4.14,0,0,1,4.14,4.14V21.83a4.4,4.4,0,0,1-4.4,4.4H5.4A4.4,4.4,0,0,1,1,21.83V9.42A4.32,4.32,0,0,1,5.32,5.1Z" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></path>
            <rect x="5.35" y="9.61" width="4.69" height="4.69" rx="1.7" ry="1.7" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></rect>
            <rect x="12.94" y="9.61" width="4.69" height="4.69" rx="1.7" ry="1.7" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></rect>
            <rect x="5.35" y="17.2" width="4.69" height="4.69" rx="1.7" ry="1.7" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></rect>
            <rect x="12.94" y="17.2" width="4.69" height="4.69" rx="1.7" ry="1.7" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></rect>
            <path d="M705.81,407.52v-1.59a1.82,1.82,0,0,1,1.83-1.82h0a1.82,1.82,0,0,1,1.83,1.82v1.59" transform="translate(-699.76 -403.11)" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></path>
            <path d="M712.47,407.52v-1.59a1.82,1.82,0,0,1,1.83-1.82h0a1.82,1.82,0,0,1,1.83,1.82v1.59" transform="translate(-699.76 -403.11)" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></path>
        </g>
        <g id="searchIcon" viewBox="0 0 9.24 11.31">
            <path d="M494.71,414.94a3.59,3.59,0,0,1-1.95-2.31,3.5,3.5,0,0,1,1-3.47,3.55,3.55,0,1,1,4.59,5.4.4.4,0,0,0-.1.56l1.85,2.55" transform="translate(-491.73 -407.26)" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
        </g>
        <g id="settingIcon" viewBox="0 0 29.7 32.75">
            <path d="M693.25,436.38a11.39,11.39,0,0,0-.16-1.86l.64-.37a4,4,0,0,0,1.46-5.46h0a4,4,0,0,0-5.46-1.47l-.63.37a11.34,11.34,0,0,0-3.22-1.85V425a4,4,0,0,0-4-4h0a4,4,0,0,0-4,4v.74a11.26,11.26,0,0,0-3.23,1.85l-.63-.37a4,4,0,0,0-5.46,1.47h0a4,4,0,0,0,1.46,5.46l.64.37a10.83,10.83,0,0,0,0,3.71l-.64.37a4,4,0,0,0-1.46,5.46h0a4,4,0,0,0,5.46,1.47l.63-.37a11.26,11.26,0,0,0,3.23,1.85v.74a4,4,0,0,0,4,4h0a4,4,0,0,0,4-4V447a11.34,11.34,0,0,0,3.22-1.85l.63.37a4,4,0,0,0,5.46-1.47h0a4,4,0,0,0-1.46-5.46l-.64-.37A11.36,11.36,0,0,0,693.25,436.38Z" transform="translate(-667.02 -420)" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></path>
            <circle cx="14.85" cy="16.38" r="4.94" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></circle>
        </g>
        <g id="lockIcon" viewBox="0 0 17.88 21.09">
            <path d="M703.38,459h-10.5a2.69,2.69,0,0,1-2.69-2.69v-4.78a2.69,2.69,0,0,1,2.69-2.69h10.5a2.69,2.69,0,0,1,2.69,2.69v4.78A2.69,2.69,0,0,1,703.38,459Zm-5.25-6.22v2.72m5.2-7.57,0-3.62c-0.24-5.89-9.65-6.16-9.65,1.09" transform="translate(-689.19 -438.88)" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.5" />
        </g>
        <g id="profitPercentHome" viewBox="0 0 213.08 194.03">
            <path d="M345.24,233.69a63.34,63.34,0,0,1-3.15,27.76c-3.39,9.32-8.87,17.37-14.1,23.78a40.7,40.7,0,0,1-18.63,13.91c-7.85,3-16.94,4.75-26.37,5.85-9.22,1-18.75.22-27.78-1.15-9-1.7-17.85-3.65-26.68-6.06-8.56-1.36-16.52-2.43-23.68-2.84-9-.52-17-1.6-23.94-4.73s-12.84-9.08-17.7-17.16a148.74,148.74,0,0,1-8.66-18.19c-2.5-6.24-4.68-12.44-6.59-18.82-2.19-6.09-4.44-12.7-7-20.2a99.45,99.45,0,0,1-5.5-28.34c0-9.94,2-18.4,6.12-24.83s10.34-11,17.87-14.17,16-5.37,24.42-7.35,16.38-4.33,24-6.4a90,90,0,0,1,23.93-3.21,116.19,116.19,0,0,1,21.17,2c7.28,1.27,15.26,2.77,24.44,3.6s19,1.09,27.37,2.36,14.32,4.36,17.46,9.57,4.74,12.73,6.94,22,5.13,19.44,8.06,29.72q2.79,8.66,4.83,16.9A156.77,156.77,0,0,1,345.24,233.69Z" transform="translate(-133.99 -120.47)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" stroke-width="3" />
            <path d="M270.55,281.16c-1.06,11.33-3.86,19.87-8.56,26a31.32,31.32,0,0,1-11.5,5.41,74.42,74.42,0,0,1-15.77,1.86c-6.12.17-13.5-.11-21.14-.69a179.18,179.18,0,0,1-23-3.23,154.74,154.74,0,0,1-19.06-5.12,79,79,0,0,1-14.64-6.65c-8.35-5-13.78-11.26-17-18.37a52.61,52.61,0,0,1-4.45-22.29,69.14,69.14,0,0,1,4.27-22.72,140.75,140.75,0,0,1,11.8-24.22,155.78,155.78,0,0,1,16.89-23.53c6.07-6.78,12.74-11.53,19.73-13.71a36.7,36.7,0,0,1,21.82.27c7.46,2.31,14.82,6.26,22.36,11.32a173.8,173.8,0,0,1,21,16.18,46.57,46.57,0,0,1,13.32,19.68c2.45,7.42,2.77,16,3.09,25.46a77.75,77.75,0,0,1,1.81,16.81C271.56,269.53,271.09,275.5,270.55,281.16Z" transform="translate(-133.99 -120.47)" fill="url(#linear-gradient-profit-home)" />
            <path d="M338.67,200c-4.66,13.83-11.94,36.4-16.11,50-9,29.34-30.07,34-40.83,37.9s-24.26,6.66-39.57,8.13-29.33.52-40.69-2.67A56.15,56.15,0,0,1,174,275.56c-6.48-9.54-11.25-21.22-14.11-34.79a167.59,167.59,0,0,1-1.64-45,136.16,136.16,0,0,1,6.56-31.33,86,86,0,0,1,11.64-23.09c9.1-12.23,21.31-19.72,35-20.73,9.14-.67,18.63,1.58,28.35,6.28,9.83,4.08,19.72,9.64,30.64,13.22,11.36,3.73,22.95,7.82,34.27,10.4C318.67,153.67,348.67,170.33,338.67,200Z" transform="translate(-133.99 -120.47)" fill="url(#linear-gradient-profit-home-2)" />
            <path d="M271.6,263.64c0,5.89-.51,11.86-1,17.52a76.91,76.91,0,0,1-1.68,10.53A195.78,195.78,0,0,1,242.16,296c-15.32,1.46-29.33.52-40.68-2.67a56.06,56.06,0,0,1-27.43-17.77c-6.48-9.54-11.26-21.22-14.12-34.79a166.36,166.36,0,0,1-2.09-39.42,134.08,134.08,0,0,1,10.62-13.72c6.07-6.78,12.74-11.53,19.73-13.71a36.7,36.7,0,0,1,21.82.27c7.46,2.31,14.82,6.26,22.36,11.32s15.32,9.92,21,16.18c13.29,14.64,16.09,35.65,16.41,45.14A79,79,0,0,1,271.6,263.64Z" transform="translate(-133.99 -120.47)" fill="url(#linear-gradient-profit-home-3)" />
        </g>
        <g id="affiftProgram" viewBox="0 0 447.77 441.51">
            <g opacity="0.05">
                <path d="M378.44,204.25c-24.28,25.63-56.22,42.93-81.17,63.6-25.74,20.14-44.49,43.64-60.74,69.28C219.06,362.5,204.3,385.22,186,396.28c-18,11.48-39.5,11.3-63.25.82-25.7-13.37-42.86-43-54.38-71.8-11.82-29.36-18-58-28.84-81.13C22.14,194.28-18.75,162.6-34.66,98.69-39.35,64.23-23.37,33.81-.87,13.05,21.74-8.16,50.87-19.7,74.73-27.1c25.91-6.18,46.57-8.55,69.12-8.48,22.69.37,47.25,3.18,84,14.45C267-7.56,305.27,24.2,332.3,50c27.8,26.72,44.39,47.51,58,59.23C403,122.43,412,130.82,411.24,145.75,410.64,160,400.16,180.87,378.44,204.25Z" transform="translate(35.98 36.08)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" />
            </g>
            <g opacity="0.14">
                <path d="M12.18,23.71C33.44,4.11,60.42-7.57,83.24-13.87a215.24,215.24,0,0,1,64.86-8.19c21.29.44,44.41,2.31,78.15,13.3,36.78,12,72,42.13,97,66.32,25.73,25.08,41.28,44.51,53.11,56.61s19.53,20.52,18.6,34.61c-.75,13.52-10.54,32.93-30.58,54.6-22.59,24-52,40.65-75.49,59.56a246.18,246.18,0,0,0-29.63,27.83c-10.29,11.46-19,23.73-27.49,36.18-16,23.52-30.58,43.49-47.72,53.49-17,9.91-37.09,10.33-58.69-.35-24.22-12-39.75-40.37-50.65-67.18-11.32-27.84-18.65-54.23-27.63-76.74-18-45.29-55.87-74.74-66.6-134C-25.18,70.92-8.59,42.84,12.18,23.71Z" transform="translate(35.98 36.08)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" stroke-width="1.18" opacity="0.94" />
            </g>
            <g opacity="0.22">
                <path d="M25.22,34.36c19.83-18.1,45-29,66.52-35a202.3,202.3,0,0,1,60.6-7.9c19.9.34,41.36,2.08,72.3,12.15,34.17,11.12,66.71,38.87,89.6,61.46,23.71,23.39,37.58,42.11,48.2,54,10.31,11.55,17.33,19.48,16.29,32.74-.9,12.73-10,30.72-28.38,50.69-20.89,22.41-48,38-69.79,55.52A244.69,244.69,0,0,0,253,283.72C243.28,294.3,235,305.49,227,316.78c-15.09,21.33-28.78,39.1-44.9,47.83-15.82,8.56-34.33,8.6-54.13-1.52-22.33-11.42-36.69-37.78-46.93-62.58-10.85-26.3-18.08-51-26.4-72.35-16.2-41.62-50-68.67-59-122.43C-9.14,77.3,6.09,51.77,25.22,34.36Z" transform="translate(35.98 36.08)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" stroke-width="1.36" opacity="0.87" />
            </g>
            <g opacity="0.31">
                <path d="M38.26,45C56.71,28.47,80,18.29,100.25,12.6A189.87,189.87,0,0,1,156.59,5C175.1,5.24,194.9,6.85,223,16c31.54,10.25,61.34,35.66,82.17,56.6,21.64,21.76,33.87,39.69,43.29,51.4,8.84,11,15.13,18.44,14,30.87-1.05,11.95-9.46,28.51-26.16,46.78-19.19,20.79-44,35.38-64.11,51.48a241.94,241.94,0,0,0-25.57,23.55A332.84,332.84,0,0,0,222.3,306.6c-14.16,19.15-27,34.73-42.09,42.17-14.66,7.22-31.58,6.88-49.58-2.69-20.43-10.86-33.63-35.18-43.19-58-10.39-24.76-17.53-47.73-25.18-68C47.9,182.21,18.2,157.55,10.81,109.25,6.89,83.68,20.83,60.75,38.26,45Z" transform="translate(35.98 36.08)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" stroke-width="1.55" opacity="0.81" />
            </g>
            <g opacity="0.4">
                <path d="M51.3,55.66c17-15,38.48-24.44,57.46-29.82a189.81,189.81,0,0,1,52.07-7.33c17.12-.2,35.27,1.64,60.6,9.85,28.93,9.38,56,32.46,74.75,51.75,19.58,20.12,30.15,37.21,38.37,48.78,7.39,10.4,12.94,17.42,11.67,29-1.2,11.17-8.93,26.31-24,42.88-17.5,19.18-40.07,32.74-58.43,47.44a245,245,0,0,0-23.54,21.4,336.33,336.33,0,0,0-22.74,26.82c-13.22,17-25.16,30.35-39.29,36.51-13.47,5.88-28.81,5.14-45-3.86-18.54-10.31-30.58-32.59-39.47-53.35-9.93-23.22-17-44.48-24-63.58C57.29,177.88,31.69,155.61,26,112.77,22.93,90.07,35.5,69.67,51.3,55.66Z" transform="translate(35.98 36.08)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" stroke-width="1.73" opacity="0.75" />
            </g>
            <g opacity="0.48">
                <path d="M64.35,66.32c15.57-13.54,35.22-22.17,52.91-27.25a178.1,178.1,0,0,1,47.81-7c15.73-.29,32.22,1.42,54.76,8.71,26.3,8.5,50.59,29.24,67.32,46.89,17.52,18.47,26.42,34.68,33.46,46.17,6,9.74,10.74,16.38,9.35,27.13-1.35,10.39-8.39,24.1-21.74,39-15.79,17.58-36.1,30.11-52.73,43.41A252.36,252.36,0,0,0,234,262.56c-7.85,7.93-14.67,15.89-21.16,23.7-12.27,14.76-23.32,26-36.47,30.84-12.29,4.55-26.05,3.42-40.46-5-16.64-9.76-27.52-30-35.73-48.74-9.49-21.67-16.43-41.22-22.74-59.18-10.75-30.57-32.24-50.48-36.29-87.86C39,96.45,50.2,78.61,64.35,66.32Z" transform="translate(35.98 36.08)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" stroke-width="1.91" opacity="0.68" />
            </g>
            <g opacity="0.57">
                <path d="M77.39,77c14.15-12,32-19.88,48.38-24.66a165.84,165.84,0,0,1,43.55-6.75c14.33-.4,29.17,1.19,48.9,7.55,23.69,7.64,45.23,26,59.9,42,15.45,16.84,22.71,32.09,28.54,43.57,4.59,9,8.55,15.34,7,25.25-1.5,9.61-7.86,21.9-19.53,35.06-14.1,16-32.14,27.48-47.05,39.37-7.14,5.7-13.6,11.41-19.48,17.12-7.26,7-13.59,13.93-19.58,20.57-11.33,12.58-21.47,21.63-33.66,25.19-11.08,3.24-23.29,1.67-35.9-6.2-14.75-9.22-24.48-27.39-32-44.13A585.63,585.63,0,0,1,85,196.15c-9-26.87-26.32-44.41-28.71-76.34C55,102.84,64.91,87.57,77.39,77Z" transform="translate(35.98 36.08)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" stroke-width="2.09" opacity="0.62" />
            </g>
            <g opacity="0.65">
                <path d="M90.43,87.62C103.17,77.13,119.15,70,134.27,65.54a154.51,154.51,0,0,1,39.29-6.46c12.95-.5,26.13,1,43.06,6.4,21.07,6.77,39.85,22.84,52.47,37.18,13.39,15.2,19,29.42,23.63,41,3.27,8.24,6.35,14.31,4.73,23.39-1.65,8.83-7.32,19.69-17.31,31.15C267.74,212.51,252,223,238.78,233.48c-6.37,5.07-12.16,10.09-17.46,15-6.66,6.15-12.51,12-18,17.45-10.38,10.39-19.6,17.3-30.84,19.52-9.87,2-20.53-.06-31.34-7.37-12.85-8.67-21.48-24.76-28.28-39.51-8.65-18.56-15.36-34.7-20.3-50.41C85.28,165,72.15,149.82,71.43,123.33,71.05,109.23,79.62,96.52,90.43,87.62Z" transform="translate(35.98 36.08)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" stroke-width="2.27" opacity="0.55" />
            </g>
            <g opacity="0.74">
                <path d="M103.47,98.27c11.34-9,25.47-15.29,39.31-19.49a142.54,142.54,0,0,1,35-6.18c11.56-.6,23.09.74,37.22,5.26,18.44,5.89,34.47,19.64,45,32.32,11.32,13.57,15.47,26.67,18.72,38.34,2.05,7.39,4.15,13.27,2.41,21.51-1.8,8.05-6.77,17.5-15.09,27.25-10.71,12.75-24.21,22.21-35.68,31.3-5.6,4.43-10.72,8.75-15.42,12.83-6.07,5.26-11.43,10-16.42,14.33-9.43,8.19-17.73,13-28,13.86-8.63.71-17.75-1.82-26.79-8.55-10.93-8.14-18.42-22.16-24.55-34.89-8.19-17-14.85-31.42-19.08-46-5.6-19.39-14.49-32.23-13.54-53.29C87.09,115.63,94.34,105.49,103.47,98.27Z" transform="translate(35.98 36.08)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" stroke-width="2.45" opacity="0.49" />
            </g>
            <g opacity="0.83">
                <path d="M116.52,108.93c10-7.43,22.21-13,34.76-16.92a131,131,0,0,1,30.77-5.88,81.89,81.89,0,0,1,31.36,4.1c15.83,5,29.09,16.44,37.62,27.46,9.24,11.95,12.08,23.88,13.8,35.74.95,6.51,2,12.23.11,19.64s-6.24,15.29-12.89,23.34c-9,11.14-20.24,19.57-30,27.26-4.82,3.8-9.28,7.42-13.39,10.68-5.49,4.37-10.34,8-14.83,11.21-8.48,6-15.86,8.8-25.23,8.2-7.4-.47-15-3.57-22.22-9.71-9-7.62-15.41-19.55-20.82-30.29-7.79-15.45-14.39-28.12-17.86-41.63-4-15.61-8.57-26.1-6-41.76C103.13,122,109.08,114.47,116.52,108.93Z" transform="translate(35.98 36.08)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" stroke-width="2.64" opacity="0.43" />
            </g>
            <g opacity="0.91">
                <path d="M129.56,119.58a119.09,119.09,0,0,1,30.23-14.33,118.5,118.5,0,0,1,26.5-5.6,63.94,63.94,0,0,1,25.52,2.95c13.2,4.16,23.7,13.26,30.19,22.61,7.17,10.33,9,21.1,8.89,33.13,0,5.65-.24,11.19-2.21,17.77A63.9,63.9,0,0,1,238,195.54c-7.31,9.52-16.27,16.93-24.3,23.22-4.06,3.17-7.86,6.07-11.36,8.54a106.77,106.77,0,0,1-13.26,8.09c-7.52,3.8-14,4.69-22.41,2.54-6.21-1.59-12.16-5.34-17.67-10.89-7-7.11-12.4-16.92-17.09-25.67-7.42-13.86-14-24.8-16.64-37.24-2.49-11.83-2.68-19.93,1.62-30.24C119.15,128.48,123.84,123.48,129.56,119.58Z" transform="translate(35.98 36.08)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" stroke-width="2.82" opacity="0.36" />
            </g>
            <path d="M232.43,179.14c-8.08,20.5-24.81,34.11-36.41,41.11-12.55,7-20,7.43-31.27,1.84-11.84-6.49-19.3-21.43-26.47-33.11-6.83-12.4-13.36-21.54-15.42-32.86-1.15-12,7.87-18.65,19.74-25.89,12.28-6.78,27.41-14.18,47.94-17.06,21.08-2,35.46,7.8,42.43,19.56C240,145.05,239.62,159.3,232.43,179.14Z" transform="translate(35.98 36.08)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" stroke-width="3" opacity="0.3" />
            <g opacity="0.7">
                <path d="M225.87,179.59c-7.35,17.52-21.43,29.58-32.07,35.62-11.29,6.09-19.15,6.16-29.18.75-10.36-6-17.24-18.64-23.41-29.3-5.9-11.13-11.1-20.28-12-30.4-.36-10.6,7.31-16.91,18.17-23.15,11.08-5.89,25.34-11.72,43.08-13.22C227.12,120,240,147.43,225.87,179.59Z" transform="translate(35.98 36.08)" fill="none" stroke="#d4e9fa" stroke-miterlimit="10" stroke-width="2.74" opacity="0.91" />
                <path d="M219.8,179.7a66.38,66.38,0,0,1-28.13,30.61c-10.1,5.22-18,5.07-26.87,0-9.09-5.46-15.34-16.2-20.6-25.82-5-9.94-9.1-18.76-9.18-27.79,1.1-17,25.11-28,55-30.57C221.47,126.81,232.91,151.45,219.8,179.7Z" transform="translate(35.98 36.08)" fill="none" stroke="#c0dff9" stroke-miterlimit="10" stroke-width="2.47" opacity="0.82" />
                <path d="M214.16,179.52c-13.57,25.58-35.09,35.27-48.91,25.48-15-11.13-24.94-33-24.8-47.67,1.59-15.17,23.1-24.86,48.91-25.48C216.07,133.19,226,155.05,214.16,179.52Z" transform="translate(35.98 36.08)" fill="none" stroke="#acd5f7" stroke-miterlimit="10" stroke-width="2.21" opacity="0.73" />
                <path d="M208.92,179.07c-11.4,21.44-30.4,29.81-43,21-13.2-9.5-21.71-28.64-20.45-41.87,2-13.44,21-21.81,43-21C210.89,139.06,219.41,158.2,208.92,179.07Z" transform="translate(35.98 36.08)" fill="none" stroke="#98cbf5" stroke-miterlimit="10" stroke-width="1.95" opacity="0.64" />
                <path d="M204,178.37c-9.46,17.73-26,24.79-37.16,17.12-11.52-8-18.63-24.49-16.64-36.2,2.36-11.76,18.86-18.83,37.15-17.12C205.91,144.43,213,160.91,204,178.37Z" transform="translate(35.98 36.08)" fill="none" stroke="#84c1f4" stroke-miterlimit="10" stroke-width="1.68" opacity="0.55" />
                <path d="M199.45,177.45c-7.68,14.38-21.68,20.19-31.44,13.72s-15.71-20.52-13.32-30.64c2.54-10.12,16.54-15.93,31.44-13.72C201.13,149.28,206.93,163.18,199.45,177.45Z" transform="translate(35.98 36.08)" fill="none" stroke="#70b8f2" stroke-miterlimit="10" stroke-width="1.42" opacity="0.45" />
                <path d="M195.13,176.35c-6,11.33-17.57,16-25.83,10.72s-12.9-16.67-10.41-25.16,14.08-13.12,25.83-10.73S201.1,165,195.13,176.35Z" transform="translate(35.98 36.08)" fill="none" stroke="#5caef1" stroke-miterlimit="10" stroke-width="1.15" opacity="0.36" />
                <path d="M191,175.08c-4.53,8.57-13.61,12.12-20.29,8.09s-10.19-13-7.84-19.78,11.43-10.35,20.29-8.08S195.55,166.52,191,175.08Z" transform="translate(35.98 36.08)" fill="none" stroke="#48a4ef" stroke-miterlimit="10" stroke-width="0.89" opacity="0.27" />
                <path d="M187.11,173.69c-3.15,6-9.78,8.56-14.83,5.71s-7.51-9.35-5.53-14.45,8.62-7.62,14.83-5.71S190.26,167.66,187.11,173.69Z" transform="translate(35.98 36.08)" fill="none" stroke="#349aed" stroke-miterlimit="10" stroke-width="0.63" opacity="0.18" />
                <path d="M183.32,172.19c-1.89,3.69-6.1,5.27-9.4,3.53a7.32,7.32,0,0,1-3.42-9.15c1.41-3.32,5.62-4.89,9.39-3.54A6.36,6.36,0,0,1,183.32,172.19Z" transform="translate(35.98 36.08)" fill="none" stroke="#2090ec" stroke-miterlimit="10" stroke-width="0.36" opacity="0.09" />
                <path d="M179.61,170.62a3,3,0,0,1-4,1.48,3,3,0,0,1-1.44-3.9,3.11,3.11,0,0,1,4-1.48A2.8,2.8,0,0,1,179.61,170.62Z" transform="translate(35.98 36.08)" fill="none" stroke="#0c86ea" stroke-miterlimit="10" stroke-width="0.1" opacity="0" />
            </g>
            <path d="M188,152.54c0,3.63-2.94,9.12-6.58,9.12s-6.58-5.49-6.58-9.12a6.58,6.58,0,0,1,13.16,0Z" transform="translate(35.98 36.08)" fill="#0c86ea" />
            <path d="M195.41,176.67c0,6.32-7.37,7.27-13.7,7.27S168,183,168,176.67s7.37-11.46,13.69-11.46S195.41,170.34,195.41,176.67Z" transform="translate(35.98 36.08)" fill="#0c86ea" />
            <circle cx="256.63" cy="194.41" r="8.78" fill="url(#linear-gradient-affiliate)" />
            <circle cx="186.3" cy="160.18" r="13.75" fill="url(#linear-gradient-affiliate-2)" />
            <circle cx="253.12" cy="259.4" r="12" fill="url(#linear-gradient-affiliate-3)" />
            <path d="M219.17,219.5c0,1.12-.91,2.81-2,2.81s-2-1.69-2-2.81a2,2,0,1,1,4,0Z" transform="translate(35.98 36.08)" fill="#fff" />
            <path d="M221.36,227c0,1.95-2.27,2.24-4.22,2.24s-4.21-.29-4.21-2.24,2.27-3.52,4.21-3.52S221.36,225.09,221.36,227Z" transform="translate(35.98 36.08)" fill="#fff" />
            <path d="M152.94,119.35c0,1.29-1,3.22-2.32,3.22s-2.33-1.93-2.33-3.22a2.33,2.33,0,0,1,4.65,0Z" transform="translate(35.98 36.08)" fill="#fff" />
            <path d="M155.46,128c0,2.23-2.6,2.57-4.84,2.57s-4.84-.34-4.84-2.57,2.6-4,4.84-4S155.46,125.76,155.46,128Z" transform="translate(35.98 36.08)" fill="#fff" />
            <circle cx="167.58" cy="223.86" r="15.11" fill="url(#linear-gradient-affiliate-4)" />
            <path d="M134.16,183c0,1.41-1.15,3.54-2.56,3.54s-2.55-2.13-2.55-3.54a2.56,2.56,0,0,1,5.11,0Z" transform="translate(35.98 36.08)" fill="#fff" />
            <path d="M136.92,192.45c0,2.46-2.86,2.82-5.32,2.82s-5.31-.36-5.31-2.82,2.86-4.44,5.31-4.44S136.92,190,136.92,192.45Z" transform="translate(35.98 36.08)" fill="#fff" />
            <path d="M222.33,155.11c0,.93-.75,2.34-1.68,2.34S219,156,219,155.11a1.68,1.68,0,0,1,3.36,0Z" transform="translate(35.98 36.08)" fill="#fff" />
            <path d="M224.15,161.37c0,1.62-1.88,1.87-3.5,1.87s-3.51-.25-3.51-1.87,1.89-2.93,3.51-2.93S224.15,159.76,224.15,161.37Z" transform="translate(35.98 36.08)" fill="#fff" />
        </g>
        <g id="successIcon" viewBox="0 0 15.22 15.22">
            <circle cx="7.61" cy="7.61" r="6.71" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
            <polyline points="4.76 7.53 6.71 9.47 10.43 5.75" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
        </g>
        <g id="userIcon" viewBox="0 0 9.99 13.47">
            <circle cx="5" cy="3.38" r="2.48" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
            <path d="M535,422a4.1,4.1,0,1,1,8.19,0" transform="translate(-534.07 -409.39)" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
        </g>
        <g id="passwordIcon" viewBox="0 0 15.54 14.61">
            <path d="M563.07,417a4.48,4.48,0,0,0-.85-7,4.46,4.46,0,0,0-6.63,4.92l-4.5,4.37a1.49,1.49,0,0,0,.58,2.49l.67.21a3.43,3.43,0,0,0,3.47-.84l3-3A4.48,4.48,0,0,0,563.07,417Z" transform="translate(-549.74 -408.47)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" />
            <circle cx="10.5" cy="4.88" r="1.09" />
        </g>
        <g id="arrowDown" viewBox="0 0 6.65 4.67">
            <polyline points="0.5 0.5 3.32 3.89 6.15 0.5" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke="#618099" />
        </g>
        <g id="markettingTools" viewBox="0 0 381 396.26">
            <path d="M408.18,282,386,269.23a136.41,136.41,0,0,0,1.22-15.46v-.49c0-.83,0-1.67,0-2.5s0-1.68,0-2.51v-.49A136.41,136.41,0,0,0,386,232.32l22.18-12.8a26.19,26.19,0,0,0,9.58-35.77l-25.44-44.08a26.19,26.19,0,0,0-35.77-9.58l-22.18,12.8a135.89,135.89,0,0,0-12.78-8.78l-.41-.24c-.72-.43-1.44-.87-2.17-1.28s-1.45-.83-2.18-1.23l-.43-.25a135.85,135.85,0,0,0-14-6.67V98.83a26.19,26.19,0,0,0-26.19-26.18H225.33a26.19,26.19,0,0,0-26.19,26.18v25.61a135.85,135.85,0,0,0-14,6.67l-.43.25c-.73.4-1.46.81-2.18,1.23s-1.45.85-2.17,1.28l-.41.24a135.89,135.89,0,0,0-12.78,8.78L145,130.09a26.18,26.18,0,0,0-35.76,9.58L83.79,183.75a26.19,26.19,0,0,0,9.58,35.77l22.18,12.8a136.41,136.41,0,0,0-1.22,15.46v.49c0,.83,0,1.67,0,2.51s0,1.67,0,2.5v.49a136.41,136.41,0,0,0,1.22,15.46L93.37,282a26.19,26.19,0,0,0-9.58,35.77l25.45,44.08A26.18,26.18,0,0,0,145,371.46l22.18-12.8A135.89,135.89,0,0,0,180,367.44l.41.24c.72.44,1.44.87,2.17,1.29l2.18,1.22.43.25a135.85,135.85,0,0,0,14,6.67v25.61a26.19,26.19,0,0,0,26.19,26.18h50.89a26.19,26.19,0,0,0,26.19-26.18V377.11a135.85,135.85,0,0,0,14-6.67l.43-.25L319,369c.73-.42,1.45-.85,2.17-1.29l.41-.24a135.89,135.89,0,0,0,12.78-8.78l22.18,12.8a26.19,26.19,0,0,0,35.77-9.58l25.44-44.08A26.19,26.19,0,0,0,408.18,282Z" transform="translate(-60.28 -52.65)" fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="40" />
            <circle cx="191.3" cy="194.16" r="59.16" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="40" />
        </g>
        <g id="externalLink" viewBox="0 0 30.58 30.58">
            <path d="M495.74,340.53l-1.93,1.93a9.13,9.13,0,0,0,0,12.9h0a9.13,9.13,0,0,0,12.9,0l2.1-2.09" transform="translate(-489.89 -328.7)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" />
            <path d="M514.78,347.3l1.77-1.78a9.13,9.13,0,0,0,0-12.9h0a9.13,9.13,0,0,0-12.9,0l-1.77,1.78" transform="translate(-489.89 -328.7)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" />
            <line x1="20.43" y1="10.16" x2="10.37" y2="20.21" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" />
            <polyline points="7.08 2.31 7.08 7.08 2.51 7.08" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" />
            <polyline points="28 23.23 23.23 23.23 23.23 27.79" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" />
        </g>
        <g id="adsBanners" viewBox="0 0 45.65 29.19">
            <path d="M550.05,346.63c-11-.32-13.48.87-15.12,3.3v-8.12a11.64,11.64,0,0,1,11.64-11.64h19.86a11.65,11.65,0,0,1,11.65,11.64v8.12c-1.65-2.43-4.08-3.62-15.12-3.3Z" transform="translate(-533.68 -328.92)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" />
            <path d="M578.08,349.36c0,6.52-9.81,7.5-9.81,7.5V351" transform="translate(-533.68 -328.92)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" />
            <path d="M535,349.54c0,6.53,9.81,7.32,9.81,7.32V351" transform="translate(-533.68 -328.92)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" />
            <polyline points="9.3 13.27 12.61 6.13 15.83 13.27" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" />
            <path d="M20.3,6.29h1.55a3.49,3.49,0,0,1,3.49,3.49v0a3.49,3.49,0,0,1-3.49,3.49H20.3a0,0,0,0,1,0,0v-7A0,0,0,0,1,20.3,6.29Z" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" />
            <path d="M563.59,342.19h2.09a1.79,1.79,0,0,0,1.79-1.79h0a1.79,1.79,0,0,0-1.79-1.79h-.3a1.79,1.79,0,0,1-1.79-1.78h0a1.79,1.79,0,0,1,1.79-1.79h2.09" transform="translate(-533.68 -328.92)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" />
        </g>
        <g id="usersOnline" viewBox="0 0 47.7 28.63">
            <path d="M654.37,331.3c0,2.72-2.2,6.52-4.92,6.52s-4.93-3.8-4.93-6.52a4.93,4.93,0,1,1,9.85,0Z" transform="translate(-625.28 -325.12)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" />
            <path d="M649.44,341.57a14.07,14.07,0,0,0-9.26,3.81c-2.55,2.41-.81,6.32,2.68,6.71a52.74,52.74,0,0,0,13.17,0c3.48-.47,5.23-4.3,2.68-6.71A14.08,14.08,0,0,0,649.44,341.57Z" transform="translate(-625.28 -325.12)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" />
            <path d="M667.27,331.57c0,2.09-1.7,5-3.79,5s-3.79-2.93-3.79-5a3.79,3.79,0,0,1,7.58,0Z" transform="translate(-625.28 -325.12)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" />
            <path d="M658.94,340.64c3.78-1.83,8.73-1.58,11.66,1.75,3.83,4.38-2.93,5.3-6.93,5.43" transform="translate(-625.28 -325.12)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" />
            <path d="M631,331.57c0,2.09,1.69,5,3.78,5s3.79-2.93,3.79-5a3.79,3.79,0,0,0-7.57,0Z" transform="translate(-625.28 -325.12)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" />
            <path d="M639.33,340.64c-3.79-1.83-8.74-1.58-11.66,1.75-3.84,4.38,2.93,5.3,6.92,5.43" transform="translate(-625.28 -325.12)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" />
        </g>
        <g id="referralIcon" viewBox="0 0 26.68 18.7">
            <circle cx="13.1" cy="4.44" r="3.44" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></circle>
            <path d="M701.59,433a1.93,1.93,0,0,0,1.74-2.76,6.52,6.52,0,0,0-11.82,0,1.93,1.93,0,0,0,1.73,2.76Z" transform="translate(-684.32 -415.28)" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></path>
            <circle cx="23.07" cy="7.87" r="2.61" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></circle>
            <circle cx="3.61" cy="7.87" r="2.61" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></circle>
        </g>
        <g id="calculateProfitIcon" viewBox="0 0 402.9 263.22">
            <line x1="361.88" y1="263.22" x2="361.88" y2="80.84" fill="none" stroke-miterlimit="10" stroke-width="40" stroke="url(#linear-gradient-calculate)" />
            <line x1="259.54" y1="263.22" x2="259.54" y2="157.74" fill="none" stroke-miterlimit="10" stroke-width="40" stroke="url(#linear-gradient-calculate-2)" />
            <line x1="157.21" y1="263.22" x2="157.21" y2="85.71" fill="none" stroke-miterlimit="10" stroke-width="40" stroke="url(#linear-gradient-calculate-3)" />
            <line x1="54.88" y1="263.22" x2="54.88" y2="129.02" fill="none" stroke-miterlimit="10" stroke-width="40" stroke="url(#linear-gradient-calculate-4)" />
            <polyline points="380.09 70.8 259.54 174.47 123.88 78.55 20 147.74" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="40" />
            <polyline points="382.9 20 259.54 129.02 124.21 30.72 25.24 115.34" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="40" stroke="url(#linear-gradient-calculate-5)" />
        </g>
        <g id="minesIcon" viewBox="0 0 10.38 1.8">
            <line x1="0.9" y1="0.9" x2="9.48" y2="0.9" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
        </g>
        <g id="plusIcon" viewBox="0 0 10.38 10.38">
            <line x1="0.9" y1="5.19" x2="9.48" y2="5.19" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
            <line x1="5.19" y1="0.9" x2="5.19" y2="9.48" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
        </g>
        <g id="facebook" viewBox="0 0 169.17 169.17">
            <path d="M924.27,0H800.69a22.8,22.8,0,0,0-22.8,22.8V146.37a22.8,22.8,0,0,0,22.8,22.8h60.95l.1-60.45H846a3.7,3.7,0,0,1-3.71-3.69l-.08-19.49A3.72,3.72,0,0,1,846,81.82h15.68V63c0-21.85,13.34-33.75,32.83-33.75h16A3.71,3.71,0,0,1,914.18,33V49.38a3.72,3.72,0,0,1-3.71,3.71h-9.81c-10.6,0-12.66,5-12.66,12.43v16.3h23.3A3.71,3.71,0,0,1,915,86l-2.31,19.49a3.72,3.72,0,0,1-3.68,3.27H888.11L888,169.17h36.27a22.79,22.79,0,0,0,22.79-22.8V22.8A22.79,22.79,0,0,0,924.27,0Z" transform="translate(-777.89)" />
        </g>
        <g id="twitter" viewBox="0 0 203.24 169.06">
            <path d="M729.35,19.67a80.54,80.54,0,0,1-14,4.72A43.67,43.67,0,0,0,726.87,6h0a2.3,2.3,0,0,0-3.36-2.67h0a81,81,0,0,1-21.42,8.85,5.52,5.52,0,0,1-1.34.16A5.65,5.65,0,0,1,697,10.94,43.85,43.85,0,0,0,668,0a46.85,46.85,0,0,0-13.88,2.14,42.46,42.46,0,0,0-28.61,30.59,46.74,46.74,0,0,0-1,16.13,1.55,1.55,0,0,1-.4,1.23,1.62,1.62,0,0,1-1.21.55h-.15a114.88,114.88,0,0,1-79-42.19h0a2.3,2.3,0,0,0-3.76.3h0A43.88,43.88,0,0,0,547.12,62a39.42,39.42,0,0,1-10-3.87h0a2.3,2.3,0,0,0-3.41,2h0a43.89,43.89,0,0,0,25.6,40.42h-.94a39.17,39.17,0,0,1-7.38-.71h0a2.29,2.29,0,0,0-2.61,3h0a43.88,43.88,0,0,0,34.68,29.87,80.79,80.79,0,0,1-45.28,13.75h-5.07a3.36,3.36,0,0,0-3.28,2.53,3.48,3.48,0,0,0,1.66,3.84,120.26,120.26,0,0,0,60.43,16.29,121.94,121.94,0,0,0,51.65-10.95A114,114,0,0,0,681,129.79,124,124,0,0,0,704.1,91,122.28,122.28,0,0,0,712,48.63V48a7.43,7.43,0,0,1,2.79-5.8A86.65,86.65,0,0,0,732.18,23h0a2.29,2.29,0,0,0-2.83-3.36Z" transform="translate(-529.33)" />
        </g>
        <g id="youtube" viewBox="0 0 238.91 169.06">
            <path d="M423.91,0H284.24a49.62,49.62,0,0,0-49.62,49.62v69.82a49.61,49.61,0,0,0,49.62,49.62H423.91a49.61,49.61,0,0,0,49.62-49.62V49.62A49.62,49.62,0,0,0,423.91,0ZM390.35,87.93,325,119.09a2.62,2.62,0,0,1-3.75-2.37V52.45a2.63,2.63,0,0,1,3.81-2.34l65.33,33.11A2.62,2.62,0,0,1,390.35,87.93Z" transform="translate(-234.62)" />
        </g>
        <g id="instagram" viewBox="0 0 169.06 169.06">
            <path d="M-76.66,84.53A22.16,22.16,0,0,1-98.8,106.67a22.17,22.17,0,0,1-22.15-22.14A22.17,22.17,0,0,1-98.8,62.39,22.16,22.16,0,0,1-76.66,84.53Z" transform="translate(183.33 0)" />
            <path d="M-60,0h-77.6a45.72,45.72,0,0,0-45.73,45.73v77.6a45.72,45.72,0,0,0,45.73,45.73H-60a45.72,45.72,0,0,0,45.73-45.73V45.73A45.72,45.72,0,0,0-60,0ZM-98.8,128.09a43.62,43.62,0,0,1-43.57-43.56A43.62,43.62,0,0,1-98.8,41,43.61,43.61,0,0,1-55.24,84.53,43.61,43.61,0,0,1-98.8,128.09ZM-39.63,47a11.11,11.11,0,0,1-7.78,3.22A11.08,11.08,0,0,1-55.18,47a11.09,11.09,0,0,1-3.23-7.78,11.06,11.06,0,0,1,3.23-7.78,11,11,0,0,1,7.77-3.22,11,11,0,0,1,7.78,3.22,11,11,0,0,1,3.22,7.78A11.08,11.08,0,0,1-39.63,47Z" transform="translate(183.33 0)" />
        </g>
        <g id="closeIcon" viewBox="0 0 11.58 11.58">
            <line x1="0.9" y1="0.9" x2="10.68" y2="10.68" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8"></line>
            <line x1="10.68" y1="0.9" x2="0.9" y2="10.68" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8"></line>
        </g>
        <g id="errorIcon" viewBox="0 0 15.22 15.22">
            <circle cx="7.61" cy="7.61" r="6.71" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
            <line x1="7.53" y1="4.13" x2="7.53" y2="7.99" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
            <line x1="7.53" y1="10.49" x2="7.53" y2="11.07" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
        </g>
        <g id="emailIcon" viewBox="0 0 17.3 13.33">
            <rect x="0.9" y="0.9" width="15.5" height="11.53" rx="3.56" ry="3.56" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
            <polyline points="4.48 4.13 8.6 8.25 12.82 4.03" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
        </g>
        <g id="messageIcon" viewBox="0 0 17.3 13.33">
            <path d="M4.46.9h8.38A3.56,3.56,0,0,1,16.4,4.46v4.4a3.56,3.56,0,0,1-3.56,3.56H.9a0,0,0,0,1,0,0v-8A3.56,3.56,0,0,1,4.46.9Z" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
            <line x1="5.05" y1="6.66" x2="5.57" y2="6.66" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
            <line x1="8.65" y1="6.66" x2="9.16" y2="6.66" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
            <line x1="12.04" y1="6.66" x2="12.55" y2="6.66" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
        </g>
        <g id="phoneIcon" viewBox="0 0 29.23 29.27">
            <path d="M576.88,333.93l-7.38,7.39,3.5,1.9c1.28,1.29-7.51,10.08-8.79,8.79l-2.51-2.89-6.4,6.4,5.08,4.09a4.92,4.92,0,0,0,6.57-.35l13.64-13.64a4.92,4.92,0,0,0,.38-6.54Z" transform="translate(-554.05 -332.68)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
            <polyline points="8.69 3.53 8.69 9.69 2.39 9.69" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
        </g>
        <g id="emailInfo" viewBox="0 0 28.11 28.28">
            <rect x="1.25" y="1.25" width="25.61" height="18.91" rx="4.94" ry="4.94" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
            <path d="M622,344.34v11.89a4.31,4.31,0,0,1-4.31,4.31h-17a4.31,4.31,0,0,1-4.31-4.31" transform="translate(-595.11 -333.51)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
            <polyline points="6.99 7.42 14.05 12.71 21.77 7.29" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
        </g>
        <g id="locationIcon" viewBox="0 0 26.92 28.82">
            <path d="M578.92,342.72c0,8-8,12.71-8,12.71s-8-5.09-8-12.71a8,8,0,1,1,15.92,0Z" transform="translate(-557.5 -333.51)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
            <circle cx="13.46" cy="8.99" r="1.01" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
            <path d="M578.92,354.57c3.1.67,4.25,1.56,4.25,2.81,0,2-5.47,3.7-12.21,3.7s-12.21-1.66-12.21-3.7c0-1.27,1-2.14,4.25-2.81" transform="translate(-557.5 -333.51)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" stroke="#fff" />
        </g>
        <g id="menuIcon" viewBox="0 0 114.03 93">
            <path d="M297.64,371.67h114m-114,39h114m-114,39h114" transform="translate(-297.64 -364.17)" fill="none" stroke-miterlimit="10" stroke-width="15" />
        </g>
        <g id="bitcoin-home" viewBox="0 0 51.42 52.83">
            <g opacity="0.85">
                <path d="M547.82,409.64a20.73,20.73,0,0,0,.3,5c2,11.52-5.15,26.55-19.29,24.82a24.84,24.84,0,0,1-4.33-.89,31.12,31.12,0,0,1-7.94-3.68,41,41,0,0,1-5.2-3.66c-5.8-5.24-12.66-12-13.65-20a15.37,15.37,0,0,1-.08-3C497,396,511,395,519.33,392.39c.81-.3,1.61-.63,2.42-1,6.48-2.77,13-6.6,19.93-3.38a12,12,0,0,1,1.8,1.15,12.51,12.51,0,0,1,1.57,1.43c3.93,4.11,4.7,10.08,3.32,15.12a15.91,15.91,0,0,0-.47,2.91C547.87,409,547.85,409.3,547.82,409.64Z" transform="translate(-497.59 -386.8)" fill="#fff" />
            </g>
            <path d="M536.94,411.6a11.49,11.49,0,0,1,.13,1.66,10.86,10.86,0,1,1-6.84-10.09" transform="translate(-497.59 -386.8)" fill="none" stroke="#47a9d4" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" />
            <path d="M526.21,407v1.82h-2.59v4.26h3.58a2.14,2.14,0,0,0,2.13-2.13h0a2.13,2.13,0,0,0-2.13-2.13h-1" transform="translate(-497.59 -386.8)" fill="none" stroke="#47a9d4" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
            <path d="M523.62,417.37v-4.25h3.58a2.13,2.13,0,0,1,2.13,2.12h0a2.13,2.13,0,0,1-2.13,2.13h-.32v1.54" transform="translate(-497.59 -386.8)" fill="none" stroke="#47a9d4" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
            <circle cx="38.37" cy="19.5" r="4.9" fill="#67d0cd" />
            <polyline points="36.49 19.63 37.93 21.07 40.73 18.27" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" />
        </g>
        <g id="time-home" viewBox="0 0 58.58 50.99">
            <g opacity="0.85">
                <path d="M621.14,396.78a33.08,33.08,0,0,1,6.27,17.94c0,.91,0,1.84,0,2.76a32.46,32.46,0,0,1-3.68,13.46,19.65,19.65,0,0,1-1.91,2.29,18.19,18.19,0,0,1-2.16,1.65,18.45,18.45,0,0,1-2.26,1.23c-8.52,3.76-17.46,0-25.38-1.43l-2.64-.44a79,79,0,0,1-10.63-2.43,17.85,17.85,0,0,1-9.6-13.59,22.2,22.2,0,0,1-.25-4.6,20,20,0,0,1,.75-4.53,18.33,18.33,0,0,1,1.06-2.84c4.68-7,12-10.91,19.25-15.54a18.46,18.46,0,0,1,4.6-2.57c6.52-2.53,14.37-1.56,20.69,2.25.59.5,1.15,1.05,1.72,1.63s1.13,1.19,1.71,1.83,1.19,1.32,1.82,2A10.16,10.16,0,0,1,621.14,396.78Z" transform="translate(-568.84 -386.74)" fill="#fff" />
            </g>
            <path d="M608.92,411.56a10,10,0,0,1,.13,1.65,10.82,10.82,0,1,1-10.82-10.81,10.68,10.68,0,0,1,4,.77" transform="translate(-568.84 -386.74)" fill="none" stroke="#a184d1" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
            <circle cx="39.1" cy="19.55" r="4.88" fill="#9f93ea" />
            <polyline points="29.38 22.83 29.38 26.6 33.73 30.66" fill="none" stroke="#a184d1" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
            <path d="M608,406.45a1.82,1.82,0,0,1-1.71,1.54,1.54,1.54,0,1,1,0-3.07C607.56,404.92,608,406.45,608,406.45Z" transform="translate(-568.84 -386.74)" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" />
            <path d="M611.17,406.45a1.54,1.54,0,0,1-1.54,1.54c-1.14,0-1.66-1.54-1.66-1.54s.57-1.53,1.66-1.53A1.53,1.53,0,0,1,611.17,406.45Z" transform="translate(-568.84 -386.74)" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" />
            <line x1="21.66" y1="26.48" x2="22.95" y2="26.48" fill="none" stroke="#a184d1" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
            <line x1="35.88" y1="26.48" x2="37.17" y2="26.48" fill="none" stroke="#a184d1" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
            <line x1="29.39" y1="32.61" x2="29.39" y2="33.9" fill="none" stroke="#a184d1" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
            <line x1="29.39" y1="18.9" x2="29.39" y2="20.19" fill="none" stroke="#a184d1" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
        </g>
        <g id="investment-home" viewBox="0 0 49.05 57.09">
            <g opacity="0.85">
                <path d="M695.28,432.21c.65,2.23-1.94,6.76-4.76,8.35-1.67.94-4.24,1.75-6.1,1.37-10.31-.41-19.52-3.75-25.71-11.09a21.09,21.09,0,0,1-4.18-7.72,24.07,24.07,0,0,1-.87-4.33c-.18-13.58,3.7-33.93,19.66-33.82,8.48-.46,14.82,4,22.38,8.76a20,20,0,0,1,3.84,4,19.46,19.46,0,0,1,2.61,5.24,19.16,19.16,0,0,1,.54,5.36,36.23,36.23,0,0,1-2.43,11,28.55,28.55,0,0,1-2.13,3.85C697.32,424.45,694.06,428.05,695.28,432.21Z" transform="translate(-653.65 -384.93)" fill="#fff" />
            </g>
            <path d="M689,411.78a9.66,9.66,0,0,1,.13,1.62,10.65,10.65,0,1,1-6.7-9.89" transform="translate(-653.65 -384.93)" fill="none" stroke="#fe786f" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" />
            <circle cx="34.38" cy="21.64" r="4.8" fill="#ff866d" />
            <path d="M678.47,419.29V413.4s0-3.12-2.36-3.83a4.81,4.81,0,0,0-4.08.24s1.27,4.06,4.86,4.09" transform="translate(-653.65 -384.93)" fill="none" stroke="#fe786f" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
            <path d="M678.7,416s0-4.62,5.76-3.81C684.46,412.19,684.47,416.86,678.7,416Z" transform="translate(-653.65 -384.93)" fill="none" stroke="#fe786f" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
            <rect x="32.76" y="21.12" width="3.23" height="2.6" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" />
            <path d="M689.65,405.43a1.61,1.61,0,0,0-1.62-1.61s-1.41,0-1.62.8" transform="translate(-653.65 -384.93)" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" />
        </g>
        <g id="aboutPageIcon" viewBox="0 0 89.83 100.42">
            <path d="M918.63,367.71c6,10.12,4.9,27.2,9.43,40.45,3.69,10.77,7.28,18.52,2.73,29.07-8,18.63-39.34,32.56-53.9,16.5-7.51-8.28-10.23-23.94-17-35-5.17-8.5-19.79-25.51-8-34.86C864.1,374.2,909.2,351.92,918.63,367.71Z" transform="translate(-847.43 -360.35)" fill="#fff" />
            <g opacity="0.5">
                <path d="M904.28,452.73c-25.83,9-29.45-19.85-42.06-33.14-15.45-16.28-15.54-42.8,8.71-53.59,32.1-14.29,40.36,6.88,54.36,29.69C939.1,418.2,929.1,444,904.28,452.73Z" transform="translate(-847.43 -360.35)" fill="none" stroke="#a2d9f2" stroke-miterlimit="10" stroke-width="2" />
            </g>
            <path d="M934.64,409.4c5.41,10.69,2.27,21.66-7.64,28.6-2.75,1.5-5.44,3.13-8.12,4.67-32.71,19.64-64-16.74-61.88-35.67,0-17,14-30,30-36,11-3.7,24.93-.59,38.43,22C927,397,934,407.53,934.64,409.4Z" transform="translate(-847.43 -360.35)" fill="url(#linear-gradient-about)" />
            <path d="M910.68,404.46a16.08,16.08,0,1,1-8.11-8" transform="translate(-847.43 -360.35)" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="3" />
            <circle cx="48.6" cy="50.8" r="9.46" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="3" />
            <line x1="48.6" y1="50.8" x2="59.66" y2="39.75" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="3" />
            <polyline points="59.66 34.71 60.25 39 64.72 39.67" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="3" />
        </g>
        <g id="aboutIntroIcon" viewBox="0 0 476.14 446.11">
            <ellipse cx="238.07" cy="412.19" rx="238.07" ry="33.92" opacity="0.25" fill="url(#linear-gradient-star)" />
            <path d="M1526.38,54.8,1575,153.3l108.7,15.79a18.35,18.35,0,0,1,10.17,31.3l-78.66,76.67,18.57,108.26a18.35,18.35,0,0,1-26.62,19.35l-97.23-51.12-97.23,51.12a18.35,18.35,0,0,1-26.62-19.35l18.57-108.26L1326,200.39a18.35,18.35,0,0,1,10.17-31.3l108.71-15.79,48.61-98.5A18.34,18.34,0,0,1,1526.38,54.8Z" transform="translate(-1271.86 -22.62)" fill="none" stroke-miterlimit="10" stroke-width="43.89" stroke="url(#linear-gradient-star-2)" />
            <polygon points="238.07 137.63 263.13 188.41 319.17 196.56 278.62 236.08 288.19 291.89 238.07 265.54 187.94 291.89 197.52 236.08 156.97 196.56 213.01 188.41 238.07 137.63" fill="url(#linear-gradient-star-3)" />
        </g>
        <g id="servicesPageIcon" viewBox="0 0 104.89 100.81">
            <path d="M949.89,415c.27,18.69-35.21,48.92-51.52,48-11.26-.63-15.11-18.32-22.67-26.59-7.34-8-22.75-12.49-23.66-24-2-25.21,18.5-49.36,44-48.16,11.52.54,19.72,14.09,28.22,22C932.4,393.93,949.72,402.91,949.89,415Z" transform="translate(-846 -363.2)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" stroke-width="2" />
            <path d="M933.56,409.3c.45,15.95-12.76,30.24-28.21,37.15-3,1.54-5.84,3-9.34,3.3-4.1.32-8.48-.18-12.08-2.71-21.17-14.86-25.68-26-24.68-36.8-.11-7.82,5.5-11.24,9.12-16.49,8.22-11.93,15.06-21.27,28.91-21.27,3.75,0,14.81.82,18.4,9.44,3.33,8,8.84,8.88,11.33,11.47C932.52,397.64,933.57,403,933.56,409.3Z" transform="translate(-846 -363.2)" fill="url(#linear-gradient-grow)" />
            <path d="M892.42,412.56c-6.68-.06-8.22-6.92-8.22-6.92s2.7-1.94,7.59-.46c4.39,1.33,4.39,7.14,4.39,7.14v13.11" transform="translate(-846 -363.2)" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="3" />
            <path d="M896.6,417.15s0-8.6,10.73-7.09C907.33,410.06,907.34,418.75,896.6,417.15Z" transform="translate(-846 -363.2)" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="3" />
            <circle cx="75.92" cy="19.05" r="10.99" fill="url(#linear-gradient-grow-2)" />
            <path d="M923.07,375.78l-.25,1.91-2.7-.36-.59,4.46,3.75.49a2.24,2.24,0,0,0,2.52-1.93h0a2.26,2.26,0,0,0-1.94-2.53l-1-.13" transform="translate(-846 -363.2)" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.5" />
            <path d="M919,386.24l.58-4.45,3.75.49a2.24,2.24,0,0,1,1.93,2.52h0a2.25,2.25,0,0,1-2.52,1.94l-.34-.05-.21,1.61" transform="translate(-846 -363.2)" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.5" />
            <circle cx="10.31" cy="20.8" r="10.31" fill="url(#linear-gradient-grow-3)" />
            <path d="M855.63,378.68l.27,1.55-2.19.38.63,3.61,3-.53a1.83,1.83,0,0,0,1.49-2.12h0a1.84,1.84,0,0,0-2.13-1.49l-.84.15" transform="translate(-846 -363.2)" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.5" />
            <path d="M855,387.84l-.63-3.62,3-.53a1.84,1.84,0,0,1,2.12,1.49h0a1.84,1.84,0,0,1-1.49,2.13l-.28,0,.23,1.31" transform="translate(-846 -363.2)" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.5" />
            <circle cx="35.06" cy="80.57" r="10.4" fill="url(#linear-gradient-grow-4)" />
            <path d="M882.81,438.65l-.45,1.52-2.15-.62-1,3.55,3,.87a1.84,1.84,0,0,0,2.29-1.26h0a1.83,1.83,0,0,0-1.26-2.29l-.83-.25" transform="translate(-846 -363.2)" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.5" />
            <path d="M878.13,446.65l1-3.55,3,.87a1.85,1.85,0,0,1,1.26,2.29h0a1.85,1.85,0,0,1-2.3,1.26l-.27-.08-.38,1.29" transform="translate(-846 -363.2)" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.5" />
            <path d="M899.22,406.41c-.66-.86-.72-7.66,3.9-8.5C904,398.23,905.79,405.2,899.22,406.41Z" transform="translate(-846 -363.2)" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="3" />
        </g>
        <g id="newsPageIcon" viewBox="0 0 87.5 78.2">
            <path d="M870.14,440.92c-9.38-14-29.37-36.94-6-50,17.94-10,58.42.34,71.32,16.63,12.23,15.45-13.11,32.59-23.38,39.35C894.47,458.46,881.4,457.73,870.14,440.92Z" transform="translate(-852.21 -377.49)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" stroke-width="2" />
            <path d="M916.11,439.88C896,451,869,438,862,418c-5-14,10-25,21.16-32.37,2.06-1.35,4.17-2.63,6.34-3.76C896,378.5,903,376.5,911,378c16.25,3.13,22,17.58,20.51,32.06a45.91,45.91,0,0,1-1.69,8.6C927,424,926,430,922.13,433.64A29.57,29.57,0,0,1,916.11,439.88Z" transform="translate(-852.21 -377.49)" fill="url(#linear-gradient-news)" />
            <ellipse cx="52.18" cy="32.51" rx="3.6" ry="10.05" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="3" />
            <path d="M904.05,400l-11.66,5.17a2.26,2.26,0,0,0-1.6,1.47c-1,2.85-1,3.94,0,6.75a2.24,2.24,0,0,0,1.58,1.45l11.53,5.21" transform="translate(-852.21 -377.49)" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="3" />
            <path d="M890.68,407h-2.92a2.87,2.87,0,0,0-2.87,2.37,2.51,2.51,0,0,0,0,1.58,2.89,2.89,0,0,0,2.87,2.38h2.91" transform="translate(-852.21 -377.49)" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="3" />
            <polyline points="36.5 36.54 36.5 43.67 38.73 44.59" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="3" />
        </g>
        <g id="faqPageIcon" viewBox="0 0 81.94 77.94">
            <path d="M886.7,448.8c-12.53-3.2-30.76-38.35-25.71-51,3.35-8.4,17.25-7.83,25.65-11.94,8.13-4,15.17-14.29,24.23-12.69,19.88,3.52,34.15,25.54,27.56,45.14C935.19,428,895.49,451,886.7,448.8Z" transform="translate(-859.12 -372)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" stroke-width="2" />
            <path d="M916.17,431.91c-8,4.27-15.83,9-25.1,8.16a27.49,27.49,0,0,1-6.51-1,23.48,23.48,0,0,1-6.1-2.71,25.77,25.77,0,0,1-4-4.77,27.81,27.81,0,0,1-2.71-5.43c-4.45-13.78-3.75-32.16,7.46-41.29,8.15-6.88,20.22-.64,30.29,2.82,2.55,1,4.94,2,7.1,3a23.54,23.54,0,0,1,7.33,3.6c11.45,7,11.37,24.95.11,32.54A55.29,55.29,0,0,1,916.17,431.91Z" transform="translate(-859.12 -372)" fill="url(#linear-gradient-helpcenter)" />
            <path d="M893.33,405.38a5.2,5.2,0,1,1,7.72,4.55,5,5,0,0,0-2.53,4.37v.63" transform="translate(-859.12 -372)" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="3" />
            <line x1="39.4" y1="47.57" x2="39.4" y2="49.77" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="3" />
        </g>
        <g id="paymetnProofsPageIcon" viewBox="0 0 78.75 72.35">
            <path d="M858.26,433c-4-19.88,10-38.38,28.84-40.72,11.09-1.37,41.83,16.2,45.51,27.51,8,24.61-13.62,28.05-33.09,31.19C884.51,453.44,862.12,452.15,858.26,433Z" transform="translate(-856.57 -380.57)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" stroke-width="2" />
            <path d="M914.39,440.85a24.72,24.72,0,0,1-7.46,4.54c-7.8,3-16.43,1.69-23.93-1.31a51,51,0,0,1-10.06-6.64,44.68,44.68,0,0,1-8.19-9,34.43,34.43,0,0,1-3.68-7A24.68,24.68,0,0,1,859,415v-.07a13.57,13.57,0,0,1,2.55-10.26c7.57-10.18,20.3-19.51,33.28-22.82a38.15,38.15,0,0,1,8.75-1.24C916,380,927,388,928,400s-4,23-8.77,33.61A27.22,27.22,0,0,1,914.39,440.85Z" transform="translate(-856.57 -380.57)" fill="url(#linear-gradient-paymetnProofs)" />
            <path d="M885,424.47V402.64a3.56,3.56,0,0,1,3.56-3.56H903a3.55,3.55,0,0,1,3.55,3.56v18.58H893a3.68,3.68,0,0,0-3.68,3.68h0a3.68,3.68,0,0,0,3.68,3.68h12.35" transform="translate(-856.57 -380.57)" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="3" />
            <polyline points="35.08 30.2 38.35 33.48 43.99 26.74" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="3" />
        </g>
        <g id="dashboardBg" viewBox="0 0 1536.9 492.87">
            <path d="M1366,147.37c-108.67-10-163,141.52-217.5,175-48.12,29.58-97.33-42.22-135-44s-62,150-120,155c-47.91,4.13-77.5-98.5-119.5-109.5s-113,72-130,63-27.25-36.72-64.5-32.5c-53,6-96.5,96.86-147.5,112-54.88,16.33-100-71.79-192-82.4-67.63-7.79-92.64,51.77-144,41C57.18,416.89,9.37,369.85-23,189" transform="translate(116.15 -131.13)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" stroke-width="2" />
            <path d="M1366,145c-108.67-10-163,141.52-217.5,175-48.12,29.58-97.33-42.22-135-44s-62,150-120,155c-47.91,4.13-77.5-98.5-119.5-109.5s-113,72-130,63-27.25-36.71-64.5-32.5c-53,6-96.5,96.86-147.5,112-54.88,16.33-100-71.79-192-82.39-67.63-7.8-92.64,51.77-144,41-38.82-8.14-86.63-55.19-119-236" transform="translate(116.15 -131.13)" fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="2" />
            <path d="M1397.67,384c-105.08,103-274.59,133.51-409,73.73-43.16-19.2-88-47.47-133.93-36.44-63.06,15.14-99.72,99.28-164.47,95.57-39.16-2.25-69.75-37.66-108.66-42.63-31-4-60.61,12-88.58,26-49.44,24.74-106.64,45-159.1,27.52-33-11-61.65-36.21-96.36-38-29.5-1.52-56.66,14.31-84.33,24.66C60,549.31-54,517.22-115.37,438.88" transform="translate(116.15 -131.13)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" stroke-width="2" />
            <path d="M1397.67,381.85c-105.08,103-274.59,133.51-409,73.72-43.16-19.19-88-47.46-133.93-36.43-63.06,15.13-99.72,99.28-164.47,95.57C651.1,512.46,620.51,477,581.6,472.08c-31-4-60.61,12-88.58,26-49.44,24.74-106.64,45-159.1,27.52-33-11-61.65-36.21-96.36-38-29.5-1.52-56.66,14.31-84.33,24.66C60,547.15-54,515.07-115.37,436.72" transform="translate(116.15 -131.13)" fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="2" />
            <path d="M1386.44,222.8c-32.85,25.8-79.85,26.25-119.58,13.32s-74.49-37.3-110.51-58.47-75.6-39.78-117.36-39.13c-41.53.65-80.27,20.25-115.85,41.67-30,18.07-59.61,38-93.3,47.67A166.75,166.75,0,0,1,729.79,225C693.72,212.45,663.3,188,631,167.52S561.45,130,523.58,135.05c-56.72,7.61-94.65,60.6-143.38,90.6-47.11,29-107.16,36-159.66,18.56-42.91-14.25-81.49-43.9-126.63-46.44C32,194.28-19.58,241.88-63,286.13" transform="translate(116.15 -131.13)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" stroke-width="2" />
            <path d="M1386.44,220.78c-32.85,25.8-79.85,26.24-119.58,13.32s-74.49-37.31-110.51-58.47-75.6-39.78-117.36-39.13c-41.53.65-80.27,20.24-115.85,41.66-30,18.08-59.61,38-93.3,47.68A166.83,166.83,0,0,1,729.79,223C693.72,210.43,663.3,185.93,631,165.5S561.45,128,523.58,133c-56.72,7.61-94.65,60.6-143.38,90.6-47.11,29-107.16,36-159.66,18.55-42.91-14.24-81.49-43.89-126.63-46.43C32,192.26-19.58,239.85-63,284.11" transform="translate(116.15 -131.13)" fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="2" />
            <path d="M1398,413.05c-80.78-27.19-172.72-19.29-247.67,21.29-81.07,43.89-145.76,124.7-237.12,137.05C833,582.23,747.3,536.7,673.07,569c-43.49,18.91-82.28,63.66-128.3,52.19-29-7.22-48.14-35.22-75.57-47-62.17-26.8-130,38.34-197,28.46-49.3-7.27-83-52.31-126.13-77.32C80.9,487.39-9.94,501.59-60.5,557.52" transform="translate(116.15 -131.13)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" stroke-width="2" />
            <path d="M1398,411c-80.78-27.19-172.72-19.29-247.67,21.29-81.07,43.89-145.76,124.7-237.12,137C833,580.18,747.3,534.66,673.07,566.91c-43.49,18.9-82.28,63.66-128.3,52.19-29-7.22-48.14-35.23-75.57-47-62.17-26.8-130,38.34-197,28.46-49.3-7.27-83-52.31-126.13-77.32C80.9,485.35-9.94,499.54-60.5,555.48" transform="translate(116.15 -131.13)" fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="2" />
            <path d="M1420,304.5c-57.32,64.68-124.07,87.25-198,42.5-26.15-15.83-74.5-68-124-56.5-18.35,4.26-68,46-96.5,53-116.19,28.54-207.25-104-319.45-62.43-30.66,11.36-57.94,34.74-90.63,35.47-31.31.7-60.33-19.94-91.61-18.38-48,2.4-76.43,52.33-109.68,87.06C351.56,425.51,286.87,449,239.42,419.66c-29.3-18.1-45.66-52.07-74.21-71.33-29.57-19.95-69.06-21.17-102.79-9.54S.05,373.52-24.64,399.27" transform="translate(116.15 -131.13)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" stroke-width="2" />
            <path d="M1420,302.53c-57.32,64.68-124.07,87.26-198,42.5-26.15-15.83-74.5-68-124-56.5-18.35,4.27-68,46-96.5,53-116.19,28.54-207.25-104-319.45-62.43-30.66,11.36-57.94,34.74-90.63,35.47-31.31.7-60.33-19.93-91.61-18.37-48,2.39-76.43,52.32-109.68,87.05C351.56,423.55,286.87,447,239.42,417.7c-29.3-18.11-45.66-52.07-74.21-71.34-29.57-19.95-69.06-21.17-102.79-9.53S.05,371.55-24.64,397.3" transform="translate(116.15 -131.13)" fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="2" />
        </g>
        <g id="logout" viewBox="0 0 32.04 34.75">
            <path d="M746.66,427.82a14,14,0,1,1-19.82,0" transform="translate(-720.73 -419)" fill="none" stroke="#ff6a73" stroke-linecap="round" stroke-miterlimit="10" stroke-width="4" />
            <line x1="16.02" y1="2" x2="16.02" y2="18.73" fill="none" stroke="#ff6a73" stroke-linecap="round" stroke-miterlimit="10" stroke-width="4" />
        </g>
        <g id="balanceIcon" viewBox="0 0 21.67 20.49">
            <path d="M749.49,414.71a3,3,0,0,0-3-3H734.23a3,3,0,0,0-3,3v8.64a3,3,0,0,0,3,3H746.5a3,3,0,0,0,3-3v-2.46" transform="translate(-730.24 -406.85)" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
            <rect x="12.42" y="10.24" width="8.25" height="3.87" rx="1.94" ry="1.94" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
            <path d="M733.73,411.72l9-3.69a2.36,2.36,0,0,1,3.25,2.18v1.51" transform="translate(-730.24 -406.85)" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
        </g>
        <g id="totalEarningIcon" viewBox="0 0 20.04 23.34">
            <path d="M761.46,419.19c-5.17,0-6.36-5.36-6.36-5.36s2.09-1.49,5.88-.35c3.39,1,3.39,5.53,3.39,5.53v10.15" transform="translate(-753.98 -406.82)" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
            <path d="M764.7,422.75s0-6.66,8.31-5.49C773,417.26,773,424,764.7,422.75Z" transform="translate(-753.98 -406.82)" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
            <path d="M766.73,414.44c-.51-.67-.55-5.94,3-6.59C770.4,408.09,771.82,413.49,766.73,414.44Z" transform="translate(-753.98 -406.82)" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
        </g>
        <g id="dashboardEmailIcon" viewBox="0 0 30 22.97">
            <rect x="1.5" y="1.5" width="27" height="19.97" rx="5.13" ry="5.13" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="3" />
            <polyline points="1.5 5.29 15 12.87 28.5 6.12" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="3" />
        </g>
        <g id="dashboardIcon" viewBox="0 0 25.8 18.01">
            <path d="M697.93,416.5c0,.42,0,.83-.08,1.24a3.11,3.11,0,0,1-4.07,2.59,28,28,0,0,0-3.59-.89.93.93,0,0,1-.73-.7c-.26-1-1.3-3-3.44-3-2.7,0-3.23,2-3.48,3a.93.93,0,0,1-.73.7,27,27,0,0,0-3.54.86,3.11,3.11,0,0,1-4.07-2.62,11.61,11.61,0,0,1-.07-1.33,11.9,11.9,0,1,1,23.8.12Z" transform="translate(-673.13 -403.47)" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
            <line x1="11.58" y1="11.66" x2="8.96" y2="6.94" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
            <line x1="2.61" y1="11.19" x2="4.32" y2="11.19" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
            <line x1="21.06" y1="11.19" x2="22.72" y2="11.19" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
            <line x1="12.9" y1="1.96" x2="12.9" y2="3.59" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
        </g>
        <g id="WithdrawIcon" viewBox="0 0 29.92 21.03">
            <circle cx="23.21" cy="12.73" r="5.71" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
            <polyline points="21.07 11.6 23.33 13.86 25.48 11.7" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
            <path d="M744.68,422.32l-10,3.3a3.75,3.75,0,0,1-4.73-2.39l-1.77-5.39a3.74,3.74,0,0,1,2.39-4.73l13.79-4.54A3.76,3.76,0,0,1,749,411l1.13,3.44" transform="translate(-726.94 -407.38)" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
            <circle cx="12.12" cy="9.64" r="3.01" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
            <path d="M733.06,425.81l2.21,1a7.65,7.65,0,0,0,5.35.3l5.88-1.82" transform="translate(-726.94 -407.38)" fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
        </g>
        <g id="loginUserIcon" viewBox="0 0 9.99 13.47">
            <circle cx="5" cy="3.38" r="2.48" fill="none" stroke="#618099" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
            <path d="M535,422a4.1,4.1,0,1,1,8.19,0" transform="translate(-534.07 -409.39)" fill="none" stroke="#618099" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
        </g>
        <g id="registerUserIcon" viewBox="0 0 15.77 13.47">
            <circle cx="5" cy="3.38" r="2.48" fill="none" stroke="#618099" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
            <path d="M535,422a4.1,4.1,0,1,1,8.19,0" transform="translate(-534.07 -409.39)" fill="none" stroke="#618099" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
            <line x1="10.56" y1="6.92" x2="14.87" y2="6.92" fill="none" stroke="#618099" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
            <line x1="12.72" y1="4.76" x2="12.72" y2="9.08" fill="none" stroke="#618099" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1.8" />
        </g>
        <g id="copyLinkIcon" viewBox="0 0 8.45 8.6">
            <rect x="0.5" y="0.5" width="5.47" height="5.47" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M560.2,418.88v4.6a.87.87,0,0,1-.87.87h-4.6" transform="translate(-552.25 -416.25)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" />
        </g>
    </svg>
    <div class="modal-bg"></div>
 
        
        
                 <?php 
//////////////////////////////////////////////////////////////////////////////////////////////
        $session_pages = array("account", "deposit_history", "deposit_list", "edit_account", "referals", "security", "withdraw", "promotion", "history");
        $nonsession_pages = array("about", "index", "partnership", "support", "testimonials");
        
//            if(isset($_SESSION['id'])){
//                include_once("includes/session_includes/base.php"); 
//            }
        
//            echo $session_variable;
    
            
    
    
            if(!isset($_GET['page'])){
             include_once('includes/indexpage.php');   
            }else{
                  if(in_array($_GET['page'], $session_pages) || in_array($_GET['page'], $nonsession_pages)){
                    $link = "includes/" . $_GET['page']. "page.php";

                    if(in_array($_GET['page'], $session_pages)){
                        $link = "includes/session_includes/" . $_GET['page']. "page.php"; 
                    include_once("includes/session_includes/base.php");
                    }

                    if($_GET['page'] == 'deposit' && !isset($_SESSION['id'])){
                       $link = 'includes/indexpage.php'; 

                    }

                        include_once($link); 
                    }else{
                        include_once('includes/indexpage.php'); 
                    }
            }
            
            ?>
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        <div class="footer-copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-sm-7 col-xs-6">
                        <!--
          <div class="footer-logo"> <img src="styles/img/logo.svg"> <strong></strong> <span></span> </div>
          
          -->
                    </div>
                    <div class="col-md-4 col-sm-5 col-xs-6 ">
                        <div class="social-icon">
                            <span>Follow Us</span>
                            <a id="facebook" href="https://www.facebook.com/astrofxc/">
                                <svg viewBox="0 0 169.17 169.17">
                                    <use xlink:href="#facebook"></use>
                                </svg>
                            </a>
                            <a id="twitter" href="https://twitter.com/AstroForexpro">
                                <svg viewBox="0 0 203.24 169.06">
                                    <use xlink:href="#twitter"></use>
                                </svg>
                            </a>
                            <a id="youtube" href="https://www.youtube.com/user/ReclaimReality">
                                <svg viewBox="0 0 238.91 169.06">
                                    <use xlink:href="#youtube"></use>
                                </svg>
                            </a>
                            <a id="instagram" href="https://www.instagram.com/astroforex/">
                                <svg viewBox="0 0 169.06 169.06">
                                    <use xlink:href="#instagram"></use>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="copyright"> <span style="color: #dae7ed;font-size: 10px;">49 Grosvenor Street, Mayfair, London, England, W1K 3HP
                        <br>
                        <a target="_blank" href="https://find-and-update.company-information.service.gov.uk/company/08939022">AstroFXC, 08939022</a> </span> <br>
                    <p>© 2020 AstroFXC Limited. All Rights Reserved. </p>
                </div>
            </div>
        </div>





    </footer>
    <div class="hidden-menu" style="display:none;">
        <button class="hidden-menu-close">
            <svg viewBox="0 0 11.58 11.58" stroke="#3e617f" style="width: 18px; height: 18px; ">
                <use xlink:href="#closeIcon"></use>
            </svg>
        </button>

        <ul class="menuList">
            <li><a href="?a=cust&amp;page=about">About Us</a></li>
            <!--<li><a href="?a=cust&amp;page=guide">How It Works</a></li>-->
            <li><a href="?a=cust&amp;page=testimonials">Testimonials</a></li>
            <li><a href="?a=cust&amp;page=partnership">Invite a Friend</a></li>
            <!--
    <li><a href="?a=news">Blog</a></li> -->
            <li><a href="?page=support">Contact Us</a></li>
            <!--<li><a href="/proofs">Payment Proofs</a></li>-->
            <li><a style="cursor:pointer" onclick="openModal('register-modal')">Sign Up</a></li>
            <li><a style="cursor:pointer" onclick="openModal('account-modal')">Login</a></li>
        </ul>
    </div>

    <style>
        input[type="text"]::-webkit-input-placeholder {

            font-size: 13px;
        }

        input[type="text"]::-moz-placeholder {

            font-size: 13px;
        }

        input[type="text"]:-ms-input-placeholder {

            font-size: 13px;
        }

        input[type="text"]::placeholder {

            font-size: 13px;
        }

        input[type="password"]::-webkit-input-placeholder {

            font-size: 13px;
        }

        input[type="password"]::-moz-placeholder {

            font-size: 13px;
        }

        input[type="password"]:-ms-input-placeholder {

            font-size: 13px;
        }

        input[type="password"]::placeholder {

            font-size: 13px;
        }

    </style>

    <div class="modal-holder">
        <div class="modal-general account-modal">
            <button class="modal-close">
                <svg viewBox="0 0 11.58 11.58">
                    <use xlink:href="#closeIcon"></use>
                </svg>
            </button>
            <div class="modal-title">
                <svg viewBox="0 0 9.99 13.47">
                    <use xlink:href="#loginUserIcon"></use>
                </svg>
                Login To Your Account </div>
            <form method="post" name="mainform" id="login_form">
<!--
                <input type="hidden" name="form_id" value="16080211547515">
                <input type="hidden" name="form_token" value="f8b34e1479c0d31625b117a7ec847c1f">
                <input type=hidden name=a value='do_login'>
                <input type=hidden name=follow value=''>
                <input type=hidden name=follow_id value=''>
-->
                <div class="input-holder-byicon">
                    <input type="text" name="email" id="login_email" value='' style="font-size: 14px;" autofocus placeholder="Username">
                    <svg viewBox="0 0 9.99 13.47">
                        <use xlink:href="#userIcon"></use>
                    </svg>
                </div>
                <div class="input-holder-byicon">
                    <input type="password" name="password" id="login_password" value='' style="font-size: 14px;" placeholder="Password">
                    <svg viewBox="0 0 15.54 14.61">
                        <use xlink:href="#passwordIcon"></use>
                    </svg>
                </div>
                <a id="forgotNowBtn" style="cursor:pointer" onclick="openModal('forgot-modal')">Forgot your password? Click here.</a>
                <div class="account-modal-bottom"> Don't have an account? <a id="registerNowBtn" class="register-btn pointer">Create an account.</a>
                    <button class="btn btn--blue" id="login_submit">login</button>
                </div>
                <div class="account-modal-bottom l_message" style="padding: 0 !important; position: relative; margin: 40px auto !important;text-align: center;display: flex;justify-content: center; ">
<!--                    <div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px"> Registration Successful</div>-->
                </div>
            </form>
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#login_form").submit(function(event) {
                event.preventDefault();
                
                var email = $("#login_email").val();
                var password = $("#login_password").val();
                var login_button = $("#login_submit").val();
                
//                console.log("email: " + email + " password: " + password );


                $("#login_submit").html('<b>....</b>');
                $.ajax({
                    type: "POST",
                    url: "phpscripts/login.php/",
                    data: {
                        email: email,
                        password: password,
                        login_button: login_button
                    },
                    success: function(response) {
                        $(".l_message").html(response);
                        $("#login_submit").html('LOGIN');
                    },
                    error: function(response) {
                        console.log(response);
                        $("#login_submit").html('LOGIN');
                    }
                });

            });

        });

    </script>
        </div>


        <div class="modal-general register-modal">
            <button class="modal-close">
                <svg viewBox="0 0 11.58 11.58">
                    <use xlink:href="#closeIcon"></use>
                </svg>
            </button>
            <div class="modal-title">
                <svg viewBox="0 0 15.77 13.47">
                    <use xlink:href="#registerUserIcon"></use>
                </svg>
                Create a New Account </div>
<!--            <iframe name="createaccountrex" src='?a=signup' id="registerIframe" frameborder="0" scrolling="no" onload="resizeIframe($(this))" style="min-height:450px"></iframe>-->
            <form method=post name="signup_form" id="signup_form">
<!--
                <input type="hidden" name="form_id" value="16080211547515">
                <input type="hidden" name="form_token" value="f8b34e1479c0d31625b117a7ec847c1f">
                <input type=hidden name=a value='do_login'>
                <input type=hidden name=follow value=''>
                <input type=hidden name=follow_id value=''>
-->
                <div class="input-holder-byicon">
                    <input type="text" name="username" id="register_username" value='' style="font-size: 14px;" autofocus placeholder="Username">
                </div>
                <div class="input-holder-byicon">
                    <input type="text" name="full_name" id="register_full_name" value='' style="font-size: 14px;" autofocus placeholder="Full Name">
                </div>
                <div class="input-holder-byicon">
                    <input type="text" name="register_phone" id="register_phone" value='' style="font-size: 14px;" autofocus placeholder="Phone Number">
                </div>
                <style>
                    
                    select {
                        line-height: 3;
                        background: url("data:image/svg+xml;utf8,<svg fill='black' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>") no-repeat right #ddd;
                        -webkit-appearance: none;
                        background-position-x: auto;
                                }
                </style>
                <div class="input-holder-byicon">
                    <label for="country" style="margin-left:10px;color:#A8A8A8">Select Country:</label><br>
                   <select id="country" class="country_select" name="country" style="height:60px !important;width:inherit !important;font-size:13px !important;padding:0px 15px !important;margin-right:0px !important;border-radius:4px;">
                       <option value="">Select Your Country</option>
                       <option value="Afganistan">Afghanistan</option>
                       <option value="Albania">Albania</option>
                       <option value="Algeria">Algeria</option>
                       <option value="American Samoa">American Samoa</option>
                       <option value="Andorra">Andorra</option>
                       <option value="Angola">Angola</option>
                       <option value="Anguilla">Anguilla</option>
                       <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                       <option value="Argentina">Argentina</option>
                       <option value="Armenia">Armenia</option>
                       <option value="Aruba">Aruba</option>
                       <option value="Australia">Australia</option>
                       <option value="Austria">Austria</option>
                       <option value="Azerbaijan">Azerbaijan</option>
                       <option value="Bahamas">Bahamas</option>
                       <option value="Bahrain">Bahrain</option>
                       <option value="Bangladesh">Bangladesh</option>
                       <option value="Barbados">Barbados</option>
                       <option value="Belarus">Belarus</option>
                       <option value="Belgium">Belgium</option>
                       <option value="Belize">Belize</option>
                       <option value="Benin">Benin</option>
                       <option value="Bermuda">Bermuda</option>
                       <option value="Bhutan">Bhutan</option>
                       <option value="Bolivia">Bolivia</option>
                       <option value="Bonaire">Bonaire</option>
                       <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                       <option value="Botswana">Botswana</option>
                       <option value="Brazil">Brazil</option>
                       <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                       <option value="Brunei">Brunei</option>
                       <option value="Bulgaria">Bulgaria</option>
                       <option value="Burkina Faso">Burkina Faso</option>
                       <option value="Burundi">Burundi</option>
                       <option value="Cambodia">Cambodia</option>
                       <option value="Cameroon">Cameroon</option>
                       <option value="Canada">Canada</option>
                       <option value="Canary Islands">Canary Islands</option>
                       <option value="Cape Verde">Cape Verde</option>
                       <option value="Cayman Islands">Cayman Islands</option>
                       <option value="Central African Republic">Central African Republic</option>
                       <option value="Chad">Chad</option>
                       <option value="Channel Islands">Channel Islands</option>
                       <option value="Chile">Chile</option>
                       <option value="China">China</option>
                       <option value="Christmas Island">Christmas Island</option>
                       <option value="Cocos Island">Cocos Island</option>
                       <option value="Colombia">Colombia</option>
                       <option value="Comoros">Comoros</option>
                       <option value="Congo">Congo</option>
                       <option value="Cook Islands">Cook Islands</option>
                       <option value="Costa Rica">Costa Rica</option>
                       <option value="Cote DIvoire">Cote DIvoire</option>
                       <option value="Croatia">Croatia</option>
                       <option value="Cuba">Cuba</option>
                       <option value="Curaco">Curacao</option>
                       <option value="Cyprus">Cyprus</option>
                       <option value="Czech Republic">Czech Republic</option>
                       <option value="Denmark">Denmark</option>
                       <option value="Djibouti">Djibouti</option>
                       <option value="Dominica">Dominica</option>
                       <option value="Dominican Republic">Dominican Republic</option>
                       <option value="East Timor">East Timor</option>
                       <option value="Ecuador">Ecuador</option>
                       <option value="Egypt">Egypt</option>
                       <option value="El Salvador">El Salvador</option>
                       <option value="Equatorial Guinea">Equatorial Guinea</option>
                       <option value="Eritrea">Eritrea</option>
                       <option value="Estonia">Estonia</option>
                       <option value="Ethiopia">Ethiopia</option>
                       <option value="Falkland Islands">Falkland Islands</option>
                       <option value="Faroe Islands">Faroe Islands</option>
                       <option value="Fiji">Fiji</option>
                       <option value="Finland">Finland</option>
                       <option value="France">France</option>
                       <option value="French Guiana">French Guiana</option>
                       <option value="French Polynesia">French Polynesia</option>
                       <option value="French Southern Ter">French Southern Ter</option>
                       <option value="Gabon">Gabon</option>
                       <option value="Gambia">Gambia</option>
                       <option value="Georgia">Georgia</option>
                       <option value="Germany">Germany</option>
                       <option value="Ghana">Ghana</option>
                       <option value="Gibraltar">Gibraltar</option>
                       <option value="Great Britain">Great Britain</option>
                       <option value="Greece">Greece</option>
                       <option value="Greenland">Greenland</option>
                       <option value="Grenada">Grenada</option>
                       <option value="Guadeloupe">Guadeloupe</option>
                       <option value="Guam">Guam</option>
                       <option value="Guatemala">Guatemala</option>
                       <option value="Guinea">Guinea</option>
                       <option value="Guyana">Guyana</option>
                       <option value="Haiti">Haiti</option>
                       <option value="Hawaii">Hawaii</option>
                       <option value="Honduras">Honduras</option>
                       <option value="Hong Kong">Hong Kong</option>
                       <option value="Hungary">Hungary</option>
                       <option value="Iceland">Iceland</option>
                       <option value="Indonesia">Indonesia</option>
                       <option value="India">India</option>
                       <option value="Iran">Iran</option>
                       <option value="Iraq">Iraq</option>
                       <option value="Ireland">Ireland</option>
                       <option value="Isle of Man">Isle of Man</option>
                       <option value="Israel">Israel</option>
                       <option value="Italy">Italy</option>
                       <option value="Jamaica">Jamaica</option>
                       <option value="Japan">Japan</option>
                       <option value="Jordan">Jordan</option>
                       <option value="Kazakhstan">Kazakhstan</option>
                       <option value="Kenya">Kenya</option>
                       <option value="Kiribati">Kiribati</option>
                       <option value="Korea North">Korea North</option>
                       <option value="Korea Sout">Korea South</option>
                       <option value="Kuwait">Kuwait</option>
                       <option value="Kyrgyzstan">Kyrgyzstan</option>
                       <option value="Laos">Laos</option>
                       <option value="Latvia">Latvia</option>
                       <option value="Lebanon">Lebanon</option>
                       <option value="Lesotho">Lesotho</option>
                       <option value="Liberia">Liberia</option>
                       <option value="Libya">Libya</option>
                       <option value="Liechtenstein">Liechtenstein</option>
                       <option value="Lithuania">Lithuania</option>
                       <option value="Luxembourg">Luxembourg</option>
                       <option value="Macau">Macau</option>
                       <option value="Macedonia">Macedonia</option>
                       <option value="Madagascar">Madagascar</option>
                       <option value="Malaysia">Malaysia</option>
                       <option value="Malawi">Malawi</option>
                       <option value="Maldives">Maldives</option>
                       <option value="Mali">Mali</option>
                       <option value="Malta">Malta</option>
                       <option value="Marshall Islands">Marshall Islands</option>
                       <option value="Martinique">Martinique</option>
                       <option value="Mauritania">Mauritania</option>
                       <option value="Mauritius">Mauritius</option>
                       <option value="Mayotte">Mayotte</option>
                       <option value="Mexico">Mexico</option>
                       <option value="Midway Islands">Midway Islands</option>
                       <option value="Moldova">Moldova</option>
                       <option value="Monaco">Monaco</option>
                       <option value="Mongolia">Mongolia</option>
                       <option value="Montserrat">Montserrat</option>
                       <option value="Morocco">Morocco</option>
                       <option value="Mozambique">Mozambique</option>
                       <option value="Myanmar">Myanmar</option>
                       <option value="Nambia">Nambia</option>
                       <option value="Nauru">Nauru</option>
                       <option value="Nepal">Nepal</option>
                       <option value="Netherland Antilles">Netherland Antilles</option>
                       <option value="Netherlands">Netherlands (Holland, Europe)</option>
                       <option value="Nevis">Nevis</option>
                       <option value="New Caledonia">New Caledonia</option>
                       <option value="New Zealand">New Zealand</option>
                       <option value="Nicaragua">Nicaragua</option>
                       <option value="Niger">Niger</option>
                       <option value="Nigeria">Nigeria</option>
                       <option value="Niue">Niue</option>
                       <option value="Norfolk Island">Norfolk Island</option>
                       <option value="Norway">Norway</option>
                       <option value="Oman">Oman</option>
                       <option value="Pakistan">Pakistan</option>
                       <option value="Palau Island">Palau Island</option>
                       <option value="Palestine">Palestine</option>
                       <option value="Panama">Panama</option>
                       <option value="Papua New Guinea">Papua New Guinea</option>
                       <option value="Paraguay">Paraguay</option>
                       <option value="Peru">Peru</option>
                       <option value="Phillipines">Philippines</option>
                       <option value="Pitcairn Island">Pitcairn Island</option>
                       <option value="Poland">Poland</option>
                       <option value="Portugal">Portugal</option>
                       <option value="Puerto Rico">Puerto Rico</option>
                       <option value="Qatar">Qatar</option>
                       <option value="Republic of Montenegro">Republic of Montenegro</option>
                       <option value="Republic of Serbia">Republic of Serbia</option>
                       <option value="Reunion">Reunion</option>
                       <option value="Romania">Romania</option>
                       <option value="Russia">Russia</option>
                       <option value="Rwanda">Rwanda</option>
                       <option value="St Barthelemy">St Barthelemy</option>
                       <option value="St Eustatius">St Eustatius</option>
                       <option value="St Helena">St Helena</option>
                       <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                       <option value="St Lucia">St Lucia</option>
                       <option value="St Maarten">St Maarten</option>
                       <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                       <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                       <option value="Saipan">Saipan</option>
                       <option value="Samoa">Samoa</option>
                       <option value="Samoa American">Samoa American</option>
                       <option value="San Marino">San Marino</option>
                       <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                       <option value="Saudi Arabia">Saudi Arabia</option>
                       <option value="Senegal">Senegal</option>
                       <option value="Seychelles">Seychelles</option>
                       <option value="Sierra Leone">Sierra Leone</option>
                       <option value="Singapore">Singapore</option>
                       <option value="Slovakia">Slovakia</option>
                       <option value="Slovenia">Slovenia</option>
                       <option value="Solomon Islands">Solomon Islands</option>
                       <option value="Somalia">Somalia</option>
                       <option value="South Africa">South Africa</option>
                       <option value="Spain">Spain</option>
                       <option value="Sri Lanka">Sri Lanka</option>
                       <option value="Sudan">Sudan</option>
                       <option value="Suriname">Suriname</option>
                       <option value="Swaziland">Swaziland</option>
                       <option value="Sweden">Sweden</option>
                       <option value="Switzerland">Switzerland</option>
                       <option value="Syria">Syria</option>
                       <option value="Tahiti">Tahiti</option>
                       <option value="Taiwan">Taiwan</option>
                       <option value="Tajikistan">Tajikistan</option>
                       <option value="Tanzania">Tanzania</option>
                       <option value="Thailand">Thailand</option>
                       <option value="Togo">Togo</option>
                       <option value="Tokelau">Tokelau</option>
                       <option value="Tonga">Tonga</option>
                       <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                       <option value="Tunisia">Tunisia</option>
                       <option value="Turkey">Turkey</option>
                       <option value="Turkmenistan">Turkmenistan</option>
                       <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                       <option value="Tuvalu">Tuvalu</option>
                       <option value="Uganda">Uganda</option>
                       <option value="United Kingdom">United Kingdom</option>
                       <option value="Ukraine">Ukraine</option>
                       <option value="United Arab Erimates">United Arab Emirates</option>
                       <option value="United States of America">United States of America</option>
                       <option value="Uraguay">Uruguay</option>
                       <option value="Uzbekistan">Uzbekistan</option>
                       <option value="Vanuatu">Vanuatu</option>
                       <option value="Vatican City State">Vatican City State</option>
                       <option value="Venezuela">Venezuela</option>
                       <option value="Vietnam">Vietnam</option>
                       <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                       <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                       <option value="Wake Island">Wake Island</option>
                       <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                       <option value="Yemen">Yemen</option>
                       <option value="Zaire">Zaire</option>
                       <option value="Zambia">Zambia</option>
                       <option value="Zimbabwe">Zimbabwe</option>
                    </select>
                </div>
                     
                <div class="input-holder-byicon">
                    <input type="text" name="email" id="register_email" value='' style="font-size: 14px;" autofocus placeholder="E-mail Address">
                </div>
                <div class="input-holder-byicon">
                    <input type="text" name="email2" id="register_email2" value='' style="font-size: 14px;" autofocus placeholder="Confirm E-mail Address">
                </div>
                <div class="input-holder-byicon">
                    <input type="password" name="password" id="register_password" value='' style="font-size: 14px;" placeholder="Password">
                </div>
                <div class="input-holder-byicon">
                    <input type="password" name="password2" id="register_password2" value='' style="font-size: 14px;" placeholder="Confirm Password">
                </div>
                <div class="account-modal-bottom" style="padding: 0 !important; position: relative; margin-top: 40px;text-align:center ">Referred by <b style="text-decoration: underline;margin-left: 5px;"> <?php if(isset($_GET['ref'])){
    echo $_GET['ref'];}else{ echo "n/a";} ?></b></div>
                <input type="hidden" id="register_ref" value="<?php
                                            if(isset($_GET['ref'])){
                                                echo $_GET['ref'];
                                            }else{
                                                echo '';
                                            }
                                            ?>">
                
                <div class="account-modal-bottom" style="padding: 0 !important; position: relative; margin-top: 40px;text-align:center ">Already have an Account? <a id="loginNowBtn" style="text-decoration: underline;margin-left: 5px;"><b>Login Here</b></a></div>
                
                <div class="account-modal-bottom" style="padding: 0 !important; position: relative; margin: 40px auto !important;text-align: center;display: flex;justify-content: center; ">
		<button class="btn btn--blue register-btn" style="text-decoration:none" id="register_submit"> <span>Register your account</span>
				<div class="spinner" style="display:block">
					<div class="bounce1"></div>
					<div class="bounce2"></div>
					<div class="bounce3"></div>
				</div>
			</button>
		</div>
                <div class="account-modal-bottom r_message" style="padding: 0 !important; position: relative; margin: 40px auto !important;text-align: center;display: flex;justify-content: center; ">
<!--                    <div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px"> Registration Successful</div>-->
                </div>
                    
                
                
<!--
                <a id="forgotNowBtn" style="cursor:pointer" onclick="openModal('forgot-modal')">Forgot your password? Click here.</a>
                <div class="account-modal-bottom"> Don't have an account? <a id="registerNowBtn" class="register-btn pointer">Create an account.</a>
                    <button class="btn btn--blue">login</button>
                </div>
-->
            </form>
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#signup_form").submit(function(event) {
                event.preventDefault();
//
                var ref = $("#register_ref").val();
                var full_name = $("#register_full_name").val();
                var username = $("#register_username").val();
                var email = $("#register_email").val();
                var country = $("#country").val();
                var email1 = $("#register_email2").val();
                var password = $("#register_password").val();
                var password2 = $("#register_password2").val();
                var phone = $("#register_phone").val();
                var create_button = $("#register_submit").val();
//                var agree = $('#agree').is(":checked");  
//                console.log("ref: " + ref + " full_name: " + full_name + " username: " + username +" country: " + country + " email: " + email + " email1: " + email1 + " password: " + password + " password2: " + password2 + " phone: " + phone + " create_button: " + create_button)


//                $("#new-password--js").val('');
                $("#register_submit").html('<b>....</b>');
                $.ajax({
                    type: "POST",
                    url: "phpscripts/signup.php/",
                    data: {
                        ref: ref,
                        full_name: full_name,
                        username: username,
                        country: country,
                        email: email,
                        email1: email1,
                        password: password,
                        password2: password2,
                        phone: phone,
                        create_button: create_button
                    },
                    success: function(response) {
                        $(".r_message").html(response);
                        //      console.log(response);
                        //      console.log("Done"); 
                        $("#register_submit").html('Register your account');
                    },
                    error: function(response) {
                        console.log(response);
                        $("#register_submit").html('Register your account');
                    }
                });

            });

        });

    </script>

        </div>



        <div class="modal-general forgot-modal">
            <button class="modal-close">
                <svg viewBox="0 0 11.58 11.58">
                    <use xlink:href="#closeIcon"></use>
                </svg>
            </button>
            <div class="modal-title">
                <svg viewBox="0 0 15.77 13.47">
                    <use xlink:href="#registerUserIcon"></use>
                </svg>
                Forgot Password </div>
<!--            <iframe name="forgotpass" src="?a=forgot_password" id="forgotIframe" frameborder="0" scrolling="no" onload="resizeIframe($(this))" style="min-height:250px"></iframe>-->
            <form method="post" name="forgotform" id="forgot_password1" target="forgotpass">
<!--
                <input type="hidden" name="form_id" value="16081205908176">
                <input type="hidden" name="form_token" value="e36b8424555d05162d905c443dc5cc18">
        <input type="hidden" name="a" value="forgot_password">
        <input type="hidden" name="action" value="forgot_password">
-->
        <div class="input-holder-byicon">
            <input type="text" name="email" id="forgot_email" value="" placeholder="Type your E-mail" style="padding-right:100px">
            <!----
    <a class="red-gradient pointer" onclick="populateform()" style="position: absolute;right: 10px;top: calc((100% - 30px)/2);color: #fff;padding: 5px 10px;border-radius: 5px;">Generate</a>
---->
        </div>
        
        <div class="account-modal-bottom" style="padding: 0 !important; position: relative; margin-top: 40px;display: flex;justify-content: center; ">
            <button class="btn btn--blue register-btn" style="text-decoration:none" id="forgot_submit1"> <span>Forgot Password</span>
                <div class="spinner" style="display:none">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>
            </button>
        </div>
                <div class="input-row fo1_message" style="padding: 0px !important; margin: 25px auto !important;text-align: center;display: flex;justify-content: center; ">
<!--                    <div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px"> Registration Successful</div>-->
                </div>
    </form>
                               <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#forgot_password1").submit(function(event) {
                event.preventDefault();
                

                var email = $("#forgot_email").val();
                var forgot_submit1 = $("#forgot_submit1").val();
                
                console.log("forgot_email: " + email );


//                $("#new-password--js").val('');
                $("#forgot_submit1").html('<b>....</b>');
                $.ajax({
                    type: "POST",
                    url: "phpscripts/forgot_password.php/",
                    data: {
                        email: email,
                        forgot_submit1: forgot_submit1
                    },
                    success: function(response) {
                        $(".fo1_message").html(response);
                        //      console.log(response);
                        //      console.log("Done"); 
                        $("#forgot_submit1").html('Forgot Password');
                    },
                    error: function(response) {
                        console.log(response);
                        $("#forgot_submit1").html('Forgot Password');
                    }
                });

            });

        });

    </script>
        </div>
        
        
        <div class="modal-general forgot-modal2">
            <button class="modal-close">
                <svg viewBox="0 0 11.58 11.58">
                    <use xlink:href="#closeIcon"></use>
                </svg>
            </button>
            
            <div class="modal-title">
                <svg viewBox="0 0 15.77 13.47">
                    <use xlink:href="#registerUserIcon"></use>
                </svg>
                Forgot Password </div>
<!--            <iframe name="forgotpass" src="?a=forgot_password" id="forgotIframe" frameborder="0" scrolling="no" onload="resizeIframe($(this))" style="min-height:250px"></iframe>-->
            <form method="post" name="forgotform" id="forgot_password2" target="forgotpass">
                
        <div class="input-holder-byicon">
            <input type="password" name="forgot_password" id="forgot_password" value="" placeholder="Type your New Password" style="padding-right:100px">
        </div>  
                
        <div class="input-holder-byicon">
            <input type="password" name="forgot_password4" id="forgot_password4" value="" placeholder="Confirm Password" style="padding-right:100px">
        </div>
        
        <div class="account-modal-bottom" style="padding: 0 !important; position: relative; margin-top: 40px;display: flex;justify-content: center; ">
            <button class="btn btn--blue register-btn" style="text-decoration:none" id="forgot_submit2"> <span>Change Pasword</span>
                <div class="spinner" style="display:none">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>
            </button>
        </div>
                <div class="input-row fo2_message" style="padding: 0px !important; margin: 25px auto !important;text-align: center;display: flex;justify-content: center; ">
                </div>
    </form>
                               <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            if(<?php echo '"' . $forgot_passsword_v . '"'; ?> == "true"){
               $("#forgot_p_onclick").trigger("click"); 
                console.log("true");
            }else{
                console.log("false");
            }
            
            
            $("#forgot_password2").submit(function(event) {
                event.preventDefault();
                
                var email = <?php if(isset($_GET['email'])){ echo '"' . $_GET['email'] . '"';} ?>;
                var elapsetime = <?php if(isset($_GET['email'])){ echo '"' . $get_et . '"';} ?>;
                var forgot_password = $("#forgot_password").val();
                var forgot_password4 = $("#forgot_password4").val();
                var forgot_submit2 = $("#forgot_submit2").val();
                


//                $("#new-password--js").val('');
                $("#forgot_submit2").html('<b>....</b>');
                $.ajax({
                    type: "POST",
                    url: "phpscripts/forgot_password.php/",
                    data: {
                        email: email,
                        elapsetime: elapsetime,
                        forgot_password: forgot_password,
                        forgot_password2: forgot_password4,
                        forgot_submit2: forgot_submit2
                    },
                    success: function(response) {
                        $(".fo2_message").html(response);
                        //      console.log(response);
                        //      console.log("Done"); 
                        $("#forgot_submit2").html('Change Pasword');
                    },
                    error: function(response) {
                        console.log(response);
                        $("#forgot_submit2").html('Change Pasword');
                    }
                });

            });

        });

    </script>
        </div>


        <div class="contact-modal">
            <button class="modal-close">
                <svg viewBox="0 0 11.58 11.58" stroke="#fff">
                    <use xlink:href="#closeIcon"></use>
                </svg>
            </button>
            <div class="contact-modal__form">


                <form method=post name=mainform id="support_form" style="height:auto !important">
<!--
                    <input type="hidden" name="form_id" value="16080211547515">
                    <input type="hidden" name="form_token" value="f8b34e1479c0d31625b117a7ec847c1f">
                    <input type=hidden name=a value=support>
                    <input type=hidden name=action value=send>
-->
                    <div class="input-row">
                        <input type="text" name="name" id="support_name" value="" placeholder="Your name">
                        <label></label>
                        <svg viewBox="0 0 9.99 13.47">
                            <use xlink:href="#userIcon"></use>
                        </svg>
                    </div>
                    <div class="input-row">
                        <input type="text" name="email" id="support_email" value="" placeholder="Your Email Address">
                        <label></label>
                        <svg viewBox="0 0 17.3 13.33">
                            <use xlink:href="#emailIcon"></use>
                        </svg>
                    </div>
                    <div class="input-row">
                        <textarea name="message" id="support_message" placeholder="Your message"></textarea>
                        <label></label>
                        <svg viewBox="0 0 17.3 13.33">
                            <use xlink:href="#messageIcon"></use>
                        </svg>
                    </div>
                    <button type="submit" id="support_submit" class="btn btn--blue">Send</button>
                    <br><br>
                    <div class="input-row s_message" style="padding: 0px !important; margin: 25px auto !important;text-align: center;display: flex;justify-content: center; ">
<!--                    <div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px"> Registration Successful</div>-->
                </div>
                </form>
                   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#support_form").submit(function(event) {
                event.preventDefault();
                

                var name = $("#support_name").val();
                var email = $("#support_email").val();
                var message = $("#support_message").val();
                var support_submit = $("#support_submit").val();
                
                console.log("name: " + name + " email: " + email  + " message: " + message );


//                $("#new-password--js").val('');
                $("#support_submit").html('<b>....</b>');
                $.ajax({
                    type: "POST",
                    url: "phpscripts/support.php/",
                    data: {
                        name: name,
                        email: email,
                        message: message,
                        support_submit: support_submit
                    },
                    success: function(response) {
                        $(".s_message").html(response);
                        //      console.log(response);
                        //      console.log("Done"); 
                        $("#support_submit").html('Send');
                    },
                    error: function(response) {
                        console.log(response);
                        $("#support_submit").html('Send');
                    }
                });

            });

        });

    </script>
            </div>
            <div class="contact-modal__info">
                <ul>
                    <li>
                        <svg viewBox="0 0 29.23 29.27">
                            <use xlink:href="#phoneIcon"></use>
                        </svg>
                        phone number <strong> <?php echo $support_phone; ?></strong> </li>
                    <li>
                        <svg viewBox="0 0 28.11 28.28">
                            <use xlink:href="#emailInfo"></use>
                        </svg>
                        email address <strong> <?php echo $support_email; ?></strong> </li>
                    <li>
                        <svg viewBox="0 0 26.92 28.82">
                            <use xlink:href="#locationIcon"></use>
                        </svg>
                        address <strong class="address">249 GROSVENOR STREET, MAYFAIR, LONDON, ENGLAND, W1K 3HP</strong> </li>
                </ul>
            </div>
            
        </div>

<!--              <div class="modal-holder" bis_skin_checked="1" style="display: none;">      -->
        <div class="modal-general withdrawal-modal" bis_skin_checked="1" style="display: none;">
            <button class="modal-close">
                <svg viewBox="0 0 11.58 11.58">
                    <use xlink:href="#closeIcon"></use>
                </svg>
            </button>
            <form method="post" id="withdrawal_form">
                
                <?php
                if(isset($_SESSION['id'])){
                     if(normalize_amount($account_balance) > 0){
                    ?>
                <div class="input-holder-byicon">
                    <label for="country" style="margin-left:10px;color:#696969">Bitcoin Wallet Adress:</label><br>
                    <input type="text" name="withdraw_bitcoin_address" id="withdraw_bitcoin_address" value="<?php
                        if(!empty($bitcoin_wallet_address)){
                            echo $bitcoin_wallet_address;
                        }else{
                            echo "Not Set";
                        }
                
                        ?>" style="font-size: 14px;background-color:grey" autofocus placeholder="Username" readonly>
                    <label for="country" style="margin-left:10px;color:#000">Make sure your wallet address is correct:</label><br>
                </div><br>
                <div class="input-holder-byicon">
                    <label for="plan" style="margin-left:10px;color:#A8A8A8">Withdaw from:</label><br>
                   <select id="plan" class="plan_select" name="country" style="height:60px !important;width:inherit !important;font-size:13px !important;padding:0px 15px !important;margin-right:0px !important;border-radius:4px;">
                       <option value="">Select plan to withdraw</option>
                        <?php 
                                $plans_b = [];
                                $plans_c = [];
                                $plans_array = array("BASIC PLAN", "BRONZE PLAN", "SILVER PLAN", "PREMIUM PLAN");
                        if(isset($_SESSION['id'])){
                            $user_i = $_SESSION['id'];
                            include('phpscripts/connection.php');
                               $sql = "SELECT * FROM `deposit_list` WHERE u_id = '$user_i' AND status= 'pending'" ;
                                
                                          if($result = mysqli_query($link, $sql)){
                                    if(mysqli_num_rows($result)>0){
                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                            $plans_b[] = $row;

                                        }
                                    }
                                          }
                            
                            
                            if(!empty($plans_b)){
                                foreach($plans_b as $plb){
                                    $plans_c[] = $plb['type'];
                                }
                            }
                            sort($plans_c);
                            $plans_c = array_unique($plans_c);
                        }
                        if(!empty($plans_c)){
                            foreach($plans_c as $plc){
                                echo '<option value="'. $plc .'">' . $plans_array[$plc - 1] . '</option>';
                            }
                        }
                        if(isset($_SESSION['id'])){
                            if($total_referal_commission != '' && $total_referal_commission > 0){
                                echo '<option value="5">REFERRAL COMMISSION</option>';
                            }
                        }
                    
                       ?>
                    </select>
                </div>
                <div class="input-holder-byicon">
                    <label for="country" style="margin-left:10px;color:#696969">Amount($):</label><br>
                    <input type="text" name="withdraw_amount" id="withdraw_amount" value='0' style="font-size: 14px;" autofocus placeholder="Amount" readonly>
                </div><br>
                <div class="input-holder-byicon">
                    <label for="country" style="margin-left:10px;color:#696969">Enter Password:</label><br>
                    <input type="password" name="withdraw_password" id="withdraw_password" value='' style="font-size: 14px;" autofocus placeholder="Password">
                </div>
                
                
                <div class="account-modal-bottom" style="padding: 0 !important; position: relative; margin: 40px auto !important;text-align: center;display: flex;justify-content: center; ">
		<button class="btn btn--blue register-btn" style="text-decoration:none" id="withdrawal_submit"> <span>Withdraw Funds</span>
				<div class="spinner" style="display:block">
					<div class="bounce1"></div>
					<div class="bounce2"></div>
					<div class="bounce3"></div>
				</div>
			</button>
		</div>
                <div class="account-modal-bottom wi_message" style="padding: 0 !important; position: relative; margin: 40px auto !important;text-align: center;display: flex;justify-content: center; ">
                </div>
                <?php
                }else{
                    ?>
                <div class="error-modal">
                  <div class="modal-head">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 99.5 99.95">
                      <defs>
                        <linearGradient id="linear-gradient-error" x1="856.76" y1="412.02" x2="937.99" y2="412.02" gradientUnits="userSpaceOnUse">
                          <stop offset="0" stop-color="#ff6873"></stop>
                          <stop offset="1" stop-color="#ff896c"></stop>
                        </linearGradient>
                      </defs>
                      <path d="M902.85,455.57c-17.44,6.74-58.1-16.06-62.89-31.67-3.31-10.78,11.94-20.53,17.07-30.49,5-9.66,3.83-25.67,14.3-30.51,23-10.6,52.71.23,60.43,24.53,3.49,11-6.38,23.39-10.89,34.11C916.54,431.86,914.12,451.22,902.85,455.57Z" transform="translate(-838.49 -357.84)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" stroke-width="2"></path>
                      <path d="M937.83,411c.78,10.66-1.18,22.21-7.61,30.51a27.82,27.82,0,0,1-21.9,10.86,32.92,32.92,0,0,1-8.78-1C880,444,848,426,859,403c7-15,23-33,42.67-31.22a32.64,32.64,0,0,1,8.61,1.79,33.31,33.31,0,0,1,15.82,9.93,49.94,49.94,0,0,1,4,4.9C933,392,937.76,406.81,937.83,411Z" transform="translate(-838.49 -357.84)" fill="url(#linear-gradient-error)"></path>
                      <line x1="51.74" y1="46.79" x2="68.31" y2="63.35" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="4"></line>
                      <line x1="68.31" y1="46.79" x2="51.74" y2="63.35" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="4"></line>
                    </svg>
                    <h2>Sorry!</h2>
                  </div>
                  <ul>
                    <li>
                      <p>You have no funds to withdraw.</p>
                    </li>
                  </ul>
                </div>
                <?php
                }
                }
                ?>
                
                
            </form>
                <script>
        $(document).ready(function() {
            
    $('.plan_select').change(function() {
        var plan_g = $(".plan_select").val();
        var get_amount = "";
        var u_id = <?php
            if(isset($_SESSION['id'])){
                     echo '"' . $_SESSION['id'] . '"'; 
                    }
            
             ?>;
//        console.log(plan_g);
        var total_referal_commission = <?php
            if(isset($_SESSION['id'])){
                     echo '"' . $total_referal_commission . '"';
                    }
            
             ?>;
        if(plan_g != ""){
            $.ajax({
                    type: "POST",
                    url: "phpscripts/withdraw.php/",
                    data: {
                        u_id: u_id,
                        total_referal_commission: total_referal_commission,
                        plan_g: plan_g,
                        get_amount: get_amount
                    },
                    success: function(response) {
//                        $(".wi_message").html(response);
                        $('#withdraw_amount').attr('value', response)
                              console.log(response);
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
        }else{
            $('#withdraw_amount').attr('value', 0);
        }
                        
});         
            
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////          
            $("#withdrawal_form").submit(function(event) {
                event.preventDefault();
                var u_id = <?php
                    if(isset($_SESSION['id'])){
                      echo '"' . $_SESSION['id'] . '"';  
                    }
                    
                     ?>;
                var main_password = <?php
                    if(isset($_SESSION['id'])){
                      echo '"' . $password . '"';  
                    }
                    
                     ?>;
                var email = <?php
                    if(isset($_SESSION['id'])){
                      echo '"' . $email . '"';  
                    }
                    
                     ?>;
                var account_balance = <?php
                    if(isset($_SESSION['id'])){
                      echo '"' . $account_balance . '"';  
                    }
                    
                     ?>;
                var withdraw_bitcoin_address = $("#withdraw_bitcoin_address").val();
                var plan_c = $(".plan_select").val();
                if ($("#plan").val() != ''){
                    plan = '';
                }
                var withdraw_password = $("#withdraw_password").val();
                var withdraw_amount = $("#withdraw_amount").val();
                var withdrawal_submit = $("#withdrawal_submit").val();
//                
//                console.log("email: " + email + " account_balance: " + account_balance  + " withdraw_amount: " + withdraw_amount + " plan: " + plan_c);


//                $("#new-password--js").val('');
                $("#withdrawal_submit").html('<b>....</b>');
                $.ajax({
                    type: "POST",
                    url: "phpscripts/withdraw.php/",
                    data: {
                        u_id: u_id,
                        plan: plan_c,
                        main_password: main_password,
                        email: email,
                        account_balance: account_balance,
                        withdraw_bitcoin_address: withdraw_bitcoin_address,
                        withdraw_password: withdraw_password,
                        withdraw_amount: withdraw_amount,
                        withdrawal_submit: withdrawal_submit
                    },
                    success: function(response) {
                        $(".wi_message").html(response);
                        //      console.log(response);
                        //      console.log("Done"); 
                        $("#withdrawal_submit").html('Withdraw Funds');
                    },
                    error: function(response) {
                        console.log(response);
                        $("#withdrawal_submit").html('Withdraw Funds');
                    }
                });

            });

        });

    </script>
        </div>
<!--    </div>-->
<div class="modal-general count_down-modal" bis_skin_checked="1" style="display: none;">
            <button class="modal-close">
                <svg viewBox="0 0 11.58 11.58">
                    <use xlink:href="#closeIcon"></use>
                </svg>
            </button>
            <form method="post" id="withdrawal_form">
                
              <h1 style="text-align:center;color:#A38A00">+$200 </h1>  
              <h2 style="text-align:center;">Welcome Bonus</h2>
                
              <h5 style="text-align:center;">Deposit funds(0.045+ BTC) to your account now, and enjoy extra benefit: <span style="color:#A38A00">$200 Bonus</span></h5>
                <br>
                <h6 style="text-align:center;">Time Left:</h6>
<!--                <h3 id="tester"><?php if(isset($_SESSION['id'])){
                                                          echo $c_time - $reg_stamp;
                                                        }
 ?></h3>-->
                <h2 style="text-align:center;"><span style="background-color:#808080;padding:6px;border-radius:3.5px;" id="count_hour">24</span> : <span style="background-color:#808080;padding:6px;border-radius:3.5px;" id="count_min">00</span> : <span style="background-color:#808080;padding:6px;border-radius:3.5px;" id="count_sec">00</span></h2>
                <h6 style="text-align:center;"><span style="margin-right:6.5%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hours</span> <span style="margin-right:6.5%">&nbsp;&nbsp;&nbsp;&nbsp;Minutes</span> <span style="margin-right:3%">seconds</span></h6>
                
                <br><br>
                <h5 style="text-align:center;">Simply click the "Deposit" or "Make A Deposit", follow the instructions and get your account funded. The minimum amount to deposit is equal to 0.001BTC and there is no fees on deposits</h5>
            </form>

        </div>
        <input type="hidden" id="diff_value" value="<?php 
                                                    if(isset($_SESSION['id'])){
                                                          echo $c_time - $reg_stamp;  
                                                        }
                                                     ?>">
        <input type="hidden" id="login_count_v" value="<?php 
                                                       if(isset($_SESSION['id'])){
                                                          echo $login_count; 
                                                        }
                                                        ?>">
            <script>
                
        $(document).ready(function() {
            var current_diff1 = $("#diff_value").val();
            var login_count_v = $("#login_count_v").val();
            var current_diff = current_diff1;
//            var variable = [1, 2, 3];
//            console.log(current_diff1);
            function format_d(xt){
                var lnt = xt.toString().length;
                var nvb = xt;
                    if(lnt < 2){
                        nvb = "0" + xt;
                    }else{
                        nvb = xt;
                    }
                return nvb;
            }
            if(current_diff1 < 86400 && login_count_v == 0){
                
                current_diff = 86397;
                $("#open_counter").trigger("click");
                window.setInterval(function(){
                    
                   current_diff = current_diff - 1
                    var hr;
                    var mn;
                    var sc;
                    hr = Math.floor(current_diff/3600);
                    
                    var n = current_diff % 3600;
                    mn = Math.floor(n/60);
                    sc = n % 60;
                    $('#count_hour').html(format_d(hr));
                    $('#count_min').html(format_d(mn));
                    $('#count_sec').html(format_d(sc));
                    
                }, 1000);
               }

        });

    </script>
        <div class="modal-general deposit_modal1" bis_skin_checked="1" style="display: none;">
            <button class="modal-close" id="first_close">
                <svg viewBox="0 0 11.58 11.58">
                    <use xlink:href="#closeIcon"></use>
                </svg>
            </button>
            <form method="post" id="deposit_form1">
                
              <h2 style="text-align:center;">Pay With BTC through Coinpayment</h2>
              <h4 style="text-align:center;">to AstroForex</h4>
                
                <div class="input-holder-byicon">
                    <label for="de_amount" style="margin-left:10px;color:#696969">Amount($):</label><br>
                    <input type="text" name="de_amount" id="de_amount" value='0' style="font-size: 14px;" autofocus placeholder="Amount" readonly>
                </div><br>
                <div class="input-holder-byicon">
                    <label for="de_email" style="margin-left:10px;color:#696969">Enter E-mail:</label><br>
                    <input type="text" name="de_email" id="de_email" value='' style="font-size: 14px;" autofocus placeholder="E-mail">
                </div>
                
                
                <div class="account-modal-bottom" style="padding: 0 !important; position: relative; margin: 40px auto !important;text-align: center;display: flex;justify-content: center; ">
		<button class="btn btn--blue register-btn" style="text-decoration:none" id="de_submit"> <span>Pay to AstroForex</span>
				<div class="spinner" style="display:block">
					<div class="bounce1"></div>
					<div class="bounce2"></div>
					<div class="bounce3"></div>
				</div>
			</button>
		</div>
                <div class="account-modal-bottom de1_message" style="padding: 0 !important; position: relative; margin: 40px auto !important;text-align: center;display: flex;justify-content: center; ">
                </div>
                
            </form>
            <script>
        $(document).ready(function() {
                     
            $("#deposit_form1").submit(function(event) {
                event.preventDefault();
                var u_id = <?php 
                    if(isset($_SESSION['id'])){
                      echo '"' . $_SESSION['id'] . '"';  
                    }
                     ?>;
                var username = <?php 
                    if(isset($_SESSION['id'])){
                        echo '"' . $username . '"';
                    }
                     ?>;
                var de_amount = $("#de_amount").val();
                var de_email = $("#de_email").val();
                var type = $("input[name='h_id']:checked").val();
                var de_submit = $("#de_submit").val();
                
//                console.log('Type: ' + type);
                
                $("#de_submit").html('<b>....</b>');
                $.ajax({
                    type: "POST",
                    url: "phpscripts/process.php/",
                    dataType: "json",
                    data: {
                        
                        u_id: u_id,
                        username: username,
                        de_amount: de_amount,
                        de_email: de_email,
                        type: type,
                        de_submit: de_submit
                    },
                    success: function(response) {
                        let json = null;
                    try {
                        json = JSON.parse(response); 
                    } catch (e) {
                        json = response;
                    }
                        if(json.error != "ok"){
                            
                            var message = '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">' + json.error +'</div>';
                            $(".de1_message").html(message);
                        }else{
                           $(".de1_message").html(" "); 
                            $("#first_close").trigger("click");
                            $("#btc_value").html(json.amount);
                            $("#pay_now_button").attr("href", json.gateway_url);
                            $("#deposit_onclick2").trigger("click");
                        }
                    
                    console.log(json.error);
                        $("#de_submit").html('Pay to AstroForex');
                    },
                    error: function(response) {
                        console.log(response);
                        $("#de_submit").html('Pay to AstroForex');
                    }
                });

            });

        });

    </script>

        </div>
                <div class="modal-general deposit_modal2" bis_skin_checked="1" style="display: none;">
            <button class="modal-close" id="second_close">
                <svg viewBox="0 0 11.58 11.58">
                    <use xlink:href="#closeIcon"></use>
                </svg>
            </button>
            <form method="post" id="deposit_form2">
                
              <h2 style="text-align:center;">Pay With BTC through Coinpayment</h2>
              <h4 style="text-align:center;">to AstroForex</h4>
                
                <div class="input-holder-byicon">
                    <label for="de_amount" style="margin-left:10px;color:#696969">Amount(BTC):</label><br>
                    <h2 style="margin-left:10px"><span id="btc_value">0.0988488</span> BTC</h2>
                </div><br>
                
                <h5 style="text-align:center;">Please pay exactly the stated amount</h5>
                <div class="account-modal-bottom" style="padding: 0 !important; position: relative; margin: 10px auto !important;text-align: center;display: flex;justify-content: center; ">
		<a class="btn btn--blue register-btn" style="text-decoration:none" id="pay_now_button" href=""> <span>Pay Now</span>
				<div class="spinner" style="display:block">
					<div class="bounce1"></div>
					<div class="bounce2"></div>
					<div class="bounce3"></div>
				</div>
			</a>
                    
		</div>
                <div class="account-modal-bottom de1_message" style="padding: 0 !important; position: relative; margin: 40px auto !important;text-align: center;display: flex;justify-content: center; ">
                </div>
                
            </form>
            <script>
        $(document).ready(function() {
            

        });

    </script>

        </div>
    </div>
    
    <script src="scripts/jquery-3.2.1.min.js"></script>
    <script src="scripts/TweenMax.min.js"></script>
    <script src="scripts/layout.js@ver=50"></script>
    <script src="scripts/ScrollMagic.min.js"></script>
    <script src="scripts/DrawSVGPlugin.min.js"></script>
    <script src="scripts/svg4everybody.min.js"></script>
    <script src="scripts/animation.gsap.min.js"></script>
    <script src="scripts/MorphSVGPlugin.min.js"></script>
    <script src="scripts/owl.carousel.min.js"></script>
    <script src="scripts/page.index.js@ver=10"></script>

<script src="scripts/anime.js"></script>
<script src="scripts/page.about.js"></script>
<script src="scripts/calculator.js@ver=5"></script> 
<script src="scripts/page.services.js@ver=10"></script> 
<script src="scripts/page.dashboard.js@ver=35"></script>
    <script src="scripts/page.helpCenter.js@ver=25"></script> 
    <script src="scripts/clipboard.min.js"></script> 
    <script>
        svg4everybody()

    </script>
    
<script>
    new Clipboard('.btn--outlineCopylink');
</script>
    
            <div class="c_message"></div>

    <script>
        $(document).ready(function() {
            $(".logout_button").click(function(event) {
                event.preventDefault();
                var logout_button = $(".logout_button").val();
//                console.log("clicked")
                $.ajax({
                    type: "POST",
                    url: "phpscripts/logout.php/",
                    data: {
                        logout_button: logout_button
                    },
                    success: function(response) {
                        $(".c_message").html(response);
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });

            });

        });

    </script>
    <?php
//    print_r($regt_diff);
    ?>
</body>

</html>
