
<?php
session_start(); 


$imgurl = 'https://scontent-lhr3-1.xx.fbcdn.net/v/t1.0-9/11988259_1672140403008188_2765317534386607908_n.jpg?oh=ef2d8c9deed78c03d070ae0ac052497e&oe=57AA2100';
file_put_contents("image.jpg", file_get_contents($imgurl));

require_once '../src/Facebook/autoload.php';

$app_id = '874168309359589';
$app_secret = '5abc1d036bf115bb722115e436ad5f6b';
$access_token = 'EAAMbDSuNoZBUBAFQlIs4qKKn0VYIPB2eH36bZBSSyt6787TuFSWPHZAcd2RE2KAtpcBsc8oy7cPyO6lOXEsvcvyySsfojeE6o7x8YHGqBKyAZAEeDC1GSDqRdXKVYSvR97rpmvxX9pvYi7xkJapycq84ZC5ZBhVUYZD';
$albumid = '187737951614546';
$groupid = '211312725908106';

$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.6', // change to 2.5
  //'default_access_token' => $app_id . '|' . $app_secret
]);


  //  'image' => 'http://apostagol.herokuapp.com/image.jpg',
$linkData = [
  'source' => $fb->fileToUpload('image.jpg'),
  'message' => 'teste',
];

try {
  $response = $fb->post('/' . $albumid . '/photos', $linkData, $access_token);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}
echo '<br>postou no user<br>';

$userNode = $response->getGraphUser();
//var_dump($userNode->getId());
$link_post = 'https://www.facebook.com/' . $userNode['id'];
echo $link_post . '<br>';


$linkData = [
  'link' => $link_post,
  'message' => 'teste2',
];

try {
  $response = $fb->post('/' . $groupid . '/feed', $linkData, $access_token);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

echo '<br>postou no grupo<br>';

?>
