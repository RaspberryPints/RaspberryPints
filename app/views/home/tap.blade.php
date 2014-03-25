
							<tr class="<?php if($i%2 > 0){ echo 'altrow'; }?>" id="<?php echo $beer['id']; ?>">
								<?php if($options[OptionNames::ShowTapNumCol]){ ?>
									<td class="tap-num">
										<span class="tapcircle"><?php echo $i; ?></span>
									</td>
								<?php } ?>
							
								<?php if($options[OptionNames::ShowSrmCol]){ ?>
									<td class="srm">
										<h3><?php echo $beer->ogAct; ?> {{{ Lang::get('common.og') }}}</h3>
										
										<div class="srm-container">
											<div class="srm-indicator" style="background-color: rgb(<?php echo $beer->srmRgb != "" ? $beer->srmRgb : "0,0,0" ?>)"></div>
											<div class="srm-stroke"></div> 
										</div>
										
										<h2><?php echo $beer->srmAct; ?> {{{ Lang::get('common.srm') }}}</h2>
									</td>
								<?php } ?>
							
								<?php if($options[OptionNames::ShowIbuCol]){ ?>
									<td class="ibu">
										<h3>
											<?php 
												if( $beer->ogAct > 1 ){
													echo $beer->BUGU();
												}else{
													echo '0.00';
												}
											?> 
											BU:GU
										</h3>
										
										<div class="ibu-container">
											<div class="ibu-indicator"><div class="ibu-full" style="height:<?php echo $beer->ibuAct > 100 ? 100 : $beer->ibuAct; ?>%"></div></div>
												
										</div>								
										<h2><?php echo $beer->ibuAct; ?> {{{ Lang::get('common.ibu') }}}</h2>
									</td>
								<?php } ?>
							
								<td class="name">
								<div class="beerimg">
									{{{ Untappd::beerIMG($options,$beer->untID) }}}
									</div>
									<h1><?php echo $beer->name; ?></h1>
									<h2 class="subhead"><?php echo $beer->style; ?></h2>
									<p class="rating">
									{{{ Untappd::BeerRating($options,$beer->untID) }}}
									</p>
									<p><?php echo $beer->notes; ?></p>
								</td>
							
								<?php if(($options[OptionNames::ShowAbvCol]) && ($options[OptionNames::ShowAbvImg])){ ?>
									<td class="abv">
										<h3><?php echo $beer->Calories(); ?> {{{ Lang::get('common.kCal') }}}
										</h3>
										<div class="abv-container">
											<?php
												$numCups = 0;
												$remaining = $beer->ABV() * 20;
												do{
														if( $remaining < 100 ){
																$level = $remaining;
														}else{
																$level = 100;
														}
														?><div class="abv-indicator"><div class="abv-full" style="height:<?php echo $level; ?>%"></div></div><?php
														
														$remaining = $remaining - $level;
														$numCups++;
												}while($remaining > 0 && $numCups < 2);
												
												if( $remaining > 0 ){
													?><div class="abv-offthechart"></div><?php
												}
											?>
										</div>
										<h2><?php echo number_format($beer->ABV(), 1, '.', ',')."%"; ?> {{{ Lang::get('common.abv') }}}</h2>
									</td>
								<?php } ?>
								
								<?php if(($options[OptionNames::ShowAbvCol]) && ! ($options[OptionNames::ShowAbvImg])){ ?>
									<td class="abv">
										<h3><?php echo $beer->Calories() ?> {{{ Lang::get('common.kCal') }}} </h3>									
										<h2><?php echo number_format($beer->ABV(), 1, '.', ',')."%"; ?>  {{{ Lang::get('common.abv') }}}</h2>
									</td>
								<?php } ?>
								
								<?php if($options[OptionNames::ShowKegCol]){ ?>
									<td class="keg">
										<h3><?php echo number_format((($beer->startLiter - $beer->remainAmount)/0.0296)); ?> {{{ Lang::get('common.flOzPoured') }}}</h3>
										<?php 
											$kegImgClass = "";
											$percentRemaining = $beer->PercentRemaining();
											if( $beer->remainAmount <= 0 ) {
												$kegImgClass = "keg-empty";
												$percentRemaining = 100; }
											else if( $percentRemaining < 15 )
												$kegImgClass = "keg-red";
											else if( $percentRemaining < 25 )
												$kegImgClass = "keg-orange";
											else if( $percentRemaining < 45 )
												$kegImgClass = "keg-yellow";
											else if ( $percentRemaining < 100 )
												$kegImgClass = "keg-green";
											else if( $percentRemaining >= 100 )
												$kegImgClass = "keg-full";
										?>
										<div class="keg-container">
											<div class="keg-indicator"><div class="keg-full <?php echo $kegImgClass ?>" style="height:<?php echo $percentRemaining; ?>%"></div></div>
										</div>
										<h2><?php echo number_format(($beer->remainAmount)/0.0296); ?> {{{ Lang::get('common.flOzLeft') }}}</h2>
									</td>
								<?php } ?>
							</tr>