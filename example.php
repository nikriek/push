<?php
require_once('push.php');

  //Create a PushCo object with necessary credentials
$push = new PushCo(array(
		"api_key" => "API_KEY",
		"api_secret" => "API_SECRET"
	));
  
  //Different methods to try
try {
  	$push->sendArticleAndImage(
  		"Message sent",
  		"http://press.push.co/70303-ifttt-and-push-co-a-match-made-in-heaven",
  		"https://d21buns5ku92am.cloudfront.net/38491/images/107905-d8ddae8e-db73-41b7-a460-73667dc1c703-iphone5screen5-1-large-1378978123.PNG");
  	$push->sendUrl("Url sent","http://nikriek.de");
	$push->sendLocation("Location sent",13.4113999,52.5234051);
} catch (Exception $e) {
	echo $e->getMessage();
}
?>
