@extends('layouts.app')

@section('contentheader_title')
        Tipos de Membresías
@endsection

@section('main-content')
    <div class="box tw-p-8 tw-rounded tw-shadow-lg tw-border-blue-darker">
        <div class="box-header tw-mb-3 lg:tw-flex lg:tw-items-center">
            <h3 class="tw-pr-4 tw-mb-2">Crear Nueva:</h3>
            <a class="tw-inline-block tw-bg-grey tw-py-2 tw-px-4 tw-text-white tw-rounded tw-font-bold tw-uppercase hover:tw-text-white hover:tw-bg-indigo"
               href="#">
                <i class=" glyphicon glyphicon-file"></i>
                Nueva
            </a>
        </div><!-- /.box-header -->
        <div class="box-body tw-px-0 tw-text-center">
            @foreach($membershipTypes as $membershipType)
                <div class="tw-shadow tw-py-4 tw-px-4 tw-rounded md:tw-flex tw-items-center tw-justify-between tw-mb-4 tw-bg-grey-lighter">
                    <div class="tw-text-center tw-bg-flex lg:tw-text-left">
                        <span class="fa fa-id-card-o fa-4x tw-text-blue-darker tw-block tw-mb-1" aria-hidden="true"></span>
                        <h2 class="tw-text-black tw-uppercase tw-text-sm">{{ $membershipType->name }}</h2>
                    </div>
                    <div class="tw-mb-4 lg:tw-mb-0">
                        <span class="tw-text-xl tw-text-blue-darker tw-rounded tw-py-2 tw-px-4 tw-font-bold"> ${{ $membershipType->price_in_dollars }}</span>
                    </div>
                    <div>
                        <a class="tw-inline-block tw-bg-indigo-dark tw-py-3 tw-px-6 tw-text-white tw-rounded tw-font-bold tw-uppercase hover:tw-text-white hover:tw-bg-indigo-light"
                           href="{{ route('admin.memberships.create', $membershipType) }}">
                            <i class="fa fa-shopping-cart tw-mr-2" aria-hidden="true"></i>
                            <span>Comprar</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div><!-- /.end box-body -->
    </div><!-- /.end box -->
@endsection

