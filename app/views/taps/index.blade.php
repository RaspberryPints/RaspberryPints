@extends('layouts.admin')

@section('title')
	{{{ Lang::get('common.myTaps') }}}
@stop

@section('content')
	
	<table class="outerborder">
	
		@if (count($taps) === 0)
			<tr><td class="no-results" colspan="99">{{{ Lang::get('common.noTaps') }}}</td></tr>
		@else
			@foreach ($taps as $tap)

				<tbody>
					<tr class="intborder thick">
						<td>{{ $tap->tapNumber }}</td>
						<td>
							{{ Form::model($tap, array('action' => array('TapController@updateBatch', $tap->id), 'method' => 'PUT')) }}

                    			{{ Form::select('batchId', $batchList) }}
			

    						{{ Form::close() }}
						</td>
					</tr>
				</tbody>	

			@endforeach
		@endif								
	</table>
@stop