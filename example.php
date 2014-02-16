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
  		"http://example.de/article",
  		"http://example.de/img.jpg");
  	$push->sendUrl("Url sent","http://nikriek.de");
	$push->sendLocation("Location sent",13.4113999,52.5234051);
} catch (Exception $e) {
	echo $e->getMessage();
}
?>
