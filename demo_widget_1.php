<?php
	
	include("ducksboard.php");
	include("ducksboard.push.php");
	include("ducksboard.pull.php");
	
	/*
	 * API data object
	 */
	$API = new stdClass();
	$API->slot = 308066;
	$API->key = "nu0WijZcIQdWE7ataiyV0lQ9MtoAQyEP2VCts5AJ9aM1Bu8pHK:ignored";

	/*
	 * Sample data sets
	 */
	$data = new stdClass();
	$data->value = new stdClass();
	$data->value->title = "nth-demo item";
	$data->value->content = "A successful push";
	$data->value->link = "http://wearefree.ca";

	$data2 = new stdClass();
	$data2->title = "test something ". rand(0,30);
	$data2->content = "Lorem ipsum dolor set.";

	$data3 = new stdClass();
	$data3->delta = 7.25;

	if($_GET["type"] == "push"){
		$ducksboard = new DucksboardAPIPush($data2, $API->slot, $API->key);
		$result = $ducksboard->push();
	}

	if($_GET["type"] == "pull"){
		$endpoint = "/last?count=5";

		$ducksboard = new DucksboardAPIPull($endpoint, $API->slot, $API->key);
		$result = $ducksboard->pull();
	}

	echo $result;

?>