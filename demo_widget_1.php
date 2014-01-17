<?php
	
	include("ducksboard.php");
	include("ducksboard.push.php");
	
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
	$data2->title = "test";
	$data2->content = "content";

	$data3 = new stdClass();
	$data3->delta = 7.25;

	$ducksboard = new DucksboardAPIPush($data2, $API->slot, $API->key);
	$result = $ducksboard->send();

	echo $result;

?>