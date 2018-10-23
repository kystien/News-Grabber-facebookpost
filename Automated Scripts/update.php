#!/usr/bin/php
<?php
	
	// require_once('src/config.php');
	
	$getitem = $db->prepare('select id, guid, pubdate, hash from item where feedid = :feedid and guid = :guid');	
	$insert = $db->prepare('insert ignore into item values(null, :feedid, :hash, :guid, :linkurl, :enclosureurl, :title, :content, :unread, :author, now(), :pubdate)');
	$update = $db->prepare('update item set guid=:guid, hash=:hash, linkurl=:linkurl, enclosureurl=:enclosureurl, title=:title, content=:content, author=:author, pubdate=:pubdate, unread=:unread where id=:id');
	$updatefeed = $db->prepare('update feed set lastupdate = now() where id = :id');
	$deactivate = $db->prepare('update feed set active = 0 where id = :id');

	// ---------------------------

	$dbfeedset = $db->query('SELECT id, feedurl from feed where active = 1 order by position');

	$dbfeeds = $dbfeedset->fetchAll();
	$dbfeedset->closeCursor();

	foreach($dbfeeds as $dbfeed){
	
		echo '<br> <p> Checking: ' . $dbfeed['id'] . ' - ' . $dbfeed['feedurl']  . "\n <br>";
    
   		$feed = new SimplePie();
		$feed->set_feed_url($dbfeed['feedurl']);
		$feed->enable_cache(false);
		$feed->init();
		
		if ($feed->error()){
			$errormsg =  $feed->error();
			echo "	Error: " . $errormsg . "\n";
			if(strpos($errormsg, 'could not be found') !== false){
				$deactivate->bindValue(':id', $dbfeed['id']);
				$deactivate->execute();
				$deactivate->closeCursor();
			}
			continue;
		}
	
		
		$items = $feed->get_items();
		
		foreach($items as $item){
			
			$guid = $item->get_id();
			
			$getitem->bindParam(':feedid', $dbfeed['id']);
			$getitem->bindParam(':guid', $guid);
			$getitem->execute();
			
			$dbitem = $getitem->fetch();
			
			if($dbitem){
				
				$pubdate = $item->get_date('Y-m-d H:i:s');
				$hash = sha1($item->get_content());
				
				if(($pubdate !== $dbitem['pubdate'] || $hash !== $dbitem['hash']) && $site['updates']){

					echo '<br>	Updating item: ' . $itemids[$p] . ' - ' . $item->get_id() . "\n <br>";

					echo 'f<br>eed date = '. $pubdate . " \t | \t " .  'db date = '. $dbitem['pubdate'] . "\n <br>";
					echo '<br>feed hash = '. $hash . " \t | \t " .  'db hash = '. $dbitem['hash'] . "\n <br>";

					if ($author = $item->get_author()){
						$authorname = $author->get_name();
					} else {
						$authorname = null;
					}

					if ($enclosure = $item->get_enclosure()){
						$enclosureUrl = $enclosure->get_link();
					} else {
						$enclosureUrl = null;
					}
					
					$title = mb_convert_encoding($item->get_title(), 'HTML-ENTITIES', 'UTF-8');
					$content = mb_convert_encoding($item->get_content(), 'HTML-ENTITIES', 'UTF-8');
					
					$update->bindParam(':guid', $item->get_id());
					$update->bindParam(':hash', $item->get_id(true));
					$update->bindParam(':linkurl', $item->get_permalink());
					$update->bindParam(':enclosureurl', $enclosureUrl);
					$update->bindParam(':title', $title);
					$update->bindParam(':content', $content);
					$update->bindParam(':author', $authorname);
					$update->bindParam(':pubdate', $item->get_date('Y-m-d H:i:s'));
					$update->bindParam(':id', $dbitem['id']);
					$update->bindValue(':unread', 1);
					
					$update->execute();
					$update->closeCursor();
					
					$updatefeed->bindParam(':id', $dbfeed['id']);
					$updatefeed->execute();
					$updatefeed->closeCursor();
					
				}	
				
			} else {
				echo '<br>	New Item found: ' .$item->get_id()  . "\n <br>";

				if ($author = $item->get_author()){
					$authorname = $author->get_name();
				} else {
					$authorname = null;
				}

				if ($enclosure = $item->get_enclosure()){
					$enclosureUrl = $enclosure->get_link();
				} else {
					$enclosureUrl = null;
				}

				$title = mb_convert_encoding($item->get_title(), 'HTML-ENTITIES', 'UTF-8');
				$prevtitle = '';
				if ($title == $prevtitle) {
				continue;
				}
				$prevtitle = $title;
				$content = mb_convert_encoding($item->get_content(), 'HTML-ENTITIES', 'UTF-8');

				$insert->bindParam(':feedid',  $dbfeed['id']);
				$insert->bindParam(':hash', sha1($item->get_content()));
				$insert->bindParam(':guid', $item->get_id());
				$insert->bindParam(':linkurl', $item->get_permalink());
				$insert->bindParam(':enclosureurl', $enclosureUrl);
				$insert->bindParam(':title', $title);
				$insert->bindParam(':content', $content);
				$insert->bindValue(':unread', 1);
				$insert->bindParam(':author', $authorname);
				$insert->bindParam(':pubdate', $item->get_date('Y-m-d H:i:s'));
				
				$insert->execute();
				$insert->closeCursor();
				
				$updatefeed->bindParam(':id', $dbfeed['id']);
				$updatefeed->execute();
				$updatefeed->closeCursor();
				
			}
			$getitem->closeCursor();
			
		}
		$feed->__destruct();
	}	