<?php  
echo phpinfo(); die;
if(mail('vinodthalwal87@gmail.com','test','message'.'abs@gmail.com')){
	echo "yes"; die;
}
else{
	echo "no"; die;
}

echo phpinfo(); die;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require __DIR__ . '/Twilio/autoload.php';
use Twilio\Rest\Client;

// Your Account SID and Auth Token from twilio.com/console
$account_sid = 'ACb91f71e69b710a801bedd6f2e9fea091';
$auth_token = '6fd3d4aecff231f1d51c0aaa12b6db5a';
// In production, these should be environment variables. E.g.:
// $auth_token = $_ENV["TWILIO_ACCOUNT_SID"]

// A Twilio number you own with SMS capabilities
$twilio_number = "+17049816330";

$client = new Client($account_sid, $auth_token);
$client->messages->create(
    // Where to send a text message (your cell phone?)
    '+919034195001',
    array(
        'from' => $twilio_number,
        'body' => 'I sent this message in under 10 minutes!'
    )
);

die;
 ?>