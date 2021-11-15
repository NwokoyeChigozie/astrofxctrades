<?php
ob_start();
//Start session
session_start();
//Connect to the database
include("../phpscripts/connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin login</title>
	<meta charset="UTF-8">
   <!--====== FAVICON ICON =======-->
    <link rel="stylesheet" href="../login/Fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../login/Fonts/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="apple-touch-icon" sizes="120x120" href="../apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png">
<link rel="manifest" href="../site.webmanifest">
<link rel="mask-icon" href="../safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#fff7f7">
<meta name="theme-color" content="#ffffff">
    <link rel="icon" type="image/png" href="../images/favicon2.png" sizes="32x32">
<link rel="icon" type="image/png" href="../images/favicon2.png" sizes="16x16">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
<!--	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>-->
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('../img/logo.png');">
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
					Admin User
				</span>
				<form class="login100-form validate-form p-b-33 p-t-5" method="post">

					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>

					<div class="container-login100-form-btn m-t-32">
						<button class="login100-form-btn" >
							Login
						</button>
					</div>
<?php
if($_POST){
//Check user inputs
    //Define error messages
$missingUsername = '<p><stong>Please enter Admin Username!</strong></p>';
$missingPassword = '<p><stong>Please enter Admin password!</strong></p>'; 
$errors = "";
    //Get email and password
    //Store errors in errors variable
if(empty($_POST["username"])){
    $errors .= $missingUsername;   
}else{
    $username = filter_var($_POST["username"], FILTER_SANITIZE_EMAIL);
}
if(empty($_POST["password"])){
    $errors .= $missingPassword;   
}else{
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
}
    //If there are any errors
if($errors){
    //print error message
    $resultMessage = '<div class="alert alert-danger">' . $errors .'</div>';
    echo $resultMessage;   
}else{
    //else: No errors
    //Prepare variables for the query
    $username = mysqli_real_escape_string($link, $username);
$password = mysqli_real_escape_string($link, $password);
$password = hash('sha256', $password);
        //Run query: Check combinaton of email & password exists
$sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-danger">Error running the query!</div>';
    exit;
}
        //If email & password don't match print error
$count = mysqli_num_rows($result);
if($count !== 1){
    echo '<div class="alert alert-danger">Wrong Username or Password</div>';
}
else {
    //log the user in: Set session variables
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $_SESSION['admin_id']=$row['id'];
    $_SESSION['admin_name']=$row['username'];
            echo '<br><div class="alert alert-success" style="text-align:center">Login successful!</div>';
        header("Refresh:1; url=dashboard");

}
    }

            //else
                //Create two variables $authentificator1 and $authentificator2
                //Store them in a cookie
                //Run query to store them in rememberme table
                //If query unsuccessful
                    //print error
                //else
                    //print "success"
}
                    ?>

				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
<?php ob_end_flush(); ?>