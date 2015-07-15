<?
function ubobjectToArray($d) {
 if (is_object($d)) {
 // Gets the properties of the given object
 // with get_object_vars function
 $d = get_object_vars($d);
 }

 if (is_array($d)) {
 /*
 * Return array converted to object
 * Using __FUNCTION__ (Magic constant)
 * for recursive call
 */
 return array_map(__FUNCTION__, $d);
 }
 else {
 // Return array
 return $d;
 }
 }

require_once("infusionsoft/src/isdk.php");
$app = new iSDK;
$MFSUnbounceInfusionsoft = get_option( 'MFSUnbounceInfusionsoft' );
$app_name = $MFSUnbounceInfusionsoft['infusionsoft_app'];
$app_key = $MFSUnbounceInfusionsoft['infusionsoft_key'];
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
  //echo 'Connected to Infusionsoft<br>';
    $data = ubobjectToArray(json_decode($_REQUEST['data_json']));
    $first_name = $data['first_name'][0];
    $last_name = $data['last_name'][0];
    $email = $data['email'][0];
    $AffiliateId = $data['ref'][0];
    $IPAddress = $data['ip_address'][0];
    $time_submitted = $data['time_submitted'][0];
    $Source = $data['page_url'][0];
    $DateSet = $data['date_submitted'][0].' '.$time_submitted;
    $DateSet = date('Y-m-d H:i:s', strtotime($DateSet));
    $DateExpires = date('Y-m-d H:i:s', strtotime($data['date_submitted'][0].' +1 year'));
    sleep(2);
    $returnFields = array('Id',);
    $contact = $app->findByEmail($email, $returnFields);
    $ContactId = $contact[0]['Id'];
    $ContactId;
    $data = array(
    'DateExpires' => $DateExpires,
    'DateSet' => $DateSet,
    'IPAddress' => $IPAddress,
    'Info' => 'From API Unbounce',
		'ContactId'  => $ContactId,
		'AffiliateId'     => $AffiliateId,
    'Type' => 2,
    'Source' => $Source
  );
    $success = $app->dsAdd("Referral", $data);
    //print_r($success);
  exit;
} else {
  echo 'Error connecting to Infusionsoft. Please make sure your keys are correct.';
}
