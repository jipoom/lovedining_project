@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
About Us
@parent
@stop
@section('content')

<div class="col-md-12" style="border-color: #dedede; border-style: solid; border-width: 1px; border-radius: 5px; padding: 25px; margin: 10px;">
{{$introduction->content}}
</div>
@stop
