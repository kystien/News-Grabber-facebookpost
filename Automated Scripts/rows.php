#!/usr/bin/php
<?php
	/* header('Content-Type: application/json'); */
	Require_Once 'src/config.php';
	$results = $dbq->prepare("SELECT item.id as id from item ORDER BY item.pubdate desc");
	$results->execute();
	
	
	$info[] = array();
	
	foreach($results as $row) {
		$id = $row['id'];
		$info[] = array(
		'id' => $id
		);
	}
	$results->closeCursor();
	$json = json_encode($info);
	$file = 'json/rows.json';
	file_put_contents($file, $json);
?>