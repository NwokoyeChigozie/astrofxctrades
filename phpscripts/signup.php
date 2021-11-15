    <?php 
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
session_start();
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
if(isset($_POST['create_button'])){ 
    
    $ref = '';
    if(isset($_SESSION['ref'])){
      $ref = $_SESSION['ref'];  
    }
    
    
    $full_name = mysqli_real_escape_string($link, $_POST['full_name']);
    $country = mysqli_real_escape_string($link, $_POST['country']);
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $email1 = mysqli_real_escape_string($link, $_POST['email1']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    $password2 = mysqli_real_escape_string($link, $_POST['password2']);
    $phone = mysqli_real_escape_string($link, $_POST['phone']);
//    $agree = mysqli_real_escape_string($link, $_POST['agree']);
      
     if($ref != ''){
        $sql = "SELECT * FROM users WHERE username = '$ref'";
        $result = mysqli_query($link, $sql);
        $rows = mysqli_fetch_array($result, MYSQLI_ASSOC); 
        $no_of_referals_o = $rows['no_of_referals'];
         $no_of_referals_n = $no_of_referals_o + 1;
                    $sql_t = "UPDATE `users` SET `no_of_referals`='$no_of_referals_n' WHERE `username`= '$ref'";    
                                        if(mysqli_query($link, $sql_t)){
//                                            $set = "ok";
                                        }else{
//                                             $set = "false"; 
                                        }
     } 


        if (empty($username)) {
                    echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">User Name is Required</div>';
                } else {
                    $username = test_input(strtolower($username));
        
                
           $sql = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($link, $sql);
        if(!$result){
        //    echo '<div class="alert alert-danger">Error occurred!</div>';
            echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Error Occurred!</div>';
            exit;
        }
                //If email & password don't match print error
        $count = mysqli_num_rows($result);
        if($count >= 1){
            echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Username has already been taken</div>';
        }else{
              if (empty($full_name)) {
                    echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Full Name is Required</div>';
                    } else {
                        $full_name = test_input($full_name);
              if (empty($phone)) {
                    echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Phone Number is required</div>';
                } else {
                    $phone = test_input($phone);
              if (empty($country)) {
                    echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Please Select Country</div>';
                } else {
                    $country = test_input($country);

  
               if (empty($email)) {
                    echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">E-mail is Required</div>';
                    } else {
                        $email = test_input(strtolower($email));
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Enter a valid E-mail</div>';
                        }else{
                    if (empty($email1)) {
                    echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Confirm E-mail</div>';
                    } else {
                         if (strtolower($email) != strtolower($email1)) {
                    echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Emails do not match</div>';
                    } else {

           
                                    
                         if (empty($password)) {
                            echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Password is required</div>';
                        } else {
                            $password = test_input($password);
      

         
                          if (strlen($password)<8) {
                            echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Password must be atleat 8 characters</div>';
                    } else {
                             

      if(digit_check($password) == "False"){
         echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Password must contain numeric character</div>';
      }else{
          $password = hash('sha256', $password);
                if (empty($password2)) {
                 echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Confirm your password</div>';
                    } else {
                    $password2 = hash('sha256', $password2);
                         if ($password != $password2) {
                                echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Passwords do not match</div>';
                            } else {
          
          
           $sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($link, $sql);
if(!$result){
//    echo '<div class="alert alert-danger">Error occurred!</div>';
    echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Error occurred!</div>';
    exit;
}
        //If email & password don't match print error
$count = mysqli_num_rows($result);
if($count >= 1){
    echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">The email address you have entered is already registered. Please <a href="./?a=login" style="color:#6051da">log in</a></div>';
}else {
//            $registered_at = date("F d, Y h:i:s", time());
            $registered_at = date("M-d-Y h:i:s A", time());
                $sql= "INSERT INTO `users`(`ref`,`full_name`, `username`,`email`, `phone`,`password`,`login_count`, `ip_address`,`account_status`,`registered_at`,`last_seen`,`country`) VALUES ('$ref','$full_name','$username','$email','$phone','$password','0','$ip','Verified','$registered_at','$registered_at','$country')";

    
    
        if(mysqli_query($link, $sql)){
         $sql = "SELECT * FROM users WHERE email='$email' ";
$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Error running query!</div>';
    exit;
}
            
$count = mysqli_num_rows($result);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
//session_start();
$_SESSION['id'] = $row['id'];
$_SESSION['email'] = $row['email']; 
$_SESSION['username'] = $row['username']; 
        
//            $resultMessage = "<p class='success'>Registration successful</p>";
            echo '<div class="alert alert-success" style="border-radius:3px;text-align:center;background-color:green;color:#fff;padding:10px 85px;margin-top:0px">Thank you for registering with ASTROFOREX. </div>';
//            echo $_SESSION['id'] . ": " . $_SESSION['email'] . " " . ' Registered';
//            echo $ip . " " . ' Registered';


//                echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';

    echo "<script>
function navigate(){
window.location = './?page=account';
}

setTimeout(navigate, 2000);
</script>";
            
//            header("Refresh:3; url=../dashboard");
            
            
           
            
            
        }else{ 
//            echo "<p class='error'>Error occurred while creating user<p>";
              echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Query Error</div>';
             } 
    
 








} 
          
          
          
      }
          
      }
      
      }
                          }
      
                         }                 }   
                                            }
                         }
                        } 

                }   
               }
            }
  }
       }      
  }

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
