#!/usr/bin/php
<?php
	// require_once('src/config.php');
	
	$results = $dbq->prepare("SELECT item.id, item.title as itemtitle, item.feedid as feedid, linkurl, item.author, item.pubdate as pubdate, item.content, item.enclosureurl from item where item.unread = 1 ORDER BY item.pubdate ASC");
	$results->execute();
		
		/* pull twitter link */
	function linkExtractor($html){
		$linkArray = [];

		if(preg_match_all('/<a\s+.*?class=\"source-link\"\s+.*?href=[\"\']?([^\"\' >]*)[\"\']?[^>]*>/i', $html, $matches, PREG_SET_ORDER)){
			foreach ($matches as $match) {
				$linkArray[]= $match[1];
			}
		}
		return $linkArray;
	}

		/* go into DB and pull liveualinks */
	foreach($results as $row){
		if (strpos($row['linkurl'],'liveuamap') !== false) {

		$url = $row['linkurl'];

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

		$newlink=linkExtractor($html)[0];

		/* insert twitter links to database */

		echo '<pre>' . $newlink . '<pre>';
			if (empty($newlink)){
				$items = $row['id'];
				$sql="UPDATE item SET unread='0' where id=$items";
				$stmt=$db->prepare($sql);
				$stmt->execute();
				continue;
			}
		$prevtitle ='';
		$prevlink ='';
			if ($row['itemtitle'] == $prevtitle && $newlink == $prevlink) {
				$items = $row['id'];
				$sql="UPDATE item SET unread='0' where id=$items";
				$stmt=$db->prepare($sql);
				$stmt->execute();
				continue;
			}
		$prevtitle = $row['itemtitle'];
		$prevlink = $newlink;

            /* Select DB data, Update DB data, Insert DB data	*/
		$produpdate = $db2->prepare('update twitterlinks set link=:link, title=:title, country=:country, feedid=:feedid, pubdate=:pubdate, read=:read where id=:id');
		$prodinsert = $db2->prepare('insert ignore into twitterlinks values(null, :link, :title, :country, :feedid, :pubdate, :read, now())');
			
		/* Name devdbitem & fetch items form db  */

		/* adding if statements to prevent repeated data entries */
	
        /* bindParam data to be added to db.	*/
		$country='';
		$date=$row['pubdate'];
		$feedid= $row['feedid'];
		$read='1';
		$prodinsert->bindParam(':link', $newlink);
		$prodinsert->bindParam(':title', $row['itemtitle']);
		$prodinsert->bindParam(':country', $country);
		$prodinsert->bindValue(':feedid', $feedid);
		$prodinsert->bindParam(':pubdate', $date);
		$prodinsert->bindValue(':read', $read);
		$prodinsert->execute();
		$prodinsert->closeCursor();
			
		echo $newlink . ' Added to Twitter Database <br> ';
		echo ' <br> ';
		$items = $row['id'];
  		$sql="UPDATE item SET unread='0' where id=$items";
 		$stmt=$db->prepare($sql);
		$stmt->execute();
		$stmt->closeCursor();

		$int = intval(preg_replace('/[^0-9]+/', '', $newlink), 10);

		} else {
			$items = $row['id'];
  			$sql="UPDATE item SET unread='0' where id=$items";
 			$stmt=$db->prepare($sql);
			$stmt->execute();
			$stmt->closeCursor();
		}
		/* end of foreach */
	}
	$results->closeCursor();
?>