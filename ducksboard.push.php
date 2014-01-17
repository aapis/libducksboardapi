<?php

	class DucksboardAPIPush extends DucksboardAPI {
		public function __construct(stdClass $data = null, $destination = null, $skeleton = null){
			try {
				if(is_null($skeleton)){
					throw new Exception("API key is required to make the request");
				}

				if(is_null($destination) || false === is_numeric($destination)){
					throw new Exception("A slot is required to make the request");
				}

				$this->_key = sprintf("%s:ignored", $skeleton);
				$this->_url = sprintf("https://push.ducksboard.com/v/%d", $destination);

				if(is_null($data)){
					$this->_data = new stdClass();
				}else {
					//ducksboard requires either a "delta" or "value" key, so if 
					//the data object doesn't have one we need to add it to the 
					//object
					if(false === property_exists($data, "value") || false === property_exists($data, "delta")){
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
	}

?>