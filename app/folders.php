<?php 

	$page['title'] = 'Folders';

?>

<div class="entry">
	<h3 class="entrytitle"> Folders</h3>
	<div class="entrybody">
	<ul>
<?

    
    $results = $db->query('SELECT * from folder order by position');

	foreach($results as $row){
		
		echo '<li><a href="' . $site['url'] . '/editfolder?id=' . $row['id'] . '">' . $row['name'] . '</a></li>' . "\n";
	
	}
	
	echo '</ul>' . "\n";

?>
	<div class="command">
		<a href="<?=$site['url']?>/addfolder">Add New Folder</a>
	</div>

	</div>

</div>
