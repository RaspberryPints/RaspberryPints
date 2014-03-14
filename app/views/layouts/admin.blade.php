<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>RaspberryPints</title>
		{{ HTML::style('styles/admin.css'); }}
		{{ HTML::style('styles/wysiwyg.css'); }}
		{{ HTML::style('styles/styles.css'); }}
		<link href='http://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
	</head>
	<body id="homepage">
	
		@include('shared.admin-header')

		<div id="breadcrumb">
			<ul>	
				<li><img src="{{ URL::to('/'); }}/img/admin/icons/icon_breadcrumb.png" alt="Location" /></li>
				<li><strong>Location:</strong></li>
				<li class="current">Control Panel</li>
			</ul>
		</div>
	
		<div id="rightside">

			@if(Session::has('flash_notice'))
            	<div id="flash_notice">{{ Session::get('flash_notice') }}</div>
        	@endif

			@if (trim($__env->yieldContent('title')))
    			<h1>@yield('title')</h1>
			@endif
			
			@yield('content')
			
			<br/><br/><br/><br/>

			@include('shared.admin-footer')			
		</div>
		
		@include('shared.admin-left_bar')		
		@include('shared.admin-scripts')		
	</body>
</html>