<?php
	
	$feed = $page['feed'];

	$folders = $db->query('SELECT * from folder order by position');
?>
<div class="entry">
	<h3 class="entrytitle"><?=$page['title']?></h3>
	<div class="entrybody">

	<form method="post" action="<?=$site['url']?>/savefeed" id="edit" >
		<label>ID: <input type="text" name="id" value="<?=$feed['id']?>" readonly="readonly"/></label>
		<label>Title: <input type="text" name="title" value="<?=$feed['title']?>" /></label>
		<label>Feed URL: <input type="text" name="feedurl" value="<?=$feed['feedurl']?>" /></label>
		<label>Site URL: <input type="text" name="siteurl" value="<?=$feed['siteurl']?>" /></label>
		<label>Icon URL: <input type="text" name="iconurl" value="<?=$feed['iconurl']?>" /></label>
		<label>Description: <input type="text" name="description" value="<?=$feed['description']?>" /></label>
		<label>Position: <input type="text" name="position" value="<?=$feed['position']?>" /></label>
		<label>Private: <input type="checkbox" name="private" <?=$feed['private']?'checked="checked"':'';?> /></label>
		<label>Active: <input type="checkbox" name="active" <?=$feed['active']?'checked="checked"':'';?> /></label>
		<label>Folder:  
			<select name="folderid">
<?	foreach($folders as $folder){ ?>
			<option value="<?=$folder['id']?>" <?=$folder['id'] == $feed['folderid']? 'selected="selected"' : '';?>><?=$folder['name']?></option>
<?	} ?>
			</select>
		</label>
		<label>Created: <input type="text" name="created" value="<?=$feed['created']?>" readonly="readonly"/></label>
		<label>Feed Updated: <input type="text" name="lastupdate" value="<?=$feed['lastupdate']?>" readonly="readonly"/></label>
		<input type="submit" value="Save" />
	</form>
		
	<div class="command">
	<?if($feed['id'] != 'new'){ ?>
		<a href="<?=$site['url']?>/deletefeed?id=<?=$feed['id']?>" onclick="return confirm('Do you want to delete this feed?');">Delete Feed</a>
	<? } else {?>
		<a href="javascript:navigator.registerContentHandler('application/vnd.mozilla.maybe.feed','<?=$site['url']?>/addfeed?url=%s','My Feeds');">Add To Firefox Reader List</a>
	<? } ?>
	</div>
	
	</div>
</div>

