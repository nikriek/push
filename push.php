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
			return $this->sendRequest($params, $notificationType);
		}

		public function sendArticle($message, $article,$notificationType = null) {
			$params = array(
				"message" => $message,
				"view_type" => 0,
				"article" => $article
			);
			return $this->sendRequest($params,$notificationType);
		}

		public function sendImage($message, $image,$notificationType = null) {
			$params = array(
				"message" => $message,
				"view_type" => 0,
				"image" => $image
			);
			return $this->sendRequest($params,$notificationType);
		}
		public function sendArticleAndImage($message, $article,$image,$notificationType = null) {
			$params = array(
				"message" => $message,
				"view_type" => 0,
				"article" => $article,
				"image" => $image
			);
			return $this->sendRequest($params,$notificationType);
		}

		public function sendUrl($message,$url,$notificationType = null) {
			$params = array(
				"message" => $message,
				"view_type" => 1,
				"url" => $url
			);
			return $this->sendRequest($params,$notificationType);
		}

		public function sendLocation($message,$longitude,$latitude,$notificationType = null) {
			$params = array(
				"message" => $message,
				"view_type" => 2,
				"longitude" => $longitude,
				"latitude" => $latitude
			);
			return $this->sendRequest($params,$notificationType);
		}

		private function sendRequest($params,$notificationType = null) {
			if ($notificationType != null) {
				$params['notification_type'] = $notificationType;
			}
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
?>
