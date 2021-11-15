<?php
//Start session
session_start();
//Connect to the database
include("../../phpscripts/connection.php");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
       <!--====== FAVICON ICON =======-->
    <link rel="apple-touch-icon" sizes="120x120" href="../../apple-touch-icon.png"> <link rel="icon" type="image/png" sizes="32x32" href="../../favicon-32x32.png"> <link rel="icon" type="image/png" sizes="16x16" href="../../favicon-16x16.png"> <link rel="manifest" href="../../site.webmanifest"> <link rel="mask-icon" href="../../safari-pinned-tab.svg" color="#5bbad5"> <meta name="msapplication-TileColor" content="#fff7f7"> <meta name="theme-color" content="#ffffff">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<!------------------------------------------save and delete-------------------------------------->
<?php
 if($_GET){ 
     $p_id= $_GET['id'];
     
$sql = "SELECT * FROM payments WHERE id='$p_id'";
$result = mysqli_query($link, $sql);
$payment_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
     
$p_id = $payment_row['id']; //BTC
$order_currency = $payment_row['to_currency']; //BTC
$order_total = $payment_row['amount']; //BTC
$u_id = $payment_row['u_id']; //BTC
$username = $payment_row['username']; //BTC
$type = $payment_row['type']; //BTC
$entered_amount = $payment_row['entered_amount']; //BTC

$u_sql = "SELECT * FROM users WHERE id='$u_id'";
$user_result = mysqli_query($link, $u_sql);
$user_data = mysqli_fetch_array($user_result, MYSQLI_ASSOC);
$u_registered_at = $user_data['registered_at']; 
     
 $history_amount = $entered_amount;
$reg_d = explode(' ', $u_registered_at);   
$reg_d =  $reg_d[0];
$rd_split = explode('-', $reg_d);
$reg_stamp = strtotime($rd_split[1] . '-' . $rd_split[0] . '-' . $rd_split[2] . ' ' . $reg_d[1]);
if(time() - $reg_stamp < 86400){
    $entered_amount = $entered_amount + 200;
} 
     
     
    $sql_t = "UPDATE `payments` SET `status`='completed' WHERE `id`= '$p_id'";    
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
                                            
                                            echo "<div class='alert alert-success'>Payment successfully Completed!!</div>";
                                            header("Refresh:2; url=payments.php");
                                            
                                        }else{
                                            echo "<div class='alert alert-error'>Error Updating Referral commission</div>"; 
                                            header("Refresh:2; url=payments.php");
                                            
                                        }
                            }else{
                                echo "<div class='alert alert-success'>Payment successfully Completed!!</div>";
                                            header("Refresh:2; url=payments.php");
                            }
                        
                            
                            
                        
                    }else{
                        echo "<div class='alert alert-error'>Error inserting into history list table</div>"; 
                                            header("Refresh:2; url=payments.php");
                    }
                }else{
                    echo "<div class='alert alert-error'>Error inserting into deposit list table</div>"; 
                                            header("Refresh:2; url=payments.php");

                }
                                            
                                            
                                        }else{
                                            echo "<div class='alert alert-error'>Error updating payments table</div>"; 
                                            header("Refresh:2; url=payments.php");
                                        }  
     
     
     
     
     
     
     
    
      
      

    
    
    
              
 }
 ?>               
<!------------------------------------------save and delete--------------------------------------> 