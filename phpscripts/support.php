
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
if(isset($_POST['support_submit'])){ 

    $name = mysqli_real_escape_string($link, $_POST['name']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $message = mysqli_real_escape_string($link, $_POST['message']);
  



       if (empty($name)) {
        echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Please Enter your Name</div>';
    } else {
           $name = test_input($name);
       if (empty($email)) {
        echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Please Enter E-mail Address</div>';
    } else {
        $email = test_input(strtolower($email));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">E-mail is Invalid</div>';
        }
           
 
                                    
     if (empty($message)) {
        echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Message Cannot be empty</div>';
    } else {
        $message = test_input($message);
   
         
 $sql = "SELECT * FROM feedback WHERE email='$email' AND message='$message'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Error running Query!</div>';
    exit;
}
        //If email & password don't match print error
$count = mysqli_num_rows($result);
if($count >= 1){
//    echo '<div class="error" style="max-width: 50% !important;">Wrong Email, Password, or Login Code</div>';
    echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Feedback Already sent</div>';
}else {
      $registered_at = date("M-d-Y h:i:s A", time());
                $sql= "INSERT INTO `feedback`(`name`,`email`, `time`,`message`) VALUES ('$name','$email','$registered_at','$message')";
    if(mysqli_query($link, $sql)){
                        //log the user in: Set session variables
//    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
//    session_start();

//            echo '<div class="success" style="max-width: 50% !important;">Login successful!</div>';
            echo '<div class="alert alert-success" style="border-radius:3px;text-align:center;background-color:green;color:#fff;padding:10px 85px;margin-top:0px">Message sent successfully</div>';
//            echo $_SESSION['id'] . ": " . $_SESSION['email'] . " " . ' Registered';


//                echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';


    }else{
        echo '<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Query Error</div>';

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
