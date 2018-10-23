<?php
	header('Content-Type: text/html; charset=UTF-8');
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title><?=$site['title']?> <?if($page['title']){ echo ' - ' . $page['title'];}?></title>
	<link rel="stylesheet" href="http://lipis.github.io/bootstrap-social/bootstrap-social.css">
	<link rel="stylesheet" href="http://lipis.github.io/bootstrap-social/assets/css/font-awesome.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="shortcut icon" type="image/ico" href="<?=$site['url']?>/favicon.ico" />
	<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<meta name="twitter:widgets:autoload"  content="on">
	<script async defer src="//platform.twitter.com/widgets.js" charset="utf-8">
</script>
	<script type="text/javascript">
  function Submit(form) {
  alert("Posted to facebook pages & group");
  return;
  }
	</script>
	<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
.holder{
    width: 100%;
    height:100%;
    position:relative
}
.frame{
    width: 100%;
    height:100%;
}
.bar{
    position:relative;
    top:0;
    left:0;
    width:100%;
    height:40px;
}
</style>
</head>

<body>

	<div id="page">
		
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
    <img src="<?=$site['url']?>/icon.png" width="50" height="50" style="vertical-align:middle" class="navbar-brand"> <a class="navbar-brand" href="<?=$site['url']?>">Global War News Network</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="<?=$site['url']?>">Home</a></li>
	    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Filter
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
			<li class="dropdown-header">By-Country</li>
			<li><a href="<?=$site['url']?>/admsyrh">Syria</a></li>
			<li><a href="#">Iraq</a></li>
			<li><a href="#">Ukraine</a></li>
			<li><a href="#">Philippines</a></li>
			<li><a href="#">Yemen</a></li>
			<li class="dropdown-header">By-Conflict</li>
			<li><a href="<?=$site['url']?>/admsyrh">Syria Civil war</a></li>
			<li><a href="<?=$site['url']?>/admsyrh">War of ISIS</a></li>
			<li><a href="<?=$site['url']?>/admsyrh">War on Terrorism</a></li>
			<li><a href="<?=$site['url']?>/admsyrh">South China Sea</a></li>
        </ul>
      </li>
      <li><a href="<?=$site['url']?>/al">Add Custom Link</a></li>
      <li><a href="<?=$site['url']?>/telegram">Telegram Add Link</a></li>
      <li><a href="#">Page 3</a></li>
	  <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Administrative
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
			<li><a href="<?=$site['url']?>/feeds">Feeds</a></li>
			<li><a href="<?=$site['url']?>/addfeed">Add Feed</a></li>
			<li class="divider"></li>
			<li><a href="<?=$site['url']?>/folders">Folders</a></li>
			<li><a href="<?=$site['url']?>/addfolder">Add Folder</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
	<div class="holder">
    <iframe class="frame" src="<?=$site['url']?>/globe/index.html" style="position:fixed" scrolling="no"></iframe>
	<div id="content" class="bar">


		<?=$page['content']?>
	</div>

	<div id="footer">
	  <p></p>
	</div>
	</div> 
	</div>

</body>
</html>
