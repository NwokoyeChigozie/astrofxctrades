
<?php
ob_start();
//Start session
session_start();
include('connection.php');
 function test_input($data){
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     return $data;
 }
if(isset($_POST['login_button'])){ 

    $email = mysqli_real_escape_string($link, $_POST['email']);
    $password1 = mysqli_real_escape_string($link, $_POST['password']);
    
  
      

       if (empty($email)) {
        echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Please Enter E-mail Address</div>';
    } else {
        $email = test_input(strtolower($email));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">E-mail is Invalid</div>';
        }else{
           
 
                                    
     if (empty($password1)) {
        echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Please Enter Password</div>';
    } else {
        $password1 = test_input($password1);
      $password = hash('sha256', $password1);
   
         
 $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Error running Query!</div>';
    exit;
}
        //If email & password don't match print error
$count = mysqli_num_rows($result);
if($count !== 1){
//    echo '<div class="error" style="max-width: 50% !important;">Wrong Email, Password, or Login Code</div>';
    echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Wrong E-mail or Password</div>';
}else {
   $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $account_status = $row['account_status'];
if($account_status == "Disabled"){
 echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Your account has been disabled. Please contact Admin</div>';
// echo '<div class="error" style="max-width: 50% !important;">Your account has been disabled. Please contact Admin</div>';
}else{
    $_SESSION['id']=$row['id'];
    $_SESSION['email']=$row['email'];
    $_SESSION['username']=$row['username'];
    $old_count = $row['login_count'];
    $new_count = $old_count + 1;
    
    $sql_t = "UPDATE `users` SET `login_count`='$new_count' WHERE `email`= '$email'";    
    if(mysqli_query($link, $sql_t)){
                        //log the user in: Set session variables
//    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
//    session_start();

//            echo '<div class="success" style="max-width: 50% !important;">Login successful!</div>';
            echo '<div class="alert alert-success" style="border-radius:3px;text-align:center;background-color:green;color:#fff;padding:10px 85px;margin-top:0px">Login Successful!</div>';
//            echo $_SESSION['id'] . ": " . $_SESSION['email'] . " " . ' Registered';


//                echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';

    echo "<script>
function navigate(){
window.location = './?page=account';
}

setTimeout(navigate, 2000);
</script>";
    }else{
        echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Query Error</div>';

    }
    

    
    
    
    
    
    
    
}

    



}        
         
          
          
          
          
          
          
          
          
     }
                                            
                                  
     }
            }   
        
  }

//php ob_end_flush(); 

?>


<!--
<script>
$("#name, #phone, #email, #password1, #password2, #country, #username, #type, #currency").removeClass("error-box");
var error = "<?php echo $error; ?>";
    
if(error == true){
    $("<?php echo $id; ?>").addClass("erro-box");
}
    
if(error == false){
    $("#name, #phone, #email, #password1, #password2, #country, #username, #type, #currency").val("");
}
</script>-->
