							<tr class="<?php if($i%2 > 0){ echo 'altrow'; }?>">
								<?php if($options[OptionNames::ShowTapNameCol]){ ?>
									<td class="tap-name">
										<span class="tapcircle"><?php echo $beer->tapName; ?></span>
									</td>
								<?php } ?>

								<?php if($options[OptionNames::ShowSrmCol]){ ?>
									<td class="srm">
										<h3></h3>
										<div class="srm-container">
											<div class="srm-indicator"></div>
											<div class="srm-stroke"></div>
										</div>

										<h2></h2>
									</td>
								<?php } ?>

								<?php if($options[OptionNames::ShowIbuCol]){ ?>
									<td class="ibu">
										<h3></h3>
										<div class="ibu-container">
											<div class="ibu-indicator"><div class="ibu-full" style="height:0%"></div></div>
										</div>
										<h2></h2>
									</td>
								<?php } ?>

								<td class="name">
									<h1>{{{ Lang::get('common.nothingOnTap') }}}</h1>
									<h2 class="subhead"></h2>
									<p></p>
								</td>

								<?php if(($options[OptionNames::ShowAbvCol]) && ($options[OptionNames::ShowAbvImg])){ ?>
									<td class="abv">
										<h3></h3>
										<div class="abv-container">
											<div class="abv-indicator"><div class="abv-full" style="height:0%"></div></div>
										</div>
										<h2></h2>
									</td>
								<?php } ?>

								<?php if(($options[OptionNames::ShowAbvCol]) && ! ($options[OptionNames::ShowAbvImg])){ ?>
									<td class="abv">
										<h3></h3>

										<h2></h2>
									</td>
								<?php } ?>

								<?php if($options[OptionNames::ShowKegCol]){ ?>
									<td class="keg">
										<h3></h3>
										<div class="keg-container">
											<div class="keg-indicator"><div class="keg-full keg-empty" style="height:0%"></div></div>
										</div>
										<h2>0 {{{ Lang::get('common.flOzLeft') }}}</h2>
									</td>
								<?php } ?>
							</tr>