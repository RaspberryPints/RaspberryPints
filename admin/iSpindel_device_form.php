<?php
require_once __DIR__.'/header.php';
$htmlHelper=new HtmlHelper();
$iSpindelDeviceManager=new iSpindelDeviceManager();

//$config=getAllConfigs();

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['save']) ) {
    $beerExloded = explode("~", $_POST['beerId']);
    $_POST['beerId'] = $beerExloded[0];
    $_POST['beerBatchId'] = $beerExloded[1];
    $iSpindelDevice = $iSpindelDeviceManager->GetById($_POST['id']);
    if( !$iSpindelDevice )$iSpindelDevice = new iSpindelDevice();
    $iSpindelDevice->set_sent($iSpindelDevice->get_sent() || $iSpindelDevice->get_interval() != $_POST["interval"] || $iSpindelDevice->get_token() != $_POST["token"] || $iSpindelDevice->get_polynomial() != $_POST["polynomal"] );
    $iSpindelDevice->setFromArray($_POST);
    if($iSpindelDeviceManager->Save($iSpindelDevice)){
        triggerPythonAction();
        unset($_POST);
        redirect('iSpindel_device_list.php');
    }
}

$iSpindelDevice = null;
if( isset($_GET['id'])){
    $iSpindelDevice = $iSpindelDeviceManager->GetById($_GET['id']);
}else if( isset($_POST['id'])){
    $iSpindelDevice = $iSpindelDeviceManager->GetById($_POST['id']);
}

if($iSpindelDevice == null){
    $iSpindelDevice = new iSpindelDevice();
    $beerExloded = explode("~", $_POST['beerId']);
    $_POST['beerId'] = $beerExloded[0];
    $_POST['beerBatchId'] = $beerExloded[1];
    $iSpindelDevice->setFromArray($_POST);
}
$beerList=(new BeerManager())->GetAllActiveWithBatches();
?>
<body>
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
			<li class="current">iSpindel Device Form</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End -->

	<!-- Right Side/Main Content Start -->
<div id="rightside">
	<div class="contentcontainer left">
		<div class="headings alt">
			<h2>iSpindel Device Form</h2>
		</div>
		<div class="contentbox">
			<?php $htmlHelper->ShowMessage(); ?>
			
			<form method="POST" id="iSpindelDevices-form">
        		<input type="hidden" name="id" value="<?php echo $iSpindelDevice->get_id() ?>" />
        		<input type="hidden" name="active" value="1" />
                <table style="width:800px" id="tableList">
                	<thead>
                        <tr>
                            <th>
                            <th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        	<td style="vertical-align: middle; text-align: left;">ID</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="number" disabled class="smallbox" name="id<?php echo $iSpindelDevice->get_id(); ?>" value=<?php echo $iSpindelDevice->get_id(); ?> />
                            </td>  
                        </tr>
						<tr>
                        	<td style="vertical-align: middle; text-align: left;">Name</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="number" disabled class="smallbox" name="id<?php echo $iSpindelDevice->get_id(); ?>" value=<?php echo $iSpindelDevice->get_name(); ?> />
                            </td>  
                        </tr>
                        <tr>
							<td style="width: 25%; vertical-align: middle; text-align: left;">Beer</td>
							<td style="width: 30%">	
 							<?php 
							
    							$str = "<select id='beerId' name='beerId' class=''>\n";
    							$str .= "<option value=''>Select One</option>\n";
    							foreach($beerList as $item){
    							    if( !$item ) continue;
    							    $sel = "";
    							    if( isset($iSpindelDevice) && $iSpindelDevice->get_beerId() == ($item->get_beerBatchId()<=0?$item->get_id():$item->get_beerId()) && (($iSpindelDevice->get_beerBatchId() <= 0 && $item->get_beerBatchId()<=0) || $iSpindelDevice->get_beerBatchId() == $item->get_beerBatchId()) )  $sel .= "selected ";
    							    $desc = $item->get_displayName();
    							    $str .= "<option value='".($item->get_beerBatchId()<=0?$item->get_id():$item->get_beerId())."~".$item->get_beerBatchId()."~".$item->get_fg()."~".$item->get_fgUnit()."' ".$sel.">".$desc."</option>\n";
    							}
    							$str .= "</select>\n";
    							
    							echo $str;
    							//echo $htmlHelper->ToSelectList("beerId[]", "beerId", $beerList, "name", "id", $fermenter->get_beerId(), "Select One");
							?>
						</tr>
<!-- 						<tr> -->
<!--                     	                    		<td style="vertical-align: middle; text-align: left;">Constant 1</td> -->
<!--                     	                            <td style="width:30%; vertical-align: middle;"> -->
<!--                     									<input type="number" class="smallbox" name="const1" step="0.000000001" value=<?php //echo $iSpindelDevice->get_const1(); ?> /> -->
<!--                             </td> -->
<!--                     	</tr> -->
<!--                         <tr> -->
<!--                     	                        	<td style="vertical-align: middle; text-align: left;">Constant 2</td> <td style="width:30%; vertical-align: middle;"> -->
<!--                     									<input type="number" class="smallbox"name="const2" step="0.000000001" value=<?php //echo $iSpindelDevice->get_const2(); ?> /> -->
<!--                             </td> -->
<!--                     	</tr> -->
<!--                         <tr> -->
<!--                     	                        	<td style="vertical-align: middle; text-align: left;">Constant 3</td> -->
<!--                     	                            <td style="width:30%; vertical-align: middle;"> -->
<!--                     									<input type="number"  class="smallbox" name="const3" step="0.000000001" value=<?php //echo $iSpindelDevice->get_const3(); ?> /> -->
<!--                             </td>   -->
<!--                     	</tr> -->
                        <tr>
                        	<td style="vertical-align: middle; text-align: left;">Gravity Unit</td>
                        	   
                            <td style="width:30%; vertical-align: middle;">
								<input type="radio" name="gravityUnit" <?php echo $iSpindelDevice->get_gravityUnit() == UnitsOfMeasure::GravityPlato?"checked":""?> value=p >Plato
								<input type="radio" name="gravityUnit" <?php echo $iSpindelDevice->get_gravityUnit() == UnitsOfMeasure::GravitySG   ?"checked":""?> value=sg>Specific Gravity
								<input type="radio" name="gravityUnit" <?php echo $iSpindelDevice->get_gravityUnit() == UnitsOfMeasure::GravityBrix ?"checked":""?> value=bx>Brix
                            </td>    
                    	</tr>
                        <tr>
                        	<td style="vertical-align: middle; text-align: left;">Update Interval(seconds)</td>
                        	   
                            <td style="width:30%; vertical-align: middle;">
								<input type="number" class="smallbox" name="interval" step="1.0" value=<?php echo $iSpindelDevice->get_interval(); ?> />
                            </td>    
                    	</tr>
                        <tr>
                        	<td style="vertical-align: middle; text-align: left;">iSpindel Token</td>
                            <td style="width:30%; vertical-align: middle;">
								<input disabled type="text" class="smallbox" name="token" value="<?php echo $iSpindelDevice->get_token(); ?>" />
                            </td>     
                    	</tr>
<!--                         <tr> -->
<!--                     	                        	<td style="vertical-align: middle; text-align: left;">Polynomial</td> -->
<!--                     	                            <td style="width:30%; vertical-align: middle;"> -->
<!--                     									<input type="number" class="smallbox" name="polynomial" step="1.0" value=<?php //echo $iSpindelDevice->get_polynomial(); ?> /> -->
<!--                             </td>                      -->
<!--                     	</tr> -->
                        <tr>
                        	<td style="vertical-align: middle; text-align: left;">Remote Interval Config Enabled</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="checkbox" name="remoteConfigEnabled" <?php  echo $iSpindelDevice->get_remoteConfigEnabled()?"checked":"" ?> value=1 />
                            </td>
                    	</tr>
                        <tr>
                        	<td style="vertical-align: middle; text-align: left;">SQL Logging Enabled</td>
                            <td style="width:30%; vertical-align: middle; align-content: center">
								<input type="checkbox" name="sqlEnabled" <?php  echo $iSpindelDevice->get_sqlEnabled()?"checked":"" ?> value=1 />
                            </td>
                    	</tr>
                        <tr>
                        	<td style="vertical-align: middle; text-align: left;">CSV Logging Enabled</td>
                            
                            <td style="width:30%; vertical-align: middle;">
								<input type="checkbox" name="csvEnabled" <?php  echo $iSpindelDevice->get_csvEnabled()?"checked":"" ?> onclick="toggleVisibility(this, 'ispindel_csv')" value=1  />
                            </td>
                    	</tr>
                        <tr id="ispindel_csv">
                        	<td style="vertical-align: middle; text-align: left;">&bull;CSV Outpath</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="text" class="smallbox" name="csvOutpath" value="<?php echo $iSpindelDevice->get_csvOutpath(); ?>" />
                            </td>
                    	</tr>
                        <tr id="ispindel_csv" style="display:<?php echo $iSpindelDevice->get_csvEnabled()?"visible":"none"; ?>">
                        	<td style="vertical-align: middle; text-align: left;">&bull;CSV Delimiter</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="text" class="smallbox" name="csvDelimiter" value="<?php echo $iSpindelDevice->get_csvDelimiter(); ?>" />
                            </td>
                    	</tr>
                        <tr id="ispindel_csv" style="display:<?php echo $iSpindelDevice->get_csvEnabled()?"visible":"none"; ?>">
                        	<td style="vertical-align: middle; text-align: left;">&bull;CSV NewLine Type</td>
                            <td style="width:30%; vertical-align: middle;">
								<select name="csvNewLine" >
									<option value=0 <?php echo $iSpindelDevice->get_csvNewLine()==0?"selected":""; ?>>Windows</option>
									<option value=1 <?php echo $iSpindelDevice->get_csvNewLine()==1?"selected":""; ?>>Linux</option>
								</select>
							</td>
                    	</tr>
                        <tr id="ispindel_csv" style="display:<?php echo $iSpindelDevice->get_csvEnabled()?"visible":"none"; ?>">
                        	<td style="vertical-align: middle; text-align: left;">&bull;CSV Include DateTime</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="checkbox" name="csvIncludeDateTime" <?php  echo $iSpindelDevice->get_csvIncludeDateTime()?"checked":"" ?> value=1 />
                            </td>
                    	</tr>
                        <tr>
                        	<td style="vertical-align: middle; text-align: left;">Unidots Logging Enabled</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="checkbox" name="unidotsEnabled" <?php  echo $iSpindelDevice->get_unidotsEnabled()?"checked":"" ?> onclick="toggleVisibility(this, 'ispindel_unidots')" value=1 />
                            </td>
                    	</tr>
                        <tr id="ispindel_unidots" style="display:<?php echo $iSpindelDevice->get_unidotsEnabled()?"visible":"none"; ?>">
                        	<td style="vertical-align: middle; text-align: left;">&bull;Unidots Use iSpindel Token</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="checkbox" name="unidotsUseiSpindelToken" <?php  echo $iSpindelDevice->get_unidotsUseiSpindelToken()?"checked":"" ?> onclick="toggleVisibility(this, 'ispindel_unidotsTokenUseiSpindelToken', true)" value=1 />
                            </td>
                    	</tr>
                        <tr id="ispindel_unidotsTokenUseiSpindelToken" style="display:<?php echo $iSpindelDevice->get_unidotsEnabled() && !$iSpindelDevice->get_unidotsUseiSpindelToken()?"visible":"none"; ?>">
                        	<td style="vertical-align: middle; text-align: left;">&bull;Unidots Token</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="text" class="smallbox" name="unidotsToken" value="<?php echo $iSpindelDevice->get_unidotsToken(); ?>" />
                            </td>
                            
                    	</tr>
                        <tr>
                        	<td style="vertical-align: middle; text-align: left;">Forward Logging Enabled</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="checkbox" name="forwardEnabled" <?php  echo $iSpindelDevice->get_forwardEnabled()?"checked":"" ?> onclick="toggleVisibility(this, 'ispindel_forward')" value=1 />
                            </td>
                    	</tr>
                        <tr id="ispindel_forward" style="display:<?php echo $iSpindelDevice->get_forwardEnabled()?"visible":"none"; ?>">
                        	<td style="vertical-align: middle; text-align: left;">&bull;Forward Address</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="text" class="smallbox" name="forwardAddress" value="<?php echo $iSpindelDevice->get_forwardAddress(); ?>" />
                            </td>
                    	</tr>
                        <tr id="ispindel_forward" style="display:<?php echo $iSpindelDevice->get_forwardEnabled()?"visible":"none"; ?>">
                        	<td style="vertical-align: middle; text-align: left;">&bull;Forward Port</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="number" class="smallbox" name="forwardPort" step="1.0" value=<?php echo $iSpindelDevice->get_forwardPort(); ?> />
                            </td> 
                    	</tr>
                        <tr>
                        	<td style="vertical-align: middle; text-align: left;">FermentTrack Logging Enabled</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="checkbox" name="fermentTrackEnabled" <?php  echo $iSpindelDevice->get_fermentTrackEnabled()?"checked":"" ?> onclick="toggleVisibility(this, 'ispindel_fermentTrack')" value=1 />
                            </td>
                    	</tr>
                        <tr id="ispindel_fermentTrack" style="display:<?php echo $iSpindelDevice->get_fermentTrackEnabled()?"visible":"none"; ?>">
                        	<td style="vertical-align: middle; text-align: left;">&bull;FermentTrack Address</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="text" class="smallbox" name="fermentTrackAddress" value="<?php echo $iSpindelDevice->get_fermentTrackAddress(); ?>" />
                            </td>
                    	</tr>
                        <tr id="ispindel_fermentTrack" style="display:<?php echo $iSpindelDevice->get_fermentTrackEnabled()?"visible":"none"; ?>">
                        	<td style="vertical-align: middle; text-align: left;">&bull;FermentTrack Port</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="number" class="smallbox" name="fermentTrackPort" step="1.0" value=<?php echo $iSpindelDevice->get_fermentTrackPort(); ?> />
                            </td>
                    	</tr>
                        <tr id="ispindel_fermentTrack" style="display:<?php echo $iSpindelDevice->get_fermentTrackEnabled()?"visible":"none"; ?>">
                        	<td style="vertical-align: middle; text-align: left;">&bull;FermentTrack Use iSpindel Token</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="checkbox" name="fermentTrackUseiSpindelToken" <?php  echo $iSpindelDevice->get_fermentTrackUseiSpindelToken()?"checked":"" ?> onclick="toggleVisibility(this, 'ispindel_fermentTrackUseiSpindelToken', true)" value=1 />
                            </td>
                    	</tr>
                        <tr id="ispindel_fermentTrackUseiSpindelToken" style="display:<?php echo $iSpindelDevice->get_fermentTrackEnabled() && !$iSpindelDevice->get_fermentTrackUseiSpindelToken()?"visible":"none"; ?>">
                        	<td style="vertical-align: middle; text-align: left;">&bull;FermentTrack Token</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="text" class="smallbox" name="fermentTrackToken" value="<?php echo $iSpindelDevice->get_fermentTrackToken(); ?>" />
                            </td>
                    	</tr>
                        <tr>
                        	<td style="vertical-align: middle; text-align: left;">BrewPiLess Logging Enabled</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="checkbox" name="brewPiLessEnabled" <?php  echo $iSpindelDevice->get_brewPiLessEnabled()?"checked":"" ?> onclick="toggleVisibility(this, 'ispindel_brewPiLess')" value=1 />
                            </td>
                    	</tr>
                        <tr id="ispindel_brewPiLess" style="display:<?php echo $iSpindelDevice->get_brewPiLessEnabled()?"visible":"none"; ?>">
                        	<td style="vertical-align: middle; text-align: left;">&bull;BrewPiLess Address</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="text" class="smallbox" name="brewPiLessAddress" value="<?php echo $iSpindelDevice->get_brewPiLessAddress(); ?>" />
                            </td>
                    	</tr>
                        <tr>
                        	<td style="vertical-align: middle; text-align: left;">CraftBeerPi Logging Enabled</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="checkbox" name="craftBeerPiEnabled" <?php  echo $iSpindelDevice->get_craftBeerPiEnabled()?"checked":"" ?> onclick="toggleVisibility(this, 'ispindel_craftBeerPi')" value=1 />
                            </td>
                    	</tr>
                        <tr id="ispindel_craftBeerPi" style="display:<?php echo $iSpindelDevice->get_craftBeerPiEnabled()?"visible":"none"; ?>">
                        	<td style="vertical-align: middle; text-align: left;">&bull;CraftBeerPi Address</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="text" class="smallbox" name="craftBeerPiAddress" value="<?php echo $iSpindelDevice->get_craftBeerPiAddress(); ?>" />
                            </td>
                    	</tr>
                        <tr id="ispindel_craftBeerPi" style="display:<?php echo $iSpindelDevice->get_craftBeerPiEnabled()?"visible":"none"; ?>">
                        	<td style="vertical-align: middle; text-align: left;">&bull;CraftBeerPi Send Raw Angle</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="checkbox" name="craftBeerPiSendAngle" <?php  echo $iSpindelDevice->get_craftBeerPiSendAngle()?"checked":"" ?> value=1 />
                            </td>
                    	</tr>
                        <tr>
                        	<td style="vertical-align: middle; text-align: left;">BrewSpy Logging Enabled</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="checkbox" name="brewSpyEnabled" <?php  echo $iSpindelDevice->get_brewSpyEnabled()?"checked":"" ?> onclick="toggleVisibility(this, 'ispindel_brewSpy')" value=1 />
                            </td>
                    	</tr>
                        <tr id="ispindel_brewSpy" style="display:<?php echo $iSpindelDevice->get_brewSpyEnabled()?"visible":"none"; ?>">
                        	<td style="vertical-align: middle; text-align: left;">&bull;BrewSpy Address</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="text" class="smallbox" name="brewSpyAddress" value="<?php echo $iSpindelDevice->get_brewSpyAddress(); ?>" />
                            </td>
                    	</tr>
                        <tr id="ispindel_brewSpy" style="display:<?php echo $iSpindelDevice->get_brewSpyEnabled()?"visible":"none"; ?>">
                        	<td style="vertical-align: middle; text-align: left;">&bull;BrewSpy Port</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="number" class="smallbox" name="brewSpyPort" step="1.0" value=<?php echo $iSpindelDevice->get_brewSpyPort(); ?> />
                            </td>
                    	</tr>
                        <tr id="ispindel_brewSpy" style="display:<?php echo $iSpindelDevice->get_brewSpyEnabled()?"visible":"none"; ?>">
                        	<td style="vertical-align: middle; text-align: left;">&bull;BrewSpy Use iSpindel Token</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="checkbox" name="brewSpyUseiSpindelToken" <?php  echo $iSpindelDevice->get_brewSpyUseiSpindelToken()?"checked":"" ?> onclick="toggleVisibility(this, 'ispindel_brewSpyUseiSpindelToken', true)" value=1 />
                            </td>
                    	</tr>
                        <tr id="ispindel_brewSpyUseiSpindelToken" style="display:<?php echo $iSpindelDevice->get_brewSpyEnabled() && !$iSpindelDevice->get_brewSpyUseiSpindelToken()?"visible":"none"; ?>">
                        	<td style="vertical-align: middle; text-align: left;">&bull;BrewSpy Token</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="text" class="smallbox" name="brewSpyToken" value="<?php echo $iSpindelDevice->get_brewSpyToken(); ?>" />
                            </td>
                    	</tr>
                        <tr>
                        	<td style="vertical-align: middle; text-align: left;">BrewFather Logging Enabled</td>
                            <td style="width:30%; vertical-align: middle; align-content: center">
								<input type="checkbox" name="brewFatherEnabled" <?php  echo $iSpindelDevice->get_brewFatherEnabled()?"checked":"" ?> onclick="toggleVisibility(this, 'ispindel_brewFather')" value=1 />
                            </td>
                    	</tr>
                        <tr id="ispindel_brewFather" style="display:<?php echo $iSpindelDevice->get_brewFatherEnabled()?"visible":"none"; ?>">
                        	<td style="vertical-align: middle; text-align: left;">&bull;BrewFather Address</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="text" class="smallbox" name="brewFatherAddress" value="<?php echo $iSpindelDevice->get_brewFatherAddress(); ?>" />
                            </td>
                    	</tr>
                        <tr id="ispindel_brewFather" style="display:<?php echo $iSpindelDevice->get_brewFatherEnabled()?"visible":"none"; ?>">
                        	<td style="vertical-align: middle; text-align: left;">&bull;BrewFather Port</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="number" class="smallbox" name="brewFatherPort" step="1.0" value=<?php echo $iSpindelDevice->get_brewFatherPort(); ?> />
                            </td>
                    	</tr>
                        <tr id="ispindel_brewFather" style="display:<?php echo $iSpindelDevice->get_brewFatherEnabled()?"visible":"none"; ?>">
                        	<td style="vertical-align: middle; text-align: left;">&bull;BrewFather Use iSpindel Token</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="checkbox" name="brewFatherUseiSpindelToken" <?php  echo $iSpindelDevice->get_brewFatherUseiSpindelToken()?"checked":"" ?> onclick="toggleVisibility(this, 'ispindel_brewFatherUseiSpindelToken', true)" value=1 />
                            </td>
                    	</tr>
                        <tr id="ispindel_brewFatherUseiSpindelToken" style="display:<?php echo $iSpindelDevice->get_brewFatherEnabled() && !$iSpindelDevice->get_brewFatherUseiSpindelToken()?"visible":"none"; ?>">
                        	<td style="vertical-align: middle; text-align: left;">&bull;BrewFather Token</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="text" class="smallbox" name="brewFatherToken" value="<?php echo $iSpindelDevice->get_brewFatherToken(); ?>" />
                            </td>
                    	</tr>
                        <tr id="ispindel_brewFather" style="display:<?php echo $iSpindelDevice->get_brewFatherEnabled()?"visible":"none"; ?>">
                        	<td style="vertical-align: middle; text-align: left;">&bull;BrewFather Suffix</td>
                            <td style="width:30%; vertical-align: middle;">
								<input type="text" class="smallbox" name="brewFatherSuffix" value="<?php echo $iSpindelDevice->get_brewFatherSuffix(); ?>" />
                            </td>
                    	</tr>
            			<tr>
            				<td colspan="2">
            					<input name="save" type="submit" class="btn" value="Save" />
            					<input type="button" class="btn" value="Cancel" onclick="window.location='iSpindel_device_list.php'" />
            				</td>
            			</tr>		
                </tbody>						
    			</table>
        		<br />
        		<div align="right">			
        			&nbsp; &nbsp; 
        		</div>
            </form>
		</div>
	</div>
	<!-- Start Footer -->
	<?php
	include 'footer.php';
	?>
	<!-- End Footer -->
</div>
	<!-- End On Tap Section -->
	<!-- Right Side/Main Content End -->
	<!-- Start Left Bar Menu -->
<?php
include 'left_bar.php';
?>
	<!-- End Left Bar Menu -->
	<!-- Start Js  -->
	<script type="text/javascript">
function toggleVisibility(btn, row)
{
	$("[id*="+row+"]").toggle();
}
	</script>
<?php
require_once 'scripts.php';
?>

	<!-- End Js -->
	<!--[if IE 6]>
	<script type='text/javascript' src='scripts/png_fix.js'></script>
	<script type='text/javascript'>
	DD_belatedPNG.fix('img, .notifycount, .selected');
	</script>
	<![endif]-->
</body>
</html>
