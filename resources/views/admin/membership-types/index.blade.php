@extends('layouts.app')

@section('contentheader_title')
    Tipos de Mebresías
@endsection

@section('main-content')
    <div class="spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header tw-py-4">
                        <h3 class="box-title tw-pr-4 tw-uppercase">Crear Nueva:</h3>
                        <a class="tw-px-4 tw-py-2 tw-text-xs tw-text-white tw-bg-indigo-light tw-rounded tw-uppercase" href="#">
                            <i class=" glyphicon glyphicon-file"></i>
                            Nueva
                        </a>
                    </div><!-- /.box-header -->
                    <div class="box-body tw-px-6">
                        @foreach($membershipTypes as $membershipType)
                            <div class="tw-shadow tw-p-6 tw-rounded-lg tw-flex tw-items-center tw-justify-between tw-mb-4">
                                <h2 class="tw-text-black tw-uppercase tw-text-2xl">{{ $membershipType->name }}</h2>
                                <div>
                                    <span class="tw-text-xl"> ${{ $membershipType->price_in_dollars }}</span>
                                </div>
                                <div>
                                    <a class="tw-bg-indigo tw-py-2 tw-px-4 tw-text-white tw-rounded" href="#">Comprar</a>
                                </div>
                            </div>
                        @endforeach
                    </div><!-- /.end box-body -->
                </div>
            </div>
        </div>
    </div>
@endsection

