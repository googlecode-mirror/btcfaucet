<?php
// BTCFaucet Project 
// code.google.com/p/btcfaucet
// Coded by Spenzert and KrusherPT/etsoberano
//
// Current version: 0.01 Alpha
// Not suitable for production use, make your own faucet to public at your own risk!
// If you really want to continue, you should consider add some IP Blocker to block Datacenters IPs (Using IP Ranges)
//
// BTCFaucet is licensed under a Creative Commons Attribution 3.0 Unported License
?>
<html>
  <body>
  <center>
    <form action="" method="post">
	Bitcoin Address: <input type="text" name="address" style="width: 300px;" />
	<p><p/>
	<p><p/>

<?php

$username = "DB_USERNAME";
$password = "DB_PASSWORD";
$hostname = "DB_HOST"; 

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password)
 or die("Unable to connect to MySQL");
// echo "Connected to MySQL<br>";

//select a database to work with
$selected = mysql_select_db("DB_DATABASE", $dbhandle)
  or die("Could not select DB_DATABASE");
  
// Purge records
mysql_query("DELETE FROM ip_table WHERE access_date < DATE_SUB(NOW(), INTERVAL 1440 MINUTE)");

$ip = mysql_real_escape_string($_SERVER['REMOTE_ADDR']);
$result = mysql_query("SELECT ip FROM ip_table WHERE ip = '$ip'");
if($result && mysql_num_rows($result) > 0){
  die("You already received your free Bitcoins today!");
} 
else {
// $result = mysql_query("INSERT INTO ip_table (ip, access_date) VALUES ('$ip', NOW())");
  
require_once('recaptchalib.php');

// Get a key from https://www.google.com/recaptcha/admin/create
$publickey = "PUBLIC_KEY";
$privatekey = "PRIVATE_KEY";

# the response from reCAPTCHA
$resp = null;
# the error code from reCAPTCHA, if any
$error = null;

# was there a reCAPTCHA response?
if ($_POST["recaptcha_response_field"]) {
        $resp = recaptcha_check_answer ($privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);

        if ($resp->is_valid) {
                $file = 'pending.txt';
		        $address = $_POST["address"]."\n";
		        $fh = fopen($file, 'a') or die("can't open file");
		        fwrite($fh, $address);
		        fclose($fh);
                echo "Soon you will receive your Bitcoins!";
                $result = mysql_query("INSERT INTO ip_table (ip, access_date) VALUES ('$ip', NOW())");
        } else {
                echo "<!-- Captcha Challenge Failed -->";
                $error = $resp->error;
        }
}
echo recaptcha_get_html($publickey, $error);
}

?>


    <br/>
	
    <input type="submit" value="Send Bitcoins" />
    </form>
	</center>
  </body>
</html>
