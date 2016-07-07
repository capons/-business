<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link href="{!! asset('public/css/style.css') !!}" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <!--style js -->
    <script type="text/javascript" src="{!! asset('/public/js/main.js') !!}"></script>

</head>
<body>
<!--nav menu -->
<section>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!--
                <a class="navbar-brand" href="#">Brand</a>
                -->
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-left">
                    <li <?php if(Route::getCurrentRoute()->getPath() == '/'){ echo 'class=active';} else { echo '';} ?>><a href="{{ url('/')}}">Главная<span class="sr-only"></span></a></li>
                    <li <?php if(Route::getCurrentRoute()->getPath() == 'auth/login'){ echo 'class=active';} else { echo '';} ?>><a href="{{ url('auth/login')}}">Войти<span class="sr-only"></span></a></li>
                    <li <?php if(Route::getCurrentRoute()->getPath() == 'auth/registration'){ echo 'class=active';} else { echo '';} ?>><a href="{{ url('auth/registration')}}">Регистрация<span class="sr-only"></span></a></li>

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li <?php if(Route::getCurrentRoute()->getPath() == 'client/account' || Route::getCurrentRoute()->getPath() == 'client/account/manager' || Route::getCurrentRoute()->getPath() == 'client/account/script'){ echo 'class=active';} else { echo '';} ?>><a href="{{ url('client/account')}}">Клиент аккаунт<span class="sr-only"></span></a></li>
                    <li <?php if(Route::getCurrentRoute()->getPath() == 'manager/account'){ echo 'class=active';} else { echo '';} ?>><a href="{{ url('manager/account')}}">Менеджер аккаунт<span class="sr-only"></span></a></li>
                    <li <?php if(Route::getCurrentRoute()->getPath() == 'auth/logout'){ echo 'class=active';} else { echo '';} ?>><a href="{{ url('auth/logout')}}">Выйти<span class="sr-only"></span></a></li>
                </ul>
                <!--
                <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
                -->
                <!--
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Link</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </li>
                </ul>
                -->
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</section>
@section('sidebar')
    Это - главный сайдбар.
@show
@yield('content')





</body>
</html>