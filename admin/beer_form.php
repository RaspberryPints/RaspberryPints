<?php
require_once __DIR__.'/header.php';
require_once __DIR__.'/../includes/Pintlabs/Service/Untappd.php';
require_once __DIR__.'/../includes/functions.php';
require_once __DIR__.'/includes/managers/beerFermentable_manager.php';
require_once __DIR__.'/includes/managers/beerHop_manager.php';
require_once __DIR__.'/includes/managers/beerYeast_manager.php';
require_once __DIR__.'/includes/managers/beerAccolade_manager.php';
require_once __DIR__.'/includes/models/beerFermentable.php';
require_once __DIR__.'/includes/models/beerHop.php';
require_once __DIR__.'/includes/models/beerYeast.php';
require_once __DIR__.'/includes/managers/containerType_manager.php';

$htmlHelper = new HtmlHelper();
$beerManager = new BeerManager();
$beerStyleManager = new BeerStyleManager();
$FermentableManager = new FermentableManager();
$HopManager= new HopManager();
$YeastManager = new YeastManager();
$AccoladeManager = new AccoladeManager();
$beerFermentableManager = new BeerFermentableManager();
$beerHopManager= new BeerHopManager();
$beerYeastManager = new BeerYeastManager();
$beerAccoladeManager = new BeerAccoladeManager();
$breweryManager = new BreweryManager();
$srmManager = new SrmManager();
$containerTypeManager= new ContainerTypeManager();
$beer = null;
$config = getAllConfigs();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$beer = new Beer();
	if(isset($_POST["fromUntapped"])){
	    $breweryList = $breweryManager->GetAllActive();
	    $ut = new Pintlabs_Service_Untappd($config);
	    try{
	       $feed = $ut->beerInfo($_POST["untID"]);
    	    if($feed){
        	    $beer = new Beer();
        	    $beer->set_name($feed->response->beer->beer_name);
        	    $beer->set_untID($feed->response->beer->bid);
        	    $beer->set_notes($feed->response->beer->beer_description);
        	    $beer->set_abv($feed->response->beer->beer_abv);
        	    $beer->set_ibu($feed->response->beer->beer_ibu);
        	    $brewery = $breweryManager->GetOrAdd($feed->response->beer->brewery->brewery_name, $feed->response->beer->brewery->brewery_label);
        	    if($brewery) $beer->set_breweryId($brewery->get_id());
        	    
        	    $style = $beerStyleManager->GetFirstByName($feed->response->beer->beer_style);
        	    if( $style ) $beer->set_beerStyleId($style->get_id());
    	    }else{
    	        $_SESSION['errorMessage'] = "Unable to find Untappd ID =".$_POST["untID"];
    	    }
	    }catch(Exception $e){
	        $_SESSION['errorMessage'] = $e->__toString();
	    }
	}else{
    	$beer->setFromArray($_POST);
    	if($beerManager->Save($beer)){
    	    beerRATING($config, $beer->get_untID(), FALSE);
    	    
    	    $beerFermentableManager->DeleteAllByBeerId($beer->get_id());
    	    $beerHopManager->DeleteAllByBeerId($beer->get_id());
    	    $beerYeastManager->DeleteAllByBeerId($beer->get_id());
    	    $beerAccoladeManager->DeleteAllByBeerId($beer->get_id());
    	    
    	    if(isset($_POST['fermId'])){
    	        $ii = 0;
        	    while(isset($_POST['fermId'][$ii])){
        	        if($_POST['fermId'][$ii] != ''){
            	        $id = explode("~", $_POST['fermId'][$ii])[0];
            	        $item = new BeerFermentable();
            	        //$item->set_id($_POST['beerFermId'][$ii]);
            	        $item->set_beerID($beer->get_id());
            	        $item->set_fermentablesID($id);
            	        $item->set_amount($_POST['fermAmount'][$ii]);
            	        $item->set_time($_POST['fermTime'][$ii]);
            	        $beerFermentableManager->Save($item); 
        	        }
        	        $ii++;
        	    }
    	    }
    	    if(isset($_POST['hopId'])){
    	        $ii = 0;
    	        while(isset($_POST['hopId'][$ii])){
    	            if($_POST['hopId'][$ii] != ''){
    	                $id = explode("~", $_POST['hopId'][$ii])[0];
        	            $item = new BeerHop();
    	               // $item->set_id($_POST['beerHopId'][$ii]);
        	            $item->set_beerID($beer->get_id());
        	            $item->set_hopsID($id);
        	            $item->set_amount($_POST['hopAmount'][$ii]);
        	            $item->set_time($_POST['hopTime'][$ii]);
        	            $beerHopManager->Save($item);
    	            }
    	            $ii++;
    	        }
    	    }
    	    if(isset($_POST['yeastId'])){
    	        $ii = 0;
    	        while(isset($_POST['yeastId'][$ii])){
    	            if($_POST['yeastId'][$ii] != ''){
        	            $id = explode("~", $_POST['yeastId'][$ii])[0];
        	            $item = new BeerYeast();
        	           // $item->set_id($_POST['beerYeastId'][$ii]);
        	            $item->set_beerID($beer->get_id());
        	            $item->set_yeastsID($id);
        	            $item->set_amount($_POST['yeastAmount'][$ii]);
        	            $beerYeastManager->Save($item);
    	            }
    	            $ii++;
    	        }
    	    }
    	    if(isset($_POST['accoladeId'])){
    	        $ii = 0;
    	        while(isset($_POST['accoladeId'][$ii])){
    	            if($_POST['accoladeId'][$ii] != ''){
        	            $id = explode("~", $_POST['accoladeId'][$ii])[0];
        	            $item = new BeerAccolade();
        	           // $item->set_id($_POST['beerYeastId'][$ii]);
        	            $item->set_beerID($beer->get_id());
        	            $item->set_accoladeID($id);
        	            $item->set_amount($_POST['accoladeAmount'][$ii]);
        	            $beerAccoladeManager->Save($item);
    	            }
    	            $ii++;
    	        }
    	    }
    	    redirect('beer_list.php');
    	}
	}
}

if( null === $beer ){
    if( isset($_GET['id'])){
    	$beer = $beerManager->GetById($_GET['id']);
    }else{
    	$beer = new Beer();
    	$beer->setFromArray($_POST);
    }
}

$fementableList = $FermentableManager->GetAllActive();
$hopList = $HopManager->GetAllActive();
$yeastList = $YeastManager->GetAllActive();
$accoladeList = $AccoladeManager->GetAllActive();

$beerFermentables = $beerFermentableManager->GetAllByBeerId($beer->get_id());
$beerHops = $beerHopManager->GetAllByBeerId($beer->get_id());
$beerYeasts  = $beerYeastManager->GetAllByBeerId($beer->get_id());
$beerAccolades  = $beerAccoladeManager->GetAllByBeerId($beer->get_id());

$breweryList = $breweryManager->GetAllActive();
$srmList = $srmManager->getAll();
$cTypes = $containerTypeManager->GetAllActive();
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
			<li><a href="beer_list.php">My Beers</a></li>
			<li>/</li>
			<li class="current">Beer Form</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer med left">
			<p>Fields marked with <b><font color="red">*</font></b> are required.<br><br>
			<?php $htmlHelper->ShowMessage(); ?>

	<form id="beer-form" method="POST" action="image_prompt.php?id=<?php echo $beer->get_id();?>">
		<input type="hidden" name="id" value="<?php echo $beer->get_id() ?>" />
		<input type="hidden" name="active" value="<?php echo $beer->get_active() ?>" />		
        <input type="hidden" name="targetDir" value="beer/beer"/>
        <input type="hidden" name="redirect" value="../beer_form.php?id=<?php echo $beer->get_id() ?>"/>
		<table style="width:800;border:0;cellspacing:1;cellpadding:0;">	
			<tr>
				<td style="vertical-align: middle">
					<b>Image:</b>
				</td>
				<td style="vertical-align: middle">
                   <?php 
                        $hasImg = false;
                        if(isset($beer))
						{
						    $imgs = glob ( '../img/beer/beer'.$beer->get_id().'.*' );
							if(count($imgs) > 0)
							{
							    echo '<img src="'.$imgs[0].'"></img>';
							    $hasImg = true;
							}
						}
					?> 
                	<?php if($hasImg) {?>
                		<a onclick="removeImage(<?php echo $beer->get_id();?>)"><span class="tooltip"><img src="img/icons/icon_missing.png" /><span class="tooltiptext">Remove Beer Image</span></span></a>
                	<?php }?>
                	<input name="save" type="submit" class="btn" value="Upload" />
				</td>
			</tr>
		</table>
	</form>
	<form id="beer-form" method="POST">
		<input type="hidden" name="id" value="<?php echo $beer->get_id() ?>" />
		<input type="hidden" name="active" value="<?php echo $beer->get_active() ?>" />

		<table style="width:800;border:0;cellspacing:1;cellpadding:0;">
			<tr>
				<td width="100">
					<b>Name:<font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="name" class="largebox" name="name" value="<?php echo $beer->get_name() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<b>UnTappd Beer ID:</b>
				</td>
				<td>
					<input type="text" id="untID" class="smallbox" name="untID" value="<?php echo $beer->get_untID() ?>" />
				</td>
			</tr>
			<tr>
			<tr>
				<td>
					<b>Brewery:</b>
				</td>
				<td>
					<?php echo $htmlHelper->ToSelectList("breweryId", "breweryId", $breweryList, "name", "id", $beer->get_breweryId(), "Select One"); ?>
				</td>
			</tr>
			<tr>
				<td rowspan=2>
					<b>Style:</b>
				</td>
				<td>
		          Beer style list: <br>
		          <?php 
						$beerStyleLists = $beerStyleManager->GetBeerStyleList();
						$beersStyle = $beerStyleManager->GetById($beer->get_beerStyleId());
						$beersStyleList=""; 
						foreach($beerStyleLists as $styleList)
						{ 
							$selected = "";
							$styleId = preg_replace('/\s+/', '', $styleList);
							if($beersStyle && $styleList == $beersStyle->get_beerStyleList())
							{
								$selected = "checked";
								$beersStyleList = $styleId;
							}
							echo "$styleList<input type=\"radio\" name=\"beerStyleList\" id='styleListBtn$styleId' value=\"$styleId\" $selected onclick=\"changeVisibleStyleList(this, 'styleListDiv$styleId');\" />&nbsp;\n";
						}
		         ?>
                 
		         </td>
			</tr>
			<tr>
				<td>
				  	<div id="styleListsDiv">
		          	<?php 
						echo "<input type=\"hidden\" name=\"beerStyleId\" id=\"beerStyleId\" value=\"".$beer->get_beerStyleId()."\" />";
						foreach($beerStyleLists as $styleList)
						{ 	
							$styleId = preg_replace('/\s+/', '', $styleList);
				  			echo "<div id=\"styleListDiv$styleId\" ".($beersStyleList!=$styleId?"style=\"display:none\"":""). " >";
							$beerStyleList = $beerStyleManager->GetAllByList($styleList); 
							echo $htmlHelper->ToCombinedSelectList("beerStyleId$styleId", $beerStyleList, "catNum", "name", "id", 
																	$beer->get_beerStyleId(), "Select One", "", "setInputValue('beerStyleId', this)"); 
							
		          			echo "</div>";
						}
					?>
                    </div>
				</td>
			</tr>
			<tr>
				<td>
					<b>SRM:</b>
				</td>
				<td>
                    <?php
					   	echo $htmlHelper->ToColorSelectList("srm", "srm", $srmList, "srm", "srm", $beer->get_srm(), "Select SRM", "", "rgb"); 
					?>							
				</td>
			</tr>
			<tr>
				<td>
					<b>Container :</b>
				</td>
				<td>
					<!--<table>
					<tr><td>
					 <img width="50px" src="../img/srm/containerSvg.php?container=<?php echo "nonic"; ?>&rgb=<?php echo $beer->get_srm(); ?>" />
					
					</td><td>-->
                    <?php
                        echo $htmlHelper->ToSelectList("containerId", "containerId", $cTypes, "name", "id", $beer->get_containerId(), null); 
					?>	
					<!--</td></tr>
					</table>-->						
				</td>
			</tr>
			<tr>
				<td>
					<b>IBU:</b>
				</td>
				<td>
					<input type="text" id="ibu" class="xsmallbox" name="ibu" value="<?php echo $beer->get_ibu() ?>" />
				</td>
			</tr>
            <tr >
            	<td colspan="2">
                ABV is fixed value and overrides OG/FG.
                If ABV not filled in and OG/FG are, ABV will be calculated
                </td>
            </tr>
            <tr>
                <td>
                    <b>ABV:</b>
                </td>
                <td>
                    <input type="text" id="abv" class="smallbox" name="abv" value="<?php echo $beer->get_abv() ?>" />
                </td>
            </tr>
			<tr>
				<td>
					<b>OG:</b>
				</td>
				<td>
					<input type="text" id="og" class="smallbox" name="og" value="<?php echo convert_gravity($beer->get_og(), $beer->get_ogUnit(), $config[ConfigNames::DisplayUnitGravity]); ?>" /> <?php echo $config[ConfigNames::DisplayUnitGravity]; ?>
					<input type="hidden" name="ogUnit" value="<?php echo $config[ConfigNames::DisplayUnitGravity]; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<b>FG:</b>
				</td>
				<td>
					<input type="text" id="fg" class="smallbox" name="fg" value="<?php echo convert_gravity($beer->get_fg(), $beer->get_fgUnit(), $config[ConfigNames::DisplayUnitGravity]); ?>" /> <?php echo $config[ConfigNames::DisplayUnitGravity]; ?>
					<input type="hidden" name="fgUnit" value="<?php echo $config[ConfigNames::DisplayUnitGravity]; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<b>Rating:</b>
				</td>
				<td>
					<input type="text" id="fg" class="smallbox" name="rating" value="<?php echo $beer->get_rating() ?>" />
				</td>
            </tr>
            <tr>
				<td>
					<b>Tasting<br>Notes:</b>
				</td>
				<td>
					<textarea id="notes" class="text-input textarea" style="width:320px;height:80px" name="notes"><?php echo $beer->get_notes() ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<h3 style="align-content:center">Fermentables</h3>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<table style="width:100%" id="fermentableList">
						<tr style="width:100%">
							<td><strong>Name</strong></td>
							<td><strong>Amount</strong></td>
							<td><strong>Time</strong></td>
							<td><strong>Type</strong></td>
							<td><strong>SRM</strong></td>
							<td></td>
						</tr>
						
                            <?php
                            if(count($beerFermentables) == 0){
                                $beerFermentables[] = new BeerFermentable();
                            } 
                            $ii = 0;
							foreach ($beerFermentables as $beerFermentable){
							?>
							<tr style="width:100%">
							<td>         
								<input type="hidden" id="beerFermId" name="beerFermId[]" value="<?php echo $beerFermentable->get_id(); ?>"/>                   
							<?php 
							    $selectedItem = null;
							    $str = "<select id='fermId".$ii."' name='fermId[]' class='' onChange='toggleDisplay(this, 3)'>\n";
                                $str .= "<option value=''>Select One</option>\n";
                                foreach($fementableList as $item){
                                    if( !$item ) continue;
                                    $sel = "";
                                    if( $beerFermentable && $beerFermentable->get_fermentablesID() == $item->get_id() ){
                                        $sel .= "selected ";
                                        $beerFermentable->set_fermentable($item);
                                    }
                                    $desc = $item->get_name();
									$str .= "<option value='".$item->get_id()."~".$item->get_name()."~".$item->get_type()."~".$item->get_srm()."|".$item->get_rgb()."' ".$sel.">".$desc."</option>\n";
                                }					
                                $str .= "</select>\n";
                                                        
                                echo $str;
                            ?>
							</td>
							<td><input type="text" id="fermAmount" class="meddiumbox" name="fermAmount[]" value="<?php echo $beerFermentable->get_amount() ?>"/></td>
							<td><input type="text" id="fermTime" class="meddiumbox" name="fermTime[]" value="<?php echo $beerFermentable->get_time() ?>"/></td>
							<td><input type="text" disabled id="fermtype" class="meddiumbox" name="fermtype[]" value="<?php echo $beerFermentable->get_fermentable()->get_type() ?>"/></td>
							<td><input type="text" disabled id="fermSrm" class="meddiumbox" name="fermSrm[]" value="<?php echo $beerFermentable->get_fermentable()->get_srm() ?>" style="background-color:rgb(<?php echo $beerFermentable->get_fermentable()->get_rgb() ?>)"/></td>
                            <td style="width:10%;vertical-align: middle;">
                                <button name="delete" type="button" class="btn" style="white-space:nowrap" value="<?php echo $beer->get_id()?>" onClick="removeRow(this)">Delete</button>
                            </td>
						</tr>
						<?php
						      $ii++;
							}
					?>
					</table>
				</td>
			</tr>
			<tr> 
				<td>	
	 				<input type="button" id="newRow1" name="newRow2" class="btn" value="Add Fermentable" onclick="addRow('fermentableList')" />
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<h3 style="align-content:center">Hops</h3>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<table style="width:100%"  id="hopList">
						<tr style="width:100%">
							<td>Name</td>
							<td><strong>Amount</strong></td>
							<td><strong>Time</strong></td>
							<td><strong>Alpha</strong></td>
							<td><strong>Beta</strong></td>
							<td></td>
						</tr>
					<?php 
						if( count($beerHops) == 0 ){  
						    $beerHops[] = new BeerHop(); 
						}
						foreach ($beerHops as $beerHop){
						?>
						<tr style="width:100%">
						<td>        
							<input type="hidden" id="beerHopId" name="beerHopId[]" value="<?php echo $beerHop->get_id(); ?>"/>              
							<?php 					
							    $str = "<select id='hopId".$ii."' name='hopId[]' class='' onChange='toggleDisplay(this, 3)'>\n";
                                $str .= "<option value=''>Select One</option>\n";
                                foreach($hopList as $item){
                                    if( !$item ) continue;
                                    $sel = "";
                                    if( $beerHop && $beerHop->get_hopsID() == $item->get_id() ){
                                        $sel .= "selected ";
                                        $beerHop->set_hop($item);
                                    }
                                    $desc = $item->get_name();
									$str .= "<option value='".$item->get_id()."~".$item->get_name()."~".$item->get_alpha()."~".$item->get_beta()."' ".$sel.">".$desc."</option>\n";
                                }					
                                $str .= "</select>\n";
                                                        
                                echo $str;
                            ?>
                        </td>
						<td><input type="text" id="hopAmount" class="meddiumbox" name="hopAmount[]" value="<?php echo $beerHop->get_amount() ?>"/></td>
						<td><input type="text" id="hopTime" class="meddiumbox" name="hopTime[]" value="<?php echo $beerHop->get_time() ?>"/></td>
						<td><input type="text" disabled id="hopAlpha" class="meddiumbox" name="fermtype[]" value="<?php echo $beerHop->get_hop()->get_alpha() ?>"/></td>
						<td><input type="text" disabled id="hopBeta" class="meddiumbox" name="fermtype[]" value="<?php echo $beerHop->get_hop()->get_beta() ?>"/></td>
						<td style="width:10%;vertical-align: middle;">
                            <button name="delete" type="button" class="btn" style="white-space:nowrap" value="<?php echo $beer->get_id()?>" onClick="removeRow(this)">Delete</button>
                        </td>
					</tr>
					<?php
							}
					?>
					</table>
				</td>
			</tr>
			<tr> 
				<td>	
	 				<input type="button" id="newRow1" name="newRow2" class="btn" value="Add Hop" onclick="addRow('hopList')" />
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<h3 style="align-content:center">Yeast</h3>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<table id="yeastList">
						<tr style="width:100%">
							<td><strong>Name</strong></td>
							<td><strong>Amount</strong></td>
							<td><strong>Strand</strong></td>
							<td><strong>Format</strong></td>
						</tr>
                        <?php 
						if( count($beerYeasts) == 0 ){  
						  $beerYeasts[] = new BeerYeast();
						}
						foreach ($beerYeasts as $beerYeast){
						?>
    						<tr style="width:100%">
    						<td>
							<input type="hidden" id="beerYeastId" name="beerYeastId[]" value="<?php echo $beerYeast->get_id(); ?>"/>                     
							<?php 					
							    $str = "<select id='yeastId".$ii."' name='yeastId[]' class='' onChange='toggleDisplay(this, 2)'>\n";
                                $str .= "<option value=''>Select One</option>\n";
                                foreach($yeastList as $item){
                                    if( !$item ) continue;
                                    $sel = "";
                                    if( $beerYeast && $beerYeast->get_yeastsID() == $item->get_id() ){
                                        $sel .= "selected ";
                                        $beerYeast->set_yeast($item);
                                    }
                                    $desc = $item->get_name();
									$str .= "<option value='".$item->get_id()."~".$item->get_name()."~".$item->get_strand()."~".$item->get_format()."' ".$sel.">".$desc."</option>\n";
                                }					
                                $str .= "</select>\n";
                                                        
                                echo $str;
                            ?>
                            </td>
    						<td><input type="text" id="yeastAmount" class="meddiumbox" name="yeastAmount[]" value="<?php echo $beerYeast->get_amount() ?>"/></td>
    						<td><input type="text" disabled id="yeastStrand" class="meddiumbox" name="yeastStrand[]" value="<?php echo $beerYeast->get_yeast()->get_strand() ?>"/></td>
    						<td><input type="text" disabled id="yeastFormat" class="meddiumbox" name="yeastFormat[]" value="<?php echo $beerYeast->get_yeast()->get_format() ?>"/></td>
    						<td style="width:10%;vertical-align: middle;">
                                <button name="delete" type="button" class="btn" style="white-space:nowrap" value="<?php echo $beer->get_id()?>" onClick="removeRow(this)">Delete</button>
                            </td>
    					</tr>
					<?php
						}
					?>
					</table>
				</td>
			</tr>
			<tr> 
				<td>	
	 				<input type="button" id="newRow1" name="newRow2" class="btn" value="Add Yeast" onclick="addRow('yeastList')" />
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<h3 style="align-content:center">Accolades</h3>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<table id="accoladeList">
						<tr style="width:100%">
							<td><strong>Name</strong></td>
							<td><strong>Amount</strong></td>
						</tr>
                        <?php 
                        if( count($beerAccolades) == 0 ){  
						  $beerAccolades[] = new BeerAccolade();
						}
						foreach ($beerAccolades as $beerAccolade){
						?>
    						<tr style="width:100%">
    						<td>
							<input type="hidden" id="beerAccoladeId" name="beerAccoladeId[]" value="<?php echo $beerAccolade->get_id(); ?>"/>                     
							<?php 	
							   $selStyle = '';
							   $str = '';
							   $str .= "<option value=''>Select One</option>\n";
                                foreach($accoladeList as $item){
                                    if( !$item ) continue;
                                    $sel = "";
                                    if( $beerAccolade && $beerAccolade->get_accoladeID() == $item->get_id() ){
                                        $sel .= "selected ";
                                        $beerAccolade->set_accolade($item);
                                        $selStyle = "style=\"background-color:rgb(".$item->get_rgb().")\"";
                                    }
                                    $desc = $item->get_name();
                                    $str .= "<option value='".$item->get_id()."~".$item->get_name()."' ".$sel." style=\"background-color:rgb(".$item->get_rgb().")\">".$desc."</option>\n";
                                }					
                                $str .= "</select>\n";
                                $selStr = "<select id='accoladeId".$ii."' $selStyle name='accoladeId[]' class='' onChange='toggleDisplay(this, 2); this.style.backgroundColor=this.children[this.selectedIndex].style.backgroundColor;'>\n".$str;
                                                        
                                echo $selStr;
                            ?>
                            </td>
    						<td><input type="text" id="accoladeAmount" class="meddiumbox" name="accoladeAmount[]" value="<?php echo $beerAccolade->get_amount() ?>"/></td>
    						<td style="width:10%;vertical-align: middle;">
                                <button name="delete" type="button" class="btn" style="white-space:nowrap" value="<?php echo $beer->get_id()?>" onClick="removeRow(this)">Delete</button>
                            </td>
    					</tr>
					<?php
						}
					?>
					</table>
				</td>
			</tr>
			<tr> 
				<td>	
	 				<input type="button" id="newRow1" name="newRow2" class="btn" value="Add Accolade" onclick="addRow('accoladeList')" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input name="save" type="submit" class="btn" value="Save" />
					<input type="button" class="btn" value="Cancel" onClick="window.location='beer_list.php'" />
				</td>
			</tr>								
		</table>
		<br />
		<div align="right">			
			&nbsp; &nbsp; 
		</div>

	</form>
	</div>
	<!-- End On Tap Section -->

	<!-- Start Footer -->   
<?php 
require __DIR__.'/footer.php';
?>

	<!-- End Footer -->
		
	</div>
	<!-- Right Side/Main Content End -->
	<!-- Start Left Bar Menu -->   
<?php 
require __DIR__.'/left_bar.php';
?>
	<!-- End Left Bar Menu -->  
	<!-- Start Js  -->
<?php
require __DIR__.'/scripts.php';
?>

<script>
	$(function() {		
		
		$('#beer-form').validate({
		rules: {
			name: { required: true },
			style: { required: false },			
			srm: { required: false, number: true },
			ibu: { required: false, number: true },
			abv: { required: false, number: true },
			og: { required: false, number: true },
			fg: { required: false, number: true },
			rating: { required: false, number: true }
		}
		});
		
	});
</script>

<script type='text/javascript'>
	function changeVisibleStyleList(radioBtn, divId)
	{
		var sytleListDiv = document.getElementById("styleListsDiv");
		var allDivs = sytleListDiv.getElementsByTagName('div');
		for(i = 0; i < allDivs.length; i++)
		{
			allDivs[i].style.display = "none";
		}
		document.getElementById(divId).style.display = (radioBtn.checked==true?"":"none");
	}
	function setInputValue(inputId, selectElem)
	{
		document.getElementById(inputId).value = selectElem.value;
	}

	function toggleDisplay(selectObject, numConfigs) {
		var selArr = selectObject.value.split("~");
		var curTD = $(selectObject).parent().get(0);
		for(ii = 0; ii < numConfigs; ii++){
			curTD = $(curTD).next('td');
			if(curTD == null) break;
		}
		//Select array is id~name~data1~data2...
		for(ii = 2; ii < selArr.length; ii++){
			var inputs = $(curTD).find("input");
			if(inputs.length == 0)break;
			$(inputs).each(function() {
		        var valArr = selArr[ii].split("|");
		        this.value = valArr[0];
		        if(valArr.length > 1){
					this.style.backgroundColor = "rgb("+valArr[1]+")";
		        }
		    });

			curTD = $(curTD).next('td');
			if(curTD == null) break;
		}
	}

	function getRowStructure(tableName){
        	var rowStructure = $('#'+tableName).find('tr:eq(1)').clone();
        	rowStructure.find('input, select').each(function(){this.value="";});
        	rowStructure.find('select').each(function(){this.value=-1; this.style.backgroundColor=""});
        	return rowStructure;
	}
	function addRow(tableName){		
		var $table = $('#'+tableName)
		$table.append(getRowStructure(tableName).clone());
		if($("#pendingChangesDiv")[0] != null)$("#pendingChangesDiv")[0].style.display="";
	}
	function removeRow(btn){		
		$(btn).closest('tr').remove();
		if($("#pendingChangesDiv")[0] != null)$("#pendingChangesDiv")[0].style.display="";
	}
	function removeImage(id){
	    var form = document.createElement("form");
	    var element2 = document.createElement("input"); 
	    form.method = "POST";
	    form.action = "image_remove.php?id="+id+"&type=beer";   
	    element2.value="beer_form.php?id="+id;
	    element2.name="redirect";
	    form.appendChild(element2);  
	    document.body.appendChild(form);

	    form.submit();
  	}
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
