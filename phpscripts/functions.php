<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//formating intergers and floats
function tab_split($int_val){ 
//    echo strlen("$int_val");
    if(strlen("$int_val") <= 3){
        return $int_val;
    }else{

    $f_v = '';
    $n_count = 0;
    $val_i = str_split("$int_val");
    for ($x = (strlen("$int_val")-1); $x >=0; $x--) {
    $n_count += 1;
    if($n_count == 1){
       $f_v = $val_i[$x]; 
    }elseif($n_count % 3 == 0){
        if($x == 0){
           $f_v = $val_i[$x] . $f_v; 
        }else{
          $f_v = ',' . $val_i[$x] . $f_v;  
        }
        
    }else{
      $f_v = $val_i[$x] . $f_v;  
    }
    
//    $val_ij = $val_i[$x];
        }
    return $f_v;
        
        
    }
}



function normalize_amount($input){
    $final_output = "0.00";
    if(!empty($input) && $input != '' && is_numeric($input)){
        $input = round($input, 2);
        
        if(count(explode('.', $input)) < 2){
            $final_output = $input . ".00";
            $final_output = tab_split(explode('.', $final_output)[0]) . '.' . explode('.', $final_output)[1];
            
        }elseif(count(explode('.', $input)) > 2){
            $final_output = explode('.', $input)[0] . ".00";
            $final_output = tab_split(explode('.', $final_output)[0]) . '.' . explode('.', $final_output)[1];
            
        }elseif(count(explode('.', $input)) == 2){
            $final_output = $input;
            $final_output = tab_split(explode('.', $final_output)[0]) . '.' . explode('.', $final_output)[1];
            
        }
    }
    return $final_output;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////creat referal link
function create_reflink($username){
      $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://"; 
    if($_SERVER['HTTP_HOST'] == "localhost"){
       $pref =  $protocol . $_SERVER['HTTP_HOST'] . "/astroforex/?ref=" . $username;
        
    }else{
       $pref =  $protocol . $_SERVER['HTTP_HOST'] . "?ref=" . $username; 
    }
    
    return $pref;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////extend ref banner
function create_bannerlink($size){
      $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://"; 
    if($_SERVER['HTTP_HOST'] == "localhost"){
       $pref =  $protocol . $_SERVER['HTTP_HOST'] . "/astroforex/images/" . $size . ".gif";
        
    }else{
       $pref =  $protocol . $_SERVER['HTTP_HOST'] . "/images/" . $size . ".gif"; 
    }
    
    return $pref;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////filter history with type
function filter_type($array, $type){
    $f_v = [];
    foreach($array as $ar){
        if($ar['type'] == $type){
            $f_v[] = $ar;
        }
    }
    return $f_v;
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////filter history with date
function filter_date($array, $start_date, $end_date){
    $start_stamp = strtotime($start_date);
    $end_stamp = strtotime($end_date);
//    echo "Start: $start_stamp; End: $end_stamp";
    $f_v = [];
    foreach($array as $ar){
        $test_stamp = strtotime($ar['date']);
//        echo "<br>Main: $test_stamp<br><br>";
        if($test_stamp >= $start_stamp && $test_stamp <= $end_stamp){
            $f_v[] = $ar;
        }
    }
    return $f_v;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//// history Sum
function history_sum($array){
    $main_sum = 0;
    foreach($array as $ar){
        $main_sum = $main_sum + $ar['amount'];
    }
    return  normalize_amount($main_sum);
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


?>