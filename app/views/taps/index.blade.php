@extends('layouts.admin')

@section('title')
	{{{ Lang::get('common.myTaps') }}}
@stop

@section('content')

	<p>
		{{ link_to_action('TapController@create', Lang::get('common.addTap'), null, array( 'id' => 'add-tap', 'class' => 'btn')); }}		
	</p>

	{{ HTML::ul($errors->all()) }}
	<table id="tap-list" class="outerborder">
		@if (count($taps) === 0)
			<tr><td class="no-results" colspan="99">{{{ Lang::get('common.noTaps') }}}</td></tr>
		@else
			<thead>
				<tr>
					<th>Tap Name</th>
					<th>Batch</th>
					<th></th>
				</tr>
			</thead>
			@foreach ($taps as $tap)
				<tbody>
					<tr>
						<td>
							{{ Form::model($tap, array('action' => array('TapController@updateName', $tap->id), 'method' => 'put')) }}
								{{ Form::text('name') }}
								<span class="ajax-loading geomicon raspberry" data-id="loading"></span>
							{{ Form::close() }}
						</td>
						<td>
							{{ Form::model($tap, array('action' => array('TapController@updateBatch', $tap->id), 'method' => 'put')) }}
								{{ Form::select('batchId', $batchList) }}
								<span class="ajax-loading geomicon raspberry" data-id="loading"></span>
							{{ Form::close() }}
						</td>
						<td>
							{{ link_to_action("TapController@destroy", Lang::get('common.delete'), array( 'id' =>  $tap->id ), array( 'class' => 'btn')); }}
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
			var updateTap = function(){
				var $form = $(this).closest('form'),
					$loadingIcon = $form.find('.ajax-loading');

				$loadingIcon.css('visibility','visible');

				$.ajax({
				    url: $form.attr('action'),
				    type: 'PUT',
				    data:  $form.serialize(),
				    success: function(result) {
						$loadingIcon.css('visibility','hidden');
				    }
				});
			};

			$('#tap-list')
				.on('change', 'select', updateTap)
				.on('focusout', 'input', updateTap);
			
		});
	</script>
@stop
