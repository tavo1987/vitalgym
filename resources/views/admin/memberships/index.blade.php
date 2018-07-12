@extends('layouts.app')

@section('contentheader_title')
    Tipos de Membresías
@endsection

@section('main-content')
    <div class="box">
        <div class="box-header tw-mb-3 lg:tw-flex lg:tw-items-center">
            <h3 class="tw-pr-4 tw-mb-2">Crear Nueva:</h3>
            <a class="tw-inline-block tw-bg-grey tw-py-2 tw-px-4 tw-text-white tw-rounded tw-font-bold tw-uppercase hover:tw-text-white hover:tw-bg-indigo"
               href="{{ route('admin.membership-types') }}">
                <i class=" glyphicon glyphicon-file"></i>
                Nueva
            </a>
        </div><!-- /.box-header -->
        <div class="box-body tw-px-0 tw-text-center">
            @foreach($memberships as $membership)

            @endforeach
        </div><!-- /.end box-body -->
    </div><!-- /.end box -->
@endsection

