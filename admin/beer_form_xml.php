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
			<li class="current">Beer Form XML</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer med left">
	<p>
    Upload an BeerXML file to add a beer.
  <br><br>

        <form enctype="multipart/form-data" action="includes/upload_beer.php" method="POST"><br />
		<table style="width:400;border:0;cellspacing:1;cellpadding:0;">
			<tr>
				<td colspan="2">
          		<input name="uploaded" type="file" accept="text/xml"/>
				</td>
            </tr>
            <tr>
          		<td><input type="submit" class="btn" value="Upload" /></td>
				<td><input type="button" class="btn" value="Cancel" onclick="window.location='beer_list.php'" /></td>
			</tr>								
		</table>
        </form> 
		<br />
        <div>
        <?php
			echo "<p>
			&lt;?xml version=\"1.0\" encoding=\"utf-8\"?&gt;<br />
			&lt;BEERLISTS&gt;<br />
			&lt;RECIPE&gt;<br />
				&lt;STYLE&gt;<br />
					&lt;CATEGORY&gt;&lt;/CATEGORY&gt;<br />
					&lt;LETTER&gt;&lt;/LETTER&gt;<br />
					&lt;NAME&gt;&lt;/NAME&gt;<br />
				&lt;/STYLE&gt;<br />
				&lt;BREWERY&gt;&lt;/BREWERY&gt;<br />
				&lt;NAME&gt;&lt;/NAME&gt;<br />
				&lt;ABV&gt;&lt;/ABV&gt;<br />
				&lt;OG&gt;&lt;/OG&gt;<br />
				&lt;FG&gt;&lt;/FG&gt;<br />
				&lt;SRM&gt;&lt;/SRM&gt;<br />
				&lt;IBU&gt;&lt;/IBU&gt;<br />
				&lt;UNTAPPEDID&gt;&lt;/UNTAPPEDID&gt;<br />
				&lt;RATING&gt;&lt;/RATING&gt;<br />
				&lt;FERMENTABLES&gt;<br />
					&lt;FERMENTABLE&gt;<br />
						&lt;NAME&gt;&lt;/NAME&gt;<br />
						&lt;AMOUNT&gt;&lt;/AMOUNT&gt;<br />
					&lt;/FERMENTABLE&gt;<br />
				&lt;/FERMENTABLES&gt;<br />
				&lt;HOPS&gt;<br />
					&lt;HOP&gt;<br />
						&lt;NAME&gt;&lt;/NAME&gt;<br />
					&lt;/HOP&gt;<br />
				&lt;/HOPS&gt;<br />
				&lt;YEASTS&gt;<br />
					&lt;YEAST&gt;<br />
						&lt;NAME&gt;&lt;/NAME&gt;<br />
					&lt;/YEAST&gt;<br />
				&lt;/YEASTS&gt;<br />
			&lt;/RECIPE&gt;<br />
			&lt;/BEERLIST&gt;<br />
<p>";
?>
        </div>
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
