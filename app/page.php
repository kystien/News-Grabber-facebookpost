<!? query db to post data from ?>

<?php
$rowperpage = 5;

$row = 0;

 if(isset($_GET['page'])){
  $row = $_GET['page']-1;
  if($row < 0){
   $row = 0;
  }
 }
	$results=$db->query("SELECT * 
	FROM twitterlinks
	JOIN item
	ON item.pubdate = twitterlinks.pubdate
	");
	$allcount = $results->rowCount();
	$sth = $results->fetch(PDO::FETCH_BOTH);

	?>
<html>

<script>window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);

  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };

  return t;
}(document, "script", "twitter-wjs"));</script>

<head>
</head>

<div class="unread">
Unread: 
</div>
  <div class="entry">

<style>
.card {
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    width: 100%;
}

.card:hover {
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

.containern {
    padding: 2px 16px;
}

.pagination{
 list-style: none;
}
.pagination li{
 float: left;
 border: 1px solid #000;
 padding: 5px 7px;
 margin-right: 10px;
 border-radius: 3px;
}
.pagination li a{
 text-decoration: none;
 color:black;
}

.active{
 color: red !important;
}
</style>
<center><table width="300px" border="2" align="right">
<tr>
<td width="100" valign="center">
</td>
<td width="100" valign="center">
</td>
<td width="100" valign="center" align="center">
 	  <form name="frm" method="post" action="">
	  <button name="submit" type="submit" value="<? echo $nData[0];?>" class="btn btn-danger" style="font-size:10px"> 
      Delete selected items
    </button>
	</form>
	<?
	if(isset($_POST['submit'])){
	foreach($_POST['option'] as $item){
  	$delete = $db->prepare('DELETE FROM item WHERE id = (' . $item . ')');
	$delete->execute();
	}
	
	}
	?>
</td>
</tr>
</table></center>
<? 
	
	$limitrow = $row*$rowperpage;
	$results=$db->query("SELECT * 
	FROM twitterlinks
	JOIN item
	ON item.pubdate = twitterlinks.pubdate
	ORDER BY item.pubdate DESC limit $limitrow,".$rowperpage
	);
	$sth = $results->fetch(PDO::FETCH_BOTH);
	$sno = $row + 1;
  if(isset($_GET['page'])){
   $sno = (($_GET['page']*$rowperpage)+1) - $rowperpage;
   if($sno <=0) $sno = 1;
  }
	$oldname = '';

	foreach($results as $row){ 
				
		$string = $row['link'];
		$int = intval(preg_replace('/[^0-9]+/', '', $string), 10);

	$twitimg = "screens/" . $int . ".jpg";	
 	$nData = array();
 	$nDid = array();	
	$c = 1;
	?>

<!-- Begin Entry Data -->
<table border="2" width="100%">
<tr>
<td width="200" height="100"  style="vertical-align:top">

<!-- Begin Link Information -->
<table border="2" align="top" width="200px">
<tr>
<td width="100%">
<div class="card">
  <img src="imgs/img_avatar3.jpg" style="width:100%">
<div class="containern">
<div class="entrymeta"> <? if($row[author]){ echo $row[author]; } ?></div>
</div>
</div>
</td>
</tr>

<tr>
<td>
<div style="text-align: center">
 <div style="display: inline-block; text-align: left">
<?
	if (strpos($row[linkurl],'youtube') != true) {
?>
<a href="<?=$row[linkurl]?>">Source Link </a>
<?
}
else {
?>
Source Link
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
	if (strpos($row[link],'twitter') !== false) {
?>
<a href="<?=$row[link];?>">Twitter Link </a>
<? 
}
else {
?>
Twitter Link
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
Facebook link
</div>
</div>
</td>
</tr>

<tr>
<td>
<div style="text-align: center;">
 <div style="display: inline-block; text-align: left;">
<?
	if (strpos($row[linkurl],'youtube') !== false) {
?>
<a href="<?=$row[linkurl];?>">Youtube link</a>
<?
}
else {
?>
Youtube link
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
 <div style="display: inline-block; text-align: left">
LinkedIn link
</div>
</div>
</td>
</tr>
</table>
</td>

<!-- End Link Information -->

<!-- Begin Entry Information -->

<td valign="top" align="center">
<table border="2" height="300px" width="100%">
<th colspan="2" valign="top" align="center">
<div class="entrytitle">
<center><? echo $row[title]?></center>
</div>
</th>
<tr height="20">
<td width="50%" align="right">
<table>
<tr>
<td>Posted: </td>
<td>
<div class="entrymeta">&nbsp;&nbsp;<? echo $row[pubdate] ?> &nbsp;&nbsp;&nbsp;&nbsp;</div>
</td>
</tr>
</table>
</td>
<td colspan="2">Location: </td>
</tr>

<tr>
<td colspan="2" rowspan="5" valign="top" align="center">
<table border="2" height="300px" width="500px">
<tr>
<td  colspan="2" rowspan="5" valign="top" align="center">
<p>

<?

/* Display Twitter embeds */ 
 
	if (strpos($row[link],'twitter') !== false) {
	$nData[] = $row[link];
	$nDid[] = $row[id];

?>
<!-- img placeholder until twitter embeds work -->

<center><img src=" <?=$twitimg; ?> " height="400"></center>

<?
}

/* Display youtube video section */

elseif (strpos($row[linkurl],'youtube') !== false) {

	$url2 = $row[linkurl];
	$nData[] = $url2;
	$nDid[] = $row[id];
	parse_str( parse_url( $url2, PHP_URL_QUERY ), $yt ); 
	$ytlink = "https://www.youtube.com/embed/" . $yt['v'];
?> 

<object style="width:560;height:315;width: 560px; height: 315px; float: none; clear: both; margin: 2px auto;" data="<?=$ytlink; ?>">
</object>


<?
}
/* Display all other links in iframe section - Mostly from news srouces */

else {
	$name = $row[id];    
	$source = $name . ".jpg";
	$dest = "screens/" . $name . ".jpg";
	$nData[] = $row[linkurl];
	$nDid[] = $row[id];
?> 

 <center><img src=" <?=$dest; ?> " height="600" width="500"></center>

 <div id="container"></div>
 
 <?
 }
 ?>
 </td>
</tr>
 </table>
</td>

<!-- Buttons per link -->

<td width="200" valign="top" align="center">
<center>Check item to delete</center>
<form name="frm">
<center><input type='checkbox' name="option[]" value='<? echo $nDid[0];?>'></center>
</form>
<br>
<br>
<table width="200" border="2">
<tr>
<td id="<?=$c++;?>fbookform" align="center">
<? 
	if($nData){
?>
 	  <form method="post" action="<?=$site['url']?>/fbookpost">
	  <button name="ndata" type="submit" value="<? echo $nData[0];?>" class="btn btn-social btn-facebook" style="font-size:15px" >
      <span class="icon icon-facebook">
      </span> 
      Share to Group & Page
    </button>
	</form>
<?
}
?>
</td>
</tr>

<tr>
<td id="<?=$c++;?>fbookform" align="center">
<? 
	if($nData){
?>
 	  <form method="post" action="<?=$site['url']?>/deleteitem">
	  <button name="ndata" type="submit" value="<? echo $nDid[0];?>" class="btn btn-danger" style="font-size:15px" >
      Delete item
    </button>
	</form>
<?
}
?>
</td>
</tr>

<tr>
<td>
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>

  <!-- Your share button code -->
<!-- <div class="fb-share-button" data-href="<?=$nData[0];?>" data-layout="button_count" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="<?=$nData[0];?>">Share</a></div> -->
</td>
</>
<tr>
<td align="center">
 	<form method="post" action="<?=$site['url']?>/fbookpost" id="fbookform">
  	<input type="hidden" name="ndata" value="<? echo $nData[0];?>"/>
  	<input type="submit" name="submit" value="Post to Global War Group" id="postfbookbutton"/>
	</form> 
</td>
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
<!-- End Entry Data -->
<center><div>
  <?php
   $sno ++;
  }
  ?>
   <ul class="pagination">
 
 <?php
 // calculate total pages
 $total_pages = ceil($allcount / $rowperpage);

 $i = 1;$prev = 0;

 // Total number list show
 $numpages = 10;

 // Set previous page number and start page 
 if(isset($_GET['next'])){
  $i = $_GET['next']+1;
  $prev = $_GET['next'] - ($numpages);
 }

 if($prev <= 0) $prev = 1;
 if($i == 0) $i=1;

 // Previous button next page number
 
 $prevnext = 0;
 if(isset($_GET['next'])){
  $prevnext = ($_GET['next'])-($numpages+1);
  if($prevnext < 0){
   $prevnext = 0;
  }
 }
 
 // Previous Button
 echo '<li ><a href="?page='.$prev.'&next='.$prevnext.'">Previous</a></li>';
 
 if($i != 1){
  echo '<li ><a href="?page='.($i-1).'&next='.$_GET['next'].'" '; 
  if( ($i-1) == $_GET['page'] ){
   echo ' class="active" ';
  }
  echo ' >'.($i-1).'</a></li>';
 }
 
 // Number List
 for ($shownum = 0; $i<=$total_pages; $i++,$shownum++) {
  if($i%($numpages+1) == 0){
   break;
  }
 
  if(isset($_GET['next'])){ 
   echo "<li><a href='?page=".$i."&next=".$_GET['next']."'";
  }else{
   echo "<li><a href='?page=".$i."'";
  }
 
  // Active
  if(isset($_GET['page'])){
   if ($i==$_GET['page']) 
    echo " class='active'";
   }
   echo ">".$i."</a></li> ";
  }

  // Set next button
  $next = $i+$rowperpage;
  if(($next*$rowperpage) > $allcount){
   $next = ($next-$rowperpage)*$rowperpage;
  }

  // Next Button
  if( ($next-$rowperpage) < $allcount ){ 
   if($shownum == ($numpages)){
    echo '<li ><a href="?page='.$i.'&next='.$i.'">Next</a></li>';
   }
  }
 
  ?>
 </ul>
 <!-- Numbered List (end) -->
</div> </center>
</html>