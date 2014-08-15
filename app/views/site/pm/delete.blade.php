@extends('site.layouts.modal')

{{-- Content --}}


@section('content')
@if($privateMessage->receiver == Auth::user()->username)
    <!-- Tabs -->
      <!--  <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab">Delete Mesage</a></li>
       </ul> -->
    <!-- ./ tabs -->
    {{-- Delete Post Form --}}
    <form id="deleteForm" class="form-horizontal" method="post" action="@if (isset($post)){{ URL::to('message_service/' . $privateMessage->id . '/delete') }}@endif" autocomplete="off">
        
        <!-- CSRF Token -->
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
        <input type="hidden" name="id" value="{{ $privateMessage->id }}" />
        <!-- <input type="hidden" name="_method" value="DELETE" /> -->
        <!-- ./ csrf token -->

        <!-- Form Actions -->
        <div class="form-group">
            <div class="controls">
                
               <p><label>Are you sure you want to delete "{{$privateMessage->title}}"?</labe></p>
                <button class="btn btn-cancel close_popup">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
            </div>
        </div>
        <!-- ./ form actions -->
    </form>
@else
Access Denied
@endif
    
@stop