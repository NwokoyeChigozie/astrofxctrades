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



function get_cryp_value_bitpay($amount,$pay_currency){
$url='https://bitpay.com/api/rates';
$json=json_decode( file_get_contents( $url ) );
    $btc_to_usd_rate= 0;
    $btc_to_next_rate= 0;
    foreach( $json as $obj ){
        if($obj->code=='USD'){
            $btc_to_usd_rate=$obj->rate;
        }elseif($obj->code==$pay_currency){
            $btc_to_next_rate=$obj->rate;
            break;
        }


    }
        $btc_amount = $amount / $btc_to_usd_rate;
        return to_eight($btc_amount * $btc_to_next_rate);
}
    
function get_cryp_value_4nomics($amount,$pay_currency){
$url='https://api.nomics.com/v1/exchange-rates?key=fce316ad1f238e2617206d99b2cb52f7c64aa07f';
$json=json_decode( file_get_contents( $url ) );
    foreach( $json as $obj ){
    if( $obj->currency== $pay_currency){
        return to_eight($amount/($obj->rate));
    }
}

}

function converting($amount, $pay_currency){
    if ($pay_currency == "BTC"  || $pay_currency == "BNB"){
        return get_cryp_value_4nomics($amount,$pay_currency);
    }else{
        return get_cryp_value_bitpay($amount,$pay_currency);
    }
}

?>