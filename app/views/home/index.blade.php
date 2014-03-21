<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html>
	<head>
		<title>{{{ Lang::get('common.raspberryPints') }}}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		{{ HTML::style('styles/home.css'); }}
		
		<?php if($options[OptionNames::UseHighResolution]) { ?>
			{{ HTML::style('styles/high-res.css'); }}			
		<?php } ?>
		
		<link rel="shortcut icon" href="img/pint.ico">
	</head> 

	<body>
		<div class="bodywrapper">
			<!-- Header with Brewery Logo and Project Name -->
			<div class="header clearfix">
				<div class="HeaderLeft">
					<a href="{{URL::to('/admin')}}">
						<?php if($options[OptionNames::UseHighResolution]) { ?>		
							<img src={{asset($options[OptionNames::LogoUrl])}} height="200" alt="">
						<?php } else { ?>
							<img src={{asset($options[OptionNames::LogoUrl])}} height="100" alt="">
						<?php } ?>
					</a>
				</div>
				<div class="HeaderCenter">
					<h1 id="HeaderTitle">
						<?php
							if (mb_strlen($options[OptionNames::HeaderText], 'UTF-8') > ($options[OptionNames::HeaderTextTruncLen])) {
								echo substr($options[OptionNames::HeaderText],0,$options[OptionNames::HeaderTextTruncLen]) . "...";								
							}else{
								echo $options[OptionNames::HeaderText];
							}
						?>
					</h1>
				</div>
				<div class="HeaderRight">
					<a target="_blank" href="http://www.raspberrypints.com">
						<?php if($options[OptionNames::UseHighResolution]) { ?>
							<img src={{asset('img/RaspberryPints-4k.png')}} height="200" alt="">
						<?php } else { ?>
							<img src={{asset('img/RaspberryPints.png')}} height="100" alt="">
						<?php } ?>
					</a>
				</div>
			</div>
			<!-- End Header Bar -->
	
			<table>
				<thead>
					<tr>
						<?php if($options[OptionNames::ShowTapNumCol]){ ?>
							<th class="tap-num">
								{{{ Lang::get('common.tapNum') }}}
							</th>
						<?php } ?>
						
						<?php if($options[OptionNames::ShowSrmCol]){ ?>
							<th class="srm">
								{{{ Lang::get('common.gravity') }}}
								<hr/>
								{{{ Lang::get('common.color') }}}
							</th>
						<?php } ?>
						
						<?php if($options[OptionNames::ShowIbuCol]){ ?>
							<th class="ibu">
								{{{ Lang::get('common.balance') }}}
								<hr/>
								{{{ Lang::get('common.bitterness') }}}
							</th>
						<?php } ?>
						
						<th class="name">
							{{{ Lang::get('common.beerNameAndStyle') }}}
							<hr/>
							{{{ Lang::get('common.tastingNotes') }}}							
						</th>
						
						<?php if($options[OptionNames::ShowAbvCol]){ ?>
							<th class="abv">
								{{{ Lang::get('common.calories') }}}
								<hr/>
								{{{ Lang::get('common.alcohol') }}}
							</th>
						<?php } ?>
						
						<?php if($options[OptionNames::ShowKegCol]){ ?>
							<th class="keg">
								{{{ Lang::get('common.poured') }}}
								<hr/>
								{{{ Lang::get('common.remaining') }}}
							</th>
						<?php } ?>
					</tr>
				</thead>
	
				<tbody>
					<?php 
					for($i = 1; $i <= $options[OptionNames::NumberOfTaps]; $i++) 
					{
						$beer = ActiveTap::PickByTapNumber($taps, $i);
						if( $beer != null ) {
					?>
							@include('home.tap')
							
						<?php }else{ ?>							
							@include('home.empty-tap')
					<?php 
						}
					} 
					?>
				</tbody>
			</table>
		 <?php 
		 
		Untappd::utBreweryFeed($options);
		 
		 ?>
		</div>
	</body>
</html>
