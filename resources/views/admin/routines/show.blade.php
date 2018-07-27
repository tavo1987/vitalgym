@extends('layouts.app')

@section('contentheader_title')
    Detalles Rutina - N# {{ $routine->id }}
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datepicker/bootstrap-datepicker3.min.css') }}">
@endpush

@section('main-content')
    <div class="box">
        <div class="box-header tw-mb-3 tw-py-0 tw-mb-2">
            <h2 class="tw-text-base">Detalles de la rutina</h2>
        </div>
        <div class="box-body p">
            <div class="tw-shadow tw-rounded-lg tw-overflow-hidden">
                <h2 class="tw-bg-grey-light tw-px-4 tw-text-black tw-py-3 tw-text-lg tw-text-center md:tw-text-left">Archivo</h2>
                <div class="tw-px-6 tw-py-6 lg:tw-flex lg:tw-items-center tw-text-center md:tw-text-left">
                    <div class="tw-rounded-full tw-overflow-hidden tw-w-32 tw-inline-block tw-mr-8 tw-border-4 tw-border-grey-light">
                        <img src="{{ asset("storage/files/{$routine->file}") }}" alt="Logo">
                    </div>
                    <div>
                        <h3 class="tw-mb-px">{{ $routine->name }}</h3>
                    </div>
                </div><!-- ./End tw-flex-->
                <table class="table table-striped tw-table-auto tw-mb-0">
                    <tr>
                        <td class="tw-font-semibold tw-inline-block tw-ml-6 tw-uppercase tw-text-xs">Nivel</td>
                        <td class="tw-uppercase tw-text-xs">{{ $routine->level->name }}</td>
                    </tr>
                    <tr>
                        <td class="tw-font-semibold tw-inline-block tw-ml-6 tw-uppercase tw-text-xs">Descripción:</td>
                        <td>{{ $routine->description }}</td>
                    </tr>
                    <tr>
                        <td class="tw-font-semibold tw-inline-block tw-ml-6 tw-uppercase tw-text-xs">Archivo:</td>
                        <td>
                            <form action="{{ route('file.download') }}" method="POST">
                                <input type="submit" class="btn btn-default">
                            </form>
                        </td>
                    </tr>
                </table>
            </div><!-- ./End tw-shadow-->
        </div><!-- ./End box body-->
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

