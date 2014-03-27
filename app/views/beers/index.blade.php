@extends('layouts.admin')

@section('title')
	{{{ Lang::get('common.myBeers') }}}
@stop

@section('content')
	
	<p>{{ link_to_action('BeerController@create', Lang::get('common.addBeer'), null, array( 'class' => 'btn')); }}</p>

    <table class="outerborder">
	
		@if (count($beers) === 0)
			<tr><td class="no-results" colspan="99">{{{ Lang::get('common.noBeersAddSome') }}}</td></tr>
		@else
			@foreach ($beers as $beer)
				<thead>
					<tr class="intborder">
						<th width="35%" style="vertical-align: middle;">
							<h3>{{{ $beer->name }}}</h3>
						</th>
						<th width="35%" style="vertical-align: middle;">
							<b>{{{ $beer->BeerStyle->name }}}</b>
							<br>
							BJCP {{{ $beer->BeerStyle->catNum }}} - {{{ $beer->BeerStyle->category }}}
						</th>
					
						<th class="actions">
							{{ link_to_action('BeerController@edit', Lang::get('common.edit'), array( 'id' =>  $beer->id ), array( 'class' => 'btn')); }}
						
							{{ link_to_action('BeerController@inactivate', Lang::get('common.delete'), array( 'id' =>  $beer->id ), array( 'class' => 'btn')); }}							
						</th>					
					</tr>
				</thead>
				<tbody>
					<tr class="intborder">
						<td colspan="4">
							@if (isset($beer->notes) )
								<blockquote>{{ $beer->notes }}</blockquote>
							@endif								
						</td>
					</tr>
					<tr class="intborder thick">
						<td>
							<p><b><u>Vitals</u></b></p>
							<p>
								<b>{{{ Lang::get('common.srm') }}}:</b> {{{ isset($beer->srmEst) ? $beer->srmEst : Lang::get('common.na') }}}
								<br/>
								<b>{{{ Lang::get('common.ibu') }}}:</b> {{{ isset($beer->ibuEst) ? $beer->ibuEst : Lang::get('common.na') }}}
								<br/>
								<b>{{{ Lang::get('common.og') }}}:</b> {{{ isset($beer->ogEst) ? $beer->ogEst : Lang::get('common.na') }}}
								<br/>
								<b>{{{ Lang::get('common.fg') }}}:</b> {{{ isset($beer->fgEst) ? $beer->fgEst : Lang::get('common.na') }}}
								<br />
								<b>{{{ Lang::get('common.untID') }}}:</b> {{{ isset($beer->untID) ? $beer->untID : Lang::get('common.na') }}}
								
							</p>
							
							<p>
								<b>{{{ Lang::get('common.water') }}}:</b> <!-- Sacramento, CA --> <br>
								<b>{{{ Lang::get('common.salts') }}}:</b> <!-- Camden, pH 5.2 Stabilizer --> <br>
								<b>{{{ Lang::get('common.finings') }}}:</b> <!-- Whirfloc --> <br>
								<b>{{{ Lang::get('common.yeast') }}}</b>: <!-- Fermentis S-04 --><br>
							</p>
						</td>
						<td colspan="3">
							<p><b><u>{{{ Lang::get('common.fermentables') }}}:</u></b></p><p>
							<!--
							60.5% Pilsner (2 Row) Ger (2.0 SRM)<br>
							32.4% Pale Ale Malt, Northwestern (Great Western) (3.0 SRM)<br>
							7.1% Crystal 15, 2-Row, (Great Western) (15.0 SRM)<br>
							-->
							</p>
							
							<p><b><u>{{{ Lang::get('common.mashProfile') }}}:</u></b></p><p>
							<!--
							Step 1: Dough-in @ 70&deg;F (2 min)<br>
							Step 2: Conversion @ 154&deg;F (60 min)<br>
							Step 3: Batch Sparge @ 168&deg;F (5 min)<br>
							Step 4: Batch Sparge @ 168&deg;F (5 min)</p>
							-->
							</p>
							
							<p><b><u>{{{ Lang::get('common.hopSchedule') }}}:</u></b></p><p>
							<!--
							0.90 oz Simcoe (13.00% AA) @ 90 min<br>
							0.90 oz Simcoe (13.00% AA) @ 30 min<br>
							1.80 oz Simcoe (13.00% AA) @ 0 min<br>
							2.00 oz Simcoe (13.00% AA) @ Dry Hop 10.0 Days</p>
							-->
							</p>
						</td>
					</tr>
				</tbody>	
			@endforeach
		@endif								
	</table>
@stop