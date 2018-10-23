<?php
Require_Once 'src/config.php';

$row = 0;
$rowperpage = 10;

	$json = file_get_contents("json/rows.json");
	$data = json_decode($json, true);
	$allcount = count($data);
	
	$limitrow = $row*$rowperpage;
	
	$jsonq = file_get_contents("json/tlxquery.json");
	$dataq = json_decode($jsonq, true);
	$sno = $row + 1;
	
			function profpicExtractor($html){
	$linkArray = [];

	if(preg_match_all('/<imgs+.*?class="ProfileAvatar-image+.*?"s+.*?src=[\"\']?([^\"\' >]*)[\"\']?[^>]*>(.*?)/i', $html, $matches, PREG_SET_ORDER)){
		foreach ($matches as $match) {
		$linkArray[]= $match[1];
			}
		}
	return $linkArray;
	}
	$info[] = array();
?>

<html>
<style>
#content .twitterfeed { 
  float: center;
  background-color: #fff;
  width: 385px;
  margin: 10px 0px 30px 10px;
  border: 1px solid #d8d8d8;
  border-radius: 15px;
  padding: 5px 5px 15px 5px;
}
 
#content img  {
  margin: 5px 0px 0px 10px;
}
 
#content h3 {
  float: right;
  color: #000;
  background-color: #f2f2f2;
  font-size: 18px;
  font-weight: bold;
  width: 235px;
  padding: 10px 5px 10px 10px;
  margin: 10px 10px 25px 0px;
  text-shadow: 0 1px 0 #fff;
  border: 1px solid #d8d8d8; 
}
 
#content h3 a {
  text-decoration: none;
}
 
#content hr {
  width: 90%;
  height: 1px;
  background: #dfdfdf;
  display: block;
  border: none;
  margin: 20px 0px 20px 18px;
}
 
#tweet  {
  float: none;
  clear: both;
  display: flex;
  align-content: flex-start;
  justify-content: space-around
}
 
#tweet p {
  margin: 15px 15px 10px 15px;
}
#user  {
}
#user p {
  float: right;
}
</style>
<body>
<div id="fb-root"></div>

  <div class="entry">

<? 

	foreach($dataq['query'] as $key=>$row){ 
				/* Begin Twitter link grab ID & name image */
		$string = $row['link'];
		$int = intval(preg_replace('/[^0-9]+/', '', $string), 10);
	$twitimg = "screens/" . $int . ".jpg";	
				/* End Twitter link grab ID & name image */
 	$nData = array();
 	$nDid = array();	
	$c = 1;
	if ($row['title'] == $prevvalue) {
		continue;
	}
	$prevvalue = $row['title'];
	?>

<!-- Begin Entry Data -->
<br>
<table border="2" width="100%">
<th colspan="3" valign="top" align="center">
<div class="entrytitle">
<center><? echo $row['title']?></center>
</div>
</th>
<tr>
<td width="200" height="100"  style="vertical-align:top">

<!-- Begin Link Information -->
<table border="2" align="top" width="200px">
<tr>
<td width="100%">
<div class="card">
<?
	if (strpos($row['link'],'twitter') !== false) {

	
	$url = $row['link'];
	
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.12) Gecko/20080201 Firefox/2.0.0.12');
	curl_setopt($ch,CURLOPT_HEADER,0);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_FOLLOWLOCATION,0);
	curl_setopt($ch,CURLOPT_TIMEOUT,120);
	$html = curl_exec($ch);
	curl_close($ch);

	$imgp=profpicExtractor($html)[0];
	
	
?>
<br>
<? echo $imgp; ?>
<br>
  <center><img src="<?=$imgp;?>" style="width:50%"></center>
  
	<?
	} else {
	?>
	<center><img src="imgs/img_avatar3.jpg" style="width:50%"></center>
	<?
	}
	?>
<div class="containern">
<div class="entrymeta" align="center"> <? if($row['author']){ echo $row['author']; } ?></div>
</div>
</div>
</td>
</tr>

<tr>
<td>
<div style="text-align: center">
 <div style="display: inline-block; text-align: left">
<?
	if (strpos($row['link'],'youtube') != true) {
			$llink = '';
		if ($row['link'] == $llink) {
		continue;
	}
	$llink = $row['link'];
?>
<button type="button" class="btn"><a href="<?=$row['link']?>"><span class="fa fa-newspaper-o"></span>&nbsp;&nbsp;&nbsp;Source</a></button>
<?
}
else {
?>
<button type="button" class="btn btn-link btn-twitter" disabled><span class="fa fa-newspaper-o"></span>&nbsp;&nbsp;&nbsp;Source</button>
<?
}
?>
</div>
</div>
</td>
</tr>

<tr>
<td>
<div style="text-align: center">
 <div style="display: inline-block; text-align: left">
<?
	if (strpos($row['link'],'twitter') !== false) {
		  $twil ='';
		if ($row['link'] == $twil) {
		continue;
	}
	$twil = $row['link'];
?>
<button type="button" class="btn btn-twitter"><a href="<?=$row['link'];?>"><span class="fa fa-twitter"></span>&nbsp;&nbsp;&nbsp;Twitter</a>&nbsp;</button>
<? 
}
else {
?>
<button type="button" class="btn btn-link btn-twitter" disabled><span class="fa fa-twitter"></span>&nbsp;&nbsp;Twitter</button>
<?
}
?>
</div>
</div>
</td>
</tr>

<tr>
<td>
<div style="text-align: center;">
 <div style="display: inline-block; text-align: left;">
<button type="button" class="btn btn-link btn-facebook" disabled><span class="fa fa-facebook"></span>&nbsp;Facebook</button>
</div>
</div>
</td>
</tr>

<tr>
<td>
<div style="text-align: center;">
 <div style="display: inline-block; text-align: left;">
<?
	if (strpos($row['link'],'youtube') !== false) {
?>
<button type="button" class="btn"><span class="fa fa-youtube-play"></span>&nbsp;&nbsp;<a href="<?=$row['link'];?>" style="color: black">Youtube</a></button>
<?
}
else {
?>
<button type="button" class="btn btn-link btn-google" disabled><span class="fa fa-youtube-play"></span>&nbsp;&nbsp;Youtube</button>
<?
}
?>
</div>
</div>
</td>
</tr>

</table>
</td>

<!-- End Link Information -->

<!-- Begin Entry Information -->

<td valign="top" align="center">
<table border="2" width="100%">
<tr height="20">
<td width="50%" align="right">
<table>
<tr>
<td>Posted: </td>
<td>
<div class="entrymeta">&nbsp;&nbsp;<? echo $row['pubdate'] ?> &nbsp;&nbsp;&nbsp;&nbsp;</div>
</td>
</tr>
</table>
</td>
<td colspan="2">Location: </td>
</tr>

<tr>
<td colspan="2" rowspan="5" valign="top" align="center">
<table height="300px" width="100%">
<tr>
<td  colspan="2" rowspan="5" valign="top" align="center">
<p>

<?

/* Display Twitter embeds */ 
 
	if (strpos($row['link'],'twitter') !== false) {
	$url2 = $row['link'];
	$nData[] = $row['link'];
	$twitimg = $row['image'];
	$twtitle = $row['title'];
	$twname = $row['author'];
	$imagel = $row['image'];
	$desc = $row['content'];
	$sname = $row['author'];
?>

<!-- Begin Content -->
<div id="content">

<!-- Begin Twitter Feed Area  -->
<div class="twitterfeed">

<!--  <h3>Follow <a href="http://twitter.com/envatowebdev">Nettuts+</a> and <a href="http://twitter.com/tutsplus">Tuts+</a> on Twitter</h3>  -->

<div id="tweet">
<img src="imgs/twitter_bird.png" width="99" height="75" align="top">
<p> <?=$row['title']; ?>
</div>
<div id="user">
 (@<a href="<?=$url2; ?>"><?=$sname; ?></a>)
 <p><? echo $row['pubdate'] ?>
 </div>
</div>
<!-- End Twitter Feed Area  -->
</div>
<!-- End Content -->

<?
}

/* Display youtube video section */

elseif (strpos($row['link'],'youtube') !== false) {

	$url2 = $row['link'];
	$nData[] = $url2;
	$nDid[] = $row['id'];
	parse_str( parse_url( $url2, PHP_URL_QUERY ), $yt ); 
	$ytlink = "https://www.youtube.com/embed/" . $yt['v'];
?> 

<object style="width:560;height:315;width: 560px; height: 315px; float: none; clear: both; margin: 2px auto;" data="<?=$ytlink; ?>">
</object>


<?
}
/* Display all other links in iframe section - Mostly from news srouces */

else {
	$url2 = $row['link'];
	$nData[] = $url2;
	$imagel = $row['image'];
	$desc = $row['content'];
	$sname = $row['author'];
?> 
<div class="container-fluid">
<center><img src="<?=$imagel; ?>" width="476" height="249"></center>
<br> <span style="text-decoration: underline; white-space: pre;"></span>
<div align="left"><?=$desc; ?> </div>
<div align="right"> <?=$sname; ?> </div>

 </div>
 
 <?
 }
 ?>
 </td>
</tr>
 </table>
</td>

<!-- Buttons per link -->

<td width="200" valign="top" align="center">
<table width="200" border="2">
  <script type="text/javascript">
function showPopup(url) {
newwindow=window.open(url,'name','height=450,width=600,top=200,left=300,resizable');
if (window.focus) {newwindow.focus()}
}
</script>
<tr>
<td>
<? 
	if($nData){
?>
<form method="post" action="<?=$site['url']?>/fbookpost">
<button class="btn btn-block btn-social btn-github" style="font-size:15px" name="ndata" type="submit" value="<? echo $nData[0];?>">
<span class="fa fa-hand-pointer-o"></span>
Generate Article</button>
</form>
<?
}
?>
</td>
</tr>
<tr>
<td>
<? 
	if($nData){
?>
<a href="https://twitter.com/intent/tweet?url=<? echo $nData[0];?>&text=<? echo $row['title'];?>&via=GlobalWarNews1">
<button class="btn btn-block btn-social btn-twitter" style="font-size:15px" value="<? echo $nData[0];?>">
<span class="fa fa-twitter"></span>
Tweet</button></a>
<?
}
?>
</td>
</tr>
<tr>
<td>
<? 
	if($nData){
?>
  <!-- Your share button code -->

	  <a href="https://www.facebook.com/sharer/sharer.php?u=<? echo $nData[0];?>&quote=Posted%20from%20Global%20War%20News" onClick="showPopup(this.href);return(false);"><button class="btn btn-block btn-social btn-facebook" style="font-size:15px" >
      <span class="fa fa-facebook">
      </span> 
      &nbsp;&nbsp; &nbsp;&nbsp; Share to Facebook
    </button> </a>
 <?
}
?>
</td>
</tr>
<tr>
<td>
<? 
	if($nData){
?>
<form method="post" action="<?=$site['url']?>/fbookpost">
	  <button name="ndata" type="submit" value="<? echo $nData[0];?>" class="btn btn-block btn-social btn-facebook" style="font-size:15px" >
      <span class="fa fa-facebook">
      </span> 
      &nbsp;&nbsp; &nbsp;&nbsp; Share to Group & Page
    </button>
	Add content warning? <input type="checkbox" name="ContWarn" value="yes">
<?
}
?>
</td>
</form>
</tr>
</table>
<!-- End Button Table -->
</td>
</tr>
</table>
<!-- End Entry Information -->
</td>
</tr>
</table>
<?
}
?>
</html>