<?php
	/**
	* The MIT License (MIT)
	*
	* Copyright (c) 2014 Niklas Riekenbrauck
	*
	* Permission is hereby granted, free of charge, to any person obtaining a copy
	* of this software and associated documentation files (the "Software"), to deal
	* in the Software without restriction, including without limitation the rights
	* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	* copies of the Software, and to permit persons to whom the Software is
	* furnished to do so, subject to the following conditions:
	*
	* The above copyright notice and this permission notice shall be included in all
	* copies or substantial portions of the Software.
	* 
	* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
	* SOFTWARE.
	* 
	* 
	* 
	* PushCo
	* 
	* The PushCo class is a wrapper for Push.co's API, which can POST notifications to their iPhone-App
	* 
	* 
	*/
	class PushCo {

		// Stores configuration/connection information
		private $config = array();

		//URL for REST API
		const API_URL = 'https://api.push.co/1.0/push';

		/**
		* The constructor needs an assoziative array with your app's API-Key and -Secret
		*
		* @param Array configArray configuration array
		*/
		public function __construct($configArray) {
			$this->config = $configArray;
		}

		/**
		* A function to send a basic message
		* notification type ist optional
		*
		* @param String message message to send
		* @param String notificationType optional notification type
		*
		* @throws Exception exception for any kind of error (e.g. connection or credentials)
		*/
		public function sendMessage($message,$notificationType = null) {
			$params = array(
				"message" => $message,
				"view_type" => 0
			);
			$this->sendRequest($params, $notificationType);
		}

		/**
		* A function to send not only a basic message but also some longer text
		* notification type ist optional
		*
		* @param String message message to send
		* @param String article some longer text to send
		* @param String notificationType optional notification type
		*
		* @throws Exception exception for any kind of error (e.g. connection or credentials)
		*/
		public function sendArticle($message, $article,$notificationType = null) {
			$params = array(
				"message" => $message,
				"view_type" => 0,
				"article" => $article
			);
			$this->sendRequest($params,$notificationType);
		}

		/**
		* A function to send not only a basic message but also a link to an image
		* notification type ist optional
		*
		* @param String message message to send
		* @param String image link to an image
		* @param String notificationType optional notification type
		*
		* @throws Exception exception for any kind of error (e.g. connection or credentials)
		*/
		public function sendImage($message, $image,$notificationType = null) {
			$params = array(
				"message" => $message,
				"view_type" => 0,
				"image" => $image
			);
			$this->sendRequest($params,$notificationType);
		}

		/**
		* A function to send not only a basic message but also a link to an image along with some more text
		* notification type ist optional
		*
		* @param String message message to send
		* @param String article some longer text to send
		* @param String image link to an image
		* @param String notificationType optional notification type
		*
		* @throws Exception exception for any kind of error (e.g. connection or credentials)
		*/
		public function sendArticleAndImage($message, $article,$image,$notificationType = null) {
			$params = array(
				"message" => $message,
				"view_type" => 0,
				"article" => $article,
				"image" => $image
			);
			$this->sendRequest($params,$notificationType);
		}

		/**
		* A function to send a message along with an url
		* notification type ist optional
		*
		* @param String message message to send
		* @param String url link to an website
		* @param String notificationType optional notification type
		*
		* @throws Exception exception for any kind of error (e.g. connection or credentials)
		*/
		public function sendUrl($message,$url,$notificationType = null) {
			$params = array(
				"message" => $message,
				"view_type" => 1,
				"url" => $url
			);
			$this->sendRequest($params,$notificationType);
		}

		/**
		* A function to send a message along with location information
		* notification type ist optional
		*
		* @param String message message to send
		* @param Integer longitude the location's longitude
		* @param Integer latitude the location's latitude
		* @param String notificationType optional notification type
		*
		* @throws Exception exception for any kind of error (e.g. connection or credentials)
		*/
		public function sendLocation($message,$longitude,$latitude,$notificationType = null) {
			$params = array(
				"message" => $message,
				"view_type" => 2,
				"longitude" => $longitude,
				"latitude" => $latitude
			);
			$this->sendRequest($params,$notificationType);
		}

		/**
		* Main function to send POST requests via curl
		* notification type ist optional
		*
		* @param Array params parameters like message
		* @param String notificationType optional notification type
		*
		* @throws Exception exception for any kind of error (e.g. connection or credentials)
		*/
		private function sendRequest($params,$notificationType = null) {
			//An empty config array throws an exception
			if (empty($this->config)) {
				throw new Exception("Missing connection credentials", 1);
			}

			//Only append notification_type if given in parameters
			if ($notificationType != null) {
				$params['notification_type'] = $notificationType;
			}

			//Merge all paramaters
			$data = array_merge($this->config,$params);

			//Create curl-object with needed params
			$fields = '';
	   		foreach($data as $key => $value) { 
	      		$fields .= $key . '=' . $value . '&'; 
	   		}
	   		rtrim($fields, '&');

	   		$post = curl_init();

	   		curl_setopt($post, CURLOPT_URL, self::API_URL);
	   		curl_setopt($post, CURLOPT_POST, count($data));
	   		curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
	   		curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);

	   		$result = curl_exec($post);
	   		if(curl_exec($post) === false) {
	   			//Handle curl error
				curl_close($post);
    			throw new Exception(curl_error($post), 2);
			} else if (curl_getinfo($post, CURLINFO_HTTP_CODE) == 401) {
				//Throw exception in case of invalid credentials
				curl_close($post);
				throw new Exception("Invalid credentials", 3);
			}
	   		curl_close($post);

	   		//Handle non-success of API-call
	   		$json = json_decode($result);
	   		if ($json['success'] != true) {
	   			throw new Exception($json['message'], 4);	
	   		}
		}
	}
?>
