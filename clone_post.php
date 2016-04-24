<?php

include 'clone_post_mbreal.php';
include 'clone_post_theball.php';

function PostClone($fb, $myalbumid, $mypageid, $page_access_token, $message, $link, $picture){
  
  //echo '<td>POSTANDO</td>';
  file_put_contents("image.jpg", file_get_contents($picture));

  if (strpos($picture, 'https://scontent') !== false) {
    //imagem interna, posta como imagem
    echo '<td>Imagem interna</td>';
    $target = '/' . $myalbumid . '/photos';
    $linkData = [
      'source' => $fb->fileToUpload('image.jpg'),
      'message' => $message,
    ];
  } else {
    //imagem externa(link) ou sem imagem e link, posta link/nada
    echo '<td>Link externo/nada</td>';
    $target = '/' . $mypageid . '/feed';
    $linkData = [
      'link' => $link,
      'message' => $message,
    ];
  }
  //echo '<td></td>';
  echo '<td>' . $target . '</td>'; //target
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
