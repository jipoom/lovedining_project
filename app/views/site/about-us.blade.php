@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
About Us
@parent
@stop
@section('content')

<div class="col-md-12">
{{$introduction->content}}
</div>
@stop
