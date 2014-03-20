<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>{{{ Lang::get('common.raspberryPints') }}}</title>

		{{ HTML::style('styles/admin.css'); }}
		{{ HTML::style('styles/login.css'); }}
		{{ HTML::style('styles/styles.css'); }}
		<link href='http://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<div id="logincontainer">
			<div id="loginbox">
				<div id="loginheader">
					<h1>{{{Lang::get('common.raspberryPintsLogin')}}}</h1>
				</div>
				<div id="innerlogin">
					{{ Form::open(array('action' => 'AdminController@doLogin')) }}
						<p>
							{{ Form::label('username', Lang::get('common.username')) }}
							{{ Form::text('username', Input::old('username'), array( 'class' => '' )) }}
							{{ $errors->first('username') }}
						</p>

						<p>
							{{ Form::label('password', Lang::get('common.password')) }}
							{{ Form::password('password') }}
							{{ $errors->first('password') }}
						</p>

						<p>{{ Form::submit(Lang::get('common.submit'), array( 'class' => 'btn')) }}</p>
					{{ Form::close() }}

					<img src="{{ URL::asset('img/admin/lock.png'); }}" height="50" width="50" />
					<p>{{ link_to_action('BeerController@index', Lang::get('common.forgotPassword'), null, array( 'class' => 'btnalt')); }}</p>                    
				</div>
			</div>
		</div>
	</body>
</html>
