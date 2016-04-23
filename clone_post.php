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

$response = $fb->get('/' . $pageOriginal . '?fields=feed');
$graphNode = $response->getGraphNode();
foreach ($graphNode['feed'] as $key => $value) {
  echo '<br>' . $key . ':' . $value['message'] . '<br>';
  echo '<br>' . $key . ':' . $value['link'] . '<br>';
  echo '<br>' . $key . ':' . $value['full_picture'] . '<br>';
  echo '<br>' . $key . ':' . $value['created_time'] . '<br>';
  echo '___________________________________________________';
}



?>
