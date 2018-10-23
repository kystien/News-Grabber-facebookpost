#!/usr/bin/php
<?php
	/* header('Content-Type: application/json'); */
	Require_Once 'src/config.php';
	/* $twitterpull = $db3->query("SELECT twitterlinks.link as tlink, twitterlinks.pubdate FROM twitterlinks ORDER BY twitterlinks.pubdate DESC limit 500"); */
	$itempull = $dbq->prepare("SELECT item.linkurl as link, item.title as title, item.author as author, item.pubdate FROM item ORDER BY item.pubdate DESC limit 10");
	/* $sth1 = $twitterpull->fetch(PDO::FETCH_BOTH); */
	$itempull->execute();
	
	
	$info[] = array();
	
	/* item query refs */
	foreach($itempull as $irow) {
		if (strpos($irow['link'],'liveuamap') !== false) {
			continue;
		}
		$ilink = $irow['link'];
		$ititle = $irow['title'];
		$iauthor = $irow['author'];
		$ipubd = $irow['pubdate'];
		$graph = OpenGraph::fetch($ilink);
		$iimage = $graph->image;
		$iauthor = $graph->site_name;
		$icontent = $graph->description;
		$prevvalue ='';
		if ($irow['title'] == $prevvalue) {
			continue;
		}
	$prevvalue = $irow['title'];
	
	/* twitter query refs */
		$link = $ilink;
		$pubdate = $ipubd;
		$title = $ititle;
		$content = $icontent;
		$image = $iimage;
		$author = $iauthor;

	/* Build json file */
	$info[] = array(
		'link' => $link,
		'pubdate' => $pubdate,
		'title' => $title,
		'content' => $content,
		'author' => $author,
		'image' => $image
	);
	}
	$itempull->closeCursor();
	$json = json_encode(array('query' => $info));
	$file = 'json/query.json';
	file_put_contents($file, $json);
?>