
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
function digit_check($string){
    if (preg_match('~[0-9]+~', $string)) {
            return "True";
        }else{ return "False";}
}
if(isset($_POST['forgot_submit1'])){ 

    $email = mysqli_real_escape_string($link, $_POST['email']);
    
       if (empty($email)) {
        echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Please Enter Your E-mail Address</div>';
    } else {
        $email = test_input(strtolower($email));
           
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">E-mail is Invalid</div>';
        }else{
           
              $sr = bin2hex(openssl_random_pseudo_bytes(7));
//            $registered_at = date("M-d-Y h:i:s A", time());
            $elapse_at = time() + 86400;
                $sql= "INSERT INTO `password_recovery`(`email`,`sr`, `elapse_time`) VALUES ('$email','$sr','$elapse_at')";
            
        if(mysqli_query($link, $sql)){
             $sql = "SELECT * FROM password_recovery WHERE email='$email' AND elapse_time = '$elapse_at'";
            $result = mysqli_query($link, $sql);
            $p_r = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $pr_id = $p_r['id'];
            
            $link = "https://astrofxcinvestment.com/?sr=" . $sr . "&pri=" . $pr_id . "&email=" . $email . "&et=" . $elapse_at;
            $message = "<div style='background-color:#AFDBF5;padding-top:4px;padding-bottom:20px;border-radius:15px;justify-content: center; '><h3 style='text-align:center;border-radius:10px;padding-top:3px;color:#0018A8'>Password Reset</h3><br><br><h4 style='text-align:center;margin-bottom:6px;'>Click <a href='$link' style='color:#0018A8;'>here </a> to reset your password, or copy this link: <span style='background-color:#D3D3D3;padding:4px;border-radius:3px;color:#0018A8'>$link</span> and paste on your browser</h4></div>";


            $to = $email;
            $subject = "Password Reset";
            $txt = $message;
        //    $headers = array("From $email",
        //    "Reply To: $email", 
        //    "Content-Type: text/html",
        //    "charset=UTF-8\r\n",
        //    "X-Mailer: PHP/" . PHP_VERSION 
        //);
            $headers .= "CC: $email\r\n";
//          $from = "gregoflash05@gmail.com"  
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= 'From: AstroFxcInvestment <support@astrofxcinvestment.com>' . "\r\n";
            
//        $headers .= 'From: '.$from.' '. "\r\n";
            
            if(mail($to,$subject,$txt, $headers)){
                echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:green;color:#fff;padding:10px 85px;margin-top:0px">E-mail Sent</div>';
            }else{

                echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Error occurred while sending email, try again later.</div>';
            }
            
        }else{
            echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Error occurred, try again later.</div>';
        }
         
                                            
                                  
     }
            }   
        
  }



////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['forgot_submit2'])){ 

    $email = mysqli_real_escape_string($link, $_POST['email']);
    $elapsetime = mysqli_real_escape_string($link, $_POST['elapsetime']);
    $password = mysqli_real_escape_string($link, $_POST['forgot_password']);
    $password2 = mysqli_real_escape_string($link, $_POST['forgot_password2']);

                            
                                if(empty($password)){
                                     echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Enter your new password</div>';
                                }else{
                                    
                                    if (strlen($password)<8) {
                                        echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Password must be atleat 8 characters</div>';  
                                    }else{
                                        if(digit_check($password) == "False"){
                                            echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Password must contain numeric character</div>'; 
                                        }else{
                                            
                                            if(empty($password2)){
                                                echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Confirm your new password</div>';
                                            }else{
                                                if($password != $password2){
                                                    echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Passwords do not match</div>';
                                                }else{
                                                    $password = hash('sha256', $password);
                                                    
                                        $sql_t = "UPDATE `users` SET  `password`='$password' WHERE `email`= '$email'";    
                                        if(mysqli_query($link, $sql_t)){ 

                                            $sql_t = "UPDATE `password_recovery` SET  `count`='1' WHERE `email`= '$email' AND `elapse_time`= '$elapsetime'";    
                                        if(mysqli_query($link, $sql_t)){
                                            echo '<div class="alert alert-success" style="border-radius:3px;text-align:center;background-color:green;color:#fff;padding:10px 85px;margin-top:0px">Password Change Successful</div>';
                                                echo "<script>
                                                function navigate(){
                                                window.location = './';
                                                }

                                                setTimeout(navigate, 2000);
                                                </script>";
                                        }else{
                                            echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Error Occurred</div>';
                                        }
                                        }else{
                                             echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Error Occurred</div>';
                                        }
                                                    
                                                    
                                                    
                                                    
                                                }
                                            }
                                            
                                        }
                                        
                                    }
                                    
                                }
     
        
  }

//php ob_end_flush(); 

?>

