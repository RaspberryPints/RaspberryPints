<?php
require_once __DIR__.'/header.php';
$configs = getAllConfigs();
$htmlHelper = new HtmlHelper();
?> 
<!-- Start Header  -->
<?php
include 'top_menu.php';
?>
<!-- End Header -->
	
<!-- Top Breadcrumb Start -->
<div id="breadcrumb">
	<ul>	
		<li><img src="img/icons/icon_breadcrumb.png" alt="Location" /></li>
		<li><strong>Location:</strong></li>
		<li class="current">Units Of Measure</li>
	</ul>
</div>
<!-- Top Breadcrumb End -->

<!-- Right Side/Main Content Start -->
<div id="rightside">
	<div class="contentcontainer lg left">
		<div class="headings alt">
			<h2>Units Of Measure</h2>
		</div>
		<div class="contentbox">
		<?php $htmlHelper->ShowMessage(); ?>
		<a id="columns"></a> 
        <div id="success" style="display:none;  z-index: 99 !important;">
        Configuration Updated
        </div>
    		<div>
    			<?php
    			$result = getDisplayUnitConfigs();
    				foreach($result as $row) {
    				    echo '<h3>' . $row['displayName'] . ":"  .'<span id="' . $row['configName'] . 'Success" style="display:none; color: #8EA534;"> (Updated)</span>'. '</h3>';
    				    $options = explode('|', $row['validation']);
    				    foreach($options as $option){
    				        $displayNvalue = explode(';', $option);
    				        $display = $displayNvalue[0];
    				        $value = count($displayNvalue) > 1?$displayNvalue[1]:$displayNvalue[0];
    				        echo $display.'<input type="radio" ' . ($row['configValue']==$value?'checked':'') . ' name="' . $row['configName'] . '" value="'.$value.'" onclick="changeConfiguration(this)">'; 
    					}
    					echo '<br><br>';
    			} ?>
    		</div>
		<hr />
	</div>
</div>

<!-- Start Footer -->

<?php 
include 'footer.php';
?>

	<!-- End Footer -->
		
	</div>
	<!-- Right Side/Main Content End -->
	
	<!-- Start Left Bar Menu -->   
<?php 
include 'left_bar.php';
?>
	<!-- End Left Bar Menu -->  
	<!-- Start Js  -->
<?php
include 'scripts.php';
?>
	<!-- End Js -->
	<!--[if IE 6]>
	<script type='text/javascript' src='scripts/png_fix.js'></script>
	<script type='text/javascript'>
	DD_belatedPNG.fix('img, .notifycount, .selected');
	</script>
	<![endif]--> 
	<script>
	function changeConfiguration(checkBox, config){
		var data = {};
		data[checkBox.name] = checkBox.value;
		$.ajax(
            {
                   type: "POST",
                   url: "includes/update_columnConfig.php",
                   data: data,// data to send to above script page if any
                   cache: false,
    
                   success: function(response)
                   {
                	   checkBox.checked = true; 
                	   document.getElementById(checkBox.name + 'Success').style.display = ""; 
                   }
             });
  	}
  	</script>
</body>
</html>
