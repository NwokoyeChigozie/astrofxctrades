<?php
ob_start();
//Start session
session_start();
//Connect to the database
if(!isset($_SESSION['admin_id'])){
    header("location:../");
}
include("../../phpscripts/connection.php");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
       <!--====== FAVICON ICON =======-->
    <link rel="apple-touch-icon" sizes="120x120" href="../../apple-touch-icon.png"> <link rel="icon" type="image/png" sizes="32x32" href="../../favicon-32x32.png"> <link rel="icon" type="image/png" sizes="16x16" href="../../favicon-16x16.png"> <link rel="manifest" href="../../site.webmanifest"> <link rel="mask-icon" href="../../safari-pinned-tab.svg" color="#5bbad5"> <meta name="msapplication-TileColor" content="#fff7f7"> <meta name="theme-color" content="#ffffff">
    

    <link rel="apple-touch-icon" sizes="120x120" href="../../apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="../../favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="../../favicon-16x16.png">
<link rel="manifest" href="../../site.webmanifest">
<link rel="mask-icon" href="../../safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#fff7f7">
<meta name="theme-color" content="#ffffff">
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
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
        <li class="nav-item" style="float: right; background-color:blue;border-radius:20px">
        <a class="nav-link" href="logout.php" role="button">Logout</a>
      </li>
    </ul>

    <!-- Right navbar links -->

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="../../images/logo.png" alt="Logo" class="brand-image img-circle elevation-3"
           style=""><br>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
            
          </li>
          <li class="nav-item has-treeview menu-open">
            <a href="./users.php" class="nav-link active">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
              </p>
            </a>
            </li>
          <li class="nav-item has-treeview menu-open">
            <a href="./payments.php" class="nav-link">
              <i class="nav-icon fa fa-paper-plane"></i>
              <p>
                Payments
              </p>
            </a>
          </li> 
          <li class="nav-item has-treeview menu-open">
            <a href="./withdrawal_requests.php" class="nav-link">
              <i class="nav-icon fa fa-arrow-up"></i>
              <p>
                Withdrawal Requests
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview menu-open">
            <a href="./feedbacks.php" class="nav-link">
<!--              <i class="nav-icon fa fa-location-arrow"></i>-->
              <i class="nav-icon fa fa fa-reply"></i>
              <p>
<!--                  <i class="material-icons">menu</i>-->
                Feedbacks
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview menu-open">
            <a href="./add_funds.php" class="nav-link">
              <i class="nav-icon fa fa fa-plus"></i>
              <p>
                Add Funds
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


      
      <!-- Main content -->
    <section class="content" style="padding-bottom:40px"> <form method="post">
      <div class="row">

        <div class="col-md-12">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Edit User details</h3>
 <?php
if($_GET){   
    $id= $_GET['id'];
    
    
  $sql = "SELECT * FROM `users` WHERE `id` = '$id'" ;
          if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                     $id = $row['id'];
    $full_name =$row['full_name']; //
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
        }
        //close the result set
        mysqli_free_result($result);

    }else{
        echo "<p>User no longer exist</p>"; 

         }
}else{
    echo "<p>Unable to excecute: $sql. " . mysqli_error($link) ."</p>";   
            
}   
  
    
    
}
?> 


              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
                <input type="hidden" name="id" class="form-control" value="<?php echo $id; ?>">
              <div class="form-group">
                <label for="inputSpentBudget">Full Name</label>
                <input type="text" name="full_name" class="form-control" value="<?php echo $full_name; ?>">
              </div>
                
              <div class="form-group">
                <label for="inputSpentBudget">Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" readonly>
              </div>
                
              <div class="form-group">
                <label for="inputSpentBudget">E-mail</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>" readonly>
              </div>
                
    
              <div class="form-group">
                <label for="inputSpentBudget">Phone number</label>
                <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>">
              </div>
              <div class="form-group">
                <label for="inputSpentBudget">Country</label>
                <input type="text" name="country" class="form-control" value="<?php echo $country; ?>" readonly>
              </div>
                
              <div class="form-group">
                <label for="inputSpentBudget">Ip Address</label>
                <input type="text" name="ip_address" class="form-control" value="<?php echo $ip_address; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="inputSpentBudget">Referrer</label>
                <input type="text" name="ref" class="form-control" value="<?php echo $ref; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="inputSpentBudget">Registration Date</label>
                <input type="text" name="registered_at" class="form-control" value="<?php echo $registered_at; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="inputSpentBudget">Account Balance</label>
                <input type="text" name="account_balance" class="form-control" value="$<?php echo $account_balance; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="inputSpentBudget">Earned Total</label>
                <input type="text" name="earned_total" class="form-control" value="$<?php echo $earned_total; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="inputSpentBudget">Total Withdrawal</label>
                <input type="text" name="total_withdrawal" class="form-control" value="$<?php echo $total_withdrawal; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="inputSpentBudget">Last Withdrawal</label>
                <input type="text" name="last_withdrawal" class="form-control" value="$<?php echo $last_withdrawal; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="inputSpentBudget">Pending Withdrawal</label>
                <input type="text" name="pending_withdrawal" class="form-control" value="$<?php echo $pending_withdrawal; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="inputSpentBudget">Last Investment</label>
                <input type="text" name="last_deposit" class="form-control" value="$<?php echo $last_deposit; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="inputSpentBudget">Total Investment</label>
                <input type="text" name="total_deposit" class="form-control" value="$<?php echo $total_deposit; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="inputSpentBudget">Bitcoin Wallet Address</label>
                <input type="text" name="bitcoin_wallet_address" class="form-control" value="<?php echo $bitcoin_wallet_address; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="inputSpentBudget">Number of Referrals</label>
                <input type="text" name="no_of_referals" class="form-control" value="<?php echo $no_of_referals; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="inputSpentBudget">Total Referral Commission</label>
                <input type="text" name="total_referal_commission" class="form-control" value="$<?php echo $total_referal_commission; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="inputSpentBudget">Last Seen</label>
                <input type="text" name="last_seen" class="form-control" value="<?php echo $last_seen; ?>" readonly>
              </div>
               
                
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <button class="btn btn-success float-right" name="edit_user" type="submit">Save Changes</button>
            <?php 
            if($account_status == 'Verified'){ 
               echo "<a class='btn btn-danger btn-sm' href='disable.php?id=$id'>Disable User</a>";
            }else{
                echo "<a class='btn btn-success btn-sm' href='enable.php?id=$id'>Enable User</a>";
            }
            ?>
        </div>
      </div>
<!------------------------------------------save-------------------------------------->
<?php 
 if($_POST){      
     if(isset($_POST['edit_user'])){    
         $id= $_POST['id'];
    $full_name = mysqli_real_escape_string($link, $_POST['full_name']);
    $phone = mysqli_real_escape_string($link, $_POST['phone']);
     
     
 $sql = "UPDATE `users` SET `full_name` = '$full_name',`phone` = '$phone' WHERE `users`.`id` = $id";   
     
     
    if(mysqli_query($link, $sql)){
        
            $resultMessage = "<div class='alert alert-success'>Successfully updated</div>";
            echo $resultMessage;
        header("Refresh:1; url=edit.php?id=$id");
        
        }else{ 
        $resultMessage = "<div class='alert alert-error'>Error occured while updating database</div>";
            echo $resultMessage;
//        header("Refresh:1; url=users.php");
    } 
     }
    
               
 }
 ?>               
<!------------------------------------------save-------------------------------------->   
<!--
    </form></section>   
         <div class="row" style="padding;20px">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><strong>Trade History</strong></h3>


              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Group</th>
                      <th>Test1</th>
                      <th>Test2</th>
                      <th>Total</th>
                        <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><strong>المحبوب </strong></td>
                      <td><?php echo $group1a; ?></td>
                      <td><?php echo $group1b; ?></td>
                      <td><span class="tag tag-success"><?php echo $group1; ?></span></td>
                        <td>Beloved</td>
                    </tr>
                      <tr>
                      <td><strong> القوي </strong></td>
                      <td><?php echo $group2a; ?></td>
                      <td><?php echo $group2b; ?></td>
                      <td><span class="tag tag-success"><?php echo $group2; ?></span></td>
                          <td>Strong</td>
                    </tr>
                      <tr>
                      <td><strong>المثالي</strong></td>
                      <td><?php echo $group3a; ?></td>
                      <td><?php echo $group3b; ?></td>
                      <td><span class="tag tag-success"><?php echo $group3; ?></span></td>
                          <td>Ideal</td>
                    </tr>
                      <tr>
                      <td><strong>الصامت</strong></td>
                      <td><?php echo $group4a; ?></td>
                      <td><?php echo $group4b; ?></td>
                      <td><span class="tag tag-success"><?php echo $group4; ?></span></td>
                          <td>Silent</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>     
      
-->
    <!-- Main content -->
        
        
       
<!--
          <br><section class="content" style="padding-bottom:40px"><form method="post">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Add new history to trade history</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputEstimatedBudget">Transaction Detail</label>
                <input type="text" name="transaction" class="form-control" >
              </div>
                <div class="form-group">
                <label for="inputSpentBudget">Currency</label>
                <input type="text" name="currency" class="form-control" value="">
              </div>
              <div class="form-group">
                <label for="inputSpentBudget">Amount</label>
                <input type="text" name="amount" id="inputSpentBudget" class="form-control">
              </div>
                <div class="form-group">
                <label for="inputSpentBudget">Date</label>
                <input type="text" name="date" id="inputSpentBudget" class="form-control" >
              </div>
              <div class="form-group">
                <label for="inputSpentBudget">Comment</label>
                <input type="text" name="comment" id="inputSpentBudget" class="form-control" >
              </div>
              <div class="form-group">
                <label for="inputSpentBudget">Status</label>
                <input type="text" name="status" id="inputSpentBudget" class="form-control" >
              </div>
            </div>

          </div>
-->
<!--
        </div>
      </div>
      <div class="row">
        <div class="col-12">
            <button class="btn btn-success float-right" name="add_trade" type="submit">Add trade &nbsp;<span class="fa fa-plus"></span></button>
        </div>
      </div><br>
-->
<?php
 if($_POST){  
 if(isset($_POST['add_trade'])){
     $transaction = $_POST['transaction']; $transaction = mysqli_real_escape_string($link, $transaction);
     $amount = $_POST['amount']; $amount = mysqli_real_escape_string($link, $amount);
     $date = $_POST['date']; $date = mysqli_real_escape_string($link, $date);
     $currency = $_POST['currency']; $currency = mysqli_real_escape_string($link, $currency);
     $comment = $_POST['comment']; $comment = mysqli_real_escape_string($link, $comment);
     $status = $_POST['status']; $status = mysqli_real_escape_string($link, $status);
     //Check user inputs
    //Define error messages
$missingTransaction = '<p style="background-color:red;text-align:center"><stong>Please enter Transaction details!</strong></p>';
$missingAccount = '<p style="background-color:red;text-align:center"><stong>Please enter Transaction Amount!</strong></p>'; 
$missingDate = '<p style="background-color:red;text-align:center"><stong>Please enter Date!</strong></p>'; 
$errors = "";
    //Get email and password
    //Store errors in errors variable
if(empty($transaction)){
    echo $missingTransaction;  
}else{
    if(empty($amount)){
    echo $missingAccount;  
}else{
        if(empty($date)){
    echo $missingDate;  
}else{
              $sql1= "INSERT INTO `$username`(`transaction`, `currency`, `amount`, `date`, `comment`, `status`) VALUES ('$transaction','$currency','$amount','$date','$comment','$status')";    
        if(mysqli_query($link1, $sql1)){
        
            $resultMessage = "<div class='alert alert-success'>Trade successfully added</div>";
            echo $resultMessage;
//            header("Refresh:1; url=../dashboard");
        }else{echo 'Error occurred while creating trade history';}    
            
    
            }
           }
        }
    }
 }
?>
<!--              </form></section>       -->
        
        
    <br><section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">History</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
               <thead>
                  <tr>

                      
                      <th style="width: 20%; text-align:center">
                          Username
                      </th>
                      <th style="width: 20%; text-align:center">
                         Amount
                      </th>
                      <th style="width: 18%; text-align:center">
                         Type
                      </th>
                      <th style="width: 12%">
                         Status
                      </th>

                      <th style="width: 30%; text-align:center">
                          Ordered At
                      </th>
<!--
                      <th style="width: 8%" class="text-center">
                          Account status
                      </th>
                      <th style="width: 8%" class="text-center">
                          Last seen
                      </th>
-->
                      <th style="width: 20%">
                      </th>
                  </tr>
              </thead>
              <tbody>

<?php 
$sql1 = "SELECT * FROM `history` WHERE u_id = '$id'  ORDER BY id DESC ";
          if($result = mysqli_query($link, $sql1)){
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $history_id = $row["id"];
                   $history_u_id =  $row["u_id"];
                   $history_username =  $row["username"];
                   $history_type =  $row["type"];
                   $history_amount =  $row["amount"];
                   $history_date =  $row["date"];
                   $history_status =  $row["status"];
            
            
                   echo " <tr>";
                   echo "
                   <td style='text-align:center'>$history_username</td>
                   <td style='text-align:center'>$$history_amount</td>
                   <td style='text-align:center'>$history_type</td>
                   <td style='text-align:center'>$history_status</td>";
                   echo "<td style='text-align:center'>$history_date</td>";     
                   echo " </tr>";
        }
    }
          }
?>

                  
                  
                  
                  
              </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>  
        
      <!-- Main content -->
    <section class="content" style="padding-bottom:40px"> <form method="post">
      <div class="row">

        <div class="col-md-12">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Change Password</h3>
 


              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
                <input type="hidden" name="id" class="form-control" value="<?php echo $id; ?>">
              <div class="form-group">
                <label for="inputSpentBudget">New Password</label>
                <input type="password" name="new_password" class="form-control" placeholder="Enter Password">
              </div>
                
              <div class="form-group">
                <label for="inputSpentBudget">Confirm Password</label>
                <input type="password" name="confirm_new_password" class="form-control" placeholder="Confirm Password">
              </div>
                
                <div class="form-group">
                <label for="inputSpentBudget">Enter Admin Password</label>
                <input type="password" name="admin_password" class="form-control" placeholder="Enter Admin Password">
              </div>
                
                
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <button class="btn btn-success float-right" name="change_password" type="submit">Change Password</button>
        </div>
      </div><br>
<!------------------------------------------save-------------------------------------->
<?php 
 if($_POST){ 
      function test_input($data){
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     return $data;
 }
     
       $sql = "SELECT * FROM `admin` WHERE `id` = 1" ;
          if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                     $main_admin_password = $row['password']; 
     
        }
        //close the result set
        mysqli_free_result($result);

    }else{
        echo "<p>User no longer exist</p>"; 

         }
}else{
    echo "<p>Unable to excecute: $sql. " . mysqli_error($link) ."</p>";   
            
}
     if(isset($_POST['change_password'])){
         
      $new_password = $_POST['new_password'];
  $confirm_new_password = $_POST['confirm_new_password'];
  $admin_password = $_POST['admin_password'];

       if (empty($new_password)) {
        $new_password_error = "<p class='alert alert-danger' style='text-align:center'>Password field is empty<p>";
           echo $new_password_error;
    } else {
        $new_password = test_input($new_password);        
 
                                    
     if (empty($confirm_new_password)) {
        echo "<p class='alert alert-danger' style='text-align:center'>Confirm new password<p>";
        
    } else {
        $confirm_new_password = test_input($confirm_new_password);
         
if($new_password != $confirm_new_password){
    echo "<p class='alert alert-danger' style='text-align:center'>Passwords do not match<p>";
}else{
    
    
    
if(hash('sha256', $admin_password) != $main_admin_password){
    echo "<p class='alert alert-danger' style='text-align:center'>Incorrect admin password<p>";
}else{
    
        $new_password = hash('sha256', $new_password);
    
    
  $sql = "SELECT * FROM users WHERE id ='$id'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-danger" style="text-align:center">Error running the query!</div>';
    exit;
}
        //If email & password don't match print error
$count = mysqli_num_rows($result);
if($count !== 1){
    echo '<div class="alert alert-danger" style="text-align:center">Error occured while updating password</div>';
}
else {

    
    
   $sql = "UPDATE `users` SET 
`password`='$new_password' WHERE `id`= $id";    
 
    if(mysqli_query($link, $sql)){
        
            $resultMessage = "<div class='alert alert-success' style='text-align:center'>Password successfully changed</div>";
            echo $resultMessage;
        }else{     
 $resultMessage = "<div class='alert alert-danger' style='text-align:center'>Error ocurred, try again later.</div>";
            echo $resultMessage;
    }  
    
    
    
    

    }    
    
    

}    
    

    
    
    
    
    
    
    
}
                                            
                                        }
                                    
            }      
         
         
         
         
         
         
         
         
//         
//         $id= $_POST['id'];
//    $name = $_POST['name']; $name = mysqli_real_escape_string($link, $name);
//    $phone = $_POST['phone']; $phone = mysqli_real_escape_string($link, $phone);
//    $country = $_POST['country']; $country = mysqli_real_escape_string($link, $country);
//    
//    $type = $_POST['type']; $type = mysqli_real_escape_string($link, $type);
//    $currency = $_POST['currency']; $currency = mysqli_real_escape_string($link, $currency);
//    
////    $account_status = $_POST['account_status']; $account_status = mysqli_real_escape_string($link, $account_status);
//    
//    $balance = $_POST['balance'];$balance = mysqli_real_escape_string($link, $balance);
//    $invested = $_POST['invested'];$invested = mysqli_real_escape_string($link, $invested);
//     
//     
// $sql = "UPDATE `users` SET `name` = '$name',`phone` = '$phone', `country` = '$country', `type` = '$type', `currency` = '$currency', `balance` = '$balance', `invested` = '$invested' WHERE `users`.`id` = $id";   
//     
//     
//    if(mysqli_query($link, $sql)){
//        
//            $resultMessage = "<div class='alert alert-success'>Successfully updated</div>";
//            echo $resultMessage;
////        header("Refresh:1; url=users.php");
//        
//        }else{ 
//        $resultMessage = "<div class='alert alert-error'>Error occured while updating database</div>";
//            echo $resultMessage;
////        header("Refresh:1; url=users.php");
//    } 
         
         
         
     }
    
               
 }
 ?>               
<!------------------------------------------save-------------------------------------->   

    <!-- Main content -->
      
      
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy;Gilab</strong>
    All rights reserved.
  </footer>

  <!-- Control Sidebar -->

  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
<?php ob_end_flush(); ?>