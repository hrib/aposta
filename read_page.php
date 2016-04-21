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
  'default_access_token' => $app_id . '|' . $app_secret
]);
echo '<br>3<br>';


try {
  $response = $fb->get('/mblivre?fields=feed');
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$graphObject = $response->getGraphObject()->AsArray();
echo '<br>';
//var_dump($graphObject );
echo '<br>';
//print_r( $graphObject, 1 );
echo '<br>';
$get_data = $response->getDecodedBody();
var_dump($get_data);
echo '<br>';
print_r($get_data, 1 );
echo '<br>';

echo var_dump($get_data[0][0][1]);
echo '<br>';
echo $get_data['feed']['data']['message'];


$i = 0;
foreach ($graphObject['data'] as $key => $value){
    echo $value->message;
    echo '<br>';
    $i++; // add 1 to the counter
    if ($i == 10) {
        break;
    }
}






echo '<br>6<br>';
?>
