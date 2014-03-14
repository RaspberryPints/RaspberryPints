@extends('layouts.admin')

@section('content')
	{{{ Lang::get('common.editBeer') }}}

    {{ Form::model($beer, array('action' => array('BeerController@update', $beer->id), 'method' => 'PUT')) }}

        @include('beers.form')

    {{ Form::close() }}

@stop