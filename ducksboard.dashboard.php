<?php
	
	/**
	 * DucksboardAPIDashboard
	 * A simple library to make interfacing with the Ducksboard Dashboard API 
	 * easier
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
	class DucksboardAPIDashboard extends DucksboardAPI {

		/**
		 * Setup the class variables that we need to run the request
		 * @param string  $endpoint The API endpoint you want data from
		 * @param int     $source   Your widget's slot number
		 * @param string  $skeleton The API key
		 */
		public function __construct($request_type = null, $dashboard_id = null, $skeleton = null){
			try {
				//begin basic error handling
				if(is_null($skeleton)){
					throw new Exception("API key is required to make the request");
				}

				if(is_null($dashboard_id)){
					throw new Exception("An endpoint is required to make the request");
				}

				$this->_http_request_type = $this->_processRequestType($request_type);
				$this->_key = sprintf("%s:ignored", $skeleton);
				$this->_url = sprintf("https://app.ducksboard.com/api/dashboards", $dashboard_id);

				//no id provided? return all of them
				if(is_null($dashboard_id) || false === is_numeric($dashboard_id)){
					$this->_url = "https://app.ducksboard.com/api/dashboards";
				}
			}catch(Exception $e){
				echo $e->getMessage();
			}

			return $this;
		}

		/**
		 * Validates the request method
		 * @param  string $type The raw request method
		 * @return mixed
		 */
		private function _processRequestType($type){
			$accepted_types = array("GET", "POST", "DELETE", "PUT");

			if(in_array($type, $accepted_types)){
				return $type;
			}

			return "GET";
		}

		/**
		 * Execute the request and generate the output
		 * @return void
		 */
		public function runAction($json = false){
			return $this->_send($json);
		}

		/**
		 * Run the request and pull data from your widget/dashboard
		 * @return stdClass
		 */
		protected function _request(){
			$handler = curl_init();
			$curlopts = array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_FOLLOWLOCATION => 1,
				CURLOPT_URL => $this->_url,
				CURLOPT_USERAGENT => "Free Request",
				CURLOPT_USERPWD => $this->_key,
				);

			//process the request type (GET|POST|PUT|DELETE)
			switch($this->_http_request_type){
				case "POST":
					$curlopts[CURLOPT_POST] = 1;
					$curlopts[CURLOPT_POSTFIELDS] = array(); //post data to send
				break;

				case "PUT":
					$curlopts[CURLOPT_PUT] = 1;
				break;

				case "DELETE":
					$curlopts[CURLOPT_CUSTOMREQUEST] = $this->_http_request_type;
				break;

				default:
				case "GET":
					break;
			}

			curl_setopt_array($handler, $curlopts);

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