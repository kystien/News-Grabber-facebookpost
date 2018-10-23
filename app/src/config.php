<?
/* ------------------- Global Variables ------------------- */

    $site['title'] = 'Global War News Network - Design Section';
    $site['url'] = 'https://' . $_SERVER['HTTP_HOST'] . '/feed';
    $site['base'] = '/feed';

/* ------------------- PDO Login Information ------------------- */	
	
   $dfh= 'mysql:host=localhost';
   $host = 'localhost';

   $site1['dbuser'] = ' ';
   $site1['dbpass'] = ' ';
   $site1['dbname'] = ' ';
   
   $site['updates'] = false;

/* ------------------- Error and Logging ------------------- */

	error_reporting(E_ALL & ~E_NOTICE);
	ini_set('display_errors', 1);
	//ini_set('error_log', APP_PATH . '/log/error.log');
	ini_set('log_errors',true);

		
/* ------------------- definitions and datetime ------------------- */

    date_default_timezone_set('America/Edmonton');
    
	define('APP_PATH', realpath(dirname(__FILE__) . '/../'));
	define('API', realpath(dirname(__FILE__) . '/../src/API/'));


/* ------------------- PDO Setup database ------------------- */

	$db = new PDO('mysql:host=' . $host . ';dbname=' . $site1['dbname'], $site1['dbuser'], $site1['dbpass']);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

/* ------------------- API Paths ------------------- */
    	
	set_include_path(APP_PATH . 'src');
	require API . '/Functions/helper_functions.php';
	require API . '/Functions/action_functions.php';
	require API . '/Simplepie/autoloader.php';
	require API . '/Facebook/autoload.php';


/* ------------------- Facebook token & App data ------------------- */

$fb = new Facebook\Facebook([
 'app_id' => ' ',
 'app_secret' => ' ',
 'default_graph_version' => 'v2.9',
]);

$pageGlobalWarTTCAccessToken =' ';

$pageWW3AccessToken =' ';

/* ------------------- Twitter token & App data ------------------- */
// $settings = array(
//    'oauth_access_token' => " ",
//    'oauth_access_token_secret' => " ",
//    'consumer_key' => " ",
//    'consumer_secret' => " "
// );