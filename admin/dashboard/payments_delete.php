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
                       $sql = "UPDATE `payments` SET 
`status`='error' WHERE `id`= '$p_id'";  
  if($result = mysqli_query($link, $sql)){
           
      
       echo "<div class='alert alert-success'>Payment successfully Removed!!</div>";
      //header("location:enter.php");
       header("Refresh:1; url=payments.php");
             }else{
    echo "<div class='alert alert-error'>Error occured, Try again later</div>"; 
       header("Refresh:2; url=payments.php");
      
  }  
      
      

    
    
    
              
 }
 ?>               
<!------------------------------------------save and delete--------------------------------------> 