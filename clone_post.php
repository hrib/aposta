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
  // '<br>' . $key . ':' . $value['created_time'] . '<br>';
  $curtime = time();
  $z = gmdate(DATE_ISO8601, $curtime);
  
  $a = $value['created_time']['date'];
  echo var_dump($a);
  $converted_date_time = date( 'Y-m-d H:i:s', strtotime($a));
  echo '<br> cd:' . $converted_date_time . '<br>';
  $letras = date("M d Y h:ia", $a);
  echo '<br> letras:' . $letras . '<br>';
  $ts = strtotime($a);
  echo '<br> ts:' . $ts . '<br>';
  $myTime = gmdate(DATE_ISO8601, $a);
  echo '<br> mytime:' . $myTime . '<br>';
  echo '<br> diff:' . $z - $a . '<br>';
  
  echo '<br> tempoatual:' . $curtime . '<br>';
  $y = gmdate(DATE_ISO8601, $value['created_time']);
  echo '<br> tempoatual convertido:' . $z . '<br>';
  echo '<br> tempoapost convertido:' . $y . '<br>';
  echo '<br> diff:' . $z - $y . '<br>';
    echo '<br> diff:' . $curtime - $value['created_time'] . '<br>';
  echo '<br>___________________________________________________<br>';
}



?>
