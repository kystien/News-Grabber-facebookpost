#!/usr/bin/php
<?php
	require_once ('/src/config.php');
	require ('update.php');
	require ('twpull.php');
	unlink('/json/rows.json');
	shell_exec('php rows.php');
	unlink('/json/tquery.json');
	shell_exec('php tquery.php');
	unlink('json/query.json');
	shell_exec('php query.php');
	unlink('json/tlxquery.json');
	shell_exec('php merge.php');
	shell_exec('php telegram.php');
	exit;
?>
Run cron with: */5 * * * * /usr/bin/php path/to/automated/scripts/cron.php >/dev/null
