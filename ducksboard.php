<?php

	class DucksboardAPI {
		protected $_key;
		protected $_url;
		protected $_data;

		public function __construct(){
			return $this;
		}

		/**
		 * [send description]
		 * @return [type] [description]
		 */
		protected function _send(){
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

		protected function _out($result){
			$output = "";

			if(PHP_SAPI == "cli"){
				$output .= "Request Status: Success\n";
				$output .= sprintf("Request Type: %s\n", $this->_getClassType());
				$output .= "Request Data: \n";
				var_dump($result->data);
			}else {
				$output .= "<ul>";
				$output .= "<li>Request Status: <strong>Success</strong></li>";
				$output .= sprintf("<li>Request Type: <strong>%s</strong></li>", $this->_getClassType());
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


		protected function _getClassType(){
			$class = get_class($this);
			$class = str_replace("DucksboardAPI", "", $class);

			return $class;
		}

		/**
		 * [_request description]
		 * @param  [type] $url [description]
		 * @return [type]      [description]
		 */
		protected function _request(){
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