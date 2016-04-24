
<?php
session_start(); 
require_once '../src/Facebook/autoload.php';

$app_id = '874168309359589';
$app_secret = '5abc1d036bf115bb722115e436ad5f6b';
$access_token = 'EAAMbDSuNoZBUBAFQlIs4qKKn0VYIPB2eH36bZBSSyt6787TuFSWPHZAcd2RE2KAtpcBsc8oy7cPyO6lOXEsvcvyySsfojeE6o7x8YHGqBKyAZAEeDC1GSDqRdXKVYSvR97rpmvxX9pvYi7xkJapycq84ZC5ZBhVUYZD';
$myalbumid = '187737951614546';
$groupid = '211312725908106';
$pageOriginal = 'Anonimasgostosasbr,804933709548543';

$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.6', // change to 2.5
  'default_access_token' => $app_id . '|' . $app_secret
]);


$response = $fb->get('/?ids='. $pageOriginal .'&fields=name,posts.limit(2){message,link,full_picture,created_time}');
foreach ($graphNode as $pagina) {
    foreach ($pagina['posts'] as $key => $value) {
      echo '<tr>';
      echo '<td>' . $key . ':' . $pagina['name'] . '</td>';
      echo '<td>' . $value['message'] . '</td>';
      echo '<td>' . $value['link'] . '</td>';
      echo '<td>' . $value['full_picture'] . '</td>';
      echo '<td>';
      echo '<td>' . var_dump($value['created_time']) . '</td>'; //precisa disso pra funcionar
      $created_timeSTR = $value['created_time']->date;
      $created_time = strtotime($created_timeSTR);  //unix
      echo '<td>' . $key . ':' . $created_timeSTR . '</td>';
      $tempo = time();
      $diffunix = $tempo - $created_time;
      echo '<td> diff tempo:' . $diffunix . '</td>';
      if($diffunix < 3600){
        PostCloneUser($fb, $myalbumid, $groupid, $access_token, $value['message'], $value['link'], $value['full_picture']);
      }else{
        echo '<td></td>';
        echo '<td></td>';
        //echo '<td></td>';
        //echo '<td></td>';
      }
      echo '</tr>';
    }
}
echo '</table>';

function PostCloneUser($fb, $myalbumid, $groupid, $access_token, $message, $link, $picture){
  
  $message = 'add me!';
  file_put_contents("image.jpg", file_get_contents($picture));
  if ((strpos($picture, 'https://scontent') !== false)  AND (strpos($link, '/videos/') == false)  ) {
    //imagem interna, posta como imagem
    echo '<td>Imagem interna</td>';
    $target = '/' . $myalbumid . '/photos';
    $linkData = [
      'source' => $fb->fileToUpload('image.jpg'),
      'message' => $message,
    ];
  } else {
    //imagem externa(link), video ou sem imagem e link, posta link/nada
    echo '<td>Link externo/nada</td>';
    $target = '/me/feed';
    $linkData = [
      'link' => $link,
      'message' => $message,
    ];
  }


  try {
    $response = $fb->post($target, $linkData, $access_token);
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
    'message' => $message,
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
  //set_time_limit(25); 
  //sleep(10);

  
}


?>
