@extends('layouts.admin')

@section('content')
	{{{ Lang::get('common.addBeer') }}}
	
	{{ Form::open(array('action' => 'BeerController@store')) }}
        
        @include('beers.form')
        
    {{ Form::close() }}

@stop