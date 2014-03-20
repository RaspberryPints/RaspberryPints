@extends('layouts.admin')

@section('content')
	{{{ Lang::get('common.addKeg') }}}
	
	{{ Form::open(array('action' => 'KegController@store')) }}
        
        @include('kegs.form')
        
    {{ Form::close() }}

@stop