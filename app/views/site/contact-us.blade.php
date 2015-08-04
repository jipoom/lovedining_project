@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
{{{ Lang::get('site.contact_us') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')


<div class="col-md-12" >
	<div class="movieinfo" >
		<h4>Contact Us</h4>
		Name :   Chaisit  Sorsakul<br/>
		Email :     targeting_trend@hotmail.com<br/>
		Mobile : 0819172233
	</div>
	&nbsp;
</div>
@stop
