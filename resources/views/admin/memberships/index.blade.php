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
        <div class="box-body tw-px-0 tw-text-center tw-overflow-auto">
            <table class="table table-striped table-hover tw-min-w-lg">
                <thead>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Apellido</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Tipo</th>
                    <th class="text-center">Inicio</th>
                    <th class="text-center">Expira</th>
                    <th class="text-center">Acciones</th>
                </thead>
                <tbody>
                    @foreach($memberships as $membership)
                        <tr>
                            <td>{{ $membership->customer->name }}</td>
                            <td>{{ $membership->customer->last_name }}</td>
                            <td>{{ $membership->customer->email }}</td>
                            <td class="tw-capitalize">{{ $membership->membershipType->name }}</td>
                            <td>{{ $membership->date_start->format('d-m-y') }}</td>
                            <td>
                                @if( $membership->date_end < now())
                                    <span class="tw-bg-red tw-text-white tw-text-xs tw-px-3 tw-py-1 tw-rounded tw-inline-block">
                                        {{ $membership->date_end->format('d-m-y') }}
                                    </span>
                                @else
                                    <span class="tw-bg-green tw-text-white tw-text-xs tw-px-3 tw-py-1 tw-rounded tw-inline-block">
                                        {{ $membership->date_end->format('d-m-y') }}
                                    </span>
                                @endif
                            </td>
                            <td class="tw-flex tw-justify-center tw-items-center">
                                <a class="tw-px-2 tw-text-2xl tw-text-indigo" href=""><i class="fa fa-eye"></i></a>
                                <a class="tw-px-2 tw-text-2xl tw-text-indigo" href=""><i class="fa fa-edit"></i></a>
                                <a class="tw-px-2 tw-text-2xl tw-text-grey hover:tw-text-red-light" href=""><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- /.end box-body -->
    </div><!-- /.end box -->
@endsection

