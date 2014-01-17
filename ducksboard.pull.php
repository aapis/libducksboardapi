<?php

	class DucksboardAPIPull extends DucksboardAPI {
		private $_endpoint;

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
				$this->_endpoint = $endpoint;
			}catch(Exception $e){
				echo $e->getMessage();
			}

			return $this;
		}

		/**
		 * Execute the request and generate the output
		 * @return void
		 */
		public function pull(){
			return $this->_send();
		}

		/**
		 * [_request description]
		 * @param  [type] $url [description]
		 * @return [type]      [description]
		 */
		protected function _request(){
			//$payload = json_encode($this->_data);
			$payload = $this->_url.$this->_endpoint;
			die($payload);

			$handler = curl_init();
			curl_setopt_array($handler, array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POST => 1,
				//CURLOPT_POSTFIELDS => $payload,
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
		
		}
	}

?>