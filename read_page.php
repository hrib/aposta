<?php
session_start();
echo '<br>1<br>';
require_once 'src/Facebook/autoload.php';
echo '<br>2<br>';

$app_id = '1011974285544429';
$app_secret = '9b28ee403af9889f18c3fd6f3b9135c8';
$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.6', // change to 2.5
  'default_access_token' => $app_id . '|' . $app_secret
]);
echo '<br>3<br>';


try {
  $response = $fb->get('/mblivre?fields=feed');
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$graphObject = $response->getGraphObject();


	$posts = $fb->api('/mblivre/posts?limit=50');
	echo "<pre>"; print_r($posts); echo "</pre>";
	$i=0;
	foreach ($posts['data'] as $post){
		$time_ar = explode("T",$post['updated_time']);
		echo "<h3>{$time_ar[0]}</h3>";
		if(isset($post['message']) && $post['message']) echo "<p>".make_links($post['message'])."</p>";
		if(isset($post['story']) && $post['story']) echo "<p>".make_links($post['story'])."</p>";
		
		if($i !== count($posts['data'])-1){
			echo '<hr>';
		}
		$i++;
	}






echo '<br>6<br>';
?>
