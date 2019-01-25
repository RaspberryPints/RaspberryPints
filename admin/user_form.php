<?php
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/includes/managers/user_manager.php';
require_once __DIR__.'/../includes/Pintlabs/Service/Untappd.php';

$config = getAllConfigs();
$htmlHelper = new HtmlHelper();
$userManager = new UserManager();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $user->setFromArray($_POST);
    $redirect = false;
    if (! isset($_POST['changeToken'])) {
        $redirect = $userManager->Save($user);
    } else {
        $redirect = $userManager->ChangePassword($user->get_id(), $user->get_password());
    }
    if ($redirect)
        redirect('user_list.php');
}elseif(isset($_GET["untappd"])){
    $ut = new Pintlabs_Service_Untappd($config);
    redirect($ut->authenticateUri());
}
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '')
    $_SESSION['HTTP_REFERER'] = $_SERVER['HTTP_REFERER'];
if (isset($_GET['id'])) {
    $user = $userManager->GetById($_GET['id']);
} else {
    $user = new user();
    $user->setFromArray($_POST);
}

if(isset($_GET["code"])){
    $ut = new Pintlabs_Service_Untappd($config);
    $a = $ut->getAccessToken($_GET["code"]);
    $user->set_unTapAccessToken($a->response->access_token);
}

?>
<!-- Start Header  -->
<body>
<?php
include 'top_menu.php';
?>
	<!-- End Header -->

	<!-- Top Breadcrumb Start -->
	<div id="breadcrumb">
		<ul>
			<li><img src="img/icons/icon_breadcrumb.png" alt="Location" /></li>
			<li><strong>Location:</strong></li>
			<li><a href="user_list.php">My Users</a></li>
			<li>/</li>
			<li class="current">User Form</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End -->

	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer med left">
			<?php $htmlHelper->ShowMessage(); ?>
			<p>
				Fields marked with <b><font color="red">*</font></b> are required.
			</p>
			<br/> <br/>

			<form id="user-form" method="POST">
				<input type="hidden" name="id" value="<?php echo $user->get_id() ?>" />
				<input type="hidden" name="active" value="1" />

				<table style="width: 800; border: 0; cellspacing: 1; cellpadding: 0;">
					<tr>
						<td width="100"><b>User Name:<font color="red">*</font></b></td>
						<td> 
							<?php if(!$user->get_id()){ ?>
                            	<input type="text" id="username"
							class="largebox" name="username"
							value="<?php echo $user->get_username() ?>" />
							<?php }else{ ?>
                            	<p><?php echo $user->get_username() ?></p>
							<input type="hidden" name="username"
							value="<?php echo $user->get_username() ?>" />
							<?php } ?>
                                
                        </td>
					</tr>
    				<?php if(!$user->get_id() || isset($_GET['changeToken']) || $user->get_active() == 0){ ?>
    					<tr>
    						<td width="100"><b>Password:<font color="red">*</font></b>
        						<?php if(isset($_GET['changeToken'])) { ?>
                                	<input type="hidden" name="changeToken" value="1" />
                                <?php } ?>
                            </td>
    						<td><input type="password" id="password" class="largebox"
    							name="password"
    							value="<?php if(!isset($_GET['changeToken']) &&  $user->get_active() != 0)echo $user->get_password() ?>" />
    						</td>
    					</tr>
    					<tr>
    						<td width="100"><b>Confirm Password:<font color="red">*</font></b>
    						</td>
    						<td><input type="password" id="password1" class="largebox"
    							name="password1" value="" />
    							<div class="alert" id="divCheckPasswordMatch"></div></td>
    					</tr>
					<?php } ?>
					<?php if(!isset($_GET['changeToken'])){ ?>
                        <tr>
						<td><b>First Name:</b></td>
						<td><input type="text" id="nameFirst" class="largebox"
							name="nameFirst" value="<?php echo $user->get_nameFirst() ?>" />
						</td>
					</tr>
					<tr>
						<td><b>Last Name:</b></td>
						<td><input type="text" id="nameLast" class="largebox"
							name="nameLast" value="<?php echo $user->get_nameLast() ?>" /></td>
					</tr>
					<tr>
						<td><b>Email:</b></td>
						<td><input type="text" id="email" class="largebox" name="email"
							value="<?php echo $user->get_email() ?>" /></td>
					</tr>
					<tr>
						<td><b>UnTapped Access Token:</b></td>
						<td><input type="text" id="unTapAccessToken" class="largebox"
							name="unTapAccessToken"
							value="<?php echo $user->get_unTapAccessToken() ?>" />
							<?php if($config[ConfigNames::ClientID] && $config[ConfigNames::ClientSecret]){?>
								<a class="btn" href="user_form.php?untappd=true" target="_blank">Retreive</a></td>
							<?php }?>
					</tr>
					<tr>
						<td><b>Mug Id:</b></td>
						<td><input type="text" id="mugId" class="smallbox" name="mugId"
							value="<?php echo $user->get_mugId() ?>" /></td>
					</tr>
					<tr>
						<td><b>Admin:</b></td>
						<td><input type="checkbox" id="isAdmin" class="xsmallbox"
							name="isAdmin" value="1"
							<?php if($user->get_isAdmin() != 0)echo "checked" ?> /></td>
					</tr>
                    <?php } ?>
                    <tr>
						<td colspan="2"><input name="save" type="submit" class="btn"
							value="Save" /> <input type="button" class="btn" value="Cancel"
							onClick="window.location='user_list.php'" /></td>
					</tr>
				</table>
				<br />
				<div align="right">&nbsp; &nbsp;</div>

			</form>   
            <?php if(!isset($_GET['changeToken']) && $config[ConfigNames::UseRFID] && $user->get_id()){ ?> 
            <h1>RFID</h1>
			<table style="width: 500; border: 0; cellspacing: 1; cellpadding: 0;"
				class="outerborder">
				<tr>
					<th>RFID Tag</th>
					<th>Description</th>
					<th></th>
				</tr>
            <?php
                $rfids = $userManager->getRFIDByUserId($user->get_id());
                foreach ($rfids as $rfid) {
                    ?>
                <tr>
					<td>
						<p><?php echo $rfid['RFID'] ?></p>
					</td>
					<td>
                        <form method="post" action="user_rfid_form.php">
                            <input name="userId" id="userId" type="hidden" value="<?php echo $user->get_id() ?>" />  
                            <input name="rfid" type="hidden" value="<?php echo $rfid['RFID'] ?>" />  
                            <table>
                            <tr>
                                <td> 
                           			<input type="text" id="description" class="largebox" name="description" value="<?php echo $rfid['description'] ?>" />
                                </td>
	                            <td>
                                	<input name="saveRFID" type="submit" class="btn" value="Save" />   
                                </td>
                            </tr>
                            </table>
                        </form>                               
					</td>
					<td>
						<form method="post" action="user_rfid_form.php">
                            <input name="userId" id="userId" type="hidden" value="<?php echo $user->get_id() ?>" />  
                            <input name="rfid" type="hidden" value="<?php echo $rfid['RFID'] ?>" />  
                            <input name="deleteRFID" type="submit" class="btn" value="DELETE" />                    
						</form>
					</td>
				</tr>
            <?php } ?>   
                <tr>
                	<td>
                    	<form name="user-rfid-form" method="post" action="user_rfid_form.php">
                		<table>
                    		<tr>
                        		<td>
                            		<input name="userId" id="userId" type="hidden" value="<?php echo $user->get_id() ?>" /> 
                            	</td>
                                <td> 
                                   <input type="text" id="rfid" class="largebox" name="rfid" value="" />
                                </td>
                                <td>
                                   <input type="text" id="description" class="largebox" name="description" value="" />
                                </td>
        						<td>
                                    <input name="addRFID" type="submit" class="btn" value="Add RFID" />
                                </td>
                            </tr>
                        </table>
                   		</form>	
               		</td>
               </tr>	
				<?php
                    $unassignedRfids = $userManager->getRFIDByUserId($userManager->getUnknownUserId()); 
                    if(count($unassignedRfids) > 0)
                    {
                ?>
				<tr>
					<td>
                    	<form name="user-rfid-form" method="post" action="user_rfid_form.php">
    					<table>
    						<tr>
        						<td>
                            		<input name="userId" id="userId" type="hidden" value="<?php echo $user->get_id() ?>" />
                                </td>
                                <td> 
                                	<?php 	
                                        $str = "<select id='rfid' name='rfid'>\n";
                                        $str .= "<option value=''>Unassigned RFIDs</option>\n";
                                        foreach($unassignedRfids as $item){
                                            if( !$item ) continue;
                                            $sel = "";
                                            $rfid = $item['RFID'];
                                            $desc = $item['description'];
                                            $str .= "<option value='".$rfid."'>".$rfid.'-'.$desc."</option>\n";
                                        }					
                                        $str .= "</select>\n";
        									
                                        echo $str;
        							?>                            
                                </td>
                                <td>
                                   <input type="text" id="description" class="largebox" name="description" value="" />
                                </td>
        						<td>
                                    <input name="assignRFID" type="submit" class="btn" value="Assign RFID" />
                                </td>
                            </tr>
						</table>
    					</form>
					</td>
				</tr>
            	<?php } ?> 				
			</table>
			<br />
			<div align="right">&nbsp; &nbsp;</div>
            
            <?php } ?> 
		</div>
		<!-- End On Tap Section -->

		<!-- Start Footer -->   
<?php
require __DIR__ . '/footer.php';
?>

	<!-- End Footer -->

	</div>
	<!-- Right Side/Main Content End -->
	<!-- Start Left Bar Menu -->   
<?php
require __DIR__ . '/left_bar.php';
?>
	<!-- End Left Bar Menu -->
	<!-- Start Js  -->
<?php
require __DIR__ . '/scripts.php';
?>

<script>
	$(function() {		
		
		var password = $("#password").val();
		var confirmPassword = $("#password1").val();
		$('#user-form').validate({
			rules: {
				username: { required: true }
				<?php if(!$user || !$user->get_id() || isset($_GET['changeToken']) || ($user && $user->get_active() == 0)){ ?>
					,password1: { passwordMatch:true}
				<?php } ?>
			}			
		});
		
	});
	jQuery.validator.addMethod( 'passwordMatch', function(value, element) { 
    	var password = $("#password").val();
		var confirmPassword = $("#password1").val();
	  
	    // Check for equality with the password inputs 
	    if (password != confirmPassword ) { 
	         return false; 
	     } else { 
	         return true; 
	     } 	 
	 }, "Your Passwords Must Match"); 

	$(function() {		
		$('#user-rfid-form').validate({
			rules: {
				rfid: { required: true }
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
