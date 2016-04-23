<?php
session_start();
require_once 'src/Facebook/autoload.php';

$pageOriginal = 'mblivre';
$app_id = '1011974285544429';
$app_secret = '9b28ee403af9889f18c3fd6f3b9135c8';
$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.6', // change to 2.5
  'default_access_token' => $app_id . '|' . $app_secret
]);
//&date_format=U
$response = $fb->get('/' . $pageOriginal . '?fields=posts{message,link,full_picture,created_time}');
$graphNode = $response->getGraphNode();
foreach ($graphNode['posts'] as $key => $value) {
  echo '<br>' . $key . ':' . $value['message'] . '<br>';
  echo '<br>' . $key . ':' . $value['link'] . '<br>';
  echo '<br>' . $key . ':' . $value['full_picture'] . '<br>';
  $created_timeSTR = $value['created_time']->date;
  $created_time = strtotime($created_timeSTR);  //unix
  
  echo '<br>str' . $key . ':' . $created_timeSTR . '<br>';
  echo '<br>time' . $key . ':' . $created_time . '<br>';
  $tempo = time();
  $diffunix = $tempo - $created_timeSTR;
  //$curtime = gmdate(DATE_ISO8601, $tempo);
  //echo '<br> tempo:' . $tempo . '<br>';
  //echo '<br> curtime:' . $curtime . '<br>';
  //$diffstring = $curtime - $a;
  //echo '<br> diff string:' . $diffstring . '<br>';
  echo '<br> diff tempo:' . $diffunix . '<br>';
  echo '<br>________________________________<br>';
}



?>
