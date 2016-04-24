
<?php
session_start(); 


$imgurl = 'https://scontent-lhr3-1.xx.fbcdn.net/v/t1.0-9/11988259_1672140403008188_2765317534386607908_n.jpg?oh=ef2d8c9deed78c03d070ae0ac052497e&oe=57AA2100';
file_put_contents("image.jpg", file_get_contents($imgurl));
//echo "<img src='image.jpg'>";


require_once '../src/Facebook/autoload.php';
echo '<br>2<br>';
$app_id = '874168309359589';
$app_secret = '5abc1d036bf115bb722115e436ad5f6b';
$access_token = 'EAAMbDSuNoZBUBAH8TG7atHewGb13hYSd63B6RhGC5Ra69kU9fsIl1xCbxxz8aZBFED1ydfXrFxUwcgMExAFJe9Lv31wKAk1t8UgQIXh1ub1o24u7OnOWjal0xcdIYqi3EnSupTwZAd5CsF86bQr7JdR2DbrSU1uFFkXjhzT8AZDZD';
$albumid = '187737951614546';

$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.6', // change to 2.5
  //'default_access_token' => $app_id . '|' . $app_secret
]);


  // 'link' => 'http://apostagol.herokuapp.com/image.jpg',
  //  'image' => 'http://apostagol.herokuapp.com/image.jpg',
$linkData = [
  'source' => $fb->fileToUpload('image.jpg'),
  'message' => 'teste',
];

try {
//    $response = $fb->post('/Theballisonthetable/feed', $linkData, $page_access_token);
    $response = $fb->post('/' . $albumid . '/photos', $linkData, $access_token);

} catch(Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

?>
