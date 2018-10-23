#!/usr/bin/php
<?php
	/* header('Content-Type: application/json'); */
	Require_Once 'src/config.php';
	
	$json = file_get_contents("json/tquery.json");
	$jsonq = file_get_contents("json/query.json");
	$json1 = json_decode($jsonq, true);
	$json2 = json_decode($json, true);
	
	$info = array();
	function cmp($a, $b){
	$ad = strtotime($a['pubdate']);
	$bd = strtotime($b['pubdate']);
	return ($bd-$ad);
	}
	/* item query refs */
	foreach($json2['query'] as $key=>$irow) {
		foreach($json1['query'] as $key=>$irow2) {
			$info[] = array_merge($irow, $irow2);
		}
	}
	/* Build json file */

	usort($info, "cmp");
	$json = json_encode(array('query' => $info));
	$file = 'json/tlxquery.json';
	file_put_contents($file, $json);
?>