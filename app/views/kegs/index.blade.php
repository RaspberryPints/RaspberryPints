@extends('layouts.admin')

@section('title')
	{{{ Lang::get('common.myKegs') }}}
@stop

@section('content')
	
	<p>{{ link_to_action('KegController@create', Lang::get('common.addKeg'), null, array( 'class' => 'btn')); }}</p>

    <table class="outerborder">
	
		@if (count($kegs) === 0)
			<tr><td class="no-results" colspan="99">{{{ Lang::get('common.noKegsAddSome') }}}</td></tr>

		@else			
			<thead class="intborder thick">
				<tr>
					<th width="5%"><center>{{{ Lang::get('common.label') }}}</center></th>
					<th width="10%" colspan="2"><center>{{{ Lang::get('common.status') }}} / {{{ Lang::get('common.update') }}}</center></th>
					<th width="28%"><center>{{{ Lang::get('common.kegType') }}}</center></th>
					<th width="28%"><center>{{{ Lang::get('common.make') }}}</center></th>
					<th width="29%"><center>{{{ Lang::get('common.model') }}}</center></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($kegs as $keg)
					<tr>
						<td rowspan="2" class="intborder">
							<center><span class="kegsquare">{{{ $keg->label }}}</span></center>
						</td>
						
						<td colspan="2" class="leftborder rightborder" style="vertical-align:middle; font-size:1.2em;">
							<center><b>{{{ $keg->KegStatus->name }}}</b></center>
						</td>
						
						<td style="vertical-align:middle; font-size:1.2em;">
							<center><b>{{{ $keg->KegType->name }}}</b></center>
						</td>
						
						<td style="vertical-align:middle; font-size:1.2em;">
							<center><b>{{{ $keg->make }}}</b></center>
						</td>
						
						<td class="rightborder thick"style="vertical-align:middle; font-size:1.2em;">
							<center><b>{{{ $keg->model }}}</b></center>
						</td>
					</tr>
					<tr class="intborder">
						<td class="leftborder">
							<center>
								{{ link_to_action('KegController@edit', Lang::get('common.edit'), array( 'id' =>  $keg->id ), array( 'class' => 'btn')); }}
							</center>
						</td>
						
						<td class="rightborder">
							<center>
								{{ link_to_action('KegController@inactivate', Lang::get('common.delete'), array( 'id' =>  $keg->id ), array( 'class' => 'btn')); }}	
							</center>
						</td>
						<td colspan="3">
							<b>{{{ Lang::get('common.stampedOwner') }}} / {{{ Lang::get('common.location') }}}:</b> &nbsp; {{{ $keg->stampedOwner }}}  / {{{ $keg->stampedLoc }}}<br>
							<b>{{{ Lang::get('common.serialNumber') }}}:</b> &nbsp; {{{ $keg->serial }}} &nbsp; &nbsp; &nbsp; <b>{{{ Lang::get('common.emptyWeight') }}}:</b> {{{ $keg->weight }}}<br>
							<b>{{{ Lang::get('common.notes') }}}:</b> &nbsp; {{{ $keg->notes }}}
						</td>
					</tr>			
				@endforeach
			</tbody>
		@endif								
	</table>
@stop