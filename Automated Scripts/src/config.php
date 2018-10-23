<?php
	
	$dfh= 'mysql:host=localhost';
	$host = 'localhost';
		/*		Credentials		*/
	$site1['dbuser'] = ' ';
	$site4['dbuser'] = ' ';
	$site1['dbpass'] = ' ';
		/*		Databases		*/
	$site1['dbname'] = 'Feeds';
	$site2['dbname'] = 'DATA';
	$site3['dbname'] = 'Telegram';
	$site4['dbname'] = 'Drupal';
	
	/* ------------------- PDO Setup database ------------------- */
			/*		Insert & Update Databases		*/
	$db = new PDO('mysql:host=' . $host . ';dbname=' . $site1['dbname'], $site1['dbuser'], $site1['dbpass'], array(
    PDO::ATTR_PERSISTENT => true));
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
	
	$db2 = new PDO('mysql:host=' . $host . ';dbname=' . $site2['dbname'], $site1['dbuser'], $site1['dbpass'], array(
    PDO::ATTR_PERSISTENT => true));
	$db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db2->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
	
	$db3 = new PDO('mysql:host=' . $host . ';dbname=' . $site3['dbname'], $site1['dbuser'], $site1['dbpass'], array(
    PDO::ATTR_PERSISTENT => true));
	$db3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db3->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
	
	$db4 = new PDO('mysql:host=' . $host . ';dbname=' . $site4['dbname'], $site1['dbuser'], $site1['dbpass'], array(
    PDO::ATTR_PERSISTENT => true));
	$db4->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db4->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
	
			/*			Query Databases				*/
	$dbq = new PDO('mysql:host=' . $host . ';dbname=' . $site1['dbname'], $site4['dbuser'], $site1['dbpass'], array(
    PDO::ATTR_PERSISTENT => true));
	$dbq->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$dbq->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
	
	$dbq2 = new PDO('mysql:host=' . $host . ';dbname=' . $site2['dbname'], $site4['dbuser'], $site1['dbpass'], array(
    PDO::ATTR_PERSISTENT => true));
	$dbq2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$dbq2->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
	
	$dbq3 = new PDO('mysql:host=' . $host . ';dbname=' . $site3['dbname'], $site4['dbuser'], $site1['dbpass'], array(
    PDO::ATTR_PERSISTENT => true));
	$dbq3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$dbq3->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
	
	$dbq4 = new PDO('mysql:host=' . $host . ';dbname=' . $site4['dbname'], $site4['dbuser'], $site1['dbpass'], array(
    PDO::ATTR_PERSISTENT => true));
	$dbq4->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$dbq4->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

?>
