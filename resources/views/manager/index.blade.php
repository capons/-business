@extends('app')

@section('title', 'Main page')

@section('sidebar')
@stop

@section('content')
    <div class="container-fluid">


        <p style="text-align: center">Аккаунт менеджера</p>


        <div style="height: 300px;background-color: rgba(202, 233, 211, 0.6)" class="col-xs-12">

        </div>
        <div class="col-xs-12">
            <div style="float: none;margin: 0 auto" class="col-xs-6">
                @if (count($manager_task) > 0)
                    @foreach($manager_task as $row)
                        <div style="background-color: rgba(148, 160, 149, 0.6);padding: 20px;text-align: center;margin-bottom: 10px" class="col-xs-12">
                            <a style="cursor: pointer" hreh="">{{$row->name}}</a>
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