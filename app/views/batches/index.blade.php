@extends('layouts.admin')

@section('title')
	{{{ Lang::get('common.myBatches') }}}
@stop

@section('content')
	
	<p>{{ link_to_action('BatchController@create', Lang::get('common.addBatch'), null, array( 'class' => 'btn')); }}</p>

    <table class="outerborder">
	
		@if (count($batches) === 0)
			<tr><td class="no-results" colspan="99">{{{ Lang::get('common.noBatchesAddSome') }}}</td></tr>
		@else
			@foreach ($batches as $batch)

				<thead>
					<tr class="intborder">
						<th width="25%" style="vertical-align: middle;">
							<h3>{{ $batch->Beer->name }}</h3>
						</th>
						<th width="25%" style="vertical-align: middle;">
							<b></b>							
						</th>

						<th width="20%" style="vertical-align: middle;">
							<b></b>							
						</th>
					
						<th class="actions">
							{{ link_to_action('BatchController@edit', Lang::get('common.edit'), array( 'id' =>  $batch->id ), array( 'class' => 'btn')); }}
						
							{{ link_to_action('BatchController@inactivate', Lang::get('common.delete'), array( 'id' =>  $batch->id ), array( 'class' => 'btn')); }}							
						</th>					
					</tr>
				</thead>
				<tbody>
					<tr class="intborder thick">
						<td colspan="4">
							<p><b><u>Vitals</u></b></p>
							<p>
								<b>{{{ Lang::get('common.srm') }}}:</b> {{{ isset($batch->srmAct) ? $batch->srmAct : Lang::get('common.na') }}}
								<br/>
								<b>{{{ Lang::get('common.ibu') }}}:</b> {{{ isset($batch->ibuAct) ? $batch->ibuAct : Lang::get('common.na') }}}
								<br/>
								<b>{{{ Lang::get('common.og') }}}:</b> {{{ isset($batch->ogAct) ? $batch->ogAct : Lang::get('common.na') }}}
								<br/>
								<b>{{{ Lang::get('common.fg') }}}:</b> {{{ isset($batch->fgAct) ? $batch->fgAct : Lang::get('common.na') }}}
							</p>
						</td>
					</tr>
				</tbody>	

			@endforeach
		@endif								
	</table>
@stop