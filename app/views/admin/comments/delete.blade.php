@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
    <!-- Tabs -->
      <!--  <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
      </ul> -->
    <!-- ./ tabs -->
    {{-- Delete Blog Comment Form --}}
    <form id="deleteForm" class="form-horizontal" method="post" action="@if (isset($comment)){{ URL::to('admin/comments/' . $comment->id . '/delete') }}@endif" autocomplete="off">
        <!-- CSRF Token -->
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
        <input type="hidden" name="id" value="{{ $comment->id }}" />
        <!-- ./ csrf token -->

        <!-- Form Actions -->
        <div class="form-group">
            <div class="controls">
                <p><label>Are you sure you want to delete this content?</labe></p>
                <button class="btn btn-cancel close_popup">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </div>
        <!-- ./ form actions -->
    </form>
@stop