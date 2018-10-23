<?php 

	$page['title'] = 'Feeds';

?>

<div class="entry">
	<h3 class="entrytitle"> Feeds</h3>
	<div class="entrybody">
<?

    
    $results = $db->query('SELECT feed.id, name, title, siteurl, active FROM feed, folder where feed.folderid=folder.id order by folder.position, title');

	$oldname = '';

	foreach($results as $row){
		
		$name = $row['name'];
		
		if($name != $oldname){
			
			if($oldname){
				echo '</ul>' . "\n";
			}
			echo '<h3>' . $name . '</h3>' . "\n";
			echo '<ul>' . "\n";
			
			$oldname = $name;
			
		}
		
		if(!$row['active']){
			$itemclass='class="inactive"';
		} else {
			$itemclass = '';
		}
		
		echo '<li ' . $itemclass . '><a href="' . $site['url'] . '/editfeed?id=' . $row['id'] . '">' . $row['title'] . '</a></li>' . "\n";
	
	}
	
	echo '</ul>' . "\n";

?>
	<h3>OPML</h3>
	<ul>
	<li><a href="<?=$site['url']?>/opml">Public Only List</a></li>
	<li><a href="<?=$site['url']?>/opml?all=true">Public and Private List</a></li>
	</ul>
	</div>

</div>
