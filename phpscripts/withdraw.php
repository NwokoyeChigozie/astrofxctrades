    <?php 
ob_start();
//Start session
session_start();
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP'])){
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
           }elseif(isset($_SERVER['HTTP_X_FORWARDED'])){
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
           }elseif(isset($_SERVER['HTTP_FORWARDED_FOR'])){
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
           }elseif(isset($_SERVER['HTTP_FORWARDED'])){
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
           }elseif(isset($_SERVER['REMOTE_ADDR'])){
        $ipaddress = $_SERVER['REMOTE_ADDR'];
           }else{
        $ipaddress = 'UNKNOWN';
    }
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
    return $ip;
}
//echo get_client_ip();
$ip = get_client_ip();
//echo $_SERVER['REMOTE_ADDR'];
//        print_r($_SERVER['REMOTE_ADDR']);
//$ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
//echo "<br><br>$ip";
?>
<?php
include('connection.php');
 function test_input($data){
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     return $data;
 }
function digit_check($string){
    if (preg_match('~[0-9]+~', $string)) {
            return "True";
        }else{ return "False";}
}

    
if(isset($_POST['get_amount'])){
    $plans_b = [];
    $max_amount = 0;
    $u_id = mysqli_real_escape_string($link, $_POST['u_id']);
    $plan_g = mysqli_real_escape_string($link, $_POST['plan_g']);
    $total_referal_commission = mysqli_real_escape_string($link, $_POST['total_referal_commission']);
//    echo "REF C: $total_referal_commission <br>";
    if($plan_g != 5){
         $sql = "SELECT * FROM `deposit_list` WHERE u_id = '$u_id' AND type = '$plan_g' AND status = 'pending' " ;
                                
                       if($result = mysqli_query($link, $sql)){
                              if(mysqli_num_rows($result)>0){
                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                            $plans_b[] = $row;

                                        }
                                    }
                                          }
                                if(!empty($plans_b)){
                                    foreach($plans_b as $plb){
                                        $max_amount = $max_amount + $plb['total_amount'];
                                    }
                                }
        echo $max_amount;
    }else{
       echo $total_referal_commission;
    }
}



if(isset($_POST['withdrawal_submit'])){ 
    $plan_duration = array(0, 259200,432000,604800,15552000);
    $purpose = "Withdrawal";
    $max_amount = 0;
    $plans_b = [];
    $plans_r = [];
    $least_withdrawable = 15;
    $u_id = mysqli_real_escape_string($link, $_POST['u_id']);
    $main_password = mysqli_real_escape_string($link, $_POST['main_password']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $account_balance = mysqli_real_escape_string($link, $_POST['account_balance']);
    $withdraw_bitcoin_address = mysqli_real_escape_string($link, $_POST['withdraw_bitcoin_address']);
    $withdraw_password = mysqli_real_escape_string($link, $_POST['withdraw_password']);
    $withdraw_amount = mysqli_real_escape_string($link, $_POST['withdraw_amount']);
    $plan = mysqli_real_escape_string($link, $_POST['plan']);
    $user_name = $_SESSION['username'];
       $sql = "SELECT * FROM `admin` WHERE `id` = '1'" ;
          if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $least_withdrawable = $row['minimum_amount']; 
        }
        //close the result set
        mysqli_free_result($result);

    }
}   
  
    function check_plan($u_id, $plan){
        include('connection.php');
        $plan_duration = array(0, 259200,432000,604800,15552000);
        $plans_r = [];
               $sql = "SELECT * FROM `deposit_list` WHERE u_id = '$u_id' AND type = '$plan'" ;
                                
                       if($result = mysqli_query($link, $sql)){
                              if(mysqli_num_rows($result)>0){
                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                            
                                            $diff_t = time() - $row['create_timestamp'];
//                                            echo "1. $diff_t; 1. $plan_duration[$plan]";
                                            $plans_r[] = $diff_t - $plan_duration[$plan];
                                            

                                        }
                                    }
                                          }
                  
                            rsort($plans_r);
//                            print_r($plans_r);
                            if($plans_r[0] > 0){
                               return "true"; 
                            }else{
                               return "false";  
                            }
    }

        if (empty($plan)) {
                    echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Select plan</div>';
                } else {
                    $plan = test_input($plan);
              if ($plan < 5 && check_plan($u_id, $plan) == "false") {
                  
                  echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Cannot withdraw from this plan at the moment</div>';
                  
                } else {
                    
        if (empty($withdraw_amount)) {
                    echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Error Occured while retrieving amount</div>';
                } else {
                    $withdraw_amount = test_input(strtolower($withdraw_amount));
        
            
              if (!is_numeric($withdraw_amount)) {
                    echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Please enter a valid amount</div>';
                    } else {
              if ($withdraw_amount <= 0 || $withdraw_amount < $least_withdrawable) {
                    echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Minimum Withdrawal amount is $' . $least_withdrawable . '</div>';
                } else {

  

           
                                    
                         if (empty($withdraw_password)) {
                            echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Enter Password</div>';
                        } else {
                            $withdraw_password = test_input($withdraw_password);
                             $withdraw_password = hash('sha256', $withdraw_password);
      
                         if ($withdraw_password != $main_password) {
                                echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Password is incorrect</div>';
                            } else {
                             
                             $sql = "SELECT * FROM withdrawal WHERE u_id='$u_id' AND status='pending'";
        $result = mysqli_query($link, $sql);
        if(!$result){
        //    echo '<div class="alert alert-danger">Error occurred!</div>';
            echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Error Occurred!</div>';
            exit;
        }
                //If email & password don't match print error
        $count = mysqli_num_rows($result);
        if($count >= 1){
            echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">You still have a pending withdrawal request, Try again later or contact support.</div>';
        }else{
          
          
                if($plan == 5){
                    $purpose = "Referral Commission";
                }
//            $registered_at = date("F d, Y h:i:s", time());
//            $withdrawal_date = date("M-d-Y h:i:s A", time());
            $withdrawal_date = date("d-m-Y", time());
                $sql= "INSERT INTO `withdrawal`(`u_id`,`type`,`username`, `currency`,`withdrawal_amount`, `btc_address`,`date`,`ip`, `status`) VALUES ('$u_id','$plan','$user_name','$','$withdraw_amount','$withdraw_bitcoin_address','$withdrawal_date','$ip','pending')";

    
        if(mysqli_query($link, $sql)){
            
//            $withdrawal_date = date("d-m-Y h:i:s A", time());
                $sql= "INSERT INTO `history`(`u_id`,`username`, `type`,`amount`, `date`,`status`) VALUES ('$u_id','$user_name','$purpose','$withdraw_amount','$withdrawal_date','pending')";
           
            if(mysqli_query($link, $sql)){
                echo '<div class="alert alert-success" style="border-radius:3px;text-align:center;background-color:green;color:#fff;padding:10px 85px;margin-top:0px">Withdrawal Successfully initiated.</div>';
            }else{
                 echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Query Error</div>';
            }
            
        }else{ 
//            echo "<p class='error'>Error occurred while creating user<p>";
              echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Query Error</div>';
             } 
    
 








} 
                         }
          
                
      }
          
              }
      }
                          }
      
                         }                 } 
                       
}

?>


