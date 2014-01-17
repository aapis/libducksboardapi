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
		protected function _send(){
			try {
				$result = $this->_request();

				if(is_null($result)){
					throw new Exception("There was an error processing the request.");
				}

				$this->_out($result);
			}catch(Exception $e){
				echo $e->getMessage();
			}
		}

		/**
		 * Writes output to the screen/terminal
		 * @param  stdClass $result
		 * @return void
		 */
		protected function _out(stdClass $result){
			$output = "";

			if(PHP_SAPI == "cli"){
				$output .= sprintf("Request Status: %s\n", (property_exists($result, "success") && $result->success === true ? "Success" : "Error"));
				$output .= sprintf("Request Type: %s\n", $this->_getClassType());
				$output .= "Request Data: \n";
				var_dump($result->data);
			}else {
				$output .= "<ul>";
				$output .= sprintf("<li>Request Status: <strong>%s</strong></li>", (property_exists($result, "success") && $result->success === true ? "Success" : "Error"));
				$output .= sprintf("<li>Request Type: <strong>%s</strong></li>", $this->_getClassType());
				$output .= "<li>Request Data:";
					$output .= "<ul>";

					if(isset($result->raw)){
						$iterator = $result->raw;
					}else {
						$iterator = $result->data;
					}

					foreach($iterator as $key => $value){
						if(is_array($value)){
							for($i = 0; $i < sizeof($value); $i++){
								$output .= sprintf("<li>%s - %s</li>", $value[$i]->value->title, $value[$i]->value->content);
							}
						}else {
							$output .= sprintf("<li>%s - %s</li>", $key, $value);
						}
					}
					$output .= "</ul></li>";
				$output .= "</ul>";
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