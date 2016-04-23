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

$response = $fb->get('/' . $pageOriginal . '?fields=posts{message,link,full_picture,created_time}&date_format=U');
$graphNode = $response->getGraphNode();
foreach ($graphNode['posts'] as $key => $value) {
  echo '<br>' . $key . ':' . $value['message'] . '<br>';
  echo '<br>' . $key . ':' . $value['link'] . '<br>';
  echo '<br>' . $key . ':' . $value['full_picture'] . '<br>';
  // '<br>' . $key . ':' . $value['created_time'] . '<br>';
  $curtime = time();
  echo '<br> tempoatual:' . $curtime . '<br>';
  $z = gmdate(DATE_ISO8601, $curtime);
  $y = gmdate(DATE_ISO8601, $value['created_time']);
  echo '<br> tempoatual convertido:' . $z . '<br>';
  echo '<br> tempoapost convertido:' . $y . '<br>';
  echo '<br> diff:' . $z - $y . '<br>';
  echo '<br>___________________________________________________<br>';
}



?>
