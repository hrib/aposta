<?php
session_start();
require_once 'src/Facebook/autoload.php';


$dbopts = parse_url(getenv('DATABASE_URL'));
$dsn = "pgsql:"
    . "host=" . $dbopts["host"] . ";"
    . "dbname=". ltrim($dbopts["path"],'/') . ";"
    . "user=" . $dbopts["user"] . ";"
    . "port=" . $dbopts["port"] . ";"
    . "sslmode=require;"
    . "password=" . $dbopts["pass"];
$db = new PDO($dsn);
$query = "SELECT id1, id2, id3, id4 FROM dados WHERE id1 = 'brasilreal'";
$result = $db->query($query);
echo var_dump($result);

$row = $result->fetch(PDO::FETCH_ASSOC))
//echo "<br>" . $row["id1"] . "<br>";
$result->closeCursor();






$pageOriginal = 'mblivre';
$app_id = $row["id2"]
$app_secret = $row["id3"]
$page_access_token = $row["id4"]
echo '<br>' . $app_id . '<br>';
echo '<br>' . $app_secret . '<br>';
echo '<br>' . $page_access_token . '<br>';
//$app_id = '1011974285544429';
//$app_secret = '9b28ee403af9889f18c3fd6f3b9135c8';
//$page_access_token = 'CAAOYYpZCPyZB0BAFOuSDDRfo5eZAkn8xNCzkwwmGZC5NCNgiDkq6vZACMOb6MeiQGPZCrVW82W1K83fVJZAMO7TLPSZAfSLrm6Q2aZCwqI5qmHeqE8u8GfzwrOxuk6cf8Gqe95VvvUwdjWMu4QnMp01YYzw1m1OZAERmZAiHUEm4HcyxBWXKLoNmXs2YRy2br2hbaIZD';
  
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
  var_dump($value['created_time']); //precisa disso pra funcionar
  $created_timeSTR = $value['created_time']->date;
  $created_time = strtotime($created_timeSTR);  //unix
  echo '<br>' . $key . ':' . $created_timeSTR . '<br>';
  //echo '<br>time' . $key . ':' . $created_time . '<br>';
  $tempo = time();
  $diffunix = $tempo - $created_time;
  echo '<br> diff tempo:' . $diffunix . '<br>';
  echo '<br>________________________________<br>';
  if($diffunix < 3600){
    PostClone($fb, $value['message'], $value['link'], $value['full_picture']);
  }
  
}


function PostClone($fb, $page_access_token, $message, $link, $picture){
  
  echo '<br>.....POSTANDO......<br>';
  file_put_contents("image.jpg", file_get_contents($picture));

  $albumid = '1509106142644949';
  
  if (strpos($picture, 'https://scontent') !== false) {
    //imagem interna, posta como imagem
    echo '<br>Imagem interna<br>';
    $target = '/' . $albumid . '/photos';
    $linkData = [
      'source' => $fb->fileToUpload('image.jpg'),
      'message' => $message,
    ];
  } else {
    //imagem externa(link) ou sem imagem e link, posta link/nada
    echo '<br>Link externo/nada<br>';
    $target = '/Theballisonthetable/feed';
    $linkData = [
      'link' => $link,
      'message' => $message,
    ];
  }

  try {
      $response = $fb->post($target, $linkData, $page_access_token);
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
  }


  
  
}


?>
