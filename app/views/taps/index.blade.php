@extends('layouts.admin')

@section('title')
	{{{ Lang::get('common.myTaps') }}}
@stop

@section('content')

	{{ HTML::ul($errors->all()) }}
	<table id="tap-list" class="outerborder">
		@if (count($taps) === 0)
			<tr><td class="no-results" colspan="99">{{{ Lang::get('common.noTaps') }}}</td></tr>
		@else
			@foreach ($taps as $tap)
				<tbody>
					<tr class="intborder thick">
						<td>
							{{ Form::model($tap, array('action' => array('TapController@update', $tap->id), 'method' => 'put')) }}
								{{ Form::hidden('id') }}
								<table id="tap-entry">
									<thead>
										<tr>
											<th>Tap Name</th>
											<th>Batch</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												{{ Form::text('name') }}
											</td>
											<td>
												{{ Form::select('batchId', $batchList) }}
												<span class="ajax-loading geomicon raspberry" data-id="loading"></span>
											</td>
											<td>
												{{ link_to_action("TapController@destroy", Lang::get('common.delete'), array( 'id' =>  $tap->id ), array( 'class' => 'btn')); }}
											</td>
										</tr>
									</tbody>
								</table>
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

			$('#tap-list').on('change', 'form', function(){
				var $form = $(this).closest('form');
				var $loadingIcon = $form.find('.ajax-loading');

				$loadingIcon.css('visibility','visible');

				$.ajax({
				    url: $form.attr('action'),
				    type: 'POST',
				    data:  $form.serialize(),
				    success: function(result) {
						$loadingIcon.css('visibility','hidden');
				    }
				});
			});
		});
	</script>
@stop
