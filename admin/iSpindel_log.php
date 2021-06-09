<?php
	require_once __DIR__.'/header.php';
	require_once __DIR__.'/../admin/includes/managers/config_manager.php';	
	require_once __DIR__.'/includes/managers/iSpindelData_manager.php'; 
	require_once __DIR__.'/includes/managers/iSpindelDevice_manager.php'; 
	$htmlHelper = new HtmlHelper();
	$config = getAllConfigs();
	$i = 0;
	
	$iSpindelDeviceManager  = new iSpindelDeviceManager();
	$iSpindelDataManager  = new iSpindelDataManager();
	
	$iSpindelDevices = $iSpindelDeviceManager->GetAll();
	if(isset($_POST['reset'])) unset($_POST);
	$startDate 	= (isset($_POST['startDate'])?$_POST['startDate']:"");
	$endDate   	= (isset($_POST['endDate'])?$_POST['endDate']:"");
	$startTime 	= (isset($_POST['startTime'])?$_POST['startTime']:"");
	$endTime   	= (isset($_POST['endTime'])?$_POST['endTime']:"");
	$interval 	= (isset($_POST['timeinterval'])?$_POST['timeinterval']:168);
	if($interval != 0 ){
	    $endDate = date('Y-m-d', strtotime('0 hour'));
	    $endTime = date('H:i:s', strtotime('1 hour'));
	    $startDate = date('Y-m-d', strtotime('-'.$interval.' hour'));
	    $startTime = date('H:i:s', strtotime('-'.$interval.' hour'));
	}
	$fitlerDevice   	= (isset($_POST['device'])?$_POST['device']:(isset($_GET['device'])?$_GET['device']:""));
	$showAverage   	= (isset($_POST['showAverage'])?$_POST['showAverage']:(isset($_GET['showAverage'])?$_GET['showAverage']:false));

	$showHasBeerOnly   	= (isset($_POST['showHasBeerOnly'])?$_POST['showHasBeerOnly']:0);
	
	$changed = (isset($_POST['queryChanged'])?$_POST['queryChanged']:FALSE);
	
	$totalRows = (isset($_POST['totalRows'])?$_POST['totalRows']:0);
	$page = (isset($_POST['page'])?$_POST['page']:1);
	$maxPage =  (isset($_POST['maxPage'])?$_POST['maxPage']:1);
	$page = min($page, $maxPage);
	if($changed) $page = 1;
	$rowsPerPage = $config[ConfigNames::DefaultRowsPerPage] ;
	$dataList = $iSpindelDataManager->getLastDataFiltered($page, $rowsPerPage, $totalRows, $startDate.' '.$startTime, $endDate.' '.$endTime, $fitlerDevice, $showHasBeerOnly);
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
			<li class="current">iSpindel History</li>            
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer left">
			<?php $htmlHelper->ShowMessage(); ?>
			
            <?php
                $displayedDevices = array();
                $displayedDeviceTemps = array();
                $displayedDateData = array();
                $displayedDeviceGravity = array();
                foreach ($dataList as $data){
                    if(!in_array($data->get_name(), $displayedDevices)){
                        array_push($displayedDevices, $data->get_name());
                    }
                    if(!isset($displayedDeviceTemps[$data->get_name()])){
                        $displayedDeviceTemps[$data->get_name()] = array();
                    }
                    $displayedDeviceTemps[$data->get_name()][$data->get_createdDateFormatted()] = convert_temperature($data->get_temperature(), $data->get_temperatureUnit(), $config[ConfigNames::DisplayUnitTemperature]);
                    $displayedDeviceGravity[$data->get_name()][$data->get_createdDateFormatted()] = convert_gravity($data->get_gravity(), $data->get_gravityUnit(), $config[ConfigNames::DisplayUnitGravity]);
                    
                    if(!isset($displayedDateData[$data->get_createdDateFormatted()])){
                        $displayedDateData[$data->get_createdDateFormatted()] = array();
                    }
                }
                
                $dates = array_keys($displayedDateData);
                foreach($displayedDevices as $device){
                    for($ii = 0; $ii < count($dates); $ii++){
                        $deviceTemp = $displayedDeviceTemps[$device][$dates[$ii]];
                        //We dont want the graph to display 0 at 1 interval just because time wasnt logged
                        //If no temp logged at this time get the last time logged
                        if(null === $deviceTemp){
                            for($jj = $ii - 1; $jj >= 0; $jj--){
                                $deviceTemp = $displayedDeviceTemps[$device][$dates[$jj]];
                                if(null !== $deviceTemp) break;
                            }
                        }
                        //If no temp logged at this time or before get the next time logged
                        if(null === $deviceTemp){
                            for($jj = $ii + 1; $jj < count($dates); $jj++){
                                $deviceTemp = $displayedDeviceTemps[$device][$dates[$jj]];
                                if(null !== $deviceTemp) break;
                            }
                        }
                        
                        $deviceGravity = $displayedDeviceGravity[$device][$dates[$ii]];
                        //We dont want the graph to display 0 at 1 interval just because time wasnt logged
                        //If no temp logged at this time get the last time logged
                        if(null === $deviceGravity){
                            for($jj = $ii - 1; $jj >= 0; $jj--){
                                $deviceGravity = $displayedDeviceGravity[$device][$dates[$jj]];
                                if(null !== $deviceGravity) break;
                            }
                        }
                        //If no temp logged at this time or before get the next time logged
                        if(null === $deviceGravity){
                            for($jj = $ii + 1; $jj < count($dates); $jj++){
                                $deviceGravity = $displayedDeviceGravity[$device][$dates[$jj]];
                                if(null !== $deviceGravity) break;
                            }
                        }
                        array_push($displayedDateData[$dates[$ii]], array($deviceTemp,$deviceGravity));
                    }
                }
                if( count($displayedDevices) > 1 && $showAverage){
                    array_push($displayedDevices, "Avg");
                    foreach($displayedDateData as $date => $datasOnDate){
                        $sumTemp = 0;
                        $sumGravity = 0;
                        foreach($datasOnDate as $data) $sumTemp += $data[0];
                        foreach($datasOnDate as $data) $sumGravity += $data[1];
                        array_push($displayedDateData[$date], array($sumTemp/count($datasOnDate), $sumGravity/count($datasOnDate)));
                    }
                }
			?>
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
                        <td>iSpindel Device:</td>
                        <td>
                        	<?php 
                        	echo $htmlHelper->ToSelectList("device", "device", $iSpindelDevices, "name", "name", $fitlerDevice, "Select One");
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
                                <option value="2160" <?php echo ($interval==2160?"Selected":""); ?>>last 90 Days</option>
                        	</select>
                        </td>
                    </tr>
                    <tr>
                    <td>Show Only Devices <br/>with Beer assigned</td>
                    <td style="vertical-align: middle"><input type="checkbox" name="showHasBeerOnly" <?php echo $showHasBeerOnly?"checked ":""?>value="1"/></td>
                    <td><?php if(count($displayedDevices) > 1){ ?>Show Average<?php }?></td>
                    <td style="vertical-align: middle<?php if(count($displayedDevices) <= 1) echo ";visibility:hidden;" ?>"><input type="checkbox" name="showAverage" <?php echo $showAverage?"checked ":""?>value="1"/></td>
                    </tr>
              	</table>
                <input type="submit" name="filter" class="btn" value="Apply" />
                <input type="submit" name="reset" class="btn" value="Reset" />
			</form>
            </div>
			<div class="headings alt">
				<h2>iSpindel History</h2>
			</div>
			<!-- Start On Keg Section -->
			
           	<?php if(count($dataList) > 0){ ?>
				<div id="chart_div" style="width: 900px; height: 500px;"></div>
			<?php } ?>
            <table style="width:100%">
            <thead>
                <tr>
                	<th>Name</th>
                	<th>Temperature</th>
                	<th>Gravity</th>
                	<th>Date</th>
                </tr>
            </thead>
            <tbody>
            	<?php if(count($dataList) == 0){
            	       echo '<tr><td colspan = "4">';
            	       echo "No Data logged in this time interval";
            	       echo "</td></tr>";
            	   }else{
            	?>
                <?php 
                    $minTemp = $minGravity = 99999;
                    $minTempUnit = null;
                    $maxTemp = $maxGravity = -99999;
                    $maxTempUnit = null;
                    $sumTemp = $sumGravity = 0;
                    $sumTempUnit = null;                    
                    foreach($dataList as $data) {
                        $i++;
                        //Gather min/max/sum and convert to the correct units for each one using the first unit as the unit for all
                        if(!$minTempUnit) $minTempUnit = $data->get_temperatureUnit();
                        if($minTempUnit != $data->get_temperatureUnit()) {$data->get_temperature(convert_temperature($data->get_temperature(), $data->get_temperatureUnit(), $minTempUnit));$data->get_temperatureUnit($minTempUnit);}
                        $minTemp = min($minTemp, $data->get_temperature());
                        if(!$maxTempUnit) $maxTempUnit = $data->get_temperatureUnit();
                        if($maxTempUnit != $data->get_temperatureUnit()) {$data->get_temperature(convert_temperature($data->get_temperature(), $data->get_temperatureUnit(), $maxTempUnit));$data->get_temperatureUnit($maxTempUnit);}
                        $maxTemp = max($maxTemp, $data->get_temperature());
                        if(!$sumTempUnit) $sumTempUnit = $data->get_temperatureUnit();
                        if($sumTempUnit != $data->get_temperatureUnit()) {$data->get_temperature(convert_temperature($data->get_temperature(), $data->get_temperatureUnit(), $sumTempUnit));$data->get_temperatureUnit($sumTempUnit);}
                        $sumTemp += $data->get_temperature();
                        $minGravity = min($minGravity, $data->get_gravity());
                        $maxGravity = max($maxGravity, $data->get_gravity());
                        $sumGravity += $data->get_gravity();
                    ?>
                	<tr>
                        <td style="vertical-align: middle;">
                            <?php echo $data->get_name(); ?>
                        </td>                       
                        <td style="vertical-align: middle;">
                            <?php echo number_format(convert_temperature($data->get_temperature(), $data->get_temperatureUnit(), $config[ConfigNames::DisplayUnitTemperature]), 2); ?>
                        </td>                 
                        <td style="vertical-align: middle;">
                            <?php echo number_format(convert_gravity($data->get_gravity(), $data->get_gravityUnit(), $config[ConfigNames::DisplayUnitGravity]), 3); ?>
                        </td>
                        <td style="vertical-align: middle;">
                            <?php echo $data->get_createdDateFormatted(); ?>
                        </td>
                                  
                    </tr>
                        
                <?php } ?>
                	<tr>
                		<td></td>
                		<td>
                			Min: <?php echo number_format(convert_temperature($minTemp, $minTempUnit, $config[ConfigNames::DisplayUnitTemperature]), 2); ?><br/>
                			Max: <?php echo number_format(convert_temperature($maxTemp, $maxTempUnit, $config[ConfigNames::DisplayUnitTemperature]), 2); ?><br/>
                			Avg: <?php echo number_format(convert_temperature($sumTemp, $sumTempUnit, $config[ConfigNames::DisplayUnitTemperature])/count($dataList), 2); ?><br/>
                		</td>
                		<td>
                			Min: <?php echo number_format($minGravity, 2); ?><br/>
                			Max: <?php echo number_format($maxGravity, 2); ?><br/>
                			Avg: <?php echo number_format($sumGravity/count($dataList), 2); ?><br/>
                		</td>
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
    	<?php if(count($dataList) > 0){ ?>
        	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
            <script type="text/javascript">
              google.load("visualization", "1", {packages:["corechart"]});
              google.setOnLoadCallback(drawChart);
              function drawChart() {
                var data = google.visualization.arrayToDataTable([
                  ['Time' <?php foreach ($displayedDevices as $device) echo ",'$device-Temp','$device-Gravity'";?>] 
                  <?php 
                  foreach ($displayedDateData as $date => $datas){
                      echo ",[";
                      echo "'".$date."'";
                      foreach ($datas as $data) echo ",".$data[0].",".$data[1];
                      echo "]";
                  }
                  ?>
    
                  ]);
        
                var options = {
                  title: 'iSpindel Data',
                  // Gives each series an axis that matches the vAxes number below.
                  series: {
                    0: {targetAxisIndex: 0},
                    1: {targetAxisIndex: 1}
                  },
                  vAxes: {
                      // Adds titles to each axis.
                      0: {title: 'Temperature', viewWindow: {min: <?php echo is_unit_imperial($config[ConfigNames::DisplayUnitTemperature])?"32":"0"?>,max: <?php echo is_unit_imperial($config[ConfigNames::DisplayUnitTemperature])?"100":"37"?>}},
                      1: {title: 'Gravity', viewWindow: {min: <?php echo $config[ConfigNames::DisplayUnitGravity] != UnitsOfMeasure::GravitySG?"0":"1.000"?>,max: <?php echo $config[ConfigNames::DisplayUnitGravity] != UnitsOfMeasure::GravitySG?"32":"1.130"?>}}
                    }
                };
        
                var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
                chart.draw(data, options);
              }
            </script>
        <?php } ?>
    <!-- End Js -->
</body>
</html>
