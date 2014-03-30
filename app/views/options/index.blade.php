@extends('layouts.admin')

@section('title')
	{{{ Lang::get('common.personalization') }}}
@stop

@section('content')
	<div id='options-list'>

		<a href="#columns"></a>		
		<h2>{{{ Lang::get('common.showHideColumns')}}}</h2>
		<table class="outerborder">
			@if (count($showHideCols) > 0)
				@foreach ($showHideCols as $option)

					<tbody>
						<tr class="intborder thick">
							<td>
								{{ Form::label('configName', Lang::get('common.'.$option->configName), array('class' => 'required')) }}
							</td>
							<td>
								{{ Form::model($option, array('action' => array('OptionController@update', $option->id), 'method' => 'PUT')) }}
									{{ Form::select('configValue', $showHideColsList) }}
	                    			<span class="ajax-loading geomicon raspberry" data-id="loading"></span>
	    						{{ Form::close() }}
							</td>
						</tr>
					</tbody>	

				@endforeach
			@endif								
		</table>

		<a href="#header"></a>		
		<h2>{{{ Lang::get('common.headers')}}}</h2>

		<table class="outerborder">
			<tr class="intborder thick">
				<td>
					{{ Form::label('headerText', Lang::get('common.headerText'), array('class' => 'required')) }}
				</td>
				<td>
					{{ Form::model($headerText, array('action' => array('OptionController@update', $headerText->id), 'method' => 'PUT')) }}
						{{ Form::text('configValue') }}
            			<span class="ajax-loading geomicon raspberry" data-id="loading"></span>
					{{ Form::close() }}
				</td>
			<tr>
			<tr class="intborder thick">
				<td>
					{{ Form::label('headerTextTruncLen', Lang::get('common.headerTextTruncLen'), array('class' => 'required')) }}
				</td>
				<td>
					{{ Form::model($headerTextTruncLen, array('action' => array('OptionController@update', $headerTextTruncLen->id), 'method' => 'PUT')) }}
						{{ Form::text('configValue') }}
            			<span class="ajax-loading geomicon raspberry" data-id="loading"></span>
					{{ Form::close() }}
				</td>
			<tr>
		</table>
	</div>
@stop


@section('scripts')
	<script>
		$(function () {

			var updateConfig = function(){
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

			$('#options-list')
				.on('change', 'select[name=configValue]', updateConfig)
				.on('focusout', 'input[name=configValue]', updateConfig);
		});
	</script>
@stop