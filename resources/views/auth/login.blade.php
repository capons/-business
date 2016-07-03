@extends('app')

@section('title', 'Main page')

@section('sidebar')
@stop

@section('content')
    <div class="col-xs-12">
        <div class="col-xs-6">
            <div style="margin: 0 auto;float: none" class="col-xs-6">
                <p style="text-align: center">Форма входа руководителя</p>
                <form class="form-horizontal" action="{{action('Auth\AuthController@postLogin')}}" method="post">
                    <div class="form-group">
                        <label >Email:</label>
                        <input type="text" class="form-control" name="l_email" required placeholder="Введите адрес электронной почты">
                    </div>
                    <div class="form-group">
                        <label >Пароль:</label>
                        <input type="password" class="form-control" name="l_pass" value="111111" required placeholder="Введите пароль">
                    </div>
                    <!--
                    <div>
                        <input type="checkbox" name="remember"> Запомнить
                    </div>
                    -->
                    <div class="form-group">
                        <input style="background-color: inherit;border: 1px solid gainsboro;padding: 8px;width: 120px"  type="submit" value="Войти">
                    </div>
                    {!! csrf_field() !!}
                </form>
            </div>
        </div>
        <!--Login form for manager -->
        <div class="col-xs-6">
            <div style="margin: 0 auto;float: none" class="col-xs-6">
                <p style="text-align: center">Форма входа менеджера </p>
                <form class="form-horizontal" action="{{action('Auth\AuthController@postLoginManager')}}" method="post">
                    <div class="form-group">
                        <label >Логин:</label>
                        <input type="text" class="form-control" name="l_email" required placeholder="Введите логин">
                    </div>
                    <div class="form-group">
                        <label >Пароль:</label>
                        <input type="password" class="form-control" name="l_pass"  required placeholder="Введите пароль">
                    </div>
                    <!--
                    <div>
                        <input type="checkbox" name="remember"> Запомнить
                    </div>
                    -->
                    <div class="form-group">
                        <input style="background-color: inherit;border: 1px solid gainsboro;padding: 8px;width: 120px"  type="submit" value="Войти">
                    </div>
                    {!! csrf_field() !!}
                </form>
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