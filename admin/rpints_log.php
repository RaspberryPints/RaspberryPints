<?php
//From header.php moved here to handle just getting the last rows from the database
    session_start();
    require_once __DIR__.'/includes/conn.php';
    require_once __DIR__.'/includes/html_helper.php';
    require_once __DIR__.'/includes/functions.php';
//From header.php
	require_once __DIR__.'/../admin/includes/managers/config_manager.php';	
	require_once __DIR__.'/includes/managers/rpintsLog_manager.php'; 
	$htmlHelper = new HtmlHelper();
	$config = getAllConfigs();
	$beerColSpan = 1;
	$i = 0;
	$totalTemps = 0;
	
	$rpintsLogManager  = new RPintsLogManager();
	
	if(isset($_POST['reset'])) unset($_POST);
	$startDate 	= (isset($_POST['startDate'])?$_POST['startDate']:"");
	$endDate   	= (isset($_POST['endDate'])?$_POST['endDate']:"");
	$startTime 	= (isset($_POST['startTime'])?$_POST['startTime']:"");
	$endTime   	= (isset($_POST['endTime'])?$_POST['endTime']:"");
	$interval 	= (isset($_POST['timeinterval'])?$_POST['timeinterval']:0);
	if($interval != 0 ){
	    $endDate = date('Y-m-d', strtotime('0 hour'));
	    $endTime = date('H:i:s', strtotime('1 hour'));
	    $startDate = date('Y-m-d', strtotime('-'.$interval.' hour'));
	    $startTime = date('H:i:s', strtotime('-'.$interval.' hour'));
	}
	$process   	= (isset($_POST['process'])?$_POST['process']:"");
	$category   = (isset($_POST['category'])?$_POST['category']:"");
	
	$changed = (isset($_POST['queryChanged'])?$_POST['queryChanged']:FALSE);
	
	$totalRows = (isset($_POST['totalRows'])?$_POST['totalRows']:0);
	$page = (isset($_POST['page'])?$_POST['page']:1);
	$maxPage =  (isset($_POST['maxPage'])?$_POST['maxPage']:1);
	$lastId =  (isset($_POST['lastId'])?$_POST['lastId']:-1);
	$lastDate =  (isset($_POST['lastDate'])?$_POST['lastDate']:null);
	$page = min($page, $maxPage);
	if($changed) $page = 1;
	$rowsPerPage = $config[ConfigNames::DefaultRowsPerPage] ;
	$logList = $rpintsLogManager->getLastLogMessagesFiltered($page, $rowsPerPage, $totalRows, $startDate.' '.$startTime, $endDate.' '.$endTime, $process, $category, $lastId, $lastDate);
	$maxPage = ceil(($totalRows)/$rowsPerPage);

	if( isset($_POST['dataOnly']) && $_POST['dataOnly'] = 'TRUE')
	{
	    echo "[";
	    $firstTime = TRUE;
	    foreach( $logList as $log ){
	        if(!$firstTime) echo ',';
	        echo $log->toJson();   
            $firstTime = FALSE;
	    }
	    echo "]";
        exit;
	}
	
	$processes = $rpintsLogManager->getAllProcesses();
	$categories = $rpintsLogManager->getAllCategories();
	$maxId = -1;
	$lastDate = '1900-01-01';
	
	if(isset( $_SESSION['myusername'] )){
	    require_once __DIR__.'/header.php';
	}else{
	    ?>
	    <!DOCTYPE html>
	    <html xmlns="http://www.w3.org/1999/xhtml">
	    <head>
	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	    <title>RaspberryPints</title>
	    <link href="styles/layout.css" rel="stylesheet" type="text/css" />
	    <link href="styles/wysiwyg.css" rel="stylesheet" type="text/css" />
	    <!-- Theme Start -->
	    <link href="<?php echo $stylesheet?>" rel="stylesheet" type="text/css" />
	    <!-- Theme End -->
	    <link href='http://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
	    <?php require __DIR__.'/scripts.php'; ?>
	    </head>
	    <?php 
	}
	
?>
<body>
	<!-- Start Header  -->
<?php
if(isset( $_SESSION['myusername'] ))include 'top_menu.php';
?>
	<!-- End Header -->
		
	<!-- Top Breadcrumb Start -->
	<div id="breadcrumb">
		<ul>	
			<li><img src="img/icons/icon_breadcrumb.png" alt="Location" /></li>
			<li><strong>Location:</strong></li>
			<li class="current">Raspberry Pints Log</li>            
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
            		<tr>
                        <td>Auto Update</td>
                        <td>
                        	<input type="checkbox" name="autoRefresh" id="autoRefresh" checked="checked" />
                        </td>
                        <td></td>
                        <td>
                        </td>
            		</tr>
					<?php $columnCount= 4; include "includes/paginateTableRow.php"; ?> 
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
                        <td>Processes:</td>
                        <td>
                        	<select id="process" name="process">
                        		<option value="">All</option>
                        		<?php 
                        		foreach( $processes as $prc ){
                        		    echo '<option '.(trim($process) == trim($prc)?'selected':'').'>'.$prc.'</option>';
                        		}
                        		?>
                        	</select>
                        </td>
                        <td>
                        	Categories:
                		</td>
                        <td>
                        	<select id="category" name="category">
                        		<option value="">All</option>
                        		<?php 
                        		foreach( $categories as $cat ){
                        		    echo '<option '.($category == $cat?'selected':'').'>'.$cat.'</option>';
                        		}
                        		?>
                        	</select>
                        </td>
                    </tr>
                    <tr>
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
                        <td></td>
                        <td>
                        </td>
                    </tr>
              	</table>
                <input type="submit" name="filter" class="btn" value="Apply" />
                <input type="submit" name="reset" class="btn" value="Reset" />
			</form>
            </div>
			<div class="headings alt">
				<h2>Raspberry Pints Log</h2>
			</div>
			<!-- Start On Keg Section -->
			
            <table style="width:100%" id="tableLog">
            <thead>
                <tr>
                	<th style="width:150px">Date</th>
                	<th>Process</th>
                	<th>Category</th>
                	<th>Text</th>
                	<th>Occurances</th>
                </tr>
            </thead>
            <tbody>
            	<?php if(count($logList) == 0){
            	       echo '<tr><td>';
            	       echo "No Logs in this time interval";
            	       echo "</td></tr>";
            	   }else{
            	?>
                        <?php 
                            foreach($logList as $log) {
                                if($log->get_id() > $maxId){
                                    $maxId = $log->get_id();
                                    $maxDate = $log->get_modifiedDate();
                                }
                        ?>
                        	<tr>
                                <td style="vertical-align: middle;">
                                	<input type="hidden" name="id"  value="<?php echo $log->get_id()?>" />
                                    <?php echo $log->get_modifiedDate(); ?>
                                </td>      
                                <td style="vertical-align: middle;">
                                    <?php echo $log->get_process(); ?>
                                </td>    
                                <td style="vertical-align: middle;">
                                    <?php echo $log->get_category(); ?>
                                </td>     
                                <td style="vertical-align: middle;">
                                    <?php echo $log->get_text(); ?>
                                </td>     
                                <td style="vertical-align: middle;">
                                    <?php echo $log->get_occurances(); ?>
                                </td>                                  
                            </tr>
                                
                        <?php } ?>              	
                	<?php } ?>
					<?php $columnCount= 5; include "includes/paginateTableRow.php"; ?> 
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
if(isset( $_SESSION['myusername'] ))include 'left_bar.php';
?>
	<!-- End Left Bar Menu -->  
	<!-- Start Js  -->
		<script>
			function hideManualInputAsNeeded(intervalSel){
				document.getElementById("manDates").style.display = (intervalSel.value == 0?'':"none");
				document.getElementById("manTimes").style.display = (intervalSel.value == 0?'':"none");
			}
		</script>
		
    	<script>
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
    	<script>
		var rowStructure = $('#tableLog tbody tr:eq(0)').clone();
		rowStructure.find('input, select').each(function(){this.value="";});
		rowStructure.find('td').each(function(){this.innerHTML="";});
		function addRowTop(){		
			var topRow = $('#tableLog tbody tr:eq(0)')
			topRow.before(rowStructure.clone());
		}
		function removeNthFromLastRow(position){	
			var row = $('#tableLog tbody tr:nth-last-child('+position+')')
			row.remove();
		}
		function getRowId(position){
			if( $('#tableLog tbody tr:eq('+position+') input[name=id]').length > 0 )
			{
				return $('#tableLog tbody tr:eq('+position+') input[name=id]')[0].value;
			}
			return null;
		}
		function updateOccurances(position, id, modifiedDate, occurances){
			$('#tableLog tbody tr:eq('+position+') td:eq(0)').html('<input type="hidden" name="id"  value="'+id+'" />' +modifiedDate);
			$('#tableLog tbody tr:eq('+position+') td:eq(4)').html(occurances);
		}
		
    	setInterval(addNewLogMessages, 5000)
    	var lastId = <?php echo $maxId?>-2;
    	var lastDate = "<?php echo $maxDate?>";
    	var totalRows = <?php echo $totalRows ?>;
    	function addNewLogMessages(){
        	if( !$('#autoRefresh').is(':checked') ) return;
    		var data = {};
    		data['startDate']     = "<?php echo $startDate; ?>";
    		data['endDate']       = "<?php echo $endDate; ?>";
    		data['startTime']     = "<?php echo $startTime; ?>";
    		data['endTime']       = "<?php echo $endTime; ?>";
    		data['timeinterval']  = "<?php echo $interval; ?>";
    		data['process']       = "<?php echo $process; ?>";
    		data['category']      = "<?php echo $category; ?>";
    		data['lastId']        = lastId;
    		data['lastDate']      = lastDate;
    		data['dataOnly']      = "TRUE"
    		$.ajax(
                {
                       type: "POST",
                       url: "rpints_log.php",
                       data: data,// data to send to above script page if any
                       cache: false,
        
                       success: function(response)
                       {
                            var ids = [];
                            var newLines = JSON.parse(response);
                            for( var ii = 0; ii < newLines.length; ii ++){
                            	ids.push(getRowId(ii));
                            }
                            //The list is order ID desc so we want to add the list of the list to the the table first
                            // I.E. response 7,6,5 we want 7 on top so add 5, 6, 7
                            for( var ii = newLines.length-1; ii >= 0 ; ii --){
                				var newLine = newLines[ii];
                            	if(ids.indexOf(newLine.id) != null){
                            		updateOccurances(ids.indexOf(newLine.id), newLine.id, newLine.modifiedDate, newLine.occurances);
                            	}
                            	else
                            	{
                                	//Found a new record in the database increament the last one
                            		lastId = newLine.id;
                            		lastDate = newLine.modifiedDate
                                    addRowTop();
                                    var newRow = $('#tableLog tbody tr:eq(0)')
                                    newRow.find('td:eq(0)').html('<input type="hidden" name="id"  value="'+newLine.id+'" />' +newLine.modifiedDate);
                                    newRow.find('td:eq(1)').html(newLine.process);
                                    newRow.find('td:eq(2)').html(newLine.category);
                                    newRow.find('td:eq(3)').html(newLine.text);
                                    newRow.find('td:eq(4)').html(newLine.occurances);
                                    totalRows++;
                                    //if we added 1 more than rowsPerPage the cause a full refresh to update page controls
                                    if( totalRows % <?php echo $rowsPerPage; ?> == 1 ) location.reload();
									$('td:contains(Total Rows: '+(totalRows-1)+')').html('Total Rows: ' + totalRows);
                                    if(totalRows > <?php echo $rowsPerPage; ?>){
                                        //Remove the second to last because last is the page control
                                    	removeNthFromLastRow(2);
                                    }
                            	}
                            }
                       },
                	error: function (xhr,status,error){
                    	alert(error);
                	}
                 });
      	}
    	</script>
    <!-- End Js -->
</body>
</html>
