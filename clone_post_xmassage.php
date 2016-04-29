<?php
session_start();
require_once 'src/Facebook/autoload.php';

$mypageid = '1325563600793849';
$myalbumid = '1330244656992410';
//$pageOriginal = 'mblivre';
$pageOriginal = $mypageid;


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
$page_access_token = 'EAAOYYpZCPyZB0BAPCjWYBQuT4UQvbZBJAJ4pOkLNbr1smSUhWnZCRtq5LF7dTTGnwOMFwqXuNUEv4r4RCKxlFPkkxoQ3LHurv1prjWDARjjz4tiFl7QHLTdqwjXiWDaOrTZBlb3XZBiciuaHyHH1KwUPcFXCQruOOyRyXmgH5GwgZDZD';

$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.6', // change to 2.5
  'default_access_token' => $app_id . '|' . $app_secret
]);
//&date_format=U
//$response = $fb->get('/' . $pageOriginal . '?fields=posts{message,link,full_picture,created_time}');
$response = $fb->get('/?ids='. $pageOriginal .'&fields=videos');
$graphNode = $response->getGraphNode();

//echo var_dump($response);
//echo var_dump($graphNode);
//echo var_dump($graphNode['vempraruabrasil.org']);
//echo var_dump($graphNode['mblivre']);
echo '<table border="1" style="font-family:arial; font-size:7px;">';
foreach ($graphNode as $pagina) {
    //foreach ($graphNode['posts'] as $key => $value) {
    foreach ($pagina['videos'] as $key => $value) {
      echo '<tr>';
      echo '<td>' . $key . ':' . $pagina['name'] . '</td>';
      $url = 'https://www.facebook.com/video/embed?video_id=' . $value['id'];
      $url2 = 'https://www.facebook.com/'. $mypageid .'/videos/' . $value['id'];
      $url3 = 'https://video-lga3-1.xx.fbcdn.net/hvideo-xpt1/v/t43.1792-2/12381567_252583708424832_2029793429_n.mp4?efg=eyJ2ZW5jb2RlX3RhZyI6InN2ZV9oZCJ9&oh=73bf16786cb78370e7d398c73e428d0b&oe=5723E22D';
      echo '<td>' . $url . '</td>';
      echo '<td>' . $url2 . '</td>';
      echo '<td>' . $value['description'] . '</td>';
      echo '<td>';
      file_put_contents("video.avi", file_get_contents($url3));
      file_put_contents("video.mpeg", file_get_contents($url3));
      file_put_contents("video.mp4", file_get_contents($url3));
      
      //echo '<td>' . var_dump($value['created_time']) . '</td>'; //precisa disso pra funcionar
      //$created_timeSTR = $value['created_time']->date;
      //$created_time = strtotime($created_timeSTR);  //unix
      //echo '<td>' . $key . ':' . $created_timeSTR . '</td>';
      //echo '<br>time' . $key . ':' . $created_time . '<br>';
      //$tempo = time();
      //$diffunix = $tempo - $created_time;
      //echo '<td> diff tempo:' . $diffunix . '</td>';
      //if($diffunix < 3600){
        //PostClone($fb, $myalbumid, $mypageid, $page_access_token, $value['message'], $value['link'], $value['full_picture']);
      //}else{
        //echo '<td></td>';
        //echo '<td></td>';
        //echo '<td></td>';
        //echo '<td></td>';
      //}
      
        $data = [
          'title' => 'My Foo Video',
          'description' => 'This video is full of foo and bar action.',
          'source' => $fb->videoToUpload('video.mp4'),
        ];
        
        
        //$target = '/' . $myalbumid . '/photos';
        $target = '/' . $mypageid . '/feed';
        
        try {
          $response = $fb->post($target, $data, $page_access_token);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
          // When Graph returns an error
          echo 'Graph returned an error: ' . $e->getMessage();
          exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
          // When validation fails or other local issues
          echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
        }
        
        $graphNode = $response->getGraphNode();
        var_dump($graphNode);
        
        echo 'Video ID: ' . $graphNode['id'];
      
      
      
      
      
      echo '</tr>';
    }
}
echo '</table>';



?>
