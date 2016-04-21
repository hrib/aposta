<?php
session_start();

require_once 'src/Facebook/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '1011974285544429',
  'app_secret' => '9b28ee403af9889f18c3fd6f3b9135c8',
  'default_graph_version' => 'v2.6', // change to 2.5
  //'default_access_token' => 'CAAOYYpZCPyZB0BAEZCkFzEhIaffQWy01uchvfFom7pSoZBu7Qr6UuVxEizJdb40JXjxkOWtnZB9GzViAvsvPSgdpi9cZBC8o3GUDHJSCfGjthyC5zZCuoZAD3p6G4G1rhztjbEZAD5kRmyArM1XixvcN5cvfo5pG62JzGY1CRYNIPM8XrEZAuE96GBTSk2JzFxOljhwXNZATrAhmEO3cBTM3fpV'
]);


$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://apostagol.heroku.com/callback.php', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';

?>
