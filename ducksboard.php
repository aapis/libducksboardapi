<?php
	
	/**
	 * DucksboardAPI
	 * A simple library to make interfacing with the Ducksboard API easier
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
	class DucksboardAPI {
		protected $_key;
		protected $_url;
		protected $_data;

		/**
		 * Construct nothing, chain it
		 */
		public function __construct(){
			return $this;
		}

		/**
		 * Sends the request to Ducksboard and manages the output
		 * @return void
		 */
		protected function _send($json){
			try {
				$result = $this->_request($json);

				if(is_null($result)){
					throw new Exception("There was an error processing the request.");
				}

				$this->_out($result, $json);
			}catch(Exception $e){
				echo $e->getMessage();
			}
		}

		/**
		 * Determine if there were any errors while running the request
		 * @param  stdClass  $result The request result object
		 * @return boolean
		 */
		protected function isSuccess(stdClass $result){
			if((isset($result->success) && $result->success === true)
				|| (isset($result->raw->count) && $result->raw->count > 0)
				){
				return true;
			}

			return false;
		}

		/**
		 * Writes output to the screen/terminal
		 * @param  stdClass $result
		 * @return void
		 */
		protected function _out(stdClass $result, $json = false){
			$output = "";

			if(false === $json){
				if(PHP_SAPI == "cli"){
					$output .= sprintf("Request Status: %s\n", ($this->isSuccess($result) ? "Success" : "Error"));
					$output .= sprintf("Request Type: %s\n", $this->_getClassType());
					$output .= "Request Data: \n";
					var_dump($result->data);
				}else {
					$output .= "<ul>";
					$output .= sprintf("<li>Request Status: <strong>%s</strong></li>", ($this->isSuccess($result) ? "Success" : "Error"));
					$output .= sprintf("<li>Request Type: <strong>%s</strong></li>", $this->_getClassType());
					$output .= "<li>Request Data:";
						$output .= "<ul>";

						if(isset($result->raw)){
							$iterator = $result->raw;
						}else {
							//for dashboards?!
							if(isset($result->data->data)){
								$iterator = $result->data->data;
							}
							//for pulls
							$iterator = $result->data;
						}

						foreach($iterator as $key => $value){
							if(is_array($value)){
								for($i = 0; $i < sizeof($value); $i++){								
									if(isset($value[$i]->dashboard_id)){ //result is a dashboard
										$output .= sprintf("<li>Dashboard ID: <strong>%s</strong><br />Layout: <strong>%s</strong><br />Name: <strong>%s</strong><br />Background: <strong>%s</strong><br />Slug: <strong>%s</strong></li>", $value[$i]->dashboard_id, $value[$i]->layout, $value[$i]->name, $value[$i]->background, $value[$i]->slug); 
									}else {
										$output .= sprintf("<li>%s - <strong>%s</strong></li>", $value[$i]->value->title, $value[$i]->value->content);
									}
								}
							}else {
								$output .= sprintf("<li>%s - <strong>%s</strong></li>", $key, $value);
							}
						}
						$output .= "</ul></li>";
					$output .= "</ul>";
				}
			}else {
				$output = $result->json;
			}

			echo $output;
		}

		/**
		 * Gets the type of request from the class name
		 * @return string]
		 */
		protected function _getClassType(){
			$class = get_class($this);
			$class = str_replace("DucksboardAPI", "", $class);

			return $class;
		}
	}

?>