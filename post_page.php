<?php
session_start(); 

require_once 'src/Facebook/autoload.php';
echo '<br>2<br>';
$app_id = '1011974285544429';
$app_secret = '9b28ee403af9889f18c3fd6f3b9135c8';
$page_access_token = 'CAAOYYpZCPyZB0BAH9PGfnT0xZB3Gl6XHvSj5YeTZBnOhnjgZCX3HysliZAXnr2e1uetN07JuZCumdZAAgjHrB1ZCgsqZCeBTuGA2Rp4VN69ElvKlcQH0SPqzilRWZB77XqtorC4D3ZAV7PMibUZAyVZCitsG13UUmS7lyLY6jtrErOug8FkwqpTRlWN2plUFZB0OqxlXbLh9Tbj5qUAgQZDZD';


$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.6', // change to 2.5
  //'default_access_token' => $app_id . '|' . $app_secret
]);



$linkData = [
  'link' => 'http://apostagol.herokuapp.com/image.jpg',
  'message' => 'oi',
];

try {
    $response = $fb->post('/Theballisonthetable/feed', $linkData, $page_access_token);

} catch(Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

?>
