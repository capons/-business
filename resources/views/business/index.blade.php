@extends('app')

@section('title', 'Main page')

@section('sidebar')
@stop

@section('content')
    <p style="text-align: center">Main page</p>

    <div class="col-xs-12">
        <div style="float: none;margin: 0 auto" class="col-xs-6">
            <!-- Display Validation Errors -->
            @include('common.errors')

                    <!--Display User information -->
            @if(Session::has('user-info'))
                <div class="alert-box success">
                    <h2 style="text-align: center">{{ Session::get('user-info') }}</h2>

                </div>
            @endif
        </div>
    </div>

@stop