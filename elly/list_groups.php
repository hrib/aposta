<?php
session_start(); 
require_once(dirname(__FILE__)."/../src/Facebook/autoload.php");

$app_id = '874168309359589';
$app_secret = '5abc1d036bf115bb722115e436ad5f6b';
$access_token = 'EAAMbDSuNoZBUBAFQlIs4qKKn0VYIPB2eH36bZBSSyt6787TuFSWPHZAcd2RE2KAtpcBsc8oy7cPyO6lOXEsvcvyySsfojeE6o7x8YHGqBKyAZAEeDC1GSDqRdXKVYSvR97rpmvxX9pvYi7xkJapycq84ZC5ZBhVUYZD';

$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.6', // change to 2.5
  'default_access_token' => $app_id . '|' . $app_secret
]);

?>
