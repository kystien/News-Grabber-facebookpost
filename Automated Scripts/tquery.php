#!/usr/bin/php
<?php
	/* header('Content-Type: application/json'); */
		Require_Once 'src/config.php';
	
	$twitterpull = $dbq2->prepare("SELECT twitterlinks.link as link, twitterlinks.title as title, twitterlinks.pubdate as pubdate FROM twitterlinks ORDER BY twitterlinks.pubdate DESC limit 10");
	$twitterpull->execute();
		
			function get_twitter_id_from_url($url){
				if (preg_match("/^https?:\/\/(www\.)?twitter\.com\/(#!\/)?(?<name>[^\/]+)(\/\w+)*$/", $url, $regs)) {
					return $regs['name'];
				}
			}
	
	function linkExtractor2($html)
	{
	$linkArray = [];

	if(preg_match_all('/<img\s+.*?data-aria-label-part=""\s+.*?src=[\"\']?([^\"\' >]*)[\"\']?[^>]*>(.*?)<alt=""\s+.*?style="width:\s+.*?100%;\s+.*?top:\s+.*?-0px;">/i', $html, $matches, PREG_SET_ORDER)){
		foreach ($matches as $match) {
		$linkArray[]= $match[1];
			}
		}
	return $linkArray;
	}
	$info[] = array();
	
	/* item query refs */
	foreach($twitterpull as $irow) {
		
		$ilink = $irow['link'];
		$ititle = $irow['title'];
		$ipubd = $irow['pubdate'];
		$url = $irow['link'];
		$html = $irow['link'];
		$authors = get_twitter_id_from_url($url);
		$prevvalue ='';
		if ($ilink == $prevvalue) {
			continue;
		}
	$prevvalue = $ilink;
	/* Go into atom feed and pull links */
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.12) Gecko/20080201 Firefox/2.0.0.12');
	curl_setopt($ch,CURLOPT_HEADER,0);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_FOLLOWLOCATION,0);
	curl_setopt($ch,CURLOPT_TIMEOUT,120);
	$html = curl_exec($ch);
	curl_close($ch);

	$images=linkExtractor2($html)[0];
		
		
	/* twitter query refs */
		$link = $ilink;
		$title = $ititle;
		$pubdate = $ipubd;
		$image = $images;
		$author = $authors;
		$content = $ititle;
		
		

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
	$twitterpull->closeCursor();
	$json = json_encode(array('query' => $info));
	$file = 'json/tquery.json';
	file_put_contents($file, $json);
?>