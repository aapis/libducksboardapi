<?php
	
	/**
	 * DucksboardAPIPull
	 * A simple library to make interfacing with the Ducksboard Pull API easier
	 *
	 * DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE 
	 *                    Version 2, December 2004 
	 *
	 * Copyright (C) 2004 Sam Hocevar <sam@hocevar.net> 
	 *
	 * Everyone is permitted to copy and distribute verbatim or modified 
	 * copies of this license document, and changing it is allowed as long 
	 * as the name is changed. 
	 *
	 *            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE 
	 *   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION 
	 *
	 *  0. You just DO WHAT THE FUCK YOU WANT TO.
	 */
	class DucksboardAPIPull extends DucksboardAPI {
		private $_endpoint;

		/**
		 * Endpoints supported by Ducksboard
		 * @var array
		 */
		private $_allowed_endpoints = array(
				"/last",
				"/timezone",
			);

		/**
		 * Setup the class variables that we need to run the request
		 * @param string  $endpoint The API endpoint you want data from
		 * @param int     $source   Your widget's slot number
		 * @param string  $skeleton The API key
		 */
		public function __construct($endpoint = null, $source = null, $skeleton = null){
			try {
				//begin basic error handling
				if(is_null($skeleton)){
					throw new Exception("API key is required to make the request");
				}

				if(is_null($source)){
					throw new Exception("A slot is required to make the request");
				}

				if(is_null($endpoint)){
					throw new Exception("An endpoint is required to make the request");
				}

				$this->_key = sprintf("%s:ignored", $skeleton);
				$this->_url = sprintf("https://pull.ducksboard.com/v/%d", $source);
				$this->_endpoint = $this->_validateEndpoint($endpoint);
			}catch(Exception $e){
				echo $e->getMessage();
			}

			return $this;
		}

		/**
		 * Filter out invalid data
		 * @param  [type] $endpoint [description]
		 * @return [type]           [description]
		 */
		private function _validateEndpoint($endpoint){
			try{
				foreach($this->_allowed_endpoints as $allowed){
					if(strstr($endpoint, $allowed) !== false){
						return $endpoint;
					}
				}

				throw new Exception(sprintf("Invalid endpoint: %s", $endpoint));
			}catch(Exception $e){
				echo $e->getMessage();
			}
		}

		/**
		 * Run the request and pull data from your widget/dashboard
		 * @return stdClass
		 */
		protected function _request(){
			$payload = $this->_url.$this->_endpoint;

			$handler = curl_init();
			curl_setopt_array($handler, array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_URL => $payload,
				CURLOPT_USERAGENT => "Free Request",
				CURLOPT_USERPWD => $this->_key,
				));

			$resp = curl_exec($handler);
			$decoded = json_decode($resp);
			$ret = new stdClass();

			if(property_exists($decoded, "response")){
				$ret->success = ($decoded->response == "ok");
				$ret->data = $decoded;

				return $ret;
			}

			$ret->raw = $decoded;
			$ret->json = $resp;

			return $ret;
		
		}
	}

?>