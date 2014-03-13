<div id="header">
	<input type="button" value="My Account" class="btn" onClick="location. href='Mya.php'" />
	<input type="button" value="Logout" class="btn" onClick="location.href='includes/endses.php'"/> 
	<a class="icon" href="/admin/personalize" title="personalize"><img src="{{ URL::asset('img/admin/icons/gear.png'); }}"/></a>
	<a class="icon" href="{{ URL::action('AdminController@index'); }}" title="home"><img src="{{ URL::asset('img/admin/icons/home.png'); }}"/></a>
</div>
