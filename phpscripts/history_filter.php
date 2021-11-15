


<?php

ob_start();
//Start session
session_start();
include('connection.php');

    if(isset($_POST['filter_submit'])){
        $u_id = mysqli_real_escape_string($link, $_POST['u_id']);
        $main_email = mysqli_real_escape_string($link, $_POST['main_email']);
        $from_day = mysqli_real_escape_string($link, $_POST['from_day']);
        $from_month = mysqli_real_escape_string($link, $_POST['from_month']);
        $from_year = mysqli_real_escape_string($link, $_POST['from_year']);
        $to_day = mysqli_real_escape_string($link, $_POST['to_day']);
        $to_month = mysqli_real_escape_string($link, $_POST['to_month']);
        $to_year = mysqli_real_escape_string($link, $_POST['to_year']);
        $history__type = mysqli_real_escape_string($link, $_POST['history__type']);
        
        $start_date = "$from_day-$from_month-$from_year";
        $end_date = "$to_day-$to_month-$to_year";
        
          $_SESSION['history_type'] = $history__type;
          $_SESSION['history_start_date'] = $start_date;
          $_SESSION['history_end_date']   = $end_date;
        
       echo "<script>
        function navigate(){
        window.location = './?page=history';
        }

        setTimeout(navigate, 2000);
        </script>";
    }
?>