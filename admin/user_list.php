<?php
require_once __DIR__.'/header.php';
require_once __DIR__.'/includes/managers/user_manager.php';
$config = getAllConfigs();
$htmlHelper = new HtmlHelper();
$userManager = new UserManager();

if (isset($_POST['inactivateUser'])) {
	$userManager->Inactivate($_POST['id']);
}

$showAll = (isset($_GET['showAll']) && $_GET['showAll'] == "yes");

if($showAll){
	$users = $userManager->GetAll();
}else{
	$users = $userManager->GetAllActive();
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
			<li class="current">Users</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End -->

	<!-- Right Side/Main Content Start -->
<div id="rightside">
	<div class="contentcontainer left">
		<div class="headings alt">
			<h2>Users</h2>
		</div>
		<div class="contentbox">

			<!-- Start On Tap Section -->

			<?php $htmlHelper->ShowMessage(); ?>
			<form method="get" action="user_list.php">
            	<input type="checkbox" name="showAll" onClick="submit();" value="yes" <?php if($showAll)echo "checked" ?>>Show All (Includes Inactive) </input>
            </form>
			<br/>
			<input type="submit" class="btn" value="Add User" onClick="window.location='user_form.php'" />
			<br/><br/>

			<table style="padding:0px" class="outerborder">

				<tbody>
					<tr class="intborder">
			                        <th style="width:15%; vertical-align: middle;">User Name</th>
			                        <th style="width:15%; vertical-align: middle;">First Name</th>
			                        <th style="width:15%; vertical-align: middle;">Last Name</th>
			                        <th style="width:20%; vertical-align: middle;">Email</th>
			                        <th style="width:8%;  vertical-align: middle;">Mug ID</th>
			                        <th style="width:10%; vertical-align: middle;">Admin</th>
           							<?php if($config[ConfigNames::UseRFID]){ ?>
			                        	<th style="width:10%; vertical-align: middle;">RFIDs</th>
                                    <?php } ?>
                                    <?php if($showAll){?>
			                        	<th style="width:10%; vertical-align: middle;">Active</th>
                                    <?php } ?>
			                        <th style="width:10%; vertical-align: middle;"></th>
                                    <?php if( count($users) > 1 ){ ?>
			                        <th style="width:10%; vertical-align: middle;"></th>
                                    <?php } ?>
			                        <th style="width:10%; vertical-align: middle;"></th>
                    			</tr>
					<?php
						if( count($users) == 0 ){
					?>
							<tr><td class="no-results" colspan="99">No Users :( Add some?</td></tr>
					<?php
						}else{
							foreach ($users as $user){
					?>
								<tr class="intborder">
									<td vertical-align: middle;">
										<h3><?php echo $user->get_username() ?></h3>
									</td>
									<td style="vertical-align: middle;">
										<?php echo $user->get_namefirst() ?>
									</td>
									<td style="vertical-align: middle;">
										<?php echo $user->get_namelast() ?>
									</td>
									<td style="vertical-align: middle;">
										<?php echo $user->get_email() ?>
									</td>
									<td style="vertical-align: middle;">
										<?php echo $user->get_mugid() ?>
									</td>
									<td style="vertical-align: middle;">
										<?php echo ($user->get_isAdmin()?"Yes":"No") ?>
									</td>
           							<?php if($config[ConfigNames::UseRFID]){ ?>
									<td style="vertical-align: middle;">
										<?php echo $userManager->getRFIDCount($user->get_id()); ?>
									</td>
                                    <?php } ?>                                    
                                    <?php if($showAll){?>
                                        <td style="vertical-align: middle;">
                                            <?php echo ($user->get_active()?"Yes":"No") ?>
                                        </td>
                                    <?php } ?>
									<td style="text-align: center; vertical-align: middle; margin: 0; padding: 0; padding-right:5px">
										<input name="edituser" type="button" class="btn" value="Edit" style="text-align: center; margin: 0;" onClick="window.location='user_form.php?id=<?php echo $user->get_id()?>'" />
									</td>
                                    <?php if( count($users) > 1 ){ ?>
									<td style="text-align: center; vertical-align: middle; margin: 0; padding: 0; padding-right:5px">
										<form method="POST">
											<input type='hidden' name='id' value='<?php echo $user->get_id()?> '/>
											<?php if($user->get_active()){ ?>
                                            	<input class="inactivateUser btn" style="text-align: center; margin: 0;" name="inactivateUser" type="submit" value="Delete" />
                                            <?php } ?>
										</form>
									</td>
                                    <?php } ?>
									<td style="text-align: center; vertical-align: middle; margin: 0; padding: 0; padding-right:5px">
										<input class="btn" style="text-align: center; margin: 0;" name="changeToken" type="submit" value="Change Password" onClick="window.location='user_form.php?changeToken&amp;id=<?php echo $user->get_id()?>'" />
									</td>
								</tr>
					<?php
							}
						}
					?>
				</tbody>
			</table><br>
			<input type="submit" class="btn" value="Add user" onClick="window.location='user_form.php'" />
		</div>
	</div>
	<!-- Start Footer -->
	<?php
	include 'footer.php';
	?>
	<!-- End Footer -->
</div>
</div>
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
<script>
	$(function(){
		$('.inactivateuser').on('click', function(){
			if(!confirm('Are you sure you want to delete this user?')){
				return false;
			}
		});
	});
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
