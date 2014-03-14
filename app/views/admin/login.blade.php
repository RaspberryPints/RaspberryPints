<!doctype html>
<html>
<head>
	<title>Look at me Login</title>
</head>
<body>

	{{ Form::open(array('action' => 'AdminController@doLogin')) }}
		<h1>Login</h1>

		<p>
			{{ Form::label('username', 'Username') }}
			{{ Form::text('username', Input::old('username')) }}
			{{ $errors->first('username') }}
		</p>

		<p>
			{{ Form::label('password', 'Password') }}
			{{ Form::password('password') }}
			{{ $errors->first('password') }}
		</p>

		<p>{{ Form::submit('Submit!') }}</p>
	{{ Form::close() }}

</body>
</html>