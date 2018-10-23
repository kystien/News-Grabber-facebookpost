<?php
	Require_Once 'src/config.php';

?>

<html>
<center>
<form action="<?=$site['url']?>/telegramadd" method="post">
Enter text from Telegram
<br>
<textarea name="text" id="text" cols="30" rows="5"></textarea>
<br>
Add image: <input type="file" name="photo" id="photo" accept="image/*">
<br>
Add video: <input type="file" name="video" id="video" accept="video/*">
<br>
Additional link: <input type="text" name="link" size="100">
<br>Add content warning? <input type="checkbox" name="ContWarn" value="yes">
<br>Select source: <input type="radio" name="source" value="d4"> Directorate4 <input type="radio" name="source" value="syriatoday"> Syria Today
<br><input type="submit" value="Post">
</form>
</center>
</html>