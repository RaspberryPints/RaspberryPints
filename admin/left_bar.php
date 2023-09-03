<!-- Left Dark Bar Start -->
<div id="leftside">

<!-- Start User Echo -->
<div id="welcome"> &nbsp; Logged in as: <br />
	&nbsp;
	<?php
	class menuItem{
	    public $text;
	    public $link;
	    public $target;
	    public function __construct($_text, $_link, $_target=""){
	        $this->text = $_text;
	        $this->link = $_link;
	        $this->target = $_target;
	    }
	}
	class menuHeader{
	    public $text;
	    public $initCollapsed;
	    public $items = array();
	    
	    public function __construct($_text, $_initCollapsed){
	        $this->text = $_text;
	        $this->initCollapsed = $_initCollapsed;
	    }
	}
	if(isset($_SESSION['myusername']) )echo $_SESSION['myusername'];
	echo '<br/>';
	$menu = array();
	$menuHead = new menuHeader("Basic Setup", FALSE);
	array_push($menuHead->items, new menuItem("Beers", "beer_list.php"));
	array_push($menuHead->items, new menuItem("Beers Batches", "beerBatch_list.php"));
	array_push($menuHead->items, new menuItem("Kegs", "keg_list.php"));
	array_push($menuHead->items, new menuItem("Taps", "tap_list.php"));
	array_push($menuHead->items, new menuItem("Breweries", "brewery_list.php"));
	array_push($menuHead->items, new menuItem("Bottles", "bottle_list.php"));
	array_push($menuHead->items, new menuItem("Drinker Accounts", "user_list.php"));
	array_push($menuHead->items, new menuItem("Beer Styles", "beer_style_list.php"));
	array_push($menuHead->items, new menuItem("Fermenters", "fermenter_list.php"));
	array_push($menuHead->items, new menuItem("Gas Tanks", "gasTank_list.php"));
	array_push($menu, $menuHead);
	
	$menuHead = new menuHeader("Ingredients", FALSE);
	array_push($menuHead->items, new menuItem("Hops", "hops_list.php"));
	array_push($menuHead->items, new menuItem("Fermentables", "fermentables_list.php"));
	array_push($menuHead->items, new menuItem("Yeasts", "yeasts_list.php"));
	array_push($menuHead->items, new menuItem("Accolades", "accolades_list.php"));
	array_push($menu, $menuHead);
	
	$menuHead = new menuHeader("Personalization", FALSE);
	array_push($menuHead->items, new menuItem("Configuration", "personalize.php#columns"));
	array_push($menuHead->items, new menuItem("Headers", "personalize.php#tapHeader"));
	array_push($menuHead->items, new menuItem("Brewery Logo", "personalize.php#tapListLogo"));
	array_push($menuHead->items, new menuItem("Background Image", "personalize.php#tapListBackground"));
	array_push($menuHead->items, new menuItem("Brewery Defaults", "personalize.php#weightCalculation"));
	array_push($menuHead->items, new menuItem("Theme Options", "themes.php"));
	array_push($menuHead->items, new menuItem("Units of Measure", "units_of_measure.php"));
	array_push($menuHead->items, new menuItem("Customize Tap Display", "customize_tap_display.php"));
	array_push($menuHead->items, new menuItem("SRMs", "srm_form.php"));
	array_push($menu, $menuHead);
	
	$menuHead = new menuHeader("Advanced Hardware", TRUE);
	array_push($menuHead->items, new menuItem("RFID Readers", "rfid_reader_list.php"));
	array_push($menuHead->items, new menuItem("Temperature Probes", "temp_probe_list.php"));
	array_push($menuHead->items, new menuItem("Load Cells", "load_cell_list.php"));
	//array_push($menuHead->items, new menuItem("Valves", "valve_list.php"));
	array_push($menuHead->items, new menuItem("Motion Detectors", "motion_detector_list.php"));
	array_push($menuHead->items, new menuItem("iSpindel Connectors", "iSpindel_connector_list.php"));
	array_push($menuHead->items, new menuItem("iSpindel Devices", "iSpindel_device_list.php"));
	array_push($menuHead->items, new menuItem("Hardware IO Display", "ioPins_list.php"));
	array_push($menu, $menuHead);
		
	$menuHead = new menuHeader("Analytics", TRUE);
	array_push($menuHead->items, new menuItem("Temperature history", "temp_log.php"));
	array_push($menuHead->items, new menuItem("Pour history", "pour_list.php"));
	array_push($menuHead->items, new menuItem("Beer statistics", "stats_beer.php"));
	array_push($menuHead->items, new menuItem("Drinker statistics", "stats_drinker.php"));
	array_push($menuHead->items, new menuItem("Tap statistics", "stats_tap.php"));
	array_push($menuHead->items, new menuItem("Tap history", "stats_tapHistory.php"));
	array_push($menuHead->items, new menuItem("iSpindel history", "iSpindel_log.php"));
	array_push($menu, $menuHead);
	
	if(isset($_SESSION['showadmin']) && $_SESSION['showadmin']){
    	$menuHead = new menuHeader("Install", TRUE);
    	array_push($menuHead->items, new menuItem("Install Page", "manage_install.php"));
    	array_push($menuHead->items, new menuItem("Log", "rpints_log.php"));
    	array_push($menu, $menuHead);
	}
	
	$menuHead = new menuHeader("Help!", FALSE);
	array_push($menuHead->items, new menuItem("Report a Bug", "http://raspberrypints.com/report-bug/", '_blank'));
	array_push($menuHead->items, new menuItem("Suggest a Feature", "http://raspberrypints.com/request-feature/", '_blank'));
	array_push($menu, $menuHead);
	
	$menuHead = new menuHeader("External Links", TRUE);
	array_push($menuHead->items, new menuItem("Official Website", "http://www.raspberrypints.com/", '_blank'));
	array_push($menuHead->items, new menuItem("F.A.Q.", "http://www.raspberrypints.com/faq", '_blank'));
	array_push($menuHead->items, new menuItem("Visit Us on HBT", "http://www.homebrewtalk.com/f51/initial-release-raspberrypints-digital-taplist-solution-456809", '_blank'));
	array_push($menuHead->items, new menuItem("Contributors", "http://www.raspberrypints.com/contributors", '_blank'));
	array_push($menuHead->items, new menuItem("Licensing", "http://www.raspberrypints.com/licensing", '_blank'));
	array_push($menu, $menuHead);
	
	$foundI = -1;
	for($i = 0; $i < count($menu) && $foundI < 0; $i++){
	    $menuHeader = $menu[$i];    
	    for($j = 0; $j < count($menuHeader->items); $j++){
	        $link = $menuHeader->items[$j]->link;
	        if(strpos($link, '#') !== FALSE) $link = substr($link,0, strpos($link, '#'));
	        if($link == basename($_SERVER['PHP_SELF']))
	        {
	            $foundI = $i;
	            break;
	        }
	    }
    }
	for($i = 1; $i < $foundI; $i++){
	    $menu[$i]->initCollapsed = TRUE;
	}
	if( $foundI >= 0 && $foundI < count($menu) ) $menu[$foundI]->initCollapsed = FALSE;
	?>
</div>

<!-- End User Echo -->
<div class="user">
	<a href="../index.php"><img src="img/logo.png<?php echo "?" . time(); ?>" width="120" height="120" class="hoverimg" alt="Brewery Logo" /></a>
</div>

<!-- Start Navagation -->
<ul id="nav">
	<li>
		<ul class="navigation">
			<li class="heading selected">Welcome</li>
		</ul>
	</li>
	<?php 
	
    	for($i = 0; $i < count($menu); $i++){
    	    $menuHeader = $menu[$i];
    	    echo '<li><a class="'.(!$menuHeader->initCollapsed?"expanded":"collapsed").' heading">'.$menuHeader->text.'</a>';
    	    echo '<ul class="navigation">';
    	    for($j = 0; $j < count($menuHeader->items); $j++){
    	        echo'<li><a href="'.$menuHeader->items[$j]->link.'" '.(!empty($menuHeader->items[$j]->target)?' target="'.$menuHeader->items[$j]->target.'"':'').'>'.$menuHeader->items[$j]->text.'</a></li>';
    	    }
    	    echo '</ul></li>';
    	}
	?>
</ul>

<div>
	<?php
		require_once 'includes/managers/config_manager.php';
		echo "&nbsp;&nbsp;" . getConfigValue(ConfigNames::Version);
	?>
</div>

<!-- End Navagation -->
</div>
<!-- Left Dark Bar End --> 
