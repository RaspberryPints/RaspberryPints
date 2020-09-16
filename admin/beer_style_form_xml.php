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
			<li><a href="beer_style_list.php">Beer Style XML</a></li>
			<li>/</li>
			<li class="current">Beer Style Form XML</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer med left">
	<p>
    Upload an BeerStyleXML file to add a beer.
  <br><br>

        <form enctype="multipart/form-data" action="includes/upload_beer_style.php" method="POST"><br />
		<table style="width:400;border:0;cellspacing:1;cellpadding:0;">
			<tr>
				<td colspan="2">
          		<input name="uploaded" type="file" accept="text/xml"/>
				</td>
            </tr>
            <tr>
          		<td><input type="submit" class="btn" value="Upload" /></td>
				<td><input type="button" class="btn" value="Cancel" onclick="window.location='beer_style_list.php'" /></td>
			</tr>								
		</table>
        </form> 
		<br />
        <div>
        <?php
			echo "<p>
			&lt;?xml version=\"1.0\" encoding=\"utf-8\"?&gt;<br />
			&lt;BEERSTYLES&gt;<br />
			&lt;BEERSTYLE&gt;<br />
				&lt;NAME&gt;&lt;/NAME&gt;<br />
				&lt;CATEGORY&gt;&lt;/CATEGORY&gt;<br />
				&lt;LETTER&gt;&lt;/LETTER&gt;<br />
				&lt;STYLE_GUIDE&gt;&lt;/STYLE_GUIDE&gt;<br />
				&lt;ABV_MIN&gt;&lt;/ABV_MIN&gt;<br />
				&lt;ABV_MAX&gt;&lt;/ABV_MAX&gt;<br />
				&lt;OG_MIN&gt;&lt;/OG_MIN&gt;<br />
				&lt;OG_MAX&gt;&lt;/OG_MAX&gt;<br />
				&lt;FG_MIN&gt;&lt;/FG_MIN&gt;<br />
				&lt;FG_MAX&gt;&lt;/FG_MAX&gt;<br />
				&lt;COLOR_MIN&gt;&lt;/COLOR_MIN&gt;<br />
				&lt;COLOR_MAX&gt;&lt;/COLOR_MAX&gt;<br />
				&lt;IBU_MIN&gt;&lt;/IBU_MIN&gt;<br />
				&lt;IBU_MAX&gt;&lt;/IBU_MAX&gt;<br />
			&lt;/BEERSTYLE&gt;<br />
			&lt;/BEERSTYLES&gt;<br />
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
require __DIR__.'/scripts.php';
?>

</body>
</html>
