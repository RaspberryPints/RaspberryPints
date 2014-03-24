@extends('layouts.admin')

@section('content')
	{{{ Lang::get('common.editBatch') }}}

    {{ Form::model($batch, array('action' => array('BatchController@update', $batch->id), 'method' => 'PUT')) }}

        @include('batches.form')

    {{ Form::close() }}

@stop