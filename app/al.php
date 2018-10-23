<?php
	Require_Once 'src/config.php';

?>

<html>
<center>
<form action="<?=$site['url']?>/manualadd" method="post">
Manually add link: <br>
<input type="text" name="ndata2" size="100">
<br>Add content warning? <input type="checkbox" name="ContWarn" value="yes">
<br><input type="submit" value="Post">
</form>
</center>
</html>