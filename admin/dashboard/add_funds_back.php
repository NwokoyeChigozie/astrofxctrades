
<?php
include('../../phpscripts/connection.php');
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

if(isset($_POST['add_funds_submit'])){
    
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $amount = mysqli_real_escape_string($link, $_POST['amount']);
    $plan = mysqli_real_escape_string($link, $_POST['plan']);
    $year = mysqli_real_escape_string($link, $_POST['year']);
    $month = mysqli_real_escape_string($link, $_POST['month']);
    $day = mysqli_real_escape_string($link, $_POST['day']);
    $status = "pending";
    $history_date = "$day-$month-$year";
    $deposit_list_date = "$day/$month/$year";
    $start_time_stamp = strtotime($history_date);
    
      $email = test_input(strtolower($email));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo '<div class="alert alert-danger" style="text-align:center">Enter a Valid E-mail</div>';
        }else{
//          echo '<div class="alert alert-success" style="text-align:center">Start Stamp: '. $start_time_stamp . '</div>';
          $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($link, $sql);
        if(!$result){
            echo '<div class="alert alert-danger" style="text-align:center">Error Occurred!</div>';
            exit;
        }
            
        $count = mysqli_num_rows($result);
        if($count < 1){
            echo '<div class="alert alert-danger" style="text-align:center">Email is not registered to a user</div>';
        }else{
           $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $u_id = $row['id']; 
            $username = $row['username'];
//            echo '<div class="alert alert-success" style="text-align:center">Id: '. $u_id . ' Username:'. $username . '</div>';
            $sql= "INSERT INTO `deposit_list`(`u_id`,`username`, `type`,`amount`, `total_amount`,`date`,`create_timestamp`, `last_update_timestamp`,`status`) VALUES ('$u_id','$username','$plan','$amount','$amount','$deposit_list_date','$start_time_stamp','$start_time_stamp','$status')";
            
                if(mysqli_query($link, $sql)){
                    $sql= "INSERT INTO `history`(`u_id`,`username`, `type`,`amount`, `date`,`status`) VALUES ('$u_id','$username','Deposit','$amount','$history_date','$status')";
                    
                    if(mysqli_query($link, $sql)){
                        echo '<div class="alert alert-success" style="text-align:center">$' . $amount . ' Successfully added to ' . $email. '</div>';
                    }else{
                        echo '<div class="alert alert-danger" style="text-align:center">Error Updating History</div>';
                    }
                }else{
                    echo '<div class="alert alert-danger" style="text-align:center">Error Updating Deposit</div>';
                }
        }
      }
}





?>
