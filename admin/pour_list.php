<?php
	require_once __DIR__.'/header.php';
	require_once __DIR__.'/../admin/includes/managers/config_manager.php';	
	require_once __DIR__.'/includes/managers/pour_manager.php'; 
	require_once __DIR__.'/includes/managers/tap_manager.php'; 
	require_once __DIR__.'/includes/managers/beer_manager.php'; 
	require_once __DIR__.'/includes/managers/user_manager.php';
	require_once __DIR__.'/../includes/functions.php';
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
	
	$startTime 	= (isset($_POST['startDate'])?$_POST['startDate']:"");
	$endTime   	= (isset($_POST['endDate'])?$_POST['endDate']:"");
	$tapId		= (isset($_POST['tapId'])?$_POST['tapId']:"");
	$beerId 	= (isset($_POST['beerId'])?$_POST['beerId']:"");
	$userId 	= (isset($_POST['userId'])?$_POST['userId']:"");
	
	$changed = (isset($_POST['queryChanged'])?$_POST['queryChanged']:FALSE);
	
	$totalRows = (isset($_POST['totalRows'])?$_POST['totalRows']:0);
	$page = (isset($_POST['page'])?$_POST['page']:1);
	$maxPage =  (isset($_POST['maxPage'])?$_POST['maxPage']:1);
	$page = min($page, $maxPage);
	if($changed)$page = 1;
	$rowsPerPage = $config[ConfigNames::DefaultRowsPerPage] ;
	$pourManager = new PourManager();
	$pours = $pourManager->getLastPoursFiltered($page, $rowsPerPage, $totalRows, $startTime, $endTime, $tapId, $beerId, $userId);
	$numberOfPours = count($pours);
	$maxPage = ceil(($totalRows)/$rowsPerPage);
	
	
	$config[ConfigNames::ShowPourTapNumCol] = TRUE;
	$config[ConfigNames::ShowPourDate] = TRUE;
	$config[ConfigNames::ShowPourAmount] = TRUE;
	$config[ConfigNames::ShowPourBeerName] = TRUE;
	$config[ConfigNames::ShowPourUserName] = TRUE;
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
			<form name="statForm" method="POST">
            	<table>
					<?php include "includes/paginateTableRow.php"; ?> 
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
								echo $htmlHelper->ToSelectList("tapId", "tapId", $tapList, "tapNumber", "id", $tapId, "All");
							?>
                        </td>
                        <td>Beer:</td>
                        <td>
                        	<?php 
								echo $htmlHelper->ToSelectList("beerId", "beerId", $beerList, "name", "id", $beerId, "All");
							?>
                        </td>
                    </tr>
                    <tr>
                        <td>UserName:</td>
                        <td>
                        	<?php 
								echo $htmlHelper->ToSelectList("userId", "userId", $userList, "userName", "id", $userId, "All");
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
				include  __DIR__.'/../includes/pourListTable.php';
			?>
            <table>
					<?php include "includes/paginateTableRow.php"; ?> 
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
	<script type="text/javascript">
    	$("input[type!='hidden']").change(inputChanged);
    	$("select").change(inputChanged);
        function inputChanged(){
        	$("input[name='queryChanged']").val(1)
        }
      	function changePage(newPage){
    		$("input[name='page']").val(newPage);
    		$("input[name^=last]").remove();
    		$(statForm).submit();
    	}
    </script>
    <!-- End Js -->
</body>
</html>
