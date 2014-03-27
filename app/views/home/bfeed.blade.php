<?php
		if($options[OptionNames::ClientID]){ 

	
	if (Cache::has('bfeed')) {
	$cachefile = Cache::get('bfeed');
print $cachefile;
	}  else {
 $bfeed = Untappd::utBreweryFeed($options);
 $bfeeds ="<table width=95%><tr>";

foreach ($bfeed->response->checkins->items as $i) {
    
        $j = $i->beer->beer_name;
        $bfeeds .="<td width=20%><table width=95%><tr><td><div class='beerfeed'>";
        $bfeeds .="<center><div class=circular style='width: 50px;height: 50px;background-image: url(". $i->user->user_avatar .");background-size: cover;display: block;border-radius: 100px;-webkit-border-radius:  100px;-moz-border-radius: 100px;'></div>";
      $bfeeds .="".$i->user->user_name."<br />";

      $bfeeds .=$i->beer->beer_name;

      $bfeeds .="</td></tr></table>";
      $bfeeds .="</div></td>";
 
}

	$bfeeds .="</tr></table>";
	cache::put('bfeed',$bfeeds,15);

 
	$cachefile = Cache::get('bfeed');
print $cachefile;

} } ?>