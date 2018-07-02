@extends('layouts.app')

@section('contentheader_title')
    Bienvenido
@endsection

@section('main-content')
    <div class="spark-screen">
        <div class="row">
            <div class="col-md-4">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>10</h3>
                        <span class="">Clientes</span>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>10</h3>
                        <span class="">Membresías</span>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>10</h3>
                        <span class="">Asistencias</span>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection
