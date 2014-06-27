@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
{{{ Lang::get('site.introduction') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')

{{{ Lang::get('site.introduction') }}}

@stop
