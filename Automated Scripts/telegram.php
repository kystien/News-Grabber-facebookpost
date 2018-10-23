#!/usr/bin/php
<?php
	require_once('src/config.php');
	date_default_timezone_set('America/Edmonton');
	$prodinsert = $db2->prepare('insert ignore into telegram values(null, :channel, :text, :file, :pubdate, :unread, :msgid, now())');
	
	$telegramU = $teleurl . $telapi . $teleupdate;
	$telegramG = $teleurl . $telapi . $telefile;

	$update = json_decode(file_get_contents($telegramU), true);
	
	foreach($update['result'] as $key=>$row){ 
		$channel = $row['message']['forward_from_chat']['title'];
		$photoid = $row['message']['photo'][3]['file_id'];
		$videoid = $row['message']['video']['file_id'];
		$videothumb = $row['message']['video']['thumb']['file_id'];
		$caption = $row['message']['caption'];
		$teltext = $row['message']['text'];
		$document = $row['message']['document']['file_id'];
		$docname =  $row['message']['document']['file_name'];
		$docthumb = $row['message']['document']['file_id'];
		$timestamp = $row['message']['date'];
		$pubdate = date('Y-m-d H:i:s',$timestamp);
		$msgid = $row['message']['message_id'];
		$unread = '1';
			if(null !== $photoid){
				$fileid = $photoid;
				
					/* get data from image */
				$url = $telegramG . $fileid;
				$ch = curl_init();
				curl_setopt($ch,CURLOPT_URL,$url);
				curl_setopt($ch,CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.12) Gecko/20080201 Firefox/2.0.0.12');
				curl_setopt($ch,CURLOPT_HEADER,0);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch,CURLOPT_FOLLOWLOCATION,0);
				curl_setopt($ch,CURLOPT_TIMEOUT,120);
				$html = curl_exec($ch);
				curl_close($ch);
				$filepath = json_decode($html, true);
				$filexpath = $filepath['result']['file_path'];
					/* end get data from image */
			
				$file = $filexpath;
				$text = $caption;
				$url = $teleurlf . $telapi . '/' . $file;
				$save = 'downloads/' . $file;
				if (file_exists($save)) {
					echo "The file " . $save . " exists" . "\n";
					continue;
				} else {
					echo "The file " . $save . " does not exist!" . "\n";
					file_put_contents($save, $url);
					echo $pubdate . "\n";
					echo $caption . "\n";
					echo "file " . $file . " has been succesfully saved to: " . $save . "\n";
				}
			}
			if(null !== $videoid){
				$fileid = $videoid;
					/* get data from image */
				$url = $telegramG . $fileid;
				$ch = curl_init();
				curl_setopt($ch,CURLOPT_URL,$url);
				curl_setopt($ch,CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.12) Gecko/20080201 Firefox/2.0.0.12');
				curl_setopt($ch,CURLOPT_HEADER,0);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch,CURLOPT_FOLLOWLOCATION,0);
				curl_setopt($ch,CURLOPT_TIMEOUT,120);
				$html = curl_exec($ch);
				curl_close($ch);
				$filepath = json_decode($html, true);
				$filexpath = $filepath['result']['file_path'];
				$filexsize = $filepath['result']['file_size'];
				$filexthumb = $filepath['result']['thumb']['file_path'];
					/* end get data from image */
				$file = $filexpath;
				$text = $caption;
				$url = $teleurlf . $telapi . $file;
				$save = 'downloads/' . $file;
				if (file_exists($save)) {
					echo "The file " . $save . " exists \n";
					continue;
				} else {
					echo "The file " . $save . " does not exist!" . "\n";
					file_put_contents($save, $url);
					echo $pubdate . "\n";
					echo $caption . "\n";
					echo "file " . $file . " has been succesfully saved to: " . $save . "\n";
				}
				if($filexsize > 20000000){
					$file = $filexthumb;
					$url = $teleurlf . $telapi . '/' . $file;
					$save = 'downloads/' . $file;
					if (file_exists($save)) {
						echo "The file " . $save . " exists" . "\n";
						continue;
					} else {
						echo "The file " . $save . " does not exist!" . "\n";
						file_put_contents($save, $url);
						echo $pubdate . "\n";
						echo $caption . "\n";
						echo "file " . $file . " has been succesfully saved to: " . $save . " \n";
					}
				}
			}
			if(null !== $document){
				$fileid = $document;
					/* get data from image */
				$url = $telegramG . $fileid;
				$ch = curl_init();
				curl_setopt($ch,CURLOPT_URL,$url);
				curl_setopt($ch,CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.12) Gecko/20080201 Firefox/2.0.0.12');
				curl_setopt($ch,CURLOPT_HEADER,0);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch,CURLOPT_FOLLOWLOCATION,0);
				curl_setopt($ch,CURLOPT_TIMEOUT,120);
				$html = curl_exec($ch);
				curl_close($ch);
				$filepath = json_decode($html, true);
				$filexpath = $filepath['result']['file_path'];
				$filexsize = $filepath['result']['file_size'];
				$filexthumb = $filepath['result']['thumb']['file_path'];
					/* end get data from image */
				$filez = $filexpath;
				$text = $caption;
				$url = $teleurlf . $telapi . '/' . $filez;
				$save = 'downloads/documents/' . $docname;
				$file = $docname;
				if (file_exists($save)) {
					echo "The file " . $save . " exists" . "\n";
					continue;
				} else {
					echo "The file " . $save . " does not exist!" . "\n";
					file_put_contents($save, $url);
					echo $pubdate . "\n";
					echo $caption . "\n";
					echo "file " . $filez . " has been succesfully saved to: " . $save . "\n";
				}
				if($filexsize > 20000000){
					$file = $filexthumb;
					$url = $teleurlf . $telapi . '/' . $file;
					$save = 'downloads/documents/' . $file;
					if (file_exists($save)) {
						echo "The file " . $save . " exists" . "\n";
						continue;
					} else {
						echo "The file " . $save . " does not exist!" . "\n";
						file_put_contents($save, $url);
						echo $pubdate . "\n";
						echo $caption . "\n";
						echo "file " . $file . " has been succesfully saved to: " . $save . " \n";
					}
				}
			}
			if(null === $document && null === $videoid && null === $photoid){
				$text = $teltext;
				$file = null;
			}
		$prodinsert->bindParam(':channel', $channel);
		$prodinsert->bindParam(':text', $text);
		$prodinsert->bindParam(':file', $file);
		$prodinsert->bindValue(':pubdate', $pubdate);
		$prodinsert->bindValue(':unread', $unread);
		$prodinsert->bindValue(':msgid', $msgid);
		$prodinsert->execute();
		$prodinsert->closeCursor();
	}
	