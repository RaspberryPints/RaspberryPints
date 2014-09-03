<?php

/*
UntappdPHP 1.0

By: Greg Avola (@gregavola)
Inspired By: https://github.com/abraham/twitteroauth

*/

class UntappdPHP {

	public $access_token = "";
	public $client_id = "";
	public $client_secret = "";
	public $callback_url = "";

	public $userAgent = "UntappdPHP-GH-1.0";
	public $http_code;

	public $apiBase = "https://api.untappd.com/v4";

	public $authenticateURL = "https://untappd.com/oauth/authenticate";
	public $authorizeURL = "https://untappd.com/oauth/authorize";

	// Construct for the Class. Consumer Key and Consumer Secret are required, however you can pass through the token if you already need them.

	public function __construct($client_id, $client_secret, $redirect_url, $access_token = NULL) 
	{
		$this->client_id = $client_id;
		$this->client_secret = $client_secret;
		$this->access_token = $access_token;		
		$this->redirect_url = $redirect_url;
	}


	public function setToken($access_token) {
		$this->access_token = $access_token;
	}

	/**
	* Get the authorize URL, you must pass in the $token paramater
	*
	* @returns a string
	*/
	
	function getAuthenticateURL() {
		return $this->authenticateURL . "?client_id=".$this->client_id."&client_secret=".$this->client_secret."&redirect_url=".$this->redirect_url;
	}

	/**
	* Get the authorize URL, you must pass in the $token paramater
	*
	* @returns a string
	*/
	
	function getAccessToken($code) {
		
		$params = array(
			"client_id" => $this->client_id,
			"client_secret" => $this->client_secret,
			"redirect_url" => $this->redirect_url,
			"code" => $code
		);

		$url = $this->authorizeURL . "?" . http_build_query($params);

		$response = $this->call($url, "POST", array());

		return json_decode($response);
	}

	/**
	* Basic GET wrapper for non-oauth calls to the API
	*
	*/

	public function get($url, $params = array()) {

		$added = "";
		if (sizeof($params) != 0) {
			$added = "&" . http_build_query($params);
		}

		if ($this->access_token == "") {

			if(stristr($url, '?') === FALSE) {
				$url = $this->apiBase . $url . "?client_id=".$this->client_id . "&client_secret=" . $this->client_secret . $added;
			}
			else {
				$url = $this->apiBase . $url . "&client_id=".$this->client_id . "&client_secret=" . $this->client_secret . $added;
			}
				
		}
		else {
			$url = $this->apiBase . $url . "?access_token=".$this->access_token . $added;
		}
		
		$response = $this->call($url, 'GET', $params);
		return json_decode($response);
	}

	/**
	* Basic GET wrapper for oauth calls to the API
	*
	*/

	public function post($url, $params = array()) {
		
		if ($this->access_token == "") {

			if(stristr($url, '?') === FALSE) {
				$url = $this->apiBase . $url . "?client_id=".$this->client_id . "&client_secret=" . $this->client_secret;
			}
			else {
				$url = $this->apiBase . $url . "&client_id=".$this->client_id . "&client_secret=" . $this->client_secret;
			}
		}
		else {

			if(stristr($url, '?') === FALSE) {
				$url = $this->apiBase . $url . "?access_token=".$this->access_token;
			}
			else {
				$url = $this->apiBase . $url . "&access_token=".$this->access_token;
			}
			
		}

		$response = $this->call($url, 'POST', $params);

		return json_decode($response);
	}

	/**
	* Basic CURL request which connects to the Tumblr API URLs and returns the result
	*
	* @returns result from the URL call
	*/

	private function call($url, $method, $parameters) {
		$curl2 = curl_init();

		if ($method == "POST")
		{
			curl_setopt($curl2, CURLOPT_POST, true);
			curl_setopt($curl2, CURLOPT_POSTFIELDS, $parameters);
		}

		curl_setopt($curl2, CURLOPT_URL, $url);
		curl_setopt($curl2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curl2, CURLOPT_USERAGENT, $this->userAgent);

		$result = curl_exec($curl2);
		
		$HttpCode = curl_getinfo($curl2, CURLINFO_HTTP_CODE);

		$this->http_code = $HttpCode;

		return $result;
 	}
}
