@extends('app')

@section('title', 'Main page')

@section('sidebar')
@stop

@section('content')
    <div class="container-fluid">


        <div class="col-xs-12">
            <p style="text-align: center">Добавить скрипт</p>
        </div>


        @if (count($user) > 0)
            <div class="col-lg-12">
                <div style="text-align: center" class="col-xs-6">
                    <a style="padding: 5px;background-color: rgba(116, 34, 20, 0.6);color: white" href="{{ url('client/account')}}">Панель управления</a>
                </div>
                <div class="col-xs-6">
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

        <div class="col-xs-12">
            <div class="col-md-6">
                <div style="text-align: center;margin-top: 50px" class="row">
                    <button id="add-script-b" style="padding: 15px;background-color: rgba(8, 116, 6, 0.6);border: none;outline: none">Добавить скрипт</button>
                </div>

            </div>
        </div>
        <div class="col-xs-12">
            <div style="margin-top: 50px" class="row">
                @if(count($block_tree) > 0)
                    <?php
                    echo $block_tree;
                    ?>
                @endif
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
    </div>
    <!--Add manager modal window -->
    @include('modal.add_script')

@stop