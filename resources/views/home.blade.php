@extends('layouts.app')

@section('contentheader_title')
    Bienvenido
@endsection

@section('main-content')
    <div class="spark-screen">
        @if( auth()->user()->isAdmin())
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
        @else
            <p class="tw-text-lg tw-mb-4">
                Gracias por formar parte de VitalGym te damos la bienvenida a nuestro sistema, mediante el cual podrás ver tus pagós, tus membresías, y asistencias.
            </p>
            <p class="tw-text-lg tw-mb-4">
                para poder hacerlo, nevega en las secciones de la izquierda.
            </p>
        @endif
    </div>
@endsection
