#!/usr/bin/php
<?php
	require_once ('/home/admin/Config/config.php');
	require ('/home/admin/updater/update.php');
	require ('/home/admin/updater/twpull.php');
	unlink('/home/admin/json/rows.json');
	shell_exec('php /home/admin/updater/rows.php');
	unlink('/home/admin/json/tquery.json');
	shell_exec('php /home/admin/updater/tquery.php');
	unlink('/home/admin/json/query.json');
	shell_exec('php /home/admin/updater/query.php');
	unlink('/home/admin/json/tlxquery.json');
	shell_exec('php /home/admin/updater/merge.php');
	shell_exec('php /home/admin/updater/telegram.php');
	exit;
?>
