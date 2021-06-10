<?php
require_once __DIR__.'/header.php';
$htmlHelper = new HtmlHelper();
?>
<body>
	<!-- Start Header  -->
<?php

if (isset ( $_POST ['upgrade'] )) {
    //echo ("restarting flowmon service: ");
    triggerPythonAction("upgrade");
}

include 'top_menu.php';
?>
	<!-- End Header -->

	<!-- Top Breadcrumb Start -->
	<div id="breadcrumb">
		<ul>
			<li><img src="img/icons/icon_breadcrumb.png" alt="Location" /></li>
			<li><strong>Location:</strong></li>
			<li class="current">Manage Install</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End -->

	<!-- Right Side/Main Content Start -->
<div id="rightside">
	<div class="contentcontainer left">
		<div class="headings alt">
			<h2>Manage Install</h2>
		</div>
		<div class="contentbox">
			<?php $htmlHelper->ShowMessage(); ?>
			
			<?php $config = getAllConfigs(); if( $config[ConfigNames::UseFlowMeter] ){ ?>
			<form method="POST">
				<table style="width:300;border:0;cellspacing:1;cellpadding:0;">
					<tbody>
						<tr>
							<td><input type="submit" name="upgrade" class="btn"
								value="Get Latest RPints" onclick="return confirm('Are you sure you want to Upgrade the system?')"/></td>
						</tr>
					</tbody>
				</table>
			</form>
			<?php }?>
			<form action="../install/includes/configprocessor.php" method="post">
			<?php 
			/** @var mixed $host */
			/** @var mixed $db_name */
			/** @var mixed $username */
			/** @var mixed $password */
			?>
				<input type="hidden" value="<?php echo $host; ?>" name="servername"/>				
                <input type="hidden" value="<?php echo $db_name; ?>"  name="database"/>
                <input type="hidden" value="<?php echo $username; ?>" name="rootuser"/>			
                <input type="hidden" value="<?php echo $password; ?>" name="rootpass"/>			
                <input type="hidden" name="dbuser"/>				
                <input type="hidden" name="dbpass1"/>		
                <input type="hidden" name="dbpass2"/>
                <input type="hidden" name="adminuser"/>	
                <input type="hidden" name="adminemail"/>
                <input type="hidden" name="adminnamefirst"/>	
                <input type="hidden" name="adminnamelast"/>
                <input type="hidden" name="adminpass1"/>		
                <input type="hidden" name="adminpass2"/>		
                <input type="hidden" name="adminpass2"/>		
                <input type="hidden" id="selectaction" name="selectaction"/>	
            	<?php
                    $host = "localhost";
                    $username = "";
                    $password = "";
                    $db_name = "raspberrypints";
                    /** @var mixed $tbl_name */
                    $tbl_name = "";
                    
                    include '../admin/includes/conn.php';
                    require_once '../admin/includes/managers/config_manager.php';
                    $config = getAllConfigs();
                ?> 
    			<?php if($_SESSION['showadmin']){?>
    				<div>Last Update:<?php echo (isset($config[ConfigNames::UpdateDate]) && $config[ConfigNames::UpdateDate]?$config[ConfigNames::UpdateDate]:'never'); ?></div><br />
    				<button class="btn" type="submit" value="upgrade" onclick="confirmAndSubmit(this.value, '');">Update</button>
                    <button class="btn" type="submit" value="remove"  onclick="confirmAndSubmit(this.value, 'Are you sure you want to uninstall RaspberryPints?')">Uninstall</button>
                <?php } ?>
                <button class="btn" type="submit" value="backup" onclick="confirmAndSubmit(this.value, '');">Backup</button>
				<?php if($_SESSION['showadmin']){?>
        			<br /><br />
					<?php 
					    $backups = array();
    					if(file_exists(__DIR__.'/../sql/backups')) $backups = scandir (__DIR__.'/../sql/backups');
    					$files = array();
    					if($backups){
    					    foreach($backups as $file){
    					        if(substr($file, -4) === '.sql') $files[] = $file;   
    					    }
    					}
    					if(count($files) > 0){
    			     ?>
    			     		<select name="fileRestore">
        					<?php  
        					   foreach($files as $file){
        					        echo "<option>".$file."</option>";  
        					    }
            			     ?>
    			     		</select>
            				<button class="btn" type="submit" id="btnRestore" value="restore" onclick="confirmAndSubmit(this.value, 'Are you sure you want to overwrite current installation?')">Restore</button>
					<?php  } ?>
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
<script type="text/javascript">
    function confirmAndSubmit(value, confirmText){
      if(confirmText == "" || confirm(confirmText)){  
    	  document.getElementById('selectaction').value = value;
      }else{
		return false;
      }
    }
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
