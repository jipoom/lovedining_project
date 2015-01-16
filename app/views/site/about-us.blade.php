@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
About Us
@parent
@stop
@section('content')

<div class="col-md-12" >
	<div class="movieinfo" >
		{{$introduction->content}}
	</div>
	&nbsp;
</div>
@stop
