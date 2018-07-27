@extends('layouts.app')

@section('contentheader_title')
    Rutinas
@endsection

@section('main-content')
    <div class="box">
        <div class="box-header tw-mb-3 xl:tw-flex xl:tw-justify-between">
            <div class=" lg:tw-flex lg:tw-items-center xl:tw-w-2/5">
                <h3 class="tw-pr-4 tw-mb-2">Crear Nueva:</h3>
                <a class="vg-button tw-py-2 tw-bg-grey hover:tw-bg-indigo"
                   href="{{ route('routines.create') }}">
                    <i class=" glyphicon glyphicon-file"></i>
                    Nueva
                </a>
            </div>
            <div class="tw-pt-6 xl:tw-pt-0 xl:tw-w-3/5">
                <form action="{{ route('routines.index') }}" method="get" class="xl:tw-flex xl:tw-justify-end">
                    <label class="tw-pr-4 tw-mb-0 tw-flex tw-items-center tw-mb-2 xl:tw-mb-0">Buscar por: </label>
                    <div class="form-group tw-mb-2 xl:tw-mb-0">
                        <select class="form-control xl:tw-rounded-r-none xl:tw-border-r-0 tw-h-auto tw-py-2 tw-text-sm" id="js-select-filter">
                            <option selected disabled>seleccionar Filtro</option>
                            <option value="name">Nombre</option>
                            <option value="level">Nivel</option>
                        </select>
                    </div>
                    <div class="form-group  tw-mb-2 xl:tw-mb-0">
                        <input type="search"
                               class="form-control lg:tw-rounded-none tw-h-auto tw-py-2 tw-text-sm"
                               placeholder="nombre, nivel" id="js-input-filter">
                    </div>
                    <button class="vg-button tw-bg-indigo hover:tw-bg-indigo lg:tw-rounded-l-none tw-text-xs">
                        <i class="fa fa-search"></i>
                        Buscar
                    </button>
                </form>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body tw-px-0 tw-text-center">
            <table class="table table-striped table-hover tw-min-w-lg tw-text-center">
                <thead>
                <th class="text-center">Nombre</th>
                <th class="text-center">Nivel</th>
                <th class="text-center">Acciones</th>
                </thead>
                <tbody>
                @foreach($routines as $routine)
                    <tr>
                        <td>{{ $routine->name }}</td>
                        <td>{{ $routine->level->name }}</td>
                        <td class="tw-flex tw-justify-center tw-items-center">
                            <a href="{{ route('routines.show', $routine) }}" class="tw-px-2 tw-text-2xl tw-text-indigo"><i class="fa fa-eye"></i></a>
                            <a href="{{ route('routines.edit', $routine) }}" class="tw-px-2 tw-text-2xl tw-text-indigo"><i class="fa fa-edit"></i></a>
                            <form action="{{ route('routines.destroy', $routine) }}"  method="post" class="form-delete">
                                @csrf
                                @method('delete')
                                <button class="tw-px-2 tw-text-2xl tw-text-grey hover:tw-text-red-light js-button-delete focus:tw-outline-none">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="text-center">
                {{ $routines->links() }}
            </div>
        </div><!-- /.end box-body -->
    </div><!-- /.end box -->
@endsection
