<?php
session_start();
require_once 'src/Facebook/autoload.php';

$mypageid = '798157940318724';
$myalbumid = '801145170020001';
//$pageOriginal = 'mblivre';
$pageOriginal = 'mblivre,vemprarua.org';


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
$row = $result->fetch(PDO::FETCH_ASSOC);
$result->closeCursor();

$app_id = $row["id2"];
$app_secret = $row["id3"];
$page_access_token = $row["id4"];

$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.6', // change to 2.5
  'default_access_token' => $app_id . '|' . $app_secret
]);
//&date_format=U
//$response = $fb->get('/' . $pageOriginal . '?fields=posts{message,link,full_picture,created_time}');
$response = $fb->get('/?ids='. $pageOriginal .'&fields=posts{message,link,full_picture,created_time}');

//echo var_dump($response);
echo '<br>---<br>';
$graphNode = $response->getGraphNode();
//echo var_dump($graphNode);
echo '<br>---<br>';
echo var_dump($graphNode['vemprarua.org']);
echo '<br>---<br>';
echo var_dump($graphNode['mblivre']);
//foreach ($graphNode['ids'] as $key => $value) {
//echo var_dump($value['posts']);
//}
//foreach ($graphNode[0] as $key => $value) {
//echo var_dump ($value['posts']);
//}
echo '<br>aqui<br>';
foreach ($graphNode['posts'] as $key => $value) {
  echo '<br>' . $key . ':' . $value['message'] . '<br>';
  echo '<br>' . $key . ':' . $value['link'] . '<br>';
  echo '<br>' . $key . ':' . $value['full_picture'] . '<br>';
  echo '<br>';
  var_dump($value['created_time']); //precisa disso pra funcionar
  $created_timeSTR = $value['created_time']->date;
  $created_time = strtotime($created_timeSTR);  //unix
  echo '<br>' . $key . ':' . $created_timeSTR . '<br>';
  //echo '<br>time' . $key . ':' . $created_time . '<br>';
  $tempo = time();
  $diffunix = $tempo - $created_time;
  echo '<br> diff tempo:' . $diffunix . '<br>';
  if($diffunix < 3600){
    PostClone($fb, $myalbumid, $mypageid, $page_access_token, $value['message'], $value['link'], $value['full_picture']);
  }
  echo '<br>________________________________<br>';
}


function PostClone($fb, $myalbumid, $mypageid, $page_access_token, $message, $link, $picture){
  
  echo '<br>.....POSTANDO......<br>';
  file_put_contents("image.jpg", file_get_contents($picture));

  if (strpos($picture, 'https://scontent') !== false) {
    //imagem interna, posta como imagem
    echo '<br>Imagem interna<br>';
    $target = '/' . $myalbumid . '/photos';
    $linkData = [
      'source' => $fb->fileToUpload('image.jpg'),
      'message' => $message,
    ];
  } else {
    //imagem externa(link) ou sem imagem e link, posta link/nada
    echo '<br>Link externo/nada<br>';
    $target = '/' . $mypageid . '/feed';
    $linkData = [
      'link' => $link,
      'message' => $message,
    ];
  }
  echo '<br>' . $target . '<br><br>';
  var_dump($linkData);
  try {
      $response = $fb->post($target, $linkData, $page_access_token);
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
  }
 
  set_time_limit(25); 
  sleep(10);
  
}


?>
