@extends('app')

@section('title', 'Main page')

@section('sidebar')
@stop

@section('content')
    <p style="text-align: center">Форма регистрации клиента</p>

    <div class="col-xs-12">
        <div style="float: none;margin: 0 auto" class="col-xs-4">
            <form class="form-horizontal" action="{{action('Auth\AuthController@postRegister')}}" method="post">
                <div class="form-group">
                    <label >Название компании:</label>
                    <input type="text" class="form-control" name="name" required value="название" placeholder="Введите название компании">
                </div>
                <div class="form-group">
                    <label >Email:</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Введите адрес электронной почты">
                </div>
                <div class="form-group">
                    <label >Пароль:</label>
                    <input type="password" class="form-control" name="pass" value="111111" required placeholder="Введите пароль">
                </div>
                <div class="form-group">
                    <label>Подтвердите пароль:</label>
                    <input type="password"  class="form-control" name="re_pass" value="111111" required placeholder="Введите пароль еще раз">
                </div>
                <div class="form-group">
                    <input style="background-color: inherit;border: 1px solid gainsboro;padding: 8px"  type="submit" value="Зарегистрироваться">
                </div>
                {!! csrf_field() !!}
            </form>
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