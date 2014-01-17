<?php
	
	include("ducksboard.php");
	
	$API = new stdClass();
	$API->push_url = "https://push.ducksboard.com/v/308066";
	$API->key = "nu0WijZcIQdWE7ataiyV0lQ9MtoAQyEP2VCts5AJ9aM1Bu8pHK:ignored";


	$data = new stdClass();
	$data->value = new stdClass();
	$data->value->title = "nth-demo item";
	$data->value->content = "A successful push";
	$data->value->link = "http://wearefree.ca";

	$data2 = new stdClass();
	$data2->title = "test";
	$data2->content = "content";

	$ducksboard = new DucksboardAPI($data2, 308066, "nu0WijZcIQdWE7ataiyV0lQ9MtoAQyEP2VCts5AJ9aM1Bu8pHK");
	$result = $ducksboard->send();

	echo $result;
	/*$payload = json_encode($data);

	$handler = curl_init();
	curl_setopt_array($handler, array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => 1,
		CURLOPT_POSTFIELDS => $payload,
		CURLOPT_URL => $API->push_url,
		CURLOPT_USERAGENT => "Free Request",
		CURLOPT_USERPWD => $API->key,
		));

	$resp = curl_exec($handler);
	$decoded = json_decode($resp);

	if(isset($argv)){
		echo sprintf("Result: %s\n", $decoded->response);
	}else {
		echo "<pre>";
			echo sprintf("Result: <strong>%s</strong>", $decoded->response);
		echo "</pre>";
	}*/


?>