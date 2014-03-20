@extends('layouts.admin')

@section('content')
	{{{ Lang::get('common.editKeg') }}}

    {{ Form::model($keg, array('action' => array('KegController@update', $keg->id), 'method' => 'PUT')) }}

        @include('kegs.form')

    {{ Form::close() }}

@stop