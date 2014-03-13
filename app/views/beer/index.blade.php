@extends('layouts.admin')

@section('title')
	My Beers
@stop

@section('content')
	
	<p>{{ link_to_action('BeerController@form', 'Add Beer', null, array( 'class' => 'btn')); }}</p>

    <table class="outerborder">
	
		@if (count($beers) === 0)
			<tr><td class="no-results" colspan="99">No beers :( Add some?</td></tr>
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
							{{ link_to_action('BeerController@form', 'Edit', array( 'id' =>  $beer->id ), array( 'class' => 'btn')); }}
						
							{{ link_to_action('BeerController@inactivate', 'Delete', array( 'id' =>  $beer->id ), array( 'class' => 'btn')); }}							
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
								<b>SRM:</b> {{{ isset($beer->srmEst) ? $beer->srmEst : 'N/A' }}}
								<br/>
								<b>IBU:</b> {{{ isset($beer->ibuEst) ? $beer->ibuEst : 'N/A' }}}
								<br/>
								<b>IBU:</b> {{{ isset($beer->ogEst) ? $beer->ogEst : 'N/A' }}}
								<br/>
								<b>IBU:</b> {{{ isset($beer->fgEst) ? $beer->fgEst : 'N/A' }}}
							</p>
							
							<p><b>Water:</b> <!-- Sacramento, CA --> <br>
							<b>Salts:</b> <!-- Camden, pH 5.2 Stabilizer --> <br>
							<b>Finings:</b> <!-- Whirfloc --> <br>
							<b>Yeast</b>: <!-- Fermentis S-04 --><br></p>
						</td>
						<td colspan="3">
							<p><b><u>Fermentables:</u></b></p><p>
							<!--
							60.5% Pilsner (2 Row) Ger (2.0 SRM)<br>
							32.4% Pale Ale Malt, Northwestern (Great Western) (3.0 SRM)<br>
							7.1% Crystal 15, 2-Row, (Great Western) (15.0 SRM)<br>
							-->
							</p>
							
							<p><b><u>Mash Profile:</u></b></p><p>
							<!--
							Step 1: Dough-in @ 70&deg;F (2 min)<br>
							Step 2: Conversion @ 154&deg;F (60 min)<br>
							Step 3: Batch Sparge @ 168&deg;F (5 min)<br>
							Step 4: Batch Sparge @ 168&deg;F (5 min)</p>
							-->
							</p>
							
							<p><b><u>Hop Schedule:</u></b></p><p>
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