<?
require_once("src/isdk.php");
$app = new iSDK;
$app_name = ''; // Replace with Your Infusionsoft APP Name
$app_key = ''; // Replace with Your Infusionsoft API Key
if(empty($app_name)) {
	echo 'Your APP Name is empty. Please set your app name to your Infusionsoft API name.<br>';
	return;
}
if(empty($app_key)) {
	echo 'Your APP key is empty. Please set your app key to your Infusionsoft API key.<br>';
	return;
}
if ($app->cfgCon($app_name, $app_key)) {
	// Connected to Infusionsoft - Run Your Code Below
	echo 'Connected to Infusionsoft<br>';
} else {
	echo 'Error connecting to Infusionsoft. Please make sure your keys are correct.';	
}
?>