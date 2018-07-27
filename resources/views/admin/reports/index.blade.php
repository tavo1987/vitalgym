@extends('layouts.app')

@section('contentheader_title')
    Reportes
@endsection

@section('main-content')
    <div class="box">
        <div class="box-header tw-mb-3 xl:tw-flex xl:tw-justify-start">
            <div class=" lg:tw-flex lg:tw-items-center xl:tw-w-2/5">
                <h3 class="tw-pr-4 tw-mb-2 tw-text-xl">Reportes Disponibles:</h3>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body tw-px-0">
            <table class="table table-striped table-hover tw-min-w-lg">
                <thead>
                    <th>Nombre</th>
                    <th class="tw-text-center">Acciones</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Membresías último mes</td>
                        <td class="tw-flex tw-justify-center tw-items-center">
                            <form action=""  method="post" class="form-delete">
                                @csrf
                                <button class="tw-px-2 tw-text-2xl tw-text-indigo">
                                    <i class="fa fa-download"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td>Clientes último mes</td>
                        <td class="tw-flex tw-justify-center tw-items-center">
                            <form action=""  method="post" class="form-delete">
                                @csrf
                                <button class="tw-px-2 tw-text-2xl tw-text-indigo">
                                    <i class="fa fa-download"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                </tbody><!-- /.end tbody -->
            </table><!-- /.end table -->
        </div><!-- /.end box-body -->
    </div><!-- /.end box -->
@endsection
