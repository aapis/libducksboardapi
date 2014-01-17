<?php

	class DucksboardAPI {
		private $_key;
		private $_url;
		private $_data;

		public function __construct(stdClass $data = null, $destination = null, $skeleton = null){
			try {
				if(is_null($skeleton)){
					throw new Exception("API key is required to make the request");
				}

				if(is_null($destination)){
					throw new Exception("A slot is required to make the request");
				}

				$this->_key = sprintf("%s:ignored", $skeleton);
				$this->_url = sprintf("https://push.ducksboard.com/v/%d", $destination);

				if(is_null($data)){
					$this->_data = new stdClass();
				}else {
					//ducksboard requires the "value" key, so if the data object
					//doesn't have one we need to add it to the object
					if(false === property_exists($data, "value")){
						$data->value = new stdClass();

						foreach($data as $key => $value){
							if($key !== "value"){
								$data->value->{$key} = $value;

								unset($data->{$key});
							}
						}
					}

					$this->_data = $data;
				}

			}catch(Exception $e){
				echo $e->getMessage();
			}

			return $this;
		}

		/**
		 * [send description]
		 * @return [type] [description]
		 */
		public function send(){
			try {
				$result = $this->_request();

				if(false === $result->success){
					throw new Exception("The request could not be sent.");
				}else {
					$this->_out($result);
				}
			}catch(Exception $e){
				echo $e->getMessage();
			}
		}

		private function _out($result){
			$output = "";

			if(PHP_SAPI == "cli"){
				$output .= "Request Status: Success\n";
				$output .= "Request Data: \n";
				var_dump($result->data);
			}else {
				$output .= "<ul>";
				$output .= "<li>Request Status: <strong>Success</strong></li>\n";
				$output .= "<li>Request Data:";
					$output .= "<ul>";
					foreach($result->data as $key => $value){
						$output .= sprintf("<li>%s - %s</li>", $key, $value);
					}
					$output .= "</ul></li>";
				$output .= "</ul>";
			}

			echo $output;
		}

		/**
		 * [_request description]
		 * @param  [type] $url [description]
		 * @return [type]      [description]
		 */
		private function _request(){
			try{
				if(is_null($this->_url)){
					throw new Exception("You've entered an invalid slot");
				}

				$payload = json_encode($this->_data);

				$handler = curl_init();
				curl_setopt_array($handler, array(
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_POST => 1,
					CURLOPT_POSTFIELDS => $payload,
					CURLOPT_URL => $this->_url,
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
			}catch(Exception $e){
				echo $e->getMessage();
			}
		}
	}

?>