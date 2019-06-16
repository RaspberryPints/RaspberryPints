<?php
	require_once __DIR__.'/header.php';
	require_once __DIR__.'/../admin/includes/managers/config_manager.php';	
	require_once __DIR__.'/includes/managers/tapEvent_manager.php'; 
	require_once __DIR__.'/includes/managers/tap_manager.php'; 
	require_once __DIR__.'/includes/managers/beer_manager.php'; 
	require_once __DIR__.'/includes/managers/user_manager.php';
	require_once __DIR__.'/includes/managers/keg_manager.php';
	require_once __DIR__.'/../includes/functions.php';
	$htmlHelper = new HtmlHelper();
	$config = getAllConfigs();
	$beerColSpan = 1;
	$i = 0;
	$totalPoured = 0;
	
	$tapManager  = new TapManager();
	$beerManager = new BeerManager();
	$userManager = new UserManager();
	$kegManager = new KegManager();
	$tapList   = $tapManager->GetAll();
	$beerList  = $beerManager->GetAll();
	$userList  = $userManager->GetAll();
	$kegList   = $kegManager->GetAll();
	
	$groupBy 	= (isset($_POST['groupBy'])?$_POST['groupBy']:"tapId");
	$startTime 	= (isset($_POST['startDate'])?$_POST['startDate']:"");
	$endTime   	= (isset($_POST['endDate'])?$_POST['endDate']:"");
	$beerId 	= (isset($_POST['beerId'])?$_POST['beerId']:"");
	$tapId 	    = (isset($_POST['tapId'])?$_POST['tapId']:"");
	$kegId 	    = (isset($_POST['kegId'])?$_POST['kegId']:"");
	$userId 	= (isset($_POST['userId'])?$_POST['userId']:"");
	
	$changed = (isset($_POST['queryChanged'])?$_POST['queryChanged']:FALSE);
	
	$totalRows = (isset($_POST['totalRows'])?$_POST['totalRows']:0);
	$page = (isset($_POST['page'])?$_POST['page']:1);
	$maxPage =  (isset($_POST['maxPage'])?$_POST['maxPage']:1);
	$page = min($page, $maxPage);
	if($changed) $page = 1;
	$rowsPerPage = $config[ConfigNames::DefaultRowsPerPage] ;
	$tapEventManager = new TapEventManager();
	$events = $tapEventManager->getTapEventsFiltered($page, $rowsPerPage, $totalRows, $groupBy, $startTime, $endTime, $tapId, $beerId, $userId, $kegId);
	$numberOfEvents = 0;//count($events);
	$maxPage = ceil(($totalRows)/$rowsPerPage);
	
	$beerColSpan = 1;
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
			<li class="current">Tap History</li>            
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
								echo $htmlHelper->ToSelectList("beerId", "beerId", $beerList, "name", "id", $beerId, "All");
							?>
                        </td>
                     </tr>
                    <tr>
                        <td>Keg:</td>
                        <td>
                        	<?php 
                        	   echo $htmlHelper->ToSelectList("kegId", "kegId", $kegList, "label", "id", $kegId, "All");
							?>
                        </td>
                        <td>User:</td>
                        <td>
                        	<?php 
                        	   echo $htmlHelper->ToSelectList("userId", "userId", $userList, "userName", "id", $userId, "All");
							?>
                        </td>
                     </tr>
              	</table>
                <input type="submit" name="filter" class="btn" value="Apply" />
			</form>
            </div>
			<div class="headings alt">
				<h2>Tap History</h2>
			</div>
			<!-- Start On Keg Section -->
			<table style="width:100%">
            	<thead>
            		<tr>
            				<th class="poursdate">
            					Date
            				</th>
            				<th class="poursuser">
            					TYPE
            				</th>
            				<th class="pourstap-num">
            					TAP
            				</th>
            				<th class="poursuser">
            					KEG
            				</th>
            				<th class="poursbeername">
            					BEER
            				</th>
            				<th class="poursamount">
            					Amount In Keg<br/> (<?php echo $config[ConfigNames::DisplayUnitVolume]; ?>)
            				</th>
            				<th class="poursuser">
            					User
            				</th>
            		</tr>
            	</thead>
            	<tbody>
			<?php 
                $i=0;
    			foreach($events as $event) {
			         $i++;
		    ?>
				<tr class="<?php if($i%2 > 0){ echo 'altrow'; }?>">
    				<td class="poursdate">
    					<h2><?php echo $event->get_createdDate(); ?></h2>
    				</td>         
					<td class="poursuser">
						<h2><?php echo $event->get_typeDesc(); ?></h2>
					</td>     
					<td class="pourstap-num">
                    <span class="tapcircle" <?php if($event->get_tapRgba()) echo "style=\"background-color: ".$htmlHelper->CreateRGB($event->get_tapRgba())."\""; ?>> 
						<?php echo $event->get_tapNumber(); ?>
                    </span>
					</td>	           
					<td class="poursuser">
						<h2><?php echo $event->get_kegName(); ?></h2>
					</td>   				
					<td class="poursbeername" <?php if($beerColSpan > 1){ echo 'style="border-left: none;"'; } ?>>	
						<h1><?php echo $event->get_beerName(); ?></h1>
					</td>							
                    <td class="poursamount">
                        <h2><?php echo $tapEventManager->getDisplayAmount($event->get_amount(), $event->get_amountUnit()) ; ?></h2>
                        <?php if($event->get_newAmount()){?>
                        <h2>(<?php echo $tapEventManager->getDisplayAmount($event->get_amount(), $event->get_amountUnit())-$tapEventManager->getDisplayAmount($event->get_newAmount(), $event->get_newAmountUnit()) ; ?>)</h2>
                        <?php } ?>
                    </td>              
					<td class="poursuser">
						<h2><?php echo $event->get_userName(); ?></h2>
					</td>
				</tr>
				
		<?php } ?>             
					<?php include "includes/paginateTableRow.php"; ?> 
                  </tbody>
          	</table>
          	  
           	<?php //Dont want to display right now 
           	    if($numberOfEvents > 0){ 
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
	<?php if($numberOfEvents > 0){ ?>
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
	function getGroupValue($groupBy, $event){
	    $ret = NULL;
	    if(isset($groupBy)){
	        switch ($groupBy){
	            case 'tapId':
	                $ret = $event->get_tapNumber();
	                break;
	            case 'beerId':
	            case 'beerStyle':
	                $ret = $event->get_beerName();
	                break;
	            default:
	                $ret = $event->get_userName();
	        }
	    }
	    if($ret == '')$ret='undefined';
	    return $ret;	    
	}
	    $groups = array();

	    if($groupBy != 'tapId'){
    	    foreach ($events as $event){ 
    	        if(!in_array(getGroupValue($groupBy, $event), $groups)) array_push($groups, getGroupValue($groupBy, $event));
    	    }
	    }else{
	        $groups[0] = 'Gallons';
	    }

    	$taps = array();
	    foreach ($events as $event){
	        if(!in_array($event->get_tapId(), $taps))
	        {
	            $taps[$event->get_tapId()] = array();
	            array_push($taps[$event->get_tapId()], $event);
	            foreach ($groups as $group){
	                if(!in_array($group, $taps[$event->get_tapId()])){
	                    $taps[$event->get_tapId()]["-99"] = $event->get_tapNumber();
	                    $taps[$event->get_tapId()][$group] = NULL;
	                    foreach ($events as $temp){
	                        if( $temp->get_tapId() != $event->get_tapId() ) continue;
	                        if( $groupBy != 'tapId' && getGroupValue($groupBy, $temp) != $group )continue;
	                        $taps[$event->get_tapId()][$group] = $temp;
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
                    ['Tap' <?php foreach($groups as $group) echo ", '".$group."'"; ?> ]
                    <?php foreach ($taps as $tap=>$events){ 
                        echo ",[";
                        echo $events["-99"];
                        foreach ($groups as $group){
                            echo ", ".number_format($pours&&$pours[$group]?floatval(preg_replace("/[^0-9|^\.]/", "", $pours[$group]->get_amountPouredDisplay(TRUE))):0, 2, '.', '');
                        }
                        echo "]";
                    }
                    ?>
    
                  ]);
        
                var options = {
                  title: 'Taps Pouring'
                };
        
                var chart = new google.charts.Bar(document.getElementById('chart_div'));
                chart.draw(data, google.charts.Bar.convertOptions(options));
              }

              
            </script>
        <?php } ?>
    <!-- End Js -->
</body>
</html>
