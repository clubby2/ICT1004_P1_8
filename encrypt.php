<?php
$encryptionkey = '9chib6+CX3gde0aVc6A5VA==';
function encrypt($data, $key){
    $encryptionkey = base64_decode($key);
//    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $iv = '1234567891011121';
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

function decrypt($data, $key){
    $encryptionkey = base64_decode($key);
    $iv = '1234567891011121';
    list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($data),2), 2, null);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
}

function maskedCardNum($ccnum){
$masked =  str_pad(substr($ccnum, -4), strlen($ccnum), '*', STR_PAD_LEFT);
return $masked;
//return str_replace(range(0,9), "*", substr($cardnum, 0, -4)) .  substr($cardnum, -4);
}
?>
