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
            <a href="./add_funds.php" class="nav-link active">
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
              <h3 class="card-title">Add Funds to User's account</h3>



              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
<!--                <input type="hidden" name="id" class="form-control" value="">-->
                
              <div class="form-group">
                <label for="inputSpentBudget">User's E-mail</label>
                <input type="text" name="u_email" id="u_email" class="form-control" value="">
              </div>
                
              <div class="form-group">
                <label for="inputSpentBudget">Amount($)</label>
                <input type="number" name="u_amount" id="u_amount" class="form-control" value="">
              </div>
                
              <div class="form-group">
                <label for="inputSpentBudget">Plan</label><br>
                <select name="u_plan" id="u_plan" class="form-control" style="width:auto">
                    <option value="">Select Plan</option>
                    <option value="1">Standard Plan</option>
                    <option value="2">Professional Plan</option>
                    <option value="3">Advanced PLan</option>
                    <option value="4">Premium Plan</option>
                  </select>
              </div>
                <label>Payment Date</label>
              <div class="form-group">
                
                  <select name="u_year" id="u_year" class="form-control" style="width:auto;float:left">
                    <option value="">Select Year</option>
                    <option value="2010">2010</option>
                    <option value="2011">2011</option>
                    <option value="2012">2012</option>
                    <option value="2013">2013</option>
                    <option value="2014">2014</option>
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                  </select>
                  <select name="u_month" id="u_month" class="form-control" style="width:auto;float:left;margin-left:10px;">
                    <option value="">Select Month</option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                  </select>
                 <select name="u_day" id="u_day" class="form-control" style="width:auto;float:left;margin-left:10px;">
                     <option value="">Select Day</option>
                     <div id="28_days">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option id="day_29" value="29" style="display:block">29</option>
                        <option id="day_30" value="29" style="display:block">30</option>
                        <option id="day_31" value="29" style="display:block">31</option>
                     </div>
                    
                  </select>
                  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                  <script>
        $(document).ready(function() {
            
    $('#u_year').change(function() {
        var year_d = $("#u_year").val();
        $("#u_month").val('');
        $("#u_day").val('');
        if(year_d % 4 == 0){
            
        }
                        
});            
    $('#u_month').change(function() {
        $("#u_day").val('');
        var month_d = $("#u_month").val();
        var year_d = $("#u_year").val();
        var month_c = month_d;
        if(month_c == ''){
            month_c = 0;
        }
        
        if(month_c == 2 && year_d % 4 == 0){
            month_c = 13;
        }
        month_c = Math.round(month_c);
        console.log("Year:" + year_d + " Month: " + month_c + " Leap Calc: " + year_d % 4);
        var month_days = [31, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31, 29];
        console.log("Days Value: " + month_days[month_c]);
        


        if(month_days[month_c] == 29){
//            $("#extra_days").html("<option value="29">29</option>");
            $("#day_29").css("display", "block");
            $("#day_30").css("display", "None");
            $("#day_31").css("display", "None");
           
                }else if(month_days[month_c] == 28){
                    $("#day_29").css("display", "None");
                    $("#day_30").css("display", "None");
                    $("#day_31").css("display", "None");
//                    console.log("Statement: " + month_days[month_c]);
//                    $("#28_days").css("display", "Block");
//                    $("#29_days").css("display", "None");
//                    $("#30_days").css("display", "None");
//                    $("#31_days").css("display", "None");
            
                }else if(month_days[month_c] == 30){
                    $("#day_29").css("display", "block");
                    $("#day_30").css("display", "block");
                    $("#day_31").css("display", "None");
                 
                 }else if(month_days[month_c] == 31){
                     $("#day_29").css("display", "block");
                    $("#day_30").css("display", "block");
                    $("#day_31").css("display", "block");
                          
                          }else{
                             $("#day_29").css("display", "block");
                    $("#day_30").css("display", "block");
                    $("#day_31").css("display", "block"); 
                              
                          }
        
                        
});         
            
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////          
 

        });

    </script>

                 
<!--
                <input type="date" name="u_year" class="form-control" value="">
                <input type="date" name="u_month" class="form-control" value="">
                <input type="date" name="u_day" class="form-control" value="">
-->
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
          <button class="btn btn-success float-right" id="add_funds_submit" type="submit">Add Funds</button>
            <br><br><div class="f_message"></div>
        </div>
      </div>
        <script>
        $(document).ready(function() {
            
            
            $("#add_funds_submit").click(function(event) {
                event.preventDefault();
               $("#add_funds_submit").html('<b>....</b>');
                
                var email = $("#u_email").val();
                var amount = $("#u_amount").val();
                var plan = $("#u_plan").val();
                var year = $("#u_year").val();
                var month = $("#u_month").val();
                var day = $("#u_day").val();
                var add_funds_submit = $("#add_funds_submit").val();
                if(email == ""){
                   $(".f_message").html('<div class="alert alert-danger" style="text-align:center">Enter Email</div>');
                   }else{
                    $(".f_message").html('');
                       if(amount == ""){
                          $(".f_message").html('<div class="alert alert-danger" style="text-align:center">Enter Amount to be added</div>');
                          }else{
                            $(".f_message").html('');
                              if(amount < 50){
                                  $(".f_message").html('<div class="alert alert-danger" style="text-align:center">Amount should be greater than $50</div>');
                              }else{
                                  $(".f_message").html('');
                                  if(plan == ""){
                                     $(".f_message").html('<div class="alert alert-danger" style="text-align:center">Select a plan</div>');
                                     }else{
                                     $(".f_message").html('');
                                         if(year == ""){
                                            $(".f_message").html('<div class="alert alert-danger" style="text-align:center">Select Year</div>');
                                            }else{
                                                $(".f_message").html('');
                                                if(month == ""){
                                            $(".f_message").html('<div class="alert alert-danger" style="text-align:center">Select Month</div>');
                                            }else{
                                                $(".f_message").html('');
                                                if(day == ""){
                                            $(".f_message").html('<div class="alert alert-danger" style="text-align:center">Select Day</div>');
                                            }else{
                                                $(".f_message").html('');
                                                
                                                                $.ajax({
                                                                type: "POST",
                                                                url: "./add_funds_back.php/",
                                                                data: {
                                                                    email: email,
                                                                    amount: amount,
                                                                    plan: plan,
                                                                    year: year,
                                                                    month: month,
                                                                    day: day,
                                                                    add_funds_submit: add_funds_submit
                                                                },
                                                                success: function(response) {
                                                                    $(".f_message").html(response);
                                                                    //      console.log(response);
                                                                    //      console.log("Done"); 
                                                                    $("#add_funds_submit").html('Add Funds');
                                                                },
                                                                error: function(response) {
                                                                    console.log(response);
                                                                    $("#add_funds_submit").html('Add Funds');
                                                                }
                                                            });
                                                
                                            }
                                            }
                                            }
                                     }
                              }
                          }
                   }



                

                 $("#add_funds_submit").html('Add Funds');
            });

        });

    </script>

    <!-- Main content -->
        
        
       
 
        
    <br><section class="content">

 
    </section>  
        
      <!-- Main content -->
      


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