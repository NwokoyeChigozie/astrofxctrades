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
    <a href="index.php" class="brand-link">
      <img src="../../images/logo.png" alt="Logo" class="brand-image img-circle elevation-3"
           style="">
      <span class="brand-text font-weight-light"></span><br>
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
            <a href="./users.php" class="nav-link">
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
            <a href="./withdrawal_requests.php" class="nav-link active">
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
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Withdrawal Requests</h3>
                <form method="GET" action="./withdrawal_requests.php?p=<?php echo $_GET['p']; ?>" class="form-inline ml-3" style="margin-left:40px !important; padding-left:30px !important">
                  <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search with name" aria-label="Search" name="p" value="<?php if(isset($_GET['p'])){ echo $_GET['p']; }else{ echo '';} ?>" style="width:300px">
                    <div class="input-group-append">
                      <button class="btn btn-navbar" type="submit" style>
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </form>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
               <thead>
                  <tr>

                      <th style="width: 8%">
                          ID
                      </th>
                      <th style="width: 15%">
                         Username
                      </th>
                      <th style="width: 20%">
                          Amount
                      </th>
                      <th style="width: 20%">
                          Bitcoin Wallet Address
                      </th>
                      <th style="width: 16%" class="text-center">
                          Date
                      </th>
                      <a class='btn btn-info btn-sm' href='withdrawal_requests_all.php' style="float:right;margin-right:10px;margin-top:20px">
                              Completed Withdrawal requests
                          </a>
                  </tr>
              </thead>
              <tbody>
<?php
if(isset($_GET['p'])){
    $s_p = $_GET['p'];
    $sql = "SELECT * FROM `withdrawal` WHERE username = '$s_p' AND  status = 'completed'  ORDER BY id DESC ";
              if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                   $withdrawal_id = $row['id'];
                   $withdrawal_u_id = $row['u_id'];
                   $withdrawal_username = $row['username'];
                   $withdrawal_type = $row['type'];
                   $withdrawal_currency = $row['currency'];
                   $withdrawal_amount = $row['withdrawal_amount'];
                   $withdrawal_btc_address = $row['btc_address'];
                   $withdrawal_date = $row['date'];
                   $withdrawal_ip = $row['ip'];
                   $withdrawal_status = $row['status'];
            
                   echo " <tr>";
                   echo "
                   <td>$withdrawal_id</td>
                   <td>$withdrawal_username</td>
                   <td>$withdrawal_currency$withdrawal_amount</td>
                   <td>$withdrawal_btc_address</td>
                   <td>$withdrawal_date</td>";     
//                   echo " <td class='project-actions text-right'>
//
//                          <a class='btn btn-info btn-sm' href='withdrawal_confirm.php?id=$withdrawal_id'>
//                              <i class='fas fa-pencil-alt'>
//                              </i>
//                              Confirm
//                          </a>
//                      </td></tr>";
                        echo "</tr>";
        }
    }
          }
}else{
    $sql = "SELECT * FROM `withdrawal` WHERE status = 'completed'  ORDER BY id DESC ";
              if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                   $withdrawal_id = $row['id'];
                   $withdrawal_u_id = $row['u_id'];
                   $withdrawal_username = $row['username'];
                   $withdrawal_type = $row['type'];
                   $withdrawal_currency = $row['currency'];
                   $withdrawal_amount = $row['withdrawal_amount'];
                   $withdrawal_btc_address = $row['btc_address'];
                   $withdrawal_date = $row['date'];
                   $withdrawal_ip = $row['ip'];
                   $withdrawal_status = $row['status'];
            
                   echo " <tr>";
                   echo "
                   <td>$withdrawal_id</td>
                   <td>$withdrawal_username</td>
                   <td>$withdrawal_currency$withdrawal_amount</td>
                   <td>$withdrawal_btc_address</td>
                   <td style='text-align:center'>$withdrawal_date</td>";     
//                   echo " <td class='project-actions text-right'>
//
//                          <a class='btn btn-info btn-sm' href='withdrawal_confirm.php?id=$withdrawal_id'>
//                              <i class='fas fa-pencil-alt'>
//                              </i>
//                              Confirm
//                          </a>
//                      </td></tr>";
            echo "</tr>";
        }
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