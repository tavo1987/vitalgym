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
                    <div class="box-body">
                        <table class="table text-center table-striped">
                            <tr>
                                <th width="10px">ID</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Creada</th>
                                <th width="225px">Acciones</th>
                            </tr>
                            @foreach($membershipTypes as $membershipType)
                                <tr>
                                    <td>{{ $membershipType->id }}</td>
                                    <td><span class="tw-capitalize label tw-bg-grey">{{ $membershipType->name }}</span></td>
                                    <td>${{ $membershipType->price_in_dollars }}</td>
                                    <td>{{ $membershipType->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <div class="tw-flex tw-items-center tw-justify-around">
                                            <a class="tw-text-white tw-px-3 tw-py-1 tw-rounded tw-text-xs tw-bg-blue" href="#">
                                                <i class="fa fa-pencil tw-pr-1"></i>Editar
                                            </a>
                                            <a class="tw-text-grey-dark tw-px-3 tw-py-1 tw-rounded tw-text-xs tw-border" href="#">
                                                <i class="fa fa-trash tw-pr-1"></i>Eliminar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div><!-- /.end box-body -->
                </div>
            </div>
        </div>
    </div>
@endsection

