

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
$ip = get_client_ip();
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

if(isset($_POST['edit_account_button'])){
    
    $u_id = mysqli_real_escape_string($link, $_POST['u_id']);
    $old_password = mysqli_real_escape_string($link, $_POST['old_password']);
    $main_email = mysqli_real_escape_string($link, $_POST['main_email']);
    $fullname = mysqli_real_escape_string($link, $_POST['fullname']);
    $phone = mysqli_real_escape_string($link, $_POST['phone']);
    $country = mysqli_real_escape_string($link, $_POST['country']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    $password2 = mysqli_real_escape_string($link, $_POST['password2']);
    $bitcoin_wallet = mysqli_real_escape_string($link, $_POST['bitcoin_wallet']);
//    $ethereum_wallet = mysqli_real_escape_string($link, $_POST['ethereum_wallet']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
//    echo "bitcoin_wallet: $bitcoin_wallet; ethereum_wallet: $ethereum_wallet";
    
      if (empty($fullname)) {
                    echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Full Name cannot be empty</div>';
    } else {
        $full_name = test_input($fullname);
          if (empty($phone)) {
                    echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Phone number cannot be empty</div>';
            } else {
                $phone = test_input($phone);
                if (empty($email)) {
                    echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">E-mail Cannot be empty</div>';
                    } else {
                        $email = test_input(strtolower($email));
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Enter a valid E-mail</div>';
                        }else{
                             $sql = "SELECT * FROM users WHERE email='$email'";
                            $result = mysqli_query($link, $sql);
                            if(!$result){
                            //    echo '<div class="alert alert-danger">Error occurred!</div>';
                                echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Error occurred!</div>';
                                exit;
                            }
                                    //If email & password don't match print error
                            $count = mysqli_num_rows($result);
                            if($count >= 1 && $email != $main_email){
                                echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">E-mail is already in use</div>';
                            }else {
                            
                                if(empty($password)){
                                    
                                        $sql_t = "UPDATE `users` SET `full_name`='$full_name', `email`='$email', `phone`='$phone', `country`='$country', `bitcoin_wallet_address`='$bitcoin_wallet' WHERE `id`= '$u_id'";    
                                        if(mysqli_query($link, $sql_t)){
                                            echo '<div class="alert alert-success" style="border-radius:3px;text-align:center;background-color:green;color:#fff;padding:10px 85px;margin-top:0px">Account Successfully Updated</div>';
                                            echo "<script>
                                                function navigate(){
                                                window.location = './?page=edit_account';
                                                }

                                                setTimeout(navigate, 2000);
                                                </script>";
                                        }else{
                                             echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Error Occurred</div>';
                                        }
                                }else{
                                    
                                    if (strlen($password)<8) {
                                        echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Password must be atleat 8 characters</div>';  
                                    }else{
                                        if(digit_check($password) == "False"){
                                            echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Password must contain numeric character</div>'; 
                                        }else{
                                            
                                            if(empty($password2)){
                                                echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Retype your new password</div>';
                                            }else{
                                                if($password != $password2){
                                                    echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Passwords do not match</div>';
                                                }else{
                                                    $password = hash('sha256', $password);
                                                    
                                        $sql_t = "UPDATE `users` SET `full_name`='$full_name', `email`='$email', `phone`='$phone', `country`='$country', `bitcoin_wallet_address`='$bitcoin_wallet', `password`='$password' WHERE `id`= '$u_id'";    
                                        if(mysqli_query($link, $sql_t)){
                                            echo '<div class="alert alert-success" style="border-radius:3px;text-align:center;background-color:green;color:#fff;padding:10px 85px;margin-top:0px">Account Successfully Updated</div>';
                                                echo "<script>
                                                function navigate(){
                                                window.location = './?page=edit_account';
                                                }

                                                setTimeout(navigate, 2000);
                                                </script>";
                                        }else{
                                             echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Error Occurred</div>';
                                        }
                                                    
                                                    
                                                    
                                                    
                                                }
                                            }
                                            
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
