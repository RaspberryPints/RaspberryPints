<!-- Left Dark Bar Start -->
<div id="leftside">

<!-- Start User Echo -->
<div id="welcome"> 
	{{{ Lang::get('common.welcome') }}}, 
	<br />	
	{{{ Auth::user()->name }}}
</div>

<!-- End User Echo -->
<div class="user">
	<a href="/"><img src="{{ URL::asset('img/admin/logo.png'); }}" width="120" height="120" class="hoverimg" alt="Avatar" /></a>
</div>

<!-- Start Navagation -->
<ul id="nav">
	<li>
		<ul class="navigation">
			<li class="heading selected">{{{ Lang::get('common.welcome') }}}</li>
		</ul>
	<li>
	<li>
		<a class="expanded heading">{{{ Lang::get('common.basicSetup') }}}</a>
		<ul class="navigation">
			<li><a href="{{ URL::action('BeerController@index'); }}">{{{ Lang::get('common.myBeers') }}}</a></li>
			<li><a href="{{ URL::action('KegController@index'); }}">{{{ Lang::get('common.myKegs') }}}</a></li>
			<li><a href="{{ URL::action('BatchController@index'); }}">{{{ Lang::get('common.myBatches') }}}</a></li>
			<li><a href="{{ URL::action('TapController@index'); }}">{{{ Lang::get('common.myTaps') }}}</a></li>
		</ul>
	</li>
		<li>
		<a class="expanded heading">Personalization</a>
		<ul class="navigation">
			<li><a href="{{ URL::action('OptionController@index'); }}#columns">{{{ Lang::get('common.showHideColumns') }}}</a></li>
			<li><a href="{{ URL::action('OptionController@index'); }}#header">Headers</a></li>
			<li><a href="{{ URL::action('OptionController@index'); }}#logo">Brewery Logo</a></li>
			<li><a href="{{ URL::action('OptionController@index'); }}#background">Background Image</a></li>
		</ul>
	</li>
	<li>
		<a class="expanded heading">Help!</a>
		<ul class="navigation">
			<li><a href="http://raspberrypints.com/report-bug-make-a-suggestion/" target="_blank">Report a Bug</a></li>
			<li><a href="http://raspberrypints.com/report-bug-make-a-suggestion/" target="_blank">Request a Feature</a></li>
		</ul>	
	</li>
	<li>
		<a class="expanded heading">External Links</a>
		<ul class="navigation">
			<li><a href="http://www.raspberrypints.com/" target="_blank">Official Website</a></li>
			<li><a href="http://www.raspberrypints.com/faq" target="_blank">F.A.Q.</a></li>
			<li><a href="http://www.homebrewtalk.com/f51/initial-release-raspberrypints-digital-taplist-solution-456809" target="_blank">Visit Us on HBT</a></li>
			<li><a href="http://www.raspberrypints.com/contributors" target="_blank">Contributors</a></li>
			<li><a href="http://www.raspberrypints.com/licensing" target="_blank">Licensing</a></li>
		</ul>
	</li>
</ul>

<!-- End Navagation -->
<!-- Left Dark Bar End --> 
