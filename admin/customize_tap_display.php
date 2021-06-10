<?php
/** @var mixed $noHeadEnd **/
$noHeadEnd = True;
require_once __DIR__.'/header.php';
require_once __DIR__.'/../includes/common.php';
require_once __DIR__.'/includes/models/pour.php';


$config = getAllConfigs();
?>
<link rel="stylesheet" type="text/css" href="../style.css">
<style>

html, body {
	background-image: url(../img/background.jpg);
	background-color: #000000;
	background-size: cover;
	background-repeat:no-repeat;
	overflow: visible;
	color: #FFFFFF;
	font: 1em Georgia, arial, verdana, sans-serif;
	margin:0px;
	height:unset;
}
ul, li {list-style: none; padding: 0; margin: 0;}
tr { border:thick; border-color: #FF0000; }

th {background: transparent; text-shadow: 1px 1px 1px #000; font-size: 14px;}
<?php if($config[ConfigNames::ShowVerticleTapList] == "0"){?>
.draggable {
        cursor: move;
        user-select: none;
    }
    .placeholder {
        border: 2px dashed #cbd5e0;
    }
    .clone-list {
        
        border-top: 1px solid #ccc;
        display: flex;
    }
    .dragging {
        border: 1px solid #ccc;
        z-index: 999;
    }
<?php } ?>
    .disabled {
        opacity: 50%;
        text-decoration: line-through;
    }
    .disabled div{
        opacity: 50%;
    }
</style>
</head>
<?php

$htmlHelper = new HtmlHelper();
$error = FALSE;
if (isset ( $_POST ['save'] )) {
    /** @var mixed $value **/
    foreach( $_POST as $key => $value )
    {
        //if( substr($key, 0,4) == 'show' || substr($key, $key->length-3,3) != 'Col')continue;
        //if the showColumn is set then multiple the current value by the show value
        //this will result in a positive or negative value which will determine if the column is shown on the screen
        if( isset($_POST["show".$key]) ){
            $_POST[$key] = $_POST["show".$key] * $_POST[$key];
        }
    }
    foreach( $_POST['configs'] as $value )
    {
        //if the showColumn is set then multiple the current value by the show value
        //this will result in a positive or negative value which will determine if the column is shown on the screen
        if( !isset($_POST[$value]) ){
            $_POST[$value] = 0;
        }
    }
    setConfigurationsFromArray($_POST, $config);
    if(!$error){
        $_SESSION['successMessage'] = "Success";
    }else{
        $_SESSION['successMessage'] = "Changes Could Not Be Saved";
    }
} 
?>
<body id="customBody">
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
			<li class="current">Customize Tap Display</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End -->

	<!-- Right Side/Main Content Start -->
	<div id="rightside">
	<div class="contentcontainer left">
		<div class="headings alt">
			<h2>Customize Tap Displays</h2>
		</div>
		<div class="contentbox" style="background: none;overflow: hidden">
			<?php $htmlHelper->ShowMessage(); ?>
			<?php if(isset($_POST['edit'])) {?>
			<!-- <a style="color:#FFF" onClick="toggleSettings(this, 'settingsDiv')" class="collapsed heading">New Shield</a> -->
    		<?php }?>    		
<div>
Use this page to customize the main tap display. 
<?php if($config[ConfigNames::ShowVerticleTapList] == "0"){?>
Drag and drop the column headers to change the positioning of the columns.
<?php }else{?>   		
Drag and drop the rows to change the positioning of them. 
<?php }?>
Visible checkboxes can be used to show/hide the detail above them. Other checkboxes exists to toggle between options. Images are automatically applied but settings must be saved
<h2><font color="red">When done hit Save!</font></h2>
</div>
<br/>
        
			<form method="POST" id="background">
			<input type="hidden" name="target" value="../../img/background.jpg"/>
			BackGround<input name="uploaded" id="uploadBack"  type="file" accept="image/gif, image/jpg, image/png"/>
			</form>
			<form method="POST" id="customizeTapDisplay">
			<div>
            	<input name="save" type="submit" class="btn" value="Save" />
            </div>
			<div class="bodywrapper" id="mainTable">
				<div class="header clearfix">
    				<div class="HeaderLeft">

    				<input type="hidden" name="target" value="../../img/logo.png"/>				
    				<img id="tapListLogo" src="../img/logo.png<?php echo "?" . time(); ?>" height="100" alt="Brewery Logo" style="border-style: solid; border-width: 2px; border-color: #d6264f;" />
    				<br/><input name="uploaded" id="uploadLogo" type="file" accept="image/gif, image/jpg, image/png" /> 
					<br/><progress style="display: none"></progress>
				</div>
                <div  class="HeaderCenter" style="font: 1em Georgia, arial, verdana, sans-serif;width:25%">
    				<input type="text" id="headerCenter" class="largebox" value="<?php echo $config[ConfigNames::HeaderText]; ?>" style="font: 3em Georgia, arial, verdana, sans-serif;background-repeat: unset;width:95%;text-align:center;<?php echo ($config[ConfigNames::ClientID] && $config[ConfigNames::ClientSecret] && $config[ConfigNames::ShowUntappdBreweryFeed]?"display:none;":""); ?>" name="<?php echo ConfigNames::HeaderText; ?>"> 
    				<?php echo '<input type="hidden" name="configs[]" value="'.ConfigNames::HeaderText.'"/>'; ?>
    				<?php if( $config[ConfigNames::ClientID] && $config[ConfigNames::ClientSecret] ){?>
						<table id="untappdTable" style="align-content:center;width:100%;<?php echo (!$config[ConfigNames::ShowUntappdBreweryFeed]?"display:none;":""); ?>">
                			<tr><td style="font: 1em Georgia, arial, verdana, sans-serif;width:100%">
                    			<div class='beerfeed' style="font: 1em Georgia, arial, verdana, sans-serif;width:100%">
                    			<div class=circular style="align-content:center; width: 49px;height: 49px;background-image: url(https://untappd.akamaized.net/site/assets/images/default_avatar_v2.jpg) ; background-size: cover;border: 2px #FFCC00 solid; border-radius: 100px; margin: 1px;float: left"></div>
                    			<div class=circular style="width: 49px;height: 49px;background-image: url(https://untappd.akamaized.net/site/assets/images/temp/badge-beer-default.png) ;background-size: cover; display: block; border: 2px #FFCC00 solid; border-radius: 100px; margin: 1px; float: right"></div>
                    			First Last is drinking a<br />
                    			Beer Name<br />
                    			Brewery
                    			</div>
                			</td></tr>
                		</table>
        				<div>
        					<input type="checkbox" name="<?php echo ConfigNames::ShowUntappdBreweryFeed; ?>" value="1" <?php echo ($config[ConfigNames::ShowUntappdBreweryFeed]?" checked ":"");?> onchange="if($(this)[0].checked){$('#untappdTable').show();$('#headerCenter').hide();}else{$('#untappdTable').hide();$('#headerCenter').show();};">Show Untappd
        				</div>
        				<?php echo '<input type="hidden" name="configs[]" value="'.ConfigNames::ShowUntappdBreweryFeed.'"/>'; ?>
    				<?php }?>
                </div>
                
          		<div class="HeaderRight" id="HeaderRight" style="vertical-align:top">
          		
        <table style="border: thin;">
        	<tr>
				<td style="width:8%;border-left:none">
                    <div id="temp" <?php if(!$config[ConfigNames::ShowTempOnMainPage])echo 'class="disabled"'; ?>>
                    <div class="temp-container">
                    	<div class="temp-indicator">
                    		<div class="temp-full" style="height:75%"></div>
                    	</div>
                    </div>
                    <?php DisplayEditCheckbox(true, $config, ConfigNames::ShowTempOnMainPage, 'temp'); ?>
                    </div>
                </td>
                <td style="width:25%">
                    <div id="lastPour" <?php if(!$config[ConfigNames::ShowLastPour])echo 'class="disabled"'; ?>>
                        <table><tr>
                    		<td class="poursbeername" colspan="2">
                    			<h1 style="text-align: center">Last Pour</h1>
                    		</td>
                    		</tr>
                    		<tr>
                    		<td class="poursuser">
                    			<h1 style="font-size: 1em; text-align: right">User</h1>
                    		</td>
                    		<td class="poursbeername"style="width: 25%">
                    			<h1 style="font-size: 1em; text-align: right">Beer</h1>
                    		</td>
                    		<td class="poursamount">
                    			<h1>12<?php echo $config[ConfigNames::DisplayUnitVolume]?></h1>
                    		</td>
                        </tr></table>
                        <?php DisplayEditCheckbox(true, $config, ConfigNames::ShowLastPour, 'lastPour'); ?>
                    </div>
                </td>
                <td>
                    <div id="rpintsLogo" <?php if(!$config[ConfigNames::ShowRPLogo])echo 'class="disabled"'; ?>>
                    <img src="../img/RaspberryPints.png" alt="" style="width:75px">
                   	<?php DisplayEditCheckbox(true, $config, ConfigNames::ShowRPLogo, 'rpintsLogo'); ?>
                   	</div>
                </td>
                <td>
                    <div id="fermenters" <?php if(!$config[ConfigNames::ShowFermOnMainPage])echo 'class="disabled"'; ?>>
                    <img height="65px" src="../img/fermenter/fermenterSvg.php?container=conical&rgb=220,197,34" />
     				<?php DisplayEditCheckbox(true, $config, ConfigNames::ShowFermOnMainPage, 'fermenters'); ?>
                   	</div>
                </td>
                <td>
                    <div id="gasTanks" <?php if(!$config[ConfigNames::ShowGTOnMainPage])echo 'class="disabled"'; ?>>
                         <img height="75px" src="../img/gasTank/gasTankSvg.php?container=gasTank&fill=75&rgb=0,255,0" />
                   	<?php DisplayEditCheckbox(true, $config, ConfigNames::ShowGTOnMainPage, 'gasTanks'); ?>
                   	</div>
                </td>
            </tr>
            <tr><td colspan="5">Rotation Time(secs):<input type="number" class="smallbox" style="background-repeat: unset;" value="<?php echo $config[ConfigNames::InfoTime]; ?>" name="<?php echo ConfigNames::InfoTime;?>"></td></tr>
        </table> 
          		</div>
        		</div>
                    
            </div>
            <div>
    			<?php
    			$result = array(getConfig(ConfigNames::ShowVerticleTapList));
				foreach($result as $row) {
					$options = array();
					$options[0] = 'On';
					$options[1] = 'Off';
					$validation = $row['validation'];
					if( $validation !== NULL && $validation != ''){
					    $valids = explode('|', $validation);
					    for( $i = 0; $i < count($valids); $i++ ){
					        $options[$i] = $valids[$i];
					    }
					}
					echo '<h3>' . $row['displayName'] . ":"  ./* '<span id="' . $row['configName'] . 'Success" style="display:none; color: #8EA534;"> (Updated)</span>'.  */'</h3>'.
    					$options[0].'<input type="radio" ' . ($row['configValue']?'checked':'') . ' name="' . $row['configName'] . '" value="1">' .
    					$options[1].'<input type="radio" ' . (!$row['configValue']?'checked':'') . ' name="' . $row['configName'] . '" value="0">'.
    					'<br>';
    				}
    			?>        
            </div>
            <div>
            <input type="hidden" name="configs[]" value="<?php echo ConfigNames::RefreshTapList ?>"/>
            <input type="checkbox" name="<?php echo ConfigNames::RefreshTapList ; ?>" value="1" <?php echo ($config[ConfigNames::RefreshTapList]?" checked ":"");?>>Refresh List Every 60 Seconds
            </div>
            <div>
            <input type="hidden" name="configs[]" value="<?php echo ConfigNames::ShowBeerTableHead ?>"/>
            <input type="checkbox" name="<?php echo ConfigNames::ShowBeerTableHead ; ?>" value="1" <?php echo ($config[ConfigNames::ShowBeerTableHead]?" checked ":"");?> onchange="$('#beerList <?php echo $config[ConfigNames::ShowVerticleTapList] == "0"?'th':'tr td:first-child'?>').toggleClass('disabled');">Show <?php echo $config[ConfigNames::ShowVerticleTapList] == "0"?'Column':'Row'?> Headers
            </div>
	        <br/>
            <div>
            <?php 
                $taps = array();
                $beeritem = array(
                    "id" => 1,
                    "beername" => "BeerName",
                    "untID" => 4064135,
                    "style" => 'Style',
                    "brewery" => "BreweryName",
                    "breweryImage" =>'https://untappd.akamaized.net/site/assets/images/temp/badge-brewery-default.png',
                    "notes" => "Beer Notes",
                    "abv" => 5.0,
                    "og" => 1.065,
                    "ogUnit" => UnitsOfMeasure::GravitySG,
                    "fg" => 1.010,
                    "fgUnit" => UnitsOfMeasure::GravitySG,
                    "srm" => 10,
                    "ibu" => 43,
                    "startAmount" => 5,
                    "startAmountUnit" => UnitsOfMeasure::VolumeOunce,
                    "remainAmount" => 4,
                    "remainAmountUnit" => UnitsOfMeasure::VolumeOunce,
                    "tapRgba" => "000,000,000",
                    "tapNumber" => 1,
                    "rating" => 4.5,
                    "srmRgb" => 2,
                    "containerType" => 'standardpint',
                    "kegType" => 'corny',
                    "valvePinState" => 0,
                    "accolades" => '1~Gold~1,2~Silver~1'
                );
                $taps[1] = $beeritem;
                $numberOfTaps = 1;
                /** @var mixed $numberOfBeers **/
                $numberOfBeers = 1;
                
                $pour = new Pour();
                $pour->set_tapNumber("1");
                $pour->set_beerName("Beer Name");
                $pour->set_amountPoured(4);
                $pour->set_amountPouredUnit(UnitsOfMeasure::VolumeOunce);
                $pour->set_userName("User Name");
                $poursList = array($pour);
                /** @var mixed $numberOfPours **/
                $numberOfPours = 1;
                
                echo '<table><tr><td>';
                printBeerList($taps, $numberOfTaps, ConfigNames::CONTAINER_TYPE_KEG, TRUE);
                if($numberOfPours > 0) echo "<h1 style=\"text-align: center;\">Pours</h1>";
                ?>
                <input type="hidden" name="configs[]" value="<?php echo ConfigNames::ShowPourListOnHome ?>"/>
                <input type="checkbox" name="<?php echo ConfigNames::ShowPourListOnHome ; ?>" value="1" <?php echo ($config[ConfigNames::ShowPourListOnHome]?" checked ":"");?>>Show Pour List
            	<?php 
            	if($numberOfPours > 0) printPoursList($poursList, TRUE);
                echo '</td></tr></table>';
            ?>
            </div>
			<div>
        		<input name="save" type="submit" class="btn" value="Save" />
        	</div>
            </form>
		</div>
	</div>
	<!-- Start Footer -->
	<?php
	include 'footer.php';
	?>
	<!-- End Footer -->
</div>
<script>
<?php if($config[ConfigNames::ShowVerticleTapList] == "0"){?>
//Sortable column heads

document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('beerList');

    let draggingEle;
    let draggingColumnIndex;
    let placeholder;
    let list;
    let isDraggingStarted = false;

    // The current position of mouse relative to the dragging element
    let x = 0;
    let y = 0;
    // Swap two nodes
    const swap = function(nodeA, nodeB) {
        const parentA = nodeA.parentNode;
        const siblingA = nodeA.nextSibling === nodeB ? nodeA : nodeA.nextSibling;

        // Move `nodeA` to before the `nodeB`
        nodeB.parentNode.insertBefore(nodeA, nodeB);

        // Move `nodeB` to before the sibling of `nodeA`
        parentA.insertBefore(nodeB, siblingA);
    };

    // Check if `nodeA` is on the left of `nodeB`
    const isOnLeft = function(nodeA, nodeB) {
        // Get the bounding rectangle of nodes
        const rectA = nodeA.getBoundingClientRect();
        const rectB = nodeB.getBoundingClientRect();

        return ((rectA.left + rectA.width / 2) < (rectB.left + rectB.width / 2));
    };

    const cloneTable = function() {
        const rect = table.getBoundingClientRect();

        list = document.createElement('div');
        list.classList.add('clone-list');
        list.style.position = 'absolute';
        list.style.left = `${rect.left}px`;
        list.style.top = `${rect.top}px`;
        table.parentNode.insertBefore(list, table);

        // Hide the original table
        table.style.visibility = 'hidden';

        // Get all cells
        originalCells = [].slice.call(table.querySelectorAll('#beerList tbody td'));
        originalCells = originalCells.filter(function(c, idx) {
            return getNearestTableAncestor(c,'tbody') === table.children[0];
        });
        const originalHeaderCells = [].slice.call(table.querySelectorAll('th'));
        const numColumns = originalCells.length;

        // Loop through the header cells
        originalHeaderCells.forEach(function(headerCell, headerIndex) {
            const width = parseInt(window.getComputedStyle(headerCell).width);
            const height = parseInt(window.getComputedStyle(headerCell).height);

            // Create a new table from given row
            const item = document.createElement('div');
            item.classList.add('draggable');

            const newTable = document.createElement('table');
            newTable.setAttribute('class', 'clone-table');
            newTable.setAttribute('class', 'clone-table');
            newTable.style.width = `${width}px`;

            // Header
            const th = headerCell.cloneNode(true);
            th.innerHTML = th.innerHTML.substring(0,th.innerHTML.indexOf('<br>'))
            let newRow = document.createElement('tr');
            th.style.height = `${height}px`;
            newRow.appendChild(th);
            newTable.appendChild(newRow);

            const cells = originalCells.filter(function(c, idx) {
                return thFromTd($(c))[0] === headerCell;
            });
            newRow = document.createElement('tr');
            cells.forEach(function(cell) {
                const newCell = cell.cloneNode(true);
                newCell.style = cell.style;
                newCell.style.width = `${width}px`;
                newCell.style.borderLeft = '1px white dashed';
                newRow.appendChild(newCell);
            });
            newTable.appendChild(newRow);

            item.appendChild(newTable);
            list.appendChild(item);
        });
    };
    const getNearestTableAncestor = function (htmlElementNode, element) {
        while (htmlElementNode) {
            htmlElementNode = htmlElementNode.parentNode;
            if (htmlElementNode.tagName.toLowerCase() === element) {
                return htmlElementNode;
            }
        }
        return undefined;
    }
    const mouseDownHandler = function(e) {
        if(e.target.tagName=="INPUT")return;
        draggingColumnIndex = [].slice.call(table.querySelectorAll('th')).indexOf(e.target);
        if(draggingColumnIndex<0)draggingColumnIndex = [].slice.call(table.querySelectorAll('td')).indexOf(e.target);

        // Determine the mouse position
        x = e.clientX - e.target.offsetLeft;
        y = e.clientY - e.target.offsetTop;

        // Attach the listeners to `document`
        document.addEventListener('mousemove', mouseMoveHandler);
        document.addEventListener('mouseup', mouseUpHandler);
    };

    const mouseMoveHandler = function(e) {
        if (!isDraggingStarted) {
            isDraggingStarted = true;

            cloneTable();

            draggingEle = [].slice.call(list.children)[draggingColumnIndex];
            draggingEle.classList.add('dragging');

            // Let the placeholder take the height of dragging element
            // So the next element won't move to the left or right
            // to fill the dragging element space
            placeholder = document.createElement('div');
            placeholder.classList.add('placeholder');
            draggingEle.parentNode.insertBefore(placeholder, draggingEle.nextSibling);
            placeholder.style.width = `${draggingEle.offsetWidth}px`;
        }

        // Set position for dragging element
        draggingEle.style.position = 'absolute';
        draggingEle.style.top = `${draggingEle.offsetTop + e.clientY - y}px`;
        draggingEle.style.left = `${draggingEle.offsetLeft + e.clientX - x}px`;

        // Reassign the position of mouse
        x = e.clientX;
        y = e.clientY;

        // The current order
        // prevEle
        // draggingEle
        // placeholder
        // nextEle
        const prevEle = draggingEle.previousElementSibling;
        const nextEle = placeholder.nextElementSibling;
        
        // // The dragging element is above the previous element
        // // User moves the dragging element to the left
        if (prevEle && isOnLeft(draggingEle, prevEle)) {
            // The current order    -> The new order
            // prevEle              -> placeholder
            // draggingEle          -> draggingEle
            // placeholder          -> prevEle
            swap(placeholder, draggingEle);
            swap(placeholder, prevEle);
            return;
        }

        // The dragging element is below the next element
        // User moves the dragging element to the bottom
        if (nextEle && isOnLeft(nextEle, draggingEle)) {
            // The current order    -> The new order
            // draggingEle          -> nextEle
            // placeholder          -> placeholder
            // nextEle              -> draggingEle
            swap(nextEle, placeholder);
            swap(nextEle, draggingEle);
        }
    };

    const mouseUpHandler = function() {
        // // Remove the placeholder
        placeholder && placeholder.parentNode.removeChild(placeholder);
        
        draggingEle.classList.remove('dragging');
        draggingEle.style.removeProperty('top');
        draggingEle.style.removeProperty('left');
        draggingEle.style.removeProperty('position');

        // Get the end index
        endColumnIndex = [].slice.call(list.children).indexOf(draggingEle);
        isDraggingStarted = false;

        // Remove the `list` element
        list.parentNode.removeChild(list);

        // Move the dragged column to `endColumnIndex`
        allRows = [].slice.call(table.querySelectorAll('tr'));
        allRows = allRows.filter(function(r, idx) {
            return getNearestTableAncestor(r,'tbody') === table.children[0];
        });
        colSpanTh = 0;
        crossColSpanTh = 0;
        startThIndex = 0;
        allRows.forEach(function(row) {
            cells = [].slice.call(row.querySelectorAll('th, td'));
            cells = cells.filter(function(c, idx) {
                return getNearestTableAncestor(c,'tbody') === table.children[0];
            });
            //TH row is the row that indices are based off of
            if(cells[draggingColumnIndex].tagName=="TH") {
            	colSpanTh = cells[draggingColumnIndex].colSpan;
                for(i=0;i<=Math.max(draggingColumnIndex,endColumnIndex); i++)
                {
                    if(i<draggingColumnIndex)startThIndex += cells[i].colSpan-1;
                	if(i >= (Math.min(draggingColumnIndex,endColumnIndex)+(draggingColumnIndex > endColumnIndex?0:1)) && 
                       i <  (Math.max(draggingColumnIndex,endColumnIndex)+(draggingColumnIndex > endColumnIndex?0:1)))crossColSpanTh += cells[i].colSpan;
                }
                row.insertBefore(cells[draggingColumnIndex], draggingColumnIndex > endColumnIndex?cells[endColumnIndex]:cells[endColumnIndex].nextSibling);
            }else{
            	draggingColumnIndexTd = 0;
            	i = 0;
                crossColSpanTd = 0;
                while(crossColSpanTd < draggingColumnIndex+startThIndex)
                {
                	crossColSpanTd += cells[i++].colSpan;
                	draggingColumnIndexTd++;
                }
                //when left to right add 1 because we are inserting before
            	endColumnIndexTd = (draggingColumnIndex > endColumnIndex?draggingColumnIndexTd-(crossColSpanTh):draggingColumnIndexTd+crossColSpanTh+(colSpanTh-1)+1);
            	endColumnIndexTd = Math.max(endColumnIndexTd,0);
            	 
                //For TD we are going to jump the number of columns the header jump because the array does not account for column spans we need to cjump
                //Because cells variable does not update after each move we can use the same indexes of the array to get the moved cell
                //I.e. index 1 is index 1 after the cell is inserted before index 5.
                for(i=0; i<colSpanTh; i++)
                {
                	row.insertBefore(cells[draggingColumnIndex+startThIndex+i], (i==0?(endColumnIndexTd>=cells.length?null:cells[endColumnIndexTd]):cells[draggingColumnIndexTd+i-1].nextSibling));
//                     draggingColumnIndex > endColumnIndex //IF moving right to left
//                     ? cells[endColumnIndex].parentNode.insertBefore(cells[draggingColumnIndex+i-((draggingColumnIndex-endColumnIndex)-crossColSpan)], cells[endColumnIndex])
//                     : cells[draggingColumnIndex+crossColSpan-1].parentNode.insertBefore(cells[draggingColumnIndex+i], cells[(i==0?(draggingColumnIndex+crossColSpan-1):(draggingColumnIndex+i-1))].nextSibling);
	           }
           }
        });

        // Bring back the table
        table.style.removeProperty('visibility');

        // Remove the handlers of `mousemove` and `mouseup`
        document.removeEventListener('mousemove', mouseMoveHandler);
        document.removeEventListener('mouseup', mouseUpHandler);
        
        allInputs = $('form').find('input[type=hidden][id*=Num]');
        for( i = 0; i < allInputs.length; i++ ){
            allInputs[i].value = (i+1);
        }
    };

    table.querySelectorAll('th').forEach(function(headerCell) {
        headerCell.classList.add('draggable');
        headerCell.addEventListener('mousedown', mouseDownHandler);
    });

      // Returns jquery object
      const thFromTd = function (td) {
        var ofs = td.offset().left,
            table = td.closest('table'),
            thead = table.children('tbody').eq(0),
            positions = cacheThPositions(thead),
            matches = positions.filter(function(eldata) {
              return eldata.left <= ofs;
            }),
            match = matches[matches.length-1],
            matchEl = $(match.el);
        return matchEl;
      }
    
      const cacheThPositions = function (thead) {
        allth = thead.children('tr').children('th');
        var data = allth.map(function() {
          var th = $(this);
          return {
            el: this,
            left: th.offset().left
          };
        }).toArray();
        thead.data('cached-pos', data);
        return data;
      }
      //cloneTable();
});
<?php }else{?>
$('tbody').sortable({
	axis:"y",
	stop: function( event, ui ) {
        allInputs = $('form').find('input[type=hidden][id*=Num]');
		 for( i = 0; i < allInputs.length; i++ ){
		 	allInputs[i].value = (i+1);
		 }
		}
	}); 
<?php }?>
$('.table').disableSelection();

function setTextColor(picker, valueInput) {
	valueInput.style.backgroundColor = '#' + picker.toString()
}
function toggleSettings(callingAnchor, settingsDiv) {
	var div = document.getElementById(settingsDiv);
	if(div != null){
		if(div.style.display == ""){
			div.style.display = "none";
			callingAnchor.style.background = "url(img/bg_navigation.png) no-repeat top;";				
		}else{
			div.style.display = "";
			callingAnchor.style.background = "url(img/bg_navigation.png) 0 -76px;";				
		}
		if(document.getElementById("settingsExpanded")!= null)document.getElementById("settingsExpanded").value = div.style.display;
	}
}

$('#uploadLogo').on('change', function () {
	  $.ajax({
	    // Your server script to process the upload
	    url: 'includes/upload_image.php',
	    type: 'POST',

	    // Form data
	    data: new FormData($('form')[0]),

	    // Tell jQuery not to process data or worry about content-type
	    // You *must* include these options!
	    cache: false,
	    contentType: false,
	    processData: false,

	    // Custom XMLHttpRequest
	    xhr: function () {
	   	  $('progress').show();
	      var myXhr = $.ajaxSettings.xhr();
	      if (myXhr.upload) {
	        // For handling the progress of the upload
	        myXhr.upload.addEventListener('progress', function (e) {
	          if (e.lengthComputable) {
	            $('progress').attr({
	              value: e.loaded,
	              max: e.total,
	            });
	          }
	        }, false);
	        myXhr.upload.addEventListener('load', function (e) {
		        	$('#tapListLogo').attr('src',"../img/logo.png?"+new Date().getTime());
		        }, false);

	      }
	      return myXhr;
	    }
	  });
	});

$('#uploadBack').on('change', function () {
	  $.ajax({
	    // Your server script to process the upload
	    url: 'includes/upload_image.php',
	    type: 'POST',

	    // Form data
	    data: new FormData($('form')[0]),

	    // Tell jQuery not to process data or worry about content-type
	    // You *must* include these options!
	    cache: false,
	    contentType: false,
	    processData: false,

	    // Custom XMLHttpRequest
	    xhr: function () {
	   	  
	      var myXhr = $.ajaxSettings.xhr();
	      if (myXhr.upload) {
	        myXhr.upload.addEventListener('load', function (e) {
		        	$('#customBody').css('background-image',"url('../img/background.jpg?"+new Date().getTime()+"')");
		        }, false);

	      }
	      return myXhr;
	    }
	  });
	});
function updateKegLeftText(textBox){
	var value = parseInt($(textBox)[0].value);
	if( value > 0 )
	{
		$("#volLeft").hide();
		$("#pintsLeft").show();
		$("#pintsLeft")[0].innerHTML = (<?php echo convert_volume($beeritem['remainAmount'], $beeritem['remainAmountUnit'], $config[ConfigNames::DisplayUnitVolume], FALSE, TRUE)?>/value).toFixed(2)+(" Pints Left"); 
	}else{
		$("#volLeft").show();
		$("#pintsLeft").hide();
	}
	
}
</script>
	<!-- End On Tap Section -->
	<!-- Right Side/Main Content End -->
	<!-- Start Left Bar Menu -->
<?php
include 'left_bar.php';
?>
	<!-- End Left Bar Menu -->
	<!-- Start Js  -->
<?php
//require_once 'scripts.php';
?>
	<!--[if IE 6]>
	<script type='text/javascript' src='scripts/png_fix.js'></script>
	<script type='text/javascript'>
	DD_belatedPNG.fix('img, .notifycount, .selected');
	</script>
	<![endif]-->
</body>
</html>
