@extends('layouts.admin')

@section('title')
	{{{ Lang::get('common.personalization') }}}
@stop

@section('content')
	<div id='options-list'>

		<a name="columns"></a>		
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

		<a name="header"></a>		
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

		<a name="logo"></a>		
		<h2>{{{ Lang::get('common.breweryLogo')}}}</h2>

		<table class="outerborder">
			<tr class="intborder thick">
				<td>
					{{ Form::open(array('action' => array('OptionController@replaceLogo'), 'method' => 'PUT', 'files' => true, 'class' => 'ajax-form')) }}
						{{ Form::file('image') }}
                    	{{ Form::submit(Lang::get('common.replace'), array( 'class' => 'btn')) }}
            			<span class="ajax-loading geomicon raspberry" data-id="loading"></span>
            			<span class="error-msg"></span>
					{{ Form::close() }}
				</td>
			<tr>
		</table>

		<a name="background"></a>		
		<h2>{{{ Lang::get('common.background')}}}</h2>

		<table class="outerborder">
			<tr class="intborder thick">
				<td colspan="2">
					{{ Form::open(array('action' => array('OptionController@replaceBackground'), 'method' => 'PUT', 'files' => true, 'class' => 'ajax-form')) }}
						{{ Form::file('image') }}
						{{ Form::submit(Lang::get('common.replace'), array( 'class' => 'btn')) }}
            			<span class="ajax-loading geomicon raspberry" data-id="loading"></span>
            			<span class="error-msg"></span>
					{{ Form::close() }}
				</td>
			<tr>

			<tr class="intborder thick">
				<td>
					{{ Form::label('backgroundRepeat', Lang::get('common.imageRepeat'), array('class' => 'required')) }}
				</td>
				<td>
					{{ Form::model($backgroundRepeat, array('action' => array('OptionController@update', $backgroundRepeat->id), 'method' => 'PUT')) }}						
						{{ Form::select('configValue', array('0' => Lang::get('common.no'), '1' => Lang::get('common.yes')), $backgroundRepeat->configValue); }}
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
				.on('focusout', 'input[name=configValue]', updateConfig)
				.on('submit', '.ajax-form', function(){
					var $form = $(this),
						$loadingIcon = $form.find('.ajax-loading');

					$form.find('.error-msg').text('');

					$loadingIcon.css('visibility','visible');

				    $form.ajaxSubmit({
				    	success: function(responseText, statusText, xhr, $form){
				    		if( !responseText.success ){
								var errors = $.parseJSON(responseText.errors),
									$this,
									name,
									$errorContainer;
								$form.find('input, select').each(function(){
									$this = $(this);
									name = $this.attr('name');
									$errorContainer = $this.siblings('.error-msg');

									if( errors.hasOwnProperty( name ) ){
										$errorContainer.text(errors[name][0]);
									}
								});
							}

							$form.each(function(){ this.reset(); });

							$loadingIcon.css('visibility','hidden');
				    	}
				    }); 

				    return false; 
				});



		});
	</script>
@stop