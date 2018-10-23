<?

function deleteitemsAction(){

	global $db, $site;
	if(isset($_POST['submit'])){
	foreach($_POST['option'] as $item){
  	$delete = $db->prepare('DELETE FROM item WHERE id = (' . $item . ')');
	$delete->execute();
	}
}	
	/* header('Location: ' . $site['url']); */
	exit();
}

function deleteitemAction(){

	global $db, $site;
	
	$nlink = $_POST['ndata'];
	
	$delete = $db->prepare('DELETE FROM twitterlinks WHERE id = (' . $nlink . ')');
	
	$delete->execute();
	
	header('Location: ' . $site['url']);
	/* echo '<script type="text/javascript">alert("Posted to facebook pages & group"); </script>'; */
	exit();
}

/* New post to facebook group function */

function fbookpostAction(){

	global $fb, $pageGlobalWarTTCAccessToken, $pageWW3AccessToken, $site, $c;
	
	$nlink = $_POST['ndata'];
	
			if ($_POST['ContWarn'] == 'yes'){
				$linkData = [
				'link' => $nlink,
				'message' => 'We caution readers that the following link is questionable and may contain false information for propaganda purposes. ',
			];
			} else {
				$linkData = [
				'link' => $nlink,
				'message' => ' Posted from the Global War Admin WebApp ',
				];
			}
	try {
		// Returns a `Facebook\FacebookResponse` object
		$response = $fb->post('/1844467015803631/feed', $linkData, $pageGlobalWarTTCAccessToken);

	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
	$graphNode = $response->getGraphNode(); 
 
	try {
		// Returns a `Facebook\FacebookResponse` object
		$response = $fb->post('/1616018355318074/feed', $linkData, $pageWW3AccessToken);
		
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}

	$graphNode = $response->getGraphNode(); 
	header("Location: {$_SERVER['HTTP_REFERER']}");
	exit();
}


// ------------------------------------------------------
// items


function markreadAction(){

	global $db, $site;

	$items = $_POST['items'];
	
	$update = $db->prepare('update item set unread = 0 where id in (' . $items . ')');
	
	$update->execute();
	
	header('Location: ' . $site['url']);
	exit();
	

}

// ------------------------------------------------------
// feeds

function editfeedAction(){
	
	global $db, $site, $page;	
	
	$id = $_GET['id'];
	
	$results = $db->prepare("select * from feed where id = :id");
	$results->bindParam(':id', $id);
	$results->execute();

	$page['feed'] = $results->fetch();
	$page['title'] = 'Edit Feed';

	$page['name']= 'feedform';

}

function addfeedAction(){
	
	global $site, $page;	
	
	$newfeed = array();
	$newfeed['id'] = 'new';
	
	$feedurl = $_GET['url'];
	
	if($feedurl){
		
		$feed = new SimplePie();
		$feed->set_feed_url($feedurl);
		$feed->enable_cache(false);
		$feed->init();
		
		$newfeed['title'] = $feed->get_title();
		$newfeed['description'] = $feed->get_description();
		$newfeed['iconurl'] = $feed->get_favicon();
		$newfeed['siteurl'] = $feed->get_permalink();
		$newfeed['feedurl'] = $feedurl;
		
	}
	
	$page['feed'] = $newfeed;
	$page['title'] = 'Add Feed';

	$page['name']= 'feedform';
	
	
}

function deletefeedAction(){
	
	global $db, $site;	
	
	//need to confirm here then delete
	
	$id = $_GET['id'];
	
	$delete = $db->prepare('delete from feed where id = :id');
	$delete->bindValue(':id',$id);
	$delete->execute();
	
	$delete = $db->prepare('delete from item where feedid = :id');
	$delete->bindValue(':id',$id);
	$delete->execute();
	
	header('Location: ' . $site['url'] . '/feeds');
	exit();
	
	
}

function savefeedAction(){
	
	global $db, $site, $page;	
	
	$id = $_POST['id'];
	$title = $_POST['title'];
	$feedurl = $_POST['feedurl'];
	$siteurl = $_POST['siteurl'];
	$iconurl = $_POST['iconurl'];
	$description = $_POST['description'];
	$position = $_POST['position'];
	$private = isset($_POST['private']);
	$active = isset($_POST['active']);
	$folderid = $_POST['folderid'];
	$created = $_POST['created'];
	$lastupdate = $_POST['lastupdate'];
	
	// validation would probably be good here
	
	if($id == 'new'){
	
		$results = $db->prepare("insert into feed values(null, :title, :feedurl, :siteurl, :iconurl, :description,  now(), null, :position, :private, :active, :folderid)");
		$results->bindValue(':title', $title);
		$results->bindValue(':feedurl', $feedurl);
		$results->bindValue(':siteurl', $siteurl);
		$results->bindValue(':iconurl', $iconurl);
		$results->bindValue(':description', $description);
		$results->bindValue(':position', $position);
		$results->bindValue(':private', $private);
		$results->bindValue(':active', $active);
		$results->bindValue(':folderid', $folderid);	
		$results->execute();
	
		header('Location: ' . $site['url'] . '/feeds');
		exit();		
	
	
	} else {
	
		$results = $db->prepare("update feed set title=:title, feedurl=:feedurl, siteurl=:siteurl, iconurl=:iconurl, description=:description, position=:position, private=:private, active=:active, folderid=:folderid where id=:id");
		$results->bindValue(':title', $title);
		$results->bindValue(':feedurl', $feedurl);
		$results->bindValue(':siteurl', $siteurl);
		$results->bindValue(':iconurl', $iconurl);
		$results->bindValue(':description', $description);
		$results->bindValue(':position', $position);
		$results->bindValue(':private', $private);
		$results->bindValue(':active', $active);
		$results->bindValue(':folderid', $folderid);
		$results->bindValue(':id', $id);
		$results->execute();
		
		header('Location: ' . $site['url'] . '/feeds');
		exit();		
	
	}
	
}

// ------------------------------------------------------
// folders

function editfolderAction(){
	
	global $db, $site, $page;	
	
	$id = $_GET['id'];
	
	$results = $db->prepare("select * from folder where id = :id");
	$results->bindParam(':id', $id);
	$results->execute();

	$page['folder'] = $results->fetch();
	$page['title'] = 'Edit Folder';

	$page['name']= 'folderform';

}

function addfolderAction(){
	
	global $site, $page;	
	
	$newfolder = array();
	$newfolder['id'] = 'new';
	
	$page['folder'] = $newfolder;
	$page['title'] = 'Add Folder';

	$page['name']= 'folderform';
	
	
}

function deletefolderAction(){
	
	global $db, $site;	
	
	//need to confirm here then delete
	
	$id = $_GET['id'];
	
	$delete = $db->prepare('delete from folder where id = :id');
	$delete->bindValue(':id',$id);
	$delete->execute();
	
	header('Location: ' . $site['url'] . '/folders');
	exit();
	
	
}

function savefolderAction(){
	
	global $db, $site, $page;	
	
	$id = $_POST['id'];
	$name = $_POST['name'];
	$position = $_POST['position'];
	
	if($id == 'new'){
	
		$results = $db->prepare("insert into folder values(null, :name, :position)");
		$results->bindValue(':name', $name);
		$results->bindValue(':position', $position);
		$results->execute();
	
		header('Location: ' . $site['url'] . '/folders');
		exit();		
	
	
	} else {
	
		$results = $db->prepare("update folder set name=:name, position=:position where id=:id");
		$results->bindValue(':name', $name);
		$results->bindValue(':position', $position);
		$results->bindValue(':id', $id);
		$results->execute();
		
		header('Location: ' . $site['url'] . '/folders');
		exit();		
	
	}
	
}

function manualaddAction(){

global $fb, $pageGlobalWarTTCAccessToken, $pageWW3AccessToken, $site, $c, $db, $page;
	$update = $db->prepare('update item set guid=:guid, hash=:hash, feedid=:feedid, linkurl=:linkurl, enclosureurl=:enclosureurl, title=:title, content=:content, author=:author, pubdate=:pubdate,unread=:unread where id=:id');
	
	
	$dbfeed = "24";
	
		$nlink = $_POST['ndata2'];

		$hash = sha1($nlink);
		
		$graph = OpenGraph::fetch($nlink);
		$authorname = $graph->site_name;
		$content = $graph->description;
		$title = $graph->title;
		$pubdate = $graph->published_time;
		
		
					$update->bindParam(':guid', $guid);
					$update->bindParam(':hash', $hash);
					$update->bindParam(':feedid', $dbfeed);
					$update->bindParam(':linkurl', $nlink);
					$update->bindParam(':enclosureurl', $enclosureUrl);
					$update->bindParam(':title', $title);
					$update->bindParam(':content', $content);
					$update->bindParam(':author', $authorname);
					$update->bindParam(':pubdate', $pubdate);
					$update->bindParam(':id', $dbitem['id']);
					$update->bindValue(':unread', 1);
					
					$update->execute();
					$update->closeCursor();		
		
		
			if ($_POST['ContWarn'] == 'yes'){
				$linkData = [
				'link' => $nlink,
				'message' => 'We caution readers that the following link is questionable and may contain false information for propaganda purposes. ',
			];
			} else {
				$linkData = [
				'link' => $nlink,
				'message' => ' Posted from the Global War Admin WebApp ',
				];
			}
	try {
		// Returns a `Facebook\FacebookResponse` object
		$response = $fb->post('/1844467015803631/feed', $linkData, $pageGlobalWarTTCAccessToken);
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
	$graphNode = $response->getGraphNode(); 
 
	try {
		// Returns a `Facebook\FacebookResponse` object
		$response = $fb->post('/1616018355318074/feed', $linkData, $pageWW3AccessToken);
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
	$graphNode = $response->getGraphNode(); 
	header("Location: {$_SERVER['HTTP_REFERER']}");
	exit();
}


function telegramaddAction(){
	
	/* Uploader Function */
	function uploaderi(){
			$target_dir = "UPLOADS/";
			$target_file = $target_dir . basename($_FILES["photo"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
				// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["photo"]["tmp_name"]);
				if($check !== false) {
					echo "File is an image - " . $check["mime"] . ".";
					$uploadOk = 1;
				} else {
					echo "File is not an image.";
					$uploadOk = 0;
				}
			}
				// Check if file already exists
			if (file_exists($target_file)) {
				echo "Sorry, file already exists.";
				$uploadOk = 0;
			}
				// Check file size
			if ($_FILES["photo"]["size"] > 500000) {
				echo "Sorry, your file is too large.";
				$uploadOk = 0;
			}
				// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk = 0;
			}
				// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo "Sorry, your file was not uploaded.";
				// if everything is ok, try to upload file 
			} else {
				if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
					echo "The file ". basename( $_FILES["photo"]["name"]). " has been uploaded.";
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}
		}
	/* End Uploader Function */
	
	if(isset($_FILES['video']) && count($_FILES['video']['error']) == 1 && $_FILES['video']['error'][0] > 0){
    //file not selected
	} elseif(isset($_FILES['video'])){
			/* Vid Function */
		function vid(){
			global $fb, $pageGlobalWarTTCAccessToken, $pageWW3AccessToken, $site, $c;
		
			$vid = $_FILES['video']['name'];
			$desc = $_POST['text'];
			$message1 = "Source: Directorate4 \n Medium: Telegram App \n \n Translated from Russian \n \n" . $desc . "\n";
			$message2 = "Source: SyriaToday \n Medium: Telegram App \n \n" . $desc . "\n";
			$d4contmsg1 = "Warning! \n \n The attached content may disturb viewers! \n \n Viewer discretion is advised! \n \n Source: Directorate4 \n Medium: Telegram App \n" . $desc . "\n";
			$stcontmsg2 = "Warning! \n \n The attached content may disturb viewers! \n \n Viewer discretion is advised! \n \n Source: SyriaToday \n Medium: Telegram App \n" . $desc . "\n";
			
			$checkv = filesize($_FILES['video']['name']);
			if($checkv !== false){
				if ($_POST['name'] == 'd4'){
					if ($_POST['ContWarn'] == 'yes'){
							$data = [
							'title' => $desc,
							'description' => $d4contmsg1,
							'source' => $vid,
							];
					} else{
						$data = [
						'title' => $desc,
						'description' => $message1,
						'source' => $vid,
						];
					}
				} elseif ($_POST['name'] == 'syriatoday'){
					if ($_POST['ContWarn'] == 'yes'){
							$data = [
							'title' => $desc,
							'description' => $d4contmsg2,
							'source' => $vid,
							];
					}else {
							$data = [
							'title' => $desc,
							'description' => $message2,
							'source' => $vid,
							];
					}
				}
			} else {
				echo "Warning! File contains no data!";
			}
		
			try {
				$response = $fb->post('/1844467015803631/feed', $data, $pageGlobalWarTTCAccessToken);
			// Returns a `Facebook\FacebookResponse` object	
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
				echo 'Graph returned an error: ' . $e->getMessage();
				exit;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
				echo 'Facebook SDK returned an error: ' . $e->getMessage();
				exit;
			}
			$graphNode = $response->getGraphNode(); 
		
			try {
				$response = $fb->post('/1616018355318074/feed', $data, $pageWW3AccessToken);
			// Returns a `Facebook\FacebookResponse` object
		
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
				echo 'Graph returned an error: ' . $e->getMessage();
				exit;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
				echo 'Facebook SDK returned an error: ' . $e->getMessage();
				exit;
			}
			$graphNode = $response->getGraphNode(); 
			header("Location: {$_SERVER['HTTP_REFERER']}");
			exit();
		}
		/* End Vid Function */
	}
	if(isset($_FILES['photo']) && count($_FILES['photo']['error']) == 1 && $_FILES['photo']['error'][0] > 0){
    //file not selected
	} elseif(isset($_FILES['photo'])){
			/* Img Function */
		function img(){
			global $fb, $pageGlobalWarTTCAccessToken, $pageWW3AccessToken, $site, $c;
		
			$image = $_FILES["photo"]["name"];
			$desc = $_POST["text"];
			$message1 = "Source: Directorate4 \n Medium: Telegram App \n \n Translated from Russian \n \n" . $desc . "\n";
			$message2 = "Source: SyriaToday \n Medium: Telegram App \n \n" . $desc . "\n";
			$d4contmsg1 = "Warning! \n \n The attached content may disturb viewers! \n \n Viewer discretion is advised! \n \n Source: Directorate4 \n Medium: Telegram App \n" . $desc . "\n";
			$stcontmsg2 = "Warning! \n \n The attached content may disturb viewers! \n \n Viewer discretion is advised! \n \n Source: SyriaToday \n Medium: Telegram App \n" . $desc . "\n";
		
			$checkp = getimagesize($_FILES["photo"]["name"]);
			if ($checkp !== false){
					/* Uploader Function */
				function uploaderi(){
					$target_dir = "UPLOADS/";
					$target_file = $target_dir . basename($_FILES["photo"]["name"]);
					$uploadOk = 1;
					$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
					// Check if image file is a actual image or fake image
					if(isset($_POST["submit"])) {
						$check = getimagesize($_FILES["photo"]["tmp_name"]);
							if($check !== false) {
								echo "File is an image - " . $check["mime"] . ".";
								$uploadOk = 1;
							} else {
								echo "File is not an image.";
								$uploadOk = 0;
							}
					}
						// Check if file already exists
					if (file_exists($target_file)) {
						echo "Sorry, file already exists.";
						$uploadOk = 0;
					}
						// Check file size
					if ($_FILES["photo"]["size"] > 500000) {
						echo "Sorry, your file is too large.";
						$uploadOk = 0;
					}
						// Allow certain file formats
					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
						echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
						$uploadOk = 0;
					}
						// Check if $uploadOk is set to 0 by an error
					if ($uploadOk == 0) {
						echo "Sorry, your file was not uploaded.";
						// if everything is ok, try to upload file 
					} else {
						if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
						echo "The file ". basename( $_FILES["photo"]["name"]). " has been uploaded.";
						} else {
							echo "Sorry, there was an error uploading your file.";
						}
					}
				}
					/* End Uploader Function */
				if ($_POST['name'] == 'd4'){
					if ($_POST['ContWarn'] == 'yes'){
						$data = [
						'message' => $d4contmsg1,
						'source' => $fb->fileToUpload(uploaderi($target_file)),
						];
					}else{
						$data = [
						'message' => $message1,
						'source' => $fb->fileToUpload(uploaderi($target_file)),
						];
					}
				} elseif ($_POST['name'] == 'syriatoday'){
					if ($_POST['ContWarn'] == 'yes'){
						$data = [
						'message' => $stcontmsg2,
						'source' => $fb->fileToUpload(uploaderi($target_file)),
					];
					} else{
						$data = [
						'message' => $message2,
						'source' => $fb->fileToUpload(uploaderi($target_file)),
						];
					}
				}
			} else {
				echo "Warning! File contains no data!";
			}
		
			try {
				$response = $fb->post('/1844467015803631/feed', $data, $pageGlobalWarTTCAccessToken);
			// Returns a `Facebook\FacebookResponse` object	
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
				echo 'Graph returned an error: ' . $e->getMessage();
				exit;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
				echo 'Facebook SDK returned an error: ' . $e->getMessage();
				exit;
			}
			$graphNode = $response->getGraphNode(); 
		
			try {
				$response = $fb->post('/1616018355318074/feed', $data, $pageWW3AccessToken);
			// Returns a `Facebook\FacebookResponse` object
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
				echo 'Graph returned an error: ' . $e->getMessage();
				exit;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
				echo 'Facebook SDK returned an error: ' . $e->getMessage();
				exit;
			}
			$graphNode = $response->getGraphNode(); 
			header("Location: {$_SERVER['HTTP_REFERER']}");
			exit();
		}
			/* End Img Function */
		img();
	}
	
}

?>
