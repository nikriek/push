<?php
	class PushCo {
		private $config = array();

		const apiUrl = 'https://api.push.co/1.0/push';

		public function __construct($configArray) {
			$this->config = $configArray;
		}

		public function sendMessage($message,$notificationType = null) {
			$params = array(
				"message" => $message,
				"view_type" => 0
			);
			if ($notificationType != null) {
				$params['notification_type'] = $notificationType;
			}
			return $this->sendRequest($params);
		}

		public function sendArticle($message, $article,$notificationType = null) {
			$params = array(
				"message" => $message,
				"view_type" => 0,
				"article" => $article
			);
			if ($notificationType != null) {
				$params['notification_type'] = $notificationType;
			}
			return $this->sendRequest($params);
		}

		public function sendImage($message, $image,$notificationType = null) {
			$params = array(
				"message" => $message,
				"view_type" => 0,
				"image" => $image
			);
			if ($notificationType != null) {
				$params['notification_type'] = $notificationType;
			}
			return $this->sendRequest($params);
		}
		public function sendArticleAndImage($message, $article,$image,$notificationType = null) {
			$params = array(
				"message" => $message,
				"view_type" => 0,
				"article" => $article,
				"image" => $image
			);
			if ($notificationType != null) {
				$params['notification_type'] = $notificationType;
			}
			return $this->sendRequest($params);
		}

		public function sendUrl($message,$url,$notificationType = null) {
			$params = array(
				"message" => $message,
				"view_type" => 1,
				"url" => $url
			);
			if ($notificationType != null) {
				$params['notification_type'] = $notificationType;
			}
			return $this->sendRequest($params);
		}

		public function sendLocation($message,$longitude,$latitude,$notificationType = null) {
			$params = array(
				"message" => $message,
				"view_type" => 2,
				"longitude" => $longitude,
				"latitude" => $latitude
			);
			if ($notificationType != null) {
				$params['notification_type'] = $notificationType;
			}
			return $this->sendRequest($params);
		}

		private function sendRequest($params) {
			if (empty($this->config)) {
				throw new Exception("Missing connection credentials", 1);
			}
			$data = array_merge($this->config,$params);

			$fields = '';
	   		foreach($data as $key => $value) { 
	      		$fields .= $key . '=' . $value . '&'; 
	   		}
	   		rtrim($fields, '&');

	   		$post = curl_init();

	   		curl_setopt($post, CURLOPT_URL, self::apiUrl);
	   		curl_setopt($post, CURLOPT_POST, count($data));
	   		curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
	   		curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);

	   		$result = curl_exec($post);
	   		if(curl_exec($post) === false)
			{
				curl_close($post);
    			throw new Exception(curl_error($post), 2);
			} else if (curl_getinfo($post, CURLINFO_HTTP_CODE) == 401) {
				curl_close($post);
				throw new Exception("Invalid credentials", 3);
			}
	   		curl_close($post);
	   		return $result;
		}
	}

	

	$push = new PushCo(array(
		"api_key" => "API_KEY",
		"api_secret" => "API_SECRET"
	));

	try {
		$push->sendMessage(
			"Message sent",
			"http://press.push.co/70303-ifttt-and-push-co-a-match-made-in-heaven",
			"https://d21buns5ku92am.cloudfront.net/38491/images/107905-d8ddae8e-db73-41b7-a460-73667dc1c703-iphone5screen5-1-large-1378978123.PNG");
		$push->sendUrl("Url sent","http://nikriek.de");
		$push->sendLocation("Location sent",13.4113999,52.5234051);
	} catch (Exception $e) {
		echo $e->getMessage();
	}

?>
