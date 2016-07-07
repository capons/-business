@extends('app')

@section('title', 'Main page')

@section('sidebar')
@stop

@section('content')
    <div class="container-fluid">


        <p style="text-align: center">Аккаунт клиента</p>
        @if (count($manager) > 0)


            <div class="col-lg-12">
                <div class="col-xs-offset-6 col-xs-6">
                    <div class="col-xs-6">
                        <p>Вы вошли как <span style="font-family: Aparajita">{{$manager->name}}</span>
                        </p>
                    </div>
                    <div class="col-xs-6">
                        <a style="padding: 5px;background-color: #ff9e97;color: black" href="{{ url('auth/logout')}}">Выход</a>
                    </div>
                </div>
            </div>
        @endif


        <div style="min-height: 300px;background-color: rgba(202, 233, 211, 0.6)" class="col-xs-12">
            <p style="word-break: keep-all;" id="display-manager-task-desk"></p>
        </div>
        <div class="col-xs-12">
            <div style="float: none;margin: 0 auto" class="col-xs-6">
                @if(count($manager_task) > 0)
                    <?php
                   // echo $manager_task;
                    ?>
                    @foreach($manager_task as $row)
                            <div style="background-color: #00a0d2;margin-bottom: 20px" class="col-xs-12">
                                <div class="col-xs-4">
                                    <span id="m-desc-res-{{$row->id}}" class="glyphicon glyphicon-zoom-in b-s-b" data-m_desc="{{$row->desc}}" onclick="show_script_m('{{$row->id}}')"></span>
                                </div>
                                <div class="col-xs-4">
                                    <p style="padding: 10px;margin: 0px">{{$row->name}}</p>
                                </div>
                                <div class="col-xs-4">
                                    <a class="manager_home" href="<?php echo App::make('url')->to('/').'/manager/account';?>">на главную</a>
                                </div>

                            </div>
                    @endforeach
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

@stop