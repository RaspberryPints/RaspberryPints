@extends('layouts.admin')

@section('content')
	<?php 
	if( $beer->id == '' ) {
		echo Lang::get('common.addBeer');
	}else{
		echo Lang::get('common.editBeer');
	}
	?>

	{{ Form::model($beer, array('action' => array('BeerController@form_post', $beer->id))) }}
        {{ Form::label('name', Lang::get('common.name'), array('class' => 'required')) }}
        {{ Form::text('name') }}
        {{ $errors->first('name', '<span class="error">:message</span>') }}

		{{ Form::label('beerStyleId', Lang::get('common.beerStyle'), array('class' => 'required')) }}
        {{ Form::select('beerStyleId', $beerStyleList) }}
        {{ $errors->first('beerStyleId', '<span class="error">:message</span>') }}

        {{ Form::label('notes', Lang::get('common.notes'), array('class' => 'required')) }}
        {{ Form::textarea('notes') }}
        {{ $errors->first('notes', '<span class="error">:message</span>') }}

        {{ Form::label('ogEst', Lang::get('common.estimatedOG'), array('class' => 'required')) }}
        {{ Form::text('ogEst') }}
        {{ $errors->first('ogEst', '<span class="error">:message</span>') }}

        {{ Form::label('fgEst', Lang::get('common.estimatedFG'), array('class' => 'required')) }}
        {{ Form::text('fgEst') }}
        {{ $errors->first('fgEst', '<span class="error">:message</span>') }}

        {{ Form::label('srmEst', Lang::get('common.estimatedSRM'), array('class' => 'required')) }}
        {{ Form::text('srmEst') }}
        {{ $errors->first('srmEst', '<span class="error">:message</span>') }}

        {{ Form::label('ibuEst', Lang::get('common.estimatedIBU'), array('class' => 'required')) }}
        {{ Form::text('ibuEst') }}
        {{ $errors->first('ibuEst', '<span class="error">:message</span>') }}

        {{ Form::submit('Save') }}
    {{ Form::close() }}

@stop