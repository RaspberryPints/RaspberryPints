<?php
	require_once __DIR__.'/header.php';
	require_once __DIR__.'/../admin/includes/managers/config_manager.php';	
	require_once __DIR__.'/includes/managers/tempLog_manager.php'; 
	require_once __DIR__.'/includes/managers/tempProbe_manager.php'; 
	$htmlHelper = new HtmlHelper();
	$config = getAllConfigs();
	$beerColSpan = 1;
	$i = 0;
	$totalTemps = 0;
	
	$tempProbeManager  = new TempProbeManager();
	$tempLogManager  = new TempLogManager();
	
	$showHumidity = $tempLogManager->hasHumidityBeenLogged();
	$tempProbes = $tempProbeManager->GetAll();
	if(isset($_POST['reset'])) unset($_POST);
	$startDate 	= (isset($_POST['startDate'])?$_POST['startDate']:"");
	$endDate   	= (isset($_POST['endDate'])?$_POST['endDate']:"");
	$startTime 	= (isset($_POST['startTime'])?$_POST['startTime']:"");
	$endTime   	= (isset($_POST['endTime'])?$_POST['endTime']:"");
	$interval 	= (isset($_POST['timeinterval'])?$_POST['timeinterval']:0);
	if($interval != 0 ){
	    $endDate = date('Y-m-d', strtotime('0 hour'));
	    $endTime = date('H:i:s', strtotime('0 hour'));
	    $startDate = date('Y-m-d', strtotime('-'.$interval.' hour'));
	    $startTime = date('H:i:s', strtotime('-'.$interval.' hour'));
	}
	$probe   	= (isset($_POST['probe'])?$_POST['probe']:"");
	
	$changed = (isset($_POST['queryChanged'])?$_POST['queryChanged']:FALSE);
	
	$totalRows = (isset($_POST['totalRows'])?$_POST['totalRows']:0);
	$page = (isset($_POST['page'])?$_POST['page']:1);
	$maxPage =  (isset($_POST['maxPage'])?$_POST['maxPage']:1);
	$page = min($page, $maxPage);
	if($changed) $page = 1;
	$rowsPerPage = $config[ConfigNames::DefaultRowsPerPage] ;
	$tempList = $tempLogManager->getLastTempsFiltered($page, $rowsPerPage, $totalRows, $startDate.' '.$startTime, $endDate.' '.$endTime, $probe);
	$maxPage = ceil(($totalRows)/$rowsPerPage);
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
			<li class="current">Temperature History</li>            
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
                    <tr id="manDates" <?php echo $interval!=0?'style="display:none;"':''; ?>>
                        <td>Start Date:</td>
                        <td><input type="date" name="startDate" value="<?php echo $startDate; ?>"></td>
                        <td>End Date:</td>
                        <td><input type="date" name="endDate" value="<?php echo $endDate; ?>"></td>
                    </tr>    
                    <tr id="manTimes" <?php echo $interval!=0?'style="display:none;"':''; ?>>
                        <td>Start Time:</td>
                        <td><input type="time" name="startTime" value="<?php echo $startTime; ?>"></td>
                        <td>End Date:</td>
                        <td><input type="time" name="endTime" value="<?php echo $endTime; ?>"></td>
                    </tr>    
                    <tr>
                        <td>Temperature Probe:</td>
                        <td>
                        	<?php 
                        	echo $htmlHelper->ToSelectList("probe", "probe", $tempProbes, "name", "name", $probe, "Select One");
							?>
                        </td>
                        <td>
                        	Interval
                		</td>
                        <td>
                        	<select name="timeinterval" onChange="hideManualInputAsNeeded(this)">
                        		<option value="0" <?php echo ($interval==0?"Selected":""); ?>>Manual</option>
                        		<option value="1" <?php echo ($interval==1?"Selected":""); ?>>last hour</option>
                                <option value="6" <?php echo ($interval==6?"Selected":""); ?>>last 6 hours</option>
                                <option value="12" <?php echo ($interval==12?"Selected":""); ?>>last 12 hours</option>
                                <option value="24" <?php echo ($interval==24?"Selected":""); ?>>last 24 hours</option>
                                <option value="48" <?php echo ($interval==48?"Selected":""); ?>>last two days</option>
                                <option value="168" <?php echo ($interval==168?"Selected":""); ?>>last week</option>
                                <option value="240" <?php echo ($interval==240?"Selected":""); ?>>last 10 days</option>
                        	</select>
                        </td>
                    </tr>
              	</table>
                <input type="submit" name="filter" class="btn" value="Apply" />
                <input type="submit" name="reset" class="btn" value="Reset" />
			</form>
            </div>
			<div class="headings alt">
				<h2>Temperature History</h2>
			</div>
			<!-- Start On Keg Section -->
			
            <?php
                $displayedProbes = array();
                $displayedProbeTemps = array();
                $displayedDateTemps = array();
                foreach ($tempList as $temp){
                    if(!in_array($temp->get_probe(), $displayedProbes)){
                        array_push($displayedProbes, $temp->get_probe());
                    }
                    if(!isset($displayedProbeTemps[$temp->get_probe()])){
                        $displayedProbeTemps[$temp->get_probe()] = array();
                    }
                    $displayedProbeTemps[$temp->get_probe()][$temp->get_takenDate()] = $temp->get_temp();
                    
                    if(!isset($displayedDateTemps[$temp->get_takenDate()])){
                        $displayedDateTemps[$temp->get_takenDate()] = array();
                    }
                }
                
                $dates = array_keys($displayedDateTemps);
                foreach($displayedProbes as $prob){
                    for($ii = 0; $ii < count($dates); $ii++){
                        $probeTemp = $displayedProbeTemps[$prob][$dates[$ii]];
                        //We dont want the graph to display 0 at 1 interval just because time wasnt logged
                        //If no temp logged at this time get the last time logged
                        if(null === $probeTemp){
                            for($jj = $ii - 1; $jj >= 0; $jj--){
                                $probeTemp = $displayedProbeTemps[$prob][$dates[$jj]];
                                if(null !== $probeTemp) break;
                            }
                        }
                        //If no temp logged at this time or before get the next time logged
                        if(null === $probeTemp){
                            for($jj = $ii + 1; $jj < count($dates); $jj++){
                                $probeTemp = $displayedProbeTemps[$prob][$dates[$jj]];
                                if(null !== $probeTemp) break;
                            }
                        }
                        array_push($displayedDateTemps[$dates[$ii]], $probeTemp);
                    }
                }
                
                array_push($displayedProbes, "Avg");
                foreach($displayedDateTemps as $date => $tempsOnDate){
                    $sum = 0;
                    foreach($tempsOnDate as $temp) $sum += $temp;
                    array_push($displayedDateTemps[$date], $sum/count($tempsOnDate));
                    
                }
			?>
           	<?php if(count($tempList) > 0){ ?>
				<div id="chart_div" style="width: 900px; height: 500px;"></div>
			<?php } ?>
            <table style="width:100%">
            <thead>
                <tr>
                	<th>Probe</th>
                	<th>Temperature</th>
                    <?php if($showHumidity){?> 
                		<th>Humidity</th>
                	<?php } ?>
                	<th>Date</th>
                </tr>
            </thead>
            <tbody>
            	<?php if(count($tempList) == 0){
            	       echo '<tr><td colspan = "'.sprintf("%d", 4-($showHumidity?0:1)).'">';
            	       echo "No Temperatures logged in this time interval";
            	       echo "</td></tr>";
            	   }else{
            	?>
                <?php 
                    $minTemp = $minHum = 99999;
                    $maxTemp = $maxHum = -99999;
                    $sumTemp = $sumHum = 0;
                    $countHum = 0;
                    foreach($tempList as $temp) {
                    $i++;
                    
                    $minTemp = min($minTemp, $temp->get_temp());
                    $maxTemp = max($maxTemp, $temp->get_temp());
                    $sumTemp += $temp->get_temp();
                    
                    if($temp->get_humidity()){
                        $minHum = min($minHum, $temp->get_humidity());
                        $maxHum = max($maxHum, $temp->get_humidity());
                        $sumHum += $temp->get_humidity();
                        $countHum++;
                    }
                ?>
                	<tr>
                        <td style="vertical-align: middle;">
                            <?php echo $temp->get_probe(); ?>
                        </td>                       
                        <td style="vertical-align: middle;">
                            <?php echo $temp->get_temp(); ?>
                        </td>
                        <?php if($showHumidity){?> 
                            <td style="vertical-align: middle;">
                                <?php echo $temp->get_humidity(); ?>
                            </td>
                        <?php } ?>
                        <td style="vertical-align: middle;">
                            <?php echo $temp->get_takenDate(); ?>
                        </td>
                                  
                    </tr>
                        
                <?php } ?>
                	<tr>
                		<td></td>
                		<td>
                			Min: <?php echo $minTemp; ?><br/>
                			Max: <?php echo $maxTemp; ?><br/>
                			Avg: <?php echo $sumTemp/count($tempList); ?><br/>
                		</td>
                        <?php if($showHumidity){?> 
                    		<td>
                    			Min: <?php echo $minHum; ?><br/>
                    			Max: <?php echo $maxHum; ?><br/>
                    			Avg: <?php echo $sumHum/$countHum; ?><br/>
                    		</td>
                        <?php } ?>
                		<td></td>
                		
                	</tr>                	
                	<?php } ?>
					<?php include "includes/paginateTableRow.php"; ?> 
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
		<script type="text/javascript">
			function hideManualInputAsNeeded(intervalSel){
				document.getElementById("manDates").style.display = (intervalSel.value == 0?'':"none");
				document.getElementById("manTimes").style.display = (intervalSel.value == 0?'':"none");
			}
		</script>
		
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
    	<?php if(count($tempList) > 0){ ?>
        	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
            <script type="text/javascript">
              google.load("visualization", "1", {packages:["corechart"]});
              google.setOnLoadCallback(drawChart);
              function drawChart() {
                var data = google.visualization.arrayToDataTable([
                  ['Time' <?php foreach ($displayedProbes as $probe) echo ",'".$probe."'";?>] 
                  <?php 
                  foreach ($displayedDateTemps as $date => $temps){
                      echo ",[";
                      echo "'".$date."'";
                      foreach ($temps as $temp) echo ",".$temp;
                      echo "]";
                  }
                  ?>
    
                  ]);
        
                var options = {
                  title: 'Temperature'
                };
        
                var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
                chart.draw(data, options);
              }
            </script>
        <?php } ?>
    <!-- End Js -->
</body>
</html>
