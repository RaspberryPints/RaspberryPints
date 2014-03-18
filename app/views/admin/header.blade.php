<div id="header">
	<input type="button" value="{{{ Lang::get('common.myAccount') }}}" class="btn" onClick="location. href='Mya.php'" />
	<input type="button" value="{{{ Lang::get('common.logout') }}}" class="btn" onClick="location.href='{{ URL::action('AdminController@doLogout'); }}'"/> 
	<a class="icon" href="/admin/personalize" title="personalize"><img src="{{ URL::asset('img/admin/icons/gear.png'); }}"/></a>
	<a class="icon" href="{{ URL::action('AdminController@index'); }}" title="home"><img src="{{ URL::asset('img/admin/icons/home.png'); }}"/></a>
</div>
