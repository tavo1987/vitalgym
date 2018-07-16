@extends('layouts.app')

@section('contentheader_title')
    Planes
@endsection

@section('main-content')
    <div class="box">
        <div class="box-header tw-mb-3 lg:tw-flex lg:tw-items-center">
            <h3 class="tw-pr-4 tw-mb-2">Administrat planes:</h3>
            <a class="vg-button tw-py-2 tw-bg-grey hover:tw-bg-indigo"
               href="">
                <i class=" glyphicon glyphicon-file"></i>
                Nuevo
            </a>
        </div><!-- /.box-header -->
        <div class="box-body tw-px-0 tw-text-center">
            <div class="lg:tw-flex tw-flex-wrap">
                @foreach($plans as $plan)
                @endforeach
                    <table class="table table-striped table-hover tw-min-w-lg tw-text-center">
                        <thead>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Precio</th>
                            <th class="text-center">Premium</th>
                            <th class="text-center">Creado</th>
                            <th class="text-center">Acciones</th>
                        </thead>
                        <tbody>
                        @foreach($plans as $plan)
                            <tr>
                                <td class="tw-capitalize">{{ $plan->name }}</td>
                                <td>${{ $plan->price_in_dollars }}</td>
                                <td>{{ $plan->is_premium ? 'si' : 'no' }}</td>
                                <td>{{ $plan->created_at->format('d-m-y') }}</td>
                                <td class="tw-flex tw-justify-center tw-items-center">
                                    <a class="tw-px-2 tw-text-2xl tw-text-indigo" href=""><i class="fa fa-eye"></i></a>
                                    <a class="tw-px-2 tw-text-2xl tw-text-indigo" href=""><i class="fa fa-edit"></i></a>
                                    <a class="tw-px-2 tw-text-2xl tw-text-grey hover:tw-text-red-light" href=""><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
            </div><!-- /.end tw-flex -->
        </div><!-- /.end box-body -->
    </div><!-- /.end box -->
@endsection

