@extends('layouts.admin')

@section('content')

	{{ HTML::ul($errors->all()) }}
	{{ Form::model($user, array('action' => 'UserController@update', 'method' => 'put')) }}
		<table class="outerborder">
			<thead class="intborder thick">
				<tr>
					<th colspan='2'><center>{{{ Lang::get('common.accountInfo') }}}</center></th>
				</tr>
			</thead>
        		<tbody>
				<tr>
					<td>
						<center>{{{ Lang::get('common.name') }}}</center>
					</td>
					<td>
						<center>{{ Form::text('name') }}</center>
					</td>
				</tr>
                                <tr>
                                        <td>
                                                <center>{{{ Lang::get('common.username') }}}</center>
                                        </td>
                                        <td>
                                                <center>{{ Form::text('username') }}</center>
                                        </td>
                                </tr>
                                <tr>
                                        <td>
                                                <center>{{{ Lang::get('common.email') }}}</center>
                                        </td>
                                        <td>
                                                <center>{{ Form::text('email') }}</center>
                                        </td>
                                </tr>
			</tbody>
		</table>
		{{ Form::submit('Save'); }}
	{{ Form::close() }}
@stop
