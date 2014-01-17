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

				if(is_null($result)){
					throw new Exception("There was an error processing the request.");
				}

				$this->_out($result);
			}catch(Exception $e){
				echo $e->getMessage();
			}
		}

		protected function _out($result){
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
							//foreach($value as $k => $v){
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


		protected function _getClassType(){
			$class = get_class($this);
			$class = str_replace("DucksboardAPI", "", $class);

			return $class;
		}
	}

?>