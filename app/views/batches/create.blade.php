@extends('layouts.admin')

@section('content')
	{{{ Lang::get('common.addBatch') }}}
	
	{{ Form::open(array('action' => 'BatchController@store')) }}
        
        @include('batches.form')
        
    {{ Form::close() }}

@stop