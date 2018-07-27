@extends('layouts.app')

@section('contentheader_title')
    Rutina
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datepicker/bootstrap-datepicker3.min.css') }}">
@endpush

@section('main-content')
    <div class="box">
        <div class="box-header tw-mb-3 tw-py-0 tw-mb-2">
            <h2 class="tw-text-base">Lenar el formulario para agregar una rutina</h2>
        </div>
        <div class="box-body">
            <form action="{{ route('routines.store') }}" method="post" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="form-group {{  $errors->has('level_id') ? 'has-error': '' }}">
                    <label>Nivel</label>
                    <select name="level_id" class="form-control select2" tabindex="-1">
                        <option>Selecciona un nivel</option>
                        @foreach($levels as $level)
                            <option  value="{{ $level->id }}" {{ old('level_id') == $level->id ? 'selected' : '' }}>
                                {{ $level->name }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('level_id'))
                        <span class="help-block">{{ $errors->first('level_id') }}</span>
                    @endif
                </div>

                <div class="lg:tw-flex tw-mb-4">

                    <div class="form-group date lg:tw-w-1/2 lg:tw-pl-2 date {{ $errors->has('name') ? ' has-error': '' }}">
                        <label>Nombre</label>
                        <input name="name" type="text" class="form-control" value="{{ old('name') }}">
                        @if ($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                    <div class="form-group date lg:tw-w-1/2 lg:tw-pr-2 {{ $errors->has('file') ? ' has-error': '' }}">
                        <label>Archivo</label>
                        <input name="file" type="file" class="form-control" value="{{ old('file') }}">
                        @if ($errors->has('file'))
                            <span class="help-block">{{ $errors->first('file') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('description') ? ' has-error': '' }}">
                    <label>Descripción</label>
                    <textarea name="description" class="form-control" cols="20" rows="5">{{ old('description')  }}</textarea>
                    @if ($errors->has('description'))
                        <span class="help-block">{{ $errors->first('description') }}</span>
                    @endif
                </div>

                <button type="submit" class="vg-button tw-bg-indigo tw-inline-flex tw-items-center">
                    <i class="fa fa-save tw-mr-1 tw-text-base"></i>
                    Guardar
                </button>
            </form>
        </div>
    </div><!-- ./End box default-->
@endsection

@push('footer-scripts')
    <script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('plugins/datepicker/locales/bootstrap-datepicker.es.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.datepicker').datepicker({
                language: 'es',
                format: 'yyyy-mm-dd',
                orientation: 'bottom',
                startDate: new Date(),
                todayHighlight: true,
                autoclose: true,
            });
            $('.select2').select2();
        })
    </script>
@endpush

