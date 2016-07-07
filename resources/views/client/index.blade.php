@extends('app')

@section('title', 'Main page')

@section('sidebar')
@stop

@section('content')
    <p style="text-align: center">Аккаунт клиента</p>
    @if (count($user) > 0)


        <div class="col-lg-12">
            <div class="col-xs-offset-6 col-xs-6">
                <div class="col-xs-6">
                    <p>Вы вошли как <span style="font-family: Aparajita">{{$user->name}}</span>
                    </p>
                </div>
                <div class="col-xs-6">
                    <a style="padding: 5px;background-color: #ff9e97;color: black" href="{{ url('auth/logout')}}">Выход</a>
                </div>
            </div>
        </div>
    @endif

    <div class="col-lg-12">
        <div class="col-lg-12">
            <div class="col-xs-6">
                <div style="text-align: center" class="col-xs-12">
                    <a style="padding: 20px;margin-bottom: 20px;width: 150px;text-align: center;background-color: #2aabd2;display: inline-block;color: black" href="{{ url('client/account/script')}}">Скрипт</a>
                </div>
                <div style="text-align: center" class="col-xs-12">
                    <a style="padding: 20px;width: 150px;text-align: center;background-color: #8ec072;display: inline-block;color: black" href="{{ url('client/account/manager')}}">Менеджеры</a>
                </div>
            </div>
        </div>
    </div>



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