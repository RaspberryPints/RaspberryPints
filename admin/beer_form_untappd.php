<?php
require_once __DIR__.'/header.php';
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
			<li><a href="beer_list.php">My Beers</a></li>
			<li>/</li>
			<li class="current">Beer Form Untappd</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer med left">
	<p>
    Add Beer From Untapped
  <br><br>

        <form enctype="multipart/form-data" action="beer_form.php" method="POST"><br />
		<table style="width:400;border:0;cellspacing:1;cellpadding:0;">
			<tr>
				<td colspan="2">
				<input type="hidden" name="fromUntapped" value="fromUntapped"/>
          		<input name="untID" class="mediumbox"/>
				</td>
            </tr>
            <tr>
          		<td><input type="submit" class="btn" value="Retrieve" /></td>
				<td><input type="button" class="btn" value="Cancel" onclick="window.location='beer_list.php'" /></td>
			</tr>								
		</table>
        </form> 
		<div align="right">			
			&nbsp; &nbsp; 
		</div>

	</div>
	<!-- End On Tap Section -->

	<!-- Start Footer -->   
<?php 
require __DIR__.'/footer.php';
?>

	<!-- End Footer -->
		
	</div>
	<!-- Right Side/Main Content End -->
	<!-- Start Left Bar Menu -->   
<?php 
require __DIR__.'/left_bar.php';
?>
	<!-- End L
<script>
	$(function() {		
		
		$('#beer-form').validate({
		rules: {
			name: { required: true },
			style: { required: true },			
			srm: { required: true, number: true },
			ibu: { required: true, number: true },
			og: { required: true, number: true },
			fg: { required: true, number: true }
		}
		});
		
	});eft Bar Menu -->  
	<!-- Start Js  -->
<?php
require __DIR__.'/scripts.php';
?>

<!--
</script>

	<!-- End Js -->
	<!--[if IE 6]>
	<script type='text/javascript' src='scripts/png_fix.js'></script>
	<script type='text/javascript'>
	DD_belatedPNG.fix('img, .notifycount, .selected');
	</script>
	<![endif]--> 

</body>
</html>
