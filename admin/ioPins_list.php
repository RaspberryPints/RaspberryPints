<?php
/** @var mixed $noHeadEnd */
$noHeadEnd = True;
require_once __DIR__.'/header.php';
?>
<style>
 input.inputBox{
    border: 1px solid #999; 
    padding: 5px; 
    -moz-border-radius: 1px; 
    border-radius: 1px;
 }
</style>
</head>
<?php 
require_once __DIR__.'/includes/managers/ioPin_manager.php';

$htmlHelper = new HtmlHelper();
$ioPinManager = new IoPinManager();

foreach(array_keys($_POST) as $val){

    if(strstr($val, 'delete~')){
        $valArr = explode("~", $val);
        if(count($valArr) > 1) $ioPinManager->DeleteShield($valArr[1]);
        $_POST['edit'] = 'edit';
        break;
    }
}
if (isset ( $_POST ['save'] )) {
    $error = false;
    $ii = 0;
    while(isset($_POST ['ioShield'][$ii]) && isset($_POST ['ioPin'][$ii]))
    {
        $ioPin = new IoPin();
        $ioPin->set_shield($_POST ['ioShield'][$ii]);
        $ioPin->set_pin($_POST ['ioPin'][$ii]);
        $ioPin = $ioPinManager->GetByPk($ioPin);
        if($ioPin && isset($ioPin))
        {
            $ioPin->set_displayPin($_POST['displayPin'][$ii]);
            $ioPin->set_name($_POST['name'][$ii]);
            $ioPin->set_notes($_POST['notes'][$ii]);
            $ioPin->set_rgb($htmlHelper->ColorHextoRGB($_POST['color'][$ii]));
            if(isset($_POST['right'][$ioPin->get_id()]) && $_POST['right'][$ioPin->get_id()] == "1"){
                $ioPin->set_pinSide('right');
            }else{
                $ioPin->set_pinSide('left');                
            }
            if(!$ioPinManager->save($ioPin))$error=true;
        }
        $ii++;
    }
    if(!$error){
        $_SESSION['successMessage'] = "Success";
    }else{
        $_SESSION['successMessage'] = "Changes Could Not Be Saved";
    }
} 

if (isset ( $_POST ['saveNew'] )) {
    $shield = $_POST['newShieldName'];
    $rows = $_POST['newShieldRows'];
    $cols = $_POST['newShieldCols'];
    $pin = 1;
    for( $col = 0; $col < $cols; $col++){
        for( $row = 0; $row < $rows; $row++){
            $ioPin = new IoPin();
            $ioPin->set_shield($shield);
            $ioPin->set_pin($pin);
            $ioPin->set_row($row);
            $ioPin->set_col($col);
            $ioPinManager->Save($ioPin, true);
            $pin++;
        }
    }
    $_POST['edit'] = 'edit';
}
$ioPins = $ioPinManager->GetAll();
$numberofIoPin=count($ioPins);
$shields = array();

function printDisplayPin($ioPin, $currentSide, $editing){
    $pinSide = strtolower($ioPin->get_pinSide());
    if( $pinSide == $currentSide || (empty($ioPin->get_pinSide()) && $currentSide == 'left') ){
		echo '<td style="text-align: '.$pinSide.'">';
		if($editing) echo'<input type="text" style="width:30px" class="inputBox" id="displayPin'.$ioPin->get_id().'" name="displayPin[]" value="';
		echo $ioPin->get_displayPin();
		if($editing) echo '" />';
		echo '</td>';
    }
    //if left then right, if right then left else center
	return ($pinSide=='left'?'right':($pinSide=='right'?'left':'center'));
}
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
			<li class="current">IO Pins</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End -->

	<!-- Right Side/Main Content Start -->
	<div id="rightside">
	<div class="contentcontainer left">
		<div class="headings alt">
			<h2>IO Pins</h2>
		</div>
		<div class="contentbox">
			<?php $htmlHelper->ShowMessage(); ?>
			<?php if(isset($_POST['edit'])) {?>
			<a style="color:#FFF" onClick="toggleSettings(this, 'settingsDiv')" class="collapsed heading">New Shield</a>
		
    		<div id="settingsDiv" class="contentcontainer med" style="<?php echo (isset($_POST['settingsExpanded'])?$_POST['settingsExpanded']:'display:none'); ?>">
    		<form id="saveNew" method="post">
        	<table class="contentbox" style="width:100%; border:0;" >
            	<tr>
                	<td>Name:</td>
                	<td><input type=text class="largebox" id="newShieldName" name="newShieldName"></td>
				</tr>
				<tr>
                	<td>Rows:</td>
                	<td><input type=text class="smallbox" id="newShieldRows" name="newShieldRows"></td>
				</tr>
				<tr>
                	<td>Columns:</td>
                	<td><input type=text class="smallbox" id="newShieldCols" name="newShieldCols"></td>
				</tr>
				<tr>
                	<td colspan="2">
                		<input name="saveNew" type="submit" class="btn" value="Save New Shield" />
                	</td>
				</tr>
            </table>
			</form>  		
    		</div>
    		<?php }?>    		
			<br>
        
	        <?php
                if($numberofIoPin == 0){
                    $ioPins[] = new IoPin();
            ?>
                <br>
                <strong>No IO Found</strong>
                <br>
            <?php 
                }
            ?>
			<form method="POST" id="ioNotes-form">
			<div>
            <?php if(!isset($_POST['edit'])) {?>
           	 	<input name="edit" type="submit" class="btn" value="Edit" />
            <?php }else{?>
            	<input name="save" type="submit" class="btn" value="Save" />
            <?php } ?>
            </div>
            <table>
            	<tr>
            <?php 
                foreach ($ioPins as $ioPin){
                    if(!in_array($ioPin->get_shield(), $shields)){
                        array_push($shields, $ioPin->get_shield());
                    }
                }
                foreach ($shields as $shield){
            ?>
            	<td>
                <table style="width:400px;border-collapse: collapse" id="tableList; color:#000">
                    <thead>
                    <tr><th colspan="1"> <?php echo $shield; ?></th>
                    <th style="text-align: right"><?php if(isset($_POST['edit'])){?><input type="submit" onclick="return confirm('Do you wish to delete shield <?php echo $shield; ?>')" name="delete~<?php echo $shield; ?>" value="X"/><?php }?></th>
                    </tr>
                    </thead>
                    <tbody style="color:#000">
                        <tr> 
                    	<?php
                    	    $row = 1;
                            foreach ($ioPins as $ioPin){
                                if($ioPin->get_shield() != $shield) continue;
                        ?>
                        	<?php
                        	   if($row != intval($ioPin->get_row())) echo '</tr><tr>';
                        	   $row = intval($ioPin->get_row());
                            ?>
                                    <td id="tableData<?php echo $ioPin->get_id()?>" style="width:45%; vertical-align: middle;border: 1px solid black;<?php if(!empty($ioPin->get_rgb())) echo ";background-color: ".$htmlHelper->CreateRGB($ioPin->get_rgb()).";"; ?>">
                                    
                            			<?php 
                            			if(!empty($ioPin->get_name()) || isset($_POST['edit'])) { 
                            			    echo'<input type="hidden" id=ioShield'.$ioPin->get_id().' name="ioShield[]" value="'.$ioPin->get_shield().'"/>';
                            			    echo'<input type="hidden" id=ioPin'.$ioPin->get_id().' name="ioPin[]" value="'.$ioPin->get_pin().'"/>';
                            			?>
                                    	<table>
                                			<?php 
                                			if(isset($_POST['edit'])) {
                                			?>
                                        	<tr>
                                            	<td colspan="2">
                                                	<button class="jscolor {valueElement:'color<?php echo $ioPin->get_id()?>', onFineChange:'setTextColor(this, tableData<?php echo $ioPin->get_id()?>)'}">Color</button>
                                                	<input type="hidden" id="color<?php echo $ioPin->get_id()?>" name="color[]" value="<?php echo !empty($ioPin->get_rgb())?$htmlHelper->CreateRGB($ioPin->get_rgb()):'FFFFFF;'?>">
                                            		Pin Right:<input type="checkbox" id="right<?php echo $ioPin->get_id()?>" name="right[<?php echo $ioPin->get_id();?>]" value="1" <?php echo $ioPin->get_pinSide() == 'right'?'checked':''; ?> />                                            	
                                        		</td>
                                        	</tr>
                                			<?php } ?>
                                    		<tr>
                                    			<?php 
                                    			$textSide = printDisplayPin($ioPin, 'left', isset($_POST['edit']));
                                    			?>
                                    			<td style="width:100%; text-align: <?php echo $textSide ?>;">
                                    			<?php if(isset($_POST['edit'])){
                                			    	echo'<input type="text" class="inputBox" id="name" name="name[]" value="'.$ioPin->get_name().'" />';
                                    			}else{
                                    			    echo $ioPin->get_name()."<br> ".$ioPin->get_hardware(); 
                                    			}?>
                                    			</td>
                                    			<?php 
                                    			$textSide = printDisplayPin($ioPin, 'right', isset($_POST['edit']));
                                				?>
                                    		</tr>
                                    		<tr>
                                    			<td colspan="2">
                                    			<?php 
                                        			if(!isset($_POST['edit'])) {
                                        			    echo $ioPin->get_notes();
                                        			}else{
                                                        echo'<input type="text" style="width:100%" class="inputBox" id="notes" name="notes[]" value="'.$ioPin->get_notes().'" />';
                                        			}
                                                 ?>
                                                </td>
                                    		</tr>
                                    	</table>
                                		<?php }?>
                                    </td>
                        <?php } ?>
                        </tr>
                    </tbody>
                </table>
                </td>
            <?php } ?>
            </tr>
            </table>
            <?php if(!isset($_POST['edit'])) {?>
           	 	<input name="edit" type="submit" class="btn" value="Edit" />
            <?php }else{?>
            	<input name="save" type="submit" class="btn" value="Save" />
            <?php } ?>
            </form>
		</div>
	</div>
	<!-- Start Footer -->
	<?php
	include 'footer.php';
	?>
	<!-- End Footer -->
</div>
<script>
function setTextColor(picker, valueInput) {
	valueInput.style.backgroundColor = '#' + picker.toString()
}
function toggleSettings(callingAnchor, settingsDiv) {
	var div = document.getElementById(settingsDiv);
	if(div != null){
		if(div.style.display == ""){
			div.style.display = "none";
			callingAnchor.style.background = "url(img/bg_navigation.png) no-repeat top;";				
		}else{
			div.style.display = "";
			callingAnchor.style.background = "url(img/bg_navigation.png) 0 -76px;";				
		}
		if(document.getElementById("settingsExpanded")!= null)document.getElementById("settingsExpanded").value = div.style.display;
	}
}
</script>
	<!-- End On Tap Section -->
	<!-- Right Side/Main Content End -->
	<!-- Start Left Bar Menu -->
<?php
include 'left_bar.php';
?>
	<!-- End Left Bar Menu -->
	<!-- Start Js  -->
<?php
require_once 'scripts.php';
?>
	<!--[if IE 6]>
	<script type='text/javascript' src='scripts/png_fix.js'></script>
	<script type='text/javascript'>
	DD_belatedPNG.fix('img, .notifycount, .selected');
	</script>
	<![endif]-->
</body>
</html>
