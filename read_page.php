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

$response = $fb->get('/mblivre?fields=feed');
//var_dump($response->getDecodedBody());
echo '<br>4<br>';    
$node = $response->getGraphNode();
//var_dump($node->getField('message'));
echo '<br>5<br>'; 

//$userNode = $response->getGraphUser();
//var_dump($userNode->getId());



$graphNode = $response->getGraphNode();

//echo $graphNode['feed'][0]['message'] . '<br><br>';
//echo '<br>fim<br>';

foreach ($graphNode['feed'] as $key => $value) {
  echo '<br>' . $key . ':' . $value['message'] . '<br>';
}


//foreach ($graphNode as $key => $value) {
//  echo $key . '<br>';
  //echo var_dump($value);
//  foreach ($value as $key2 => $value2) {
//    echo $key2 . '<br>';
//    echo var_dump($value2) . '<br>';
//    echo '_y_' . $value[0]['message'] . '<br>';
//      foreach ($value2 as $key3 => $value3) {
        //echo '__' . $key3 . '<br>';
        //echo '__' . var_dump($value3) . '<br>';
//        echo '_z_' . $value2['message'] . '<br>';
//      }
//  }
//  echo '<br>';
//  echo '<br>';
//}






echo '<br>6<br>';
?>
