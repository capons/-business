@extends('app')

@section('title', 'Main page')

@section('sidebar')
@stop

@section('content')

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
            <?php
            if (isset($user_info)){
            ?>
            <div class="alert-box success">
                <h2 style="text-align: center">{{$user_info}}</h2>
            </div>
            <?php
            }
            ?>
        </div>
    </div>

    <div style="text-align: center" class="col-xs-12">
        <a  style="display: inline-block;padding: 20px;background-color: #8a95ff;text-decoration: none;color: black" href="{{ url('auth/login')}}">Войти в систему</a>
    </div>

@stop