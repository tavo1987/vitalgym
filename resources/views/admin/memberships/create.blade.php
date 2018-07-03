@extends('layouts.app')

@section('contentheader_title')
    Nueva membresía
@endsection

@section('contentheader_description')
    Crear
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('plugins/datepicker/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
@endpush

@section('main-content')
    <div class="spark-screen">
        <div class="row">
            <div class="col-md-8">
                <form action="">
                    <div class="form-group">
                        <label>Tipo de membresía</label>
                        <select name="membership_type_id" class="form-control select2 select2-hidden-accessible" tabindex="-1">
                            <option>Mensual</option>
                            <option>Semestral</option>
                            <option>Semestral</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right datepicker">
                    </div>
                </form>
            </div><!-- ./ End spark col-md-12-->
        </div><!-- ./ End row-->
    </div><!-- ./ End spark screen-->
@endsection

@push('footer-scripts')
    <script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('plugins/datepicker/locales/bootstrap-datepicker.es.js') }}"></script>
    <script src="{{ asset('plugins/select2/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.datepicker').datepicker({
                language: "es",
            });
            $('.select2').select2();
        })
    </script>
@endpush

