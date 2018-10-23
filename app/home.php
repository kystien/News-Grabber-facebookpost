<html>
<script src="app/jquery.simplePagination.js"></script>
<script>
function pagination(pageNum) {
    if (pageNum == "") {
        document.getElementById("target-content").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.open("GET","app/pagination.php?page="+ pageNum,true);
        xmlhttp.send();
    }
}

</script>
	<script type="text/javascript">
        var auto_refresh = setInterval(
            function() {
                $('#target-content').load('app/pagination.php?page=1').fadeIn("slow");
            }, 30000); 
    </script>

<br>
<br>
<div id="target-content" >loading...</div>

<?php
$rowperpage = 20;

$row = 0;

 if(isset($_GET['page'])){
  $row = $_GET['page']-1;
  if($row < 0){
   $row = 0;
  }
 }

	$json = file_get_contents("app/json/tlxquery.json");
	$data = json_decode($json, true);
	$allcount = count($data);

	$grandtotal_pages = ceil($allcount / $rowperpage); 
	$total_pages = 10; 
	?>
	
<div align="center">
<ul class='pagination text-center' id="pagination">


<?php if(!empty($total_pages)):for($i=1; $i<=$total_pages; $i++):  
			if($i == 1):?>
            <li class='active' id="<?php echo $i;?>"><a href="?page=<?php echo $i;?>"><?php echo $i;?></a></li> 
			<?php else:?>
			<li id="<?php echo $i;?>"><a href="?page=<?php echo $i;?>"><?php echo $i;?></a></li>
		<?php endif;?>			
<?php endfor;endif;?>  

</div>
</div>
</body>
<script>
jQuery(document).ready(function() {
jQuery("#target-content").load("app/pagination.php?page=1");
    jQuery("#pagination li").live('click',function(e){
	e.preventDefault();
		jQuery("#target-content").html('loading...');
		jQuery("#pagination li").removeClass('active');
		jQuery(this).addClass('active');
        var pageNum = this.id;
        jQuery("#target-content").load("?page=" + pageNum);
    });
    });
</script>
