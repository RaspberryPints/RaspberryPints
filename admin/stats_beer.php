<?php
	require_once __DIR__.'/header.php';
	require_once __DIR__.'/../admin/includes/managers/config_manager.php';	
	require_once __DIR__.'/includes/managers/pour_manager.php'; 
	require_once __DIR__.'/includes/managers/tap_manager.php'; 
	require_once __DIR__.'/includes/managers/beer_manager.php'; 
	//require_once __DIR__.'/includes/managers/user_manager.php';
	require_once __DIR__.'/../includes/functions.php';
	$htmlHelper = new HtmlHelper();
	$config = getAllConfigs();
	/** @var mixed $beerColSpan */
	$beerColSpan = 1;
	/** @var mixed $i */
	$i = 0;
	/** @var mixed $totalPoured */
	$totalPoured = 0;
	
	$tapManager  = new TapManager();
	$beerManager = new BeerManager();
	//$userManager = new UserManager();
	$beerStyleManager = new BeerStyleManager();
	$tapList   = $tapManager->GetAll();
	$beerList  = $beerManager->GetAllWithBatches();
	//$userList  = $userManager->GetAll();
	$styleList = $beerStyleManager->GetDistinctNamesFromPours();
	
	$groupBy 	= (isset($_POST['groupBy'])?$_POST['groupBy']:"beerId");
	$startTime 	= (isset($_POST['startDate'])?$_POST['startDate']:"");
	$endTime   	= (isset($_POST['endDate'])?$_POST['endDate']:"");
	if(isset($_POST['beerId'])){
	    $beerExploded = explode("~", $_POST['beerId']);
	    $beerId 	= $beerExploded[0];
	    $beerBatchId = $beerExploded[1];
	}else{
	    $beerId 	= "";
	    $beerBatchId = "";	   
	}
	$tapId 	    = (isset($_POST['tapId'])?$_POST['tapId']:"");
	$style  	= (isset($_POST['beerStyle'])?$_POST['beerStyle']:NULL);
	
	$changed = (isset($_POST['queryChanged'])?$_POST['queryChanged']:FALSE);
	
	$totalRows = (isset($_POST['totalRows'])?$_POST['totalRows']:0);
	$page = (isset($_POST['page'])?$_POST['page']:1);
	$maxPage =  (isset($_POST['maxPage'])?$_POST['maxPage']:1);
	$page = min($page, $maxPage);
	if($changed) $page = 1;
	$rowsPerPage = $config[ConfigNames::DefaultRowsPerPage] ;
	$pourManager = new PourManager();
	$pours = $pourManager->getPoursByBeerFiltered($page, $rowsPerPage, $totalRows, $groupBy, $startTime, $endTime, $tapId, $beerId, $beerBatchId, NULL, $style);
	/** @var mixed $numberOfPours */
	$numberOfPours = count($pours);
	$maxPage = ceil(($totalRows)/$rowsPerPage);
	
	//setup config to display what we want it to
	$config[ConfigNames::ShowPourTapNumCol] = FALSE;
	$config[ConfigNames::ShowPourDate] = FALSE;
	$config[ConfigNames::ShowPourBeerImages] = FALSE;
	$config[ConfigNames::ShowPourBeerName] = TRUE;
	$config[ConfigNames::ShowPourBreweryImages] = FALSE;
	$config[ConfigNames::ShowPourAmount] = TRUE;
	$config[ConfigNames::ShowPourUserName] = FALSE;
	switch ($groupBy){
	    case 'userId':
	        $config[ConfigNames::ShowPourUserName] = TRUE;
	        break;
	    case 'beerStyle':
	        $config[ConfigNames::PourBeerCol] = "STYLE";
	        break;
	    case 'tapId':
	        $config[ConfigNames::ShowPourTapNumCol] = TRUE;
	        break;
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
			<li class="current">Beer Statistics</li>            
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
                        <td>Tap:</td>
                        <td>
                        	<?php 
                        	   echo $htmlHelper->ToSelectList("tapId", "tapId", $tapList, "tapNumber", "id", $tapId, "All");
							?>
                        </td>
                        <td>Beer:</td>
                        <td>
                        	<?php 
        						$str = "<select id='beerId' name='beerId' class=''>\n";
        						$str .= "<option value=''>All</option>\n";
        						foreach($beerList as $item){
        						    if( !$item ) continue;
        						    $sel = "";
        						    if( $beerId != "" && $beerId == ($item->get_beerBatchId()<=0?$item->get_id():$item->get_beerId()) && (($beerBatchId == "" && $item->get_beerBatchId()<=0) || $beerBatchId == $item->get_beerBatchId()) )  $sel .= "selected ";
        						    $desc = $item->get_displayName();
        						    $str .= "<option value='".($item->get_beerBatchId()<=0?$item->get_id():$item->get_beerId())."~".$item->get_beerBatchId()."~".$item->get_fg()."~".$item->get_fgUnit()."' ".$sel.">".$desc."</option>\n";
        						}
        						$str .= "</select>\n";
        						
        						echo $str;
								//echo $htmlHelper->ToSelectList("beerId", "beerId", $beerList, "name", "id", $beerId, "All");
							?>
                        </td>
                     </tr>
                     <tr>
                        <td>Style:</td>
                        <td>
                        	<?php 
								echo $htmlHelper->ToSelectList("beerStyle", "beerStyle", $styleList, "name", "name", $style, "All");
							?>
                        </td>
                        <td>Group By:</td>
                        <td>
		         			<input type="radio" name="groupBy" value="beerId" checked/>Beer
		         			<input type="radio" name="groupBy" value="tapId" <?php echo $_POST['groupBy'] == 'tapId'?"checked":""; ?>/>Tap
		         			<input type="radio" name="groupBy" value="userId" <?php echo $_POST['groupBy'] == 'userId'?"checked":""; ?>/>User
		         			<input type="radio" name="groupBy" value="beerStyle" <?php echo $_POST['groupBy'] == 'beerStyle'?"checked":""; ?>/>Style
		         		</td>
                    </tr>
              	</table>
                <input type="submit" name="filter" class="btn" value="Apply" />
			</form>
            </div>
			<div class="headings alt">
				<h2>Beer Statistics</h2>
			</div>
			<!-- Start On Keg Section -->
			
            <?php
				include  __DIR__.'/../includes/pourListTable.php';
			?>
			<table>
					<?php include "includes/paginateTableRow.php"; ?> 
            </table>
                    
           	<?php //Dont want to display right now 
           	    if(count($pours) > 0){ 
           	?>
				<div id="chart_div" style="width: 900px; height: 500px;"></div>
			<?php } ?> 
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
	<?php if(count($pours) > 0){ ?>
	<?php
	function getFriendlyGroupName($groupBy){
	    if(isset($groupBy)){
	        switch ($groupBy){
	            case 'tapId':
	                return 'Tap Number';
	            case 'beerId':
	                return 'Beer';
	            case 'beerStyle':
	                return 'Style';
	            default:
	               return 'User';
	        }
	    }
	    return '';
	}
	function getGroupValue($groupBy, $pour){
	    $ret = NULL;
	    if(isset($groupBy)){
	        switch ($groupBy){
	            case 'tapId':
	                $ret = $pour->get_tapNumber();
	                break;
	            case 'beerId':
	            case 'beerStyle':
	                $ret = $pour->get_beerName();
	                break;
	            default:
	                $ret = $pour->get_userName();
	        }
	    }
	    if($ret == '')$ret='undefined';
	    return $ret;	    
	}
	    $groups = array();

	    if($groupBy != 'beerId' && $groupBy != 'beerStyle'){
    	    foreach ($pours as $pour){ 
    	        if(!in_array(getGroupValue($groupBy, $pour), $groups)) array_push($groups, getGroupValue($groupBy, $pour));
    	    }
	    }else{
	        $groups[0] = (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?'Gallons':'Liters');
	    }

    	$beers = array();
	    foreach ($pours as $pour){
	        if(!in_array($pour->get_beerId(), $beers))
	        {
	            $beers[$pour->get_beerId()] = array();
	            array_push($beers[$pour->get_beerId()], $pour);
	            foreach ($groups as $group){
	                if(!in_array($group, $beers[$pour->get_beerId()])){
	                    $beers[$pour->get_beerId()]["-99"] = $pour->get_beerName();
	                    foreach ($pours as $temp){
	                        if( $temp->get_beerId() != $pour->get_beerId() ) continue;
	                        if( $groupBy != 'beerId' &&  $groupBy != 'beerStyle' && getGroupValue($groupBy, $temp) != $group )continue;
	                        $beers[$pour->get_beerId()][$group] = $temp;
                            break;
	                    }
                    }
	            }
	        }
	    }
	?>
    		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load('current', {'packages':['bar']});
                google.charts.setOnLoadCallback(drawChart);
                
              function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Beer' <?php foreach($groups as $group) echo ", '".$group."'"; ?> ]
                    <?php  /** @var mixed $beer */ 
                    foreach ($beers as $beer=>$pours){ 
                        echo ",[";
                        echo "'".$pours["-99"]."'";
                        foreach ($groups as $group){
                            echo ", ".number_format($pours&&$pours[$group]?floatval(preg_replace("/[^0-9|^\.]/", "", $pours[$group]->get_amountPouredDisplay(TRUE))):0, 2, '.', '');
                        }
                        echo "]";
                    }
                    ?>
    
                  ]);
        
                var options = {
                  title: 'Beers Poured'
                };
        
                var chart = new google.charts.Bar(document.getElementById('chart_div'));
                chart.draw(data, google.charts.Bar.convertOptions(options));
              }
            </script>
        <?php } ?>
    <!-- End Js -->
</body>
</html>
