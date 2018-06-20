<?php
	require_once __DIR__.'/header.php';
	require_once __DIR__.'/../admin/includes/managers/config_manager.php';	
	require_once __DIR__.'/includes/managers/pour_manager.php'; 
	require_once __DIR__.'/includes/managers/tap_manager.php'; 
	require_once __DIR__.'/includes/managers/beer_manager.php'; 
	require_once __DIR__.'/includes/managers/user_manager.php'; 
	$htmlHelper = new HtmlHelper();
	$config = getAllConfigs();
	$beerColSpan = 1;
	$i = 0;
	$totalPoured = 0;
	
	$tapManager  = new TapManager();
	$beerManager = new BeerManager();
	$userManager = new UserManager();
	$tapList  = $tapManager->GetAll();
	$beerList = $beerManager->GetAll();
	$userList = $userManager->GetAll();
	
	$startTime 	= (isset($_POST['startTime'])?$_POST['startTime']:"");
	$endTime   	= (isset($_POST['endTime'])?$_POST['endTime']:"");
	$tapId		= (isset($_POST['tapId'])?$_POST['tapId']:"");
	$beerId 	= (isset($_POST['beerId'])?$_POST['beerId']:"");
	$userId 	= (isset($_POST['userId'])?$_POST['userId']:"");
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
			<li class="current">Pours List</li>            
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer left">
			<?php $htmlHelper->ShowMessage(); ?>
			<div id="settingsDiv">
			<form method="POST">
            	<table>
                    <tr>
                        <td>Start Date:</td>
                        <td><input type="date" name="startDate" value="<?php echo $startTime; ?>"></td>
                        <td>End Date:</td>
                        <td><input type="date" name="endDate" value="<?php echo $endTime; ?>"></td>
                    </tr>    
                    <tr>
                        <td>Tap Number:</td>
                        <td>
                        	<?php 
								echo $htmlHelper->ToSelectList("tapId", "tapId", $tapList, "tapNumber", "id", $tapId, "Select One");
							?>
                        </td>
                        <td>Beer:</td>
                        <td>
                        	<?php 
								echo $htmlHelper->ToSelectList("beerId", "beerId", $beerList, "name", "id", $beerId, "Select One");
							?>
                        </td>
                    </tr>
                    <tr>
                        <td>UserName:</td>
                        <td>
                        	<?php 
								echo $htmlHelper->ToSelectList("userId", "userId", $userList, "userName", "id", $userId, "Select One");
							?>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
              	</table>
                <input type="submit" name="filter" class="btn" value="Apply" />
			</form>
            </div>
			<div class="headings alt">
				<h2>Pour List</h2>
			</div>
			<!-- Start On Keg Section -->
			
            <?php
				$pourManager = new PourManager();
				$poursList = $pourManager->getLastPoursFiltered(100, $startTime, $endTime, $tapId, $beerId, $userId);
			?>
            <table style="width:100%">
            <thead>
                <tr>
                    <?php if($config[ConfigNames::ShowPourDate]){ ?>
                        <th class="poursdate">
                            Date
                        </th>
                    <?php } ?>	
                    <?php if($config[ConfigNames::ShowPourTapNumCol]){ ?>
                        <th class="pourstap-num">
                            TAP
                        </th>
                    <?php } ?>					
                    <?php if($config[ConfigNames::ShowPourBeerName]){ ?>
                        <?php 
                            if($config[ConfigNames::ShowPourBreweryImages]){ $beerColSpan++; }
                            if($config[ConfigNames::ShowPourBeerImages]){ $beerColSpan++; }
                        ?> 
                        <th <?php if($beerColSpan > 1){ echo 'colspan="$beerColSpan"';}?> class="poursbeername">
                            <?php if($config[ConfigNames::ShowPourBeerName]){ ?>
                                BEER 
                            <?php } ?>
                        </th>
                    <?php } ?>			
                    <?php if($config[ConfigNames::ShowPourAmount]){ ?>
                        <th class="poursamount">
                            Amount (<?php echo getConfigValue(ConfigNames::DisplayUnits) ?>)
                        </th>
                    <?php } ?>
                    <?php if($config[ConfigNames::ShowPourUserName]){ ?>
                        <th class="poursuser">
                            User
                        </th>
                    <?php } ?>	
                </tr>
            </thead>
            <tbody>
                <?php foreach($poursList as $pour) {
                    $i++;
                ?>
                	<tr>
                        <td style="vertical-align: middle;">
                            <?php echo $pour->get_createdDate(); ?>
                        </td>
                        
                        <td style="vertical-align: middle;">
                            <?php echo $pour->get_tapNumber(); ?>
                        </td>
                            
                        <?php if($config[ConfigNames::ShowPourBreweryImages]){ ?>
                            <td style="width:150px" >
                            <?php if(isset($pour->get_breweryImageUrl)){ ?>
                                <img class="poursbreweryimg" src="<?php echo $pour->get_beerBreweryImage(); ?>" />
                            <?php } ?>
                            </td>
                        <?php } ?>
                                
                        <?php if($config[ConfigNames::ShowPourBeerImages]){ ?>
                            <td <?php if($beerColSpan > 1){ echo 'style="border-left: none;"'; } ?>>	
                            <?php beerImg($config, $pour->get_beerUntID()); ?>
                            </td>
                        <?php } ?>
                            
                        <td <?php if($beerColSpan > 1){ echo 'style="border-left: none;"'; } ?>>	
                            <?php echo $pour->get_beerName(); ?>
                        </td>
                        
                    	<?php $totalPoured += $pour->get_amountPoured(); ?>	  
                        <td style="vertical-align: middle;">
                            <?php echo $pourManager->getDisplayAmount($pour->get_amountPoured()) ; ?>
                        </td>
                        
                        <td class="poursuser">
                            <h2><?php echo $pour->get_userName(); ?></h2>
                        </td>
                    </tr>
                        
                <?php } ?>
                	<tr>
                        <td style="vertical-align: middle;">
                        </td>
                        
                        <td style="vertical-align: middle;">
                        </td>
                    
                        <?php if($config[ConfigNames::ShowPourBreweryImages]){ ?>
                            <td style="width:150px" >
                            </td>
                        <?php } ?>
                                
                        <?php if($config[ConfigNames::ShowPourBeerImages]){ ?>
                            <td>	
                            </td>
                        <?php } ?>
                                                  
                        <td style="vertical-align: middle;">
                            <?php echo "$totalPoured Gals"; ?>
                        </td>
                                                            
                        <td style="vertical-align: middle;">
                            <?php echo $pourManager->getDisplayAmount($totalPoured); ?>
                        </td>
                    
                        <td class="poursuser">
                        </td>
                    </tr>
            </tbody>
            </table>            
			<!-- Start Footer -->   
			<?php
				include 'footer.php';
			?>
			<!-- End Footer -->
		</div>
	</div>
	
	<!-- End On Keg Section -->
	<!-- Right Side/Main Content End -->
	<!-- Start Left Bar Menu -->   
<?php
include 'left_bar.php';
?>
	<!-- End Left Bar Menu -->  
	<!-- Start Js  -->
    <!-- End Js -->
</body>
</html>
