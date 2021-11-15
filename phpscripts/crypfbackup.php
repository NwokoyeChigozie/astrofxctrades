<?php

function to_eight($input){
    $final_output = "0.00000000";
    if(!empty($input) && $input != '' && is_numeric($input)){
        $input = round($input, 8);
        if(count(explode('.', $input)) < 2){
            $final_output = $input . ".00000000";
            $final_output = explode('.', $final_output)[0] . '.' . explode('.', $final_output)[1];
            
        }elseif(count(explode('.', $input)) > 2){
            $final_output = explode('.', $input)[0] . ".00000000";
            $final_output = explode('.', $final_output)[0] . '.' . explode('.', $final_output)[1];
            
        }elseif(count(explode('.', $input)) == 2){
            $fi_array = explode('.', $input);
            if(strlen($fi_array[1]) < 8){
                $m_num = 8 - strlen($fi_array[1]);
                $zeros = str_repeat("0",$m_num);
//                echo "<br>Number Diff: $m_num; Zeros = $zeros<br>";
                $final_output = $fi_array[0] . '.' . $fi_array[1] . $zeros;
            }elseif(strlen($fi_array[1]) > 8){
                $sub = substr($fi_array[1],0,8);
                $final_output = $fi_array[0] . '.' . $sub;
            }elseif(strlen($fi_array[1]) == 8){
               $final_output = $input; 
            }
            
        }
    }
    return $final_output;
}





function usd_to_btc($usd_amount, $btc_to_usd_rate){
    return to_eight($usd_amount / $btc_to_usd_rate);
}

function usd_to_eth($usd_amount, $btc_to_usd_rate, $btc_to_eth_rate){
    $btc_amount = $usd_amount / $btc_to_usd_rate;
    return to_eight($btc_amount * $btc_to_eth_rate);
}
function usd_to_any($usd_amount, $btc_to_usd_rate, $btc_to_next_rate){
    $btc_amount = $usd_amount / $btc_to_usd_rate;
    return to_eight($btc_amount * $btc_to_next_rate);
}

function converting($usd_amount, $btc_to_usd_rate, $btc_to_next_rate, $currency){
    if($currency == "BTC"){
        return usd_to_btc($usd_amount, $btc_to_usd_rate);
    }elseif($currency == "ETH"){
        return usd_to_eth($usd_amount, $btc_to_usd_rate, $btc_to_next_rate);
    }else{
        return usd_to_any($usd_amount, $btc_to_usd_rate, $btc_to_next_rate);
    }
}

?>