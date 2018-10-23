<?php
	
	$folder = $page['folder'];

?>
<div class="entry">
	<h3 class="entrytitle"><?=$page['title']?></h3>
	<div class="entrybody">

	<form method="post" action="<?=$site['url']?>/savefolder" id="edit" >
		<label>ID: <input type="text" name="id" value="<?=$folder['id']?>" readonly="readonly"/></label>
		<label>Name: <input type="text" name="name" value="<?=$folder['name']?>" /></label>
		<label>Position: <input type="text" name="position" value="<?=$folder['position']?>" /></label>
		<input type="submit" value="Save" />
	</form>	

	<?if($folder['id'] != 'new'){ ?>
	<div class="command">
		<a href="<?=$site['url']?>/deletefolder?id=<?=$folder['id']?>" onclick="return confirm('Do you want to delete this folder?');">Delete Folder</a>
	</div>
	<? } ?>

	</div>
</div>
