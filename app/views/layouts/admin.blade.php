<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>{{{ Lang::get('common.raspberryPints') }}}</title>
		{{ HTML::style('styles/admin.css'); }}
		{{ HTML::style('styles/wysiwyg.css'); }}
		{{ HTML::style('styles/styles.css'); }}
		<link href='http://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
	</head>
	<body id="homepage">
	
		@include('admin.header')

		<div id="breadcrumb">
			<ul>	
				<li><img src="{{ URL::asset('img/admin/icons/icon_breadcrumb.png'); }}" alt="Location" /></li>
				<li><strong>{{{ Lang::get('common.location') }}}:</strong></li>
				<li class="current">{{{ Lang::get('common.controlPanel') }}}</li>
			</ul>
		</div>
	
		<div id="rightside">

			/{{ $logoUrl }}\

			@if(Session::has('flash_notice'))
            	<div id="flash_notice">{{ Session::get('flash_notice') }}</div>
        	@endif

			@if (trim($__env->yieldContent('title')))
    			<h1>@yield('title')</h1>
			@endif
			
			@yield('content')
			
			@include('admin.footer')			
		</div>
		
		@include('admin.left_bar')
		@include('admin.scripts')		
	</body>
</html>