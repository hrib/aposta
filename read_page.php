<?php
session_start();
echo '<br>1<br>';
require_once 'src/Facebook/autoload.php';
echo '<br>2<br>';

$app_id = '1011974285544429';
$app_secret = '9b28ee403af9889f18c3fd6f3b9135c8';
$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.6', // change to 2.5
  //'default_access_token' => ''
]);
echo '<br>3<br>';


try {
  $response = $fb->get('/mblivre?fields=posts{comments}', $app_id . '|' . $app_secret);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$graphObject = $response->getGraphObject();
var_dump($graphObject );
//$email = $graphObject->getProperty('email');


echo '<br>4<br>';
?>