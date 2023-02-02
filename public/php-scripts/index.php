<?php

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");


define('ENCRYPTION_KEY', 'ab86d144e');
define('KEYPAIR_PUBLIC_BASE64', '/1VQHNj8MjJhSD/eX7jc/7EfiYv43A3vZw1l00AyLRk');
define('ENCRYPTED_KEYPAIR_BASE64', 'NidTPQPa07WOxNpqHg8G9iwWhRC9XT70DDYd1McLqcHnIzFv6UibUOq5sUSyhLdG9d5ZYQpjtG5gYmFyN5hiNLO4QxE/6JIZRcLefH5BVwtv8gO3PTqVc8Dmp1/0Brph9ruNijF/rmoNRoVAzjP1xlxtkWCz4B++WP04jIX6HsfvDqV/I4YkD6x2EzBVNNeg');

$email = htmlspecialchars($_GET["email"]);
$password = htmlspecialchars($_GET["password"]);

$keypair = "NLIxOHWLmwFNPCo0xpOKCfTgPaQ2nc7Ad0W7GP1jqpn/VVAc2PwyMmFIP95fuNz/sR+Ji/jcDe9nDWXTQDItGQ";
$encrypted_keypair_base64 = "NidTPQPa07WOxNpqHg8G9iwWhRC9XT70DDYd1McLqcHnIzFv6UibUOq5sUSyhLdG9d5ZYQpjtG5gYmFyN5hiNLO4QxE/6JIZRcLefH5BVwtv8gO3PTqVc8Dmp1/0Brph9ruNijF/rmoNRoVAzjP1xlxtkWCz4B++WP04jIX6HsfvDqV/I4YkD6x2EzBVNNeg";
$keypair_public_base64 = "/1VQHNj8MjJhSD/eX7jc/7EfiYv43A3vZw1l00AyLRk";


// echo "@@".encrypt_private_key_use_password($keypair,ENCRYPTION_KEY)."@@";
// echo "<br/><br/><br/><br/><br/>";
// $decrypted_keypair_base64 = decrypt_private_key_use_password($encrypted_keypair_base64,ENCRYPTION_KEY);

// echo "|||".$decrypted_keypair_base64."|||<br/>";
// $keypair = sodium_crypto_box_keypair();
// $keypair_public = sodium_crypto_box_publickey($keypair);
// $keypair_secret = sodium_crypto_box_secretkey($keypair);

// echo "пппппп". sodium_bin2base64($keypair_public, 3) . "пппп<br>";

// echo "<br>ппп" . sodium_bin2base64($keypair, 3) . "ппп<br>";



// $opened = sodium_crypto_box_seal_open(base64_decode($encrypted_base64), base64_decode($decrypted_keypair_base64));
// echo "===".$opened ."===<br>";

if ($email!="") {saveEmail($email);} 
else if ($password!="") {showEmails();}

function saveEmail($email){
    function saveRow($list) {
        $file = fopen("base.csv","a");
        foreach ($list as $line)
        { 
          fputcsv($file,explode(':',$line));
        }
        fclose($file); 
      }
      $email_encrypted = encrypt_email_use_public_key($email,KEYPAIR_PUBLIC_BASE64);
      saveRow(Array($email_encrypted));
} 


function showEmails(){
    $decrypted_keypair_base64 = decrypt_private_key_use_password(ENCRYPTED_KEYPAIR_BASE64,ENCRYPTION_KEY);
    $row = 1;
    if (($handle = fopen("base.csv", "r")) !== FALSE) {
        echo '<table border="1">';
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $num = count($data);
            // echo "<p> $num полей в строке $row: <br /></p>\n";
            $row++;
           
            for ($c=0; $c < $num; $c++) {
                echo "<tr><td>". decrypt_email_use_private_key($data[$c],$decrypted_keypair_base64) . "</td></tr>";
            }
           
        }
        echo "</table>";
        fclose($handle);
    }
}

function encrypt_private_key_use_password($plaintext,$password){
    // Encrypt private key
    // $plaintext = "Тестируем обратимое шифрование на php 7";
    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $password, $options=OPENSSL_RAW_DATA, $iv);
    $hmac = hash_hmac('sha256', $ciphertext_raw, $password, $as_binary=true);
    $encrypt_base64 = base64_encode( $iv.$hmac.$ciphertext_raw );
    return $encrypt_base64;
}

 
function decrypt_private_key_use_password($ciphertext,$password){
    // Decrypt keys
    $c = base64_decode($ciphertext);
    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    $iv = substr($c, 0, $ivlen);
    $hmac = substr($c, $ivlen, $sha2len=32);
    $ciphertext_raw = substr($c, $ivlen+$sha2len);
    $plaintext = openssl_decrypt($ciphertext_raw, $cipher, $password, $options=OPENSSL_RAW_DATA, $iv);
    $calcmac = hash_hmac('sha256', $ciphertext_raw, $password, $as_binary=true);

    if (hash_equals($hmac, $calcmac))
        {
            return $plaintext;
        } else return false;
}

function encrypt_email_use_public_key($email,$keypair_public_base64){
    // $message = 'hello';
    $encrypted = sodium_crypto_box_seal($email, base64_decode($keypair_public_base64));
    $encrypted_email_base64 = base64_encode($encrypted);
    // echo "+++".base64_encode($encrypted) ."+++<br>";
    return $encrypted_email_base64;
}

function decrypt_email_use_private_key($encrypted_email_base64,$decrypted_keypair_base64){
    $opened = sodium_crypto_box_seal_open(base64_decode($encrypted_email_base64), base64_decode($decrypted_keypair_base64));
    return $opened;
}