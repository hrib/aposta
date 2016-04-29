<?php
session_start();
require_once 'src/Facebook/autoload.php';

$mypageid = '1325563600793849';
//$myalbumid = '1330244656992410';
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
$query = "SELECT id1, id2, id3, id4 FROM dados WHERE id1 = 'xmassage'";
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
$response = $fb->get('/?ids='. $pageOriginal .'&fields=posts{source,full_picture,message}');
$graphNode = $response->getGraphNode();


echo '<table border="1" style="font-family:arial; font-size:7px;">';
foreach ($graphNode as $pagina) {
echo count($pagina['posts']);
echo '<br>';
echo sizeof($pagina['posts']);
echo '<br>';
    foreach ($pagina['posts'] as $key => $value) {
      echo '<tr>';
      echo '<td>' . $key . ':' . $pagina['name'] . '</td>';
      echo '<td>' . $value['source'] . '</td>';
      echo '<td>' . $value['full_picture'] . '</td>';
      echo '<td>' . $value['message'] . '</td>';
      echo '<td>';
      file_put_contents("video.mp4", file_get_contents($value['source']));
      
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
        $target = '/' . $mypageid . '/videos';
        
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
