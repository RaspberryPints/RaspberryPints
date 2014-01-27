<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
	header("location:index.php");
}

require_once 'includes/conn.php';
require_once '../includes/config_names.php';

require_once 'includes/html_helper.php';
require_once 'includes/functions.php';

require_once 'includes/models/keg.php';
require_once 'includes/models/kegType.php';
require_once 'includes/models/kegStatus.php';

require_once 'includes/managers/keg_manager.php';
require_once 'includes/managers/kegStatus_manager.php';
require_once 'includes/managers/kegType_manager.php';

$kegManager = new KegManager();
$kegStatusManager = new KegStatusManager();
$kegTypeManager = new KegTypeManager();

$kegs = $kegManager->getAll();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>RaspberryPints</title>
<link href="styles/layout.css" rel="stylesheet" type="text/css" />
<link href="styles/wysiwyg.css" rel="stylesheet" type="text/css" />
	<!-- Theme Start -->
<link href="styles.css" rel="stylesheet" type="text/css" />
	<!-- Theme End -->
<link href='http://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
</head>
	<!-- Start Header  -->
<?php
include 'header.php';
?>
	<!-- End Header -->
        
    <!-- Top Breadcrumb Start -->
    <div id="breadcrumb">
    	<ul>	
        	<li><img src="img/icons/icon_breadcrumb.png" alt="Location" /></li>
        	<li><strong>Location:</strong></li>
            <li class="current">Keg List</li>            
        </ul>
    </div>
    <!-- Top Breadcrumb End --> 
     
    <!-- Right Side/Main Content Start -->
    <div id="rightside">
		 <div class="contentcontainer med left">		
			<!-- Start On Tap Section -->
			
			<input type="submit" class="btn" value="Add Keg" onclick="window.location='keg_form.php'" />
			<br/><br/>
			
			<table width="950" border="0" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th>Name</th>
						<th>Keg Type</th>
						<th>Make</th>
						<th>Model</th>
						<th>Serial</th>
						<th>Stamped Owner</th>
						<th>Stamped Loc</th>
						<th>Notes</th>
						<th>Status</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php 
						if( count($kegs) == 0 ){  
					?>
							<tr><td class="no-results" colspan="99">No kegs</td></tr>
					<?php 
						}else{  
							for($c = 1; $c <= count($kegs); $c++ ){ 
								$keg = $kegs[$c];
								
								if( $keg->get_kegStatusCode() != null ){
									$kegStatus = $kegStatusManager->GetByCode($keg->get_kegStatusCode());
								}else{
									$kegStatus = new KegStatus();
								}
								
								if( $keg->get_kegTypeId() != null ){
									$kegType = $kegTypeManager->GetById($keg->get_kegTypeId());
								}else{
									$kegType = new KegType();
								}
					?>
								<tr>
									<td>
										<?php echo $keg->get_label() ?>
									</td>
									
									<td>							
										<?php echo $kegType->get_name() ?>
									</td>
									
									<td>
										<?php echo $keg->get_make() ?>
									</td>
									
									<td>							
										<?php echo $keg->get_model() ?>
									</td>
									
									<td>							
										<?php echo $keg->get_serial() ?>
									</td>
									
									<td>
										<?php echo $keg->get_stampedOwner() ?>
									</td>
																
									<td>
										<?php echo $keg->get_stampedLoc() ?>
									</td>
									
									<td>
										<?php echo $keg->get_notes() ?>
									</td>
									
									<td>
										<?php echo $kegStatus->get_name() ?>
									</td>
									
									<td>
										<input name="editTap" type="submit" class="btn" value="Edit" onclick="window.location='keg_form.php?id=<?php echo $keg->get_id()?>'" />
									</td>
									
								</tr>
					<?php 
							} 
						}
					?>
				</tbody>
			</table>
		</div>
    </div>
	<!-- End On Tap Section -->

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
</body>
</html>