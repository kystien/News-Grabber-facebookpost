<?php

function do404(){
	
	global $site;
	
	header("HTTP/1.0 404 Not Found");
	
	echo '<div id="content">';
	echo '<div class="entry">';
	echo '<h1>Not Found - Sorry!</h1>';
	echo '<p>We couldn\'t find that page, please try another URL</p>';
	echo '</div></div>';
	
}



function debug($message){

	if(is_array($message)){
		$message = print_r($message, true);
	}

	syslog(LOG_DEBUG, $message);
	
}

function formatContent($content){
	
	
	$config = array(
        'output-xhtml'  => true,
        'hide-comments' => true,
        'quote-nbsp' => true,
        'quote-ampersand' => true,
        'preserve-entities' => true,
        'alt-text'	   => '[image]',
        'drop-font-tags' => true,
        'logical-emphasis' => true,
        'show-body-only' => true
        );

	return tidy_repair_string($content, $config);
	

}



?>
