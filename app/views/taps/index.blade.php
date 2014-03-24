@extends('layouts.admin')

@section('title')
	{{{ Lang::get('common.myTaps') }}}
@stop

@section('content')
		
	{{ Form::model($numTaps, array('action' => array('TapController@updateNumTaps', $numTaps->id), 'method' => 'PUT')) }}
		{{ Form::text('configValue', Input::old('configValue')) }}
        {{ Form::submit(Lang::get('common.save'), array( 'class' => 'btn')) }}
    {{ Form::close() }}

	<table id="tap-list" class="outerborder">
		@if (count($taps) === 0)
			<tr><td class="no-results" colspan="99">{{{ Lang::get('common.noTaps') }}}</td></tr>
		@else
			@foreach ($taps as $tap)

				<tbody>
					<tr class="intborder thick">
						<td>{{ $tap->tapNumber }}</td>
						<td>
							{{ Form::model($tap, array('action' => 'TapController@updateBatch', 'method' => 'PUT')) }}
								{{ Form::hidden('id') }}
                    			{{ Form::select('batchId', $batchList) }}
                    			<div class='icon-loading'></div>
    						{{ Form::close() }}
						</td>
					</tr>
				</tbody>	

			@endforeach
		@endif								
	</table>
@stop


@section('scripts')
	<script>
		$(function () {
			$('#tap-list').on('change', 'select[name=batchId]', function(){
				var $form = $(this).closest('form'),
					$loadingIcon = $form.find('.icon-loading');

				$loadingIcon.addClass('active');

				$.ajax({
				    url: $form.attr('action'),
				    type: 'PUT',
				    data:  $form.serialize(),
				    success: function(result) {
				        $loadingIcon.removeClass('active');
				    }
				});
			});
		});
	</script>
@stop