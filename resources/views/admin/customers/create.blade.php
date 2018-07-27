@extends('layouts.app')

@section('contentheader_title')
    Nuveo cliente
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('plugins/datepicker/bootstrap-datepicker3.min.css') }}">
@endpush

@section('main-content')
    <div class="box">
        <div class="box-header tw-mb-3 tw-py-0 tw-mb-2">
            <h2 class="tw-text-base">Lenar el formulario para agregar un nuevo cliente</h2>
        </div>
        <div class="box-body">
            <form action="{{ route('admin.customers.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                {{--<div class="form-group {{  $errors->has('customer_id') ? 'has-error': '' }}">
                    <label>Cliente</label>
                    <select name="customer_id" class="form-control select2" tabindex="-1">
                        <option>Selecciona un cliente</option>
                        @foreach($customers as $customer)
                            <option  value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} {{ $customer->last_name }} - {{ $customer->email }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('customer_id'))
                        <span class="help-block">{{ $errors->first('customer_id') }}</span>
                    @endif
                </div>--}}


                <div class="xl:tw-flex xl:tw-flex-wrap">
                    <div class="form-group xl:tw-w-1/2 xl:tw-pr-2 {{ $errors->has('name') ? ' has-error': '' }}">
                        <label>Nombre:</label>
                        <input class="form-control" type="text" name="name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group xl:tw-w-1/2 xl:tw-pl-2 {{ $errors->has('last_name') ? ' has-error': '' }}">
                        <label>Apellido:</label>
                        <input class="form-control" type="text" name="last_name" value="{{ old('last_name') }}">
                    </div>
                    <div class="form-group xl:tw-w-1/2 xl:tw-pr-2 {{ $errors->has('ci') ? ' has-error': '' }}">
                        <label>Cédula:</label>
                        <input class="form-control" type="text" name="ci" value="{{ old('ci') }}">
                    </div>
                    <div class="form-group xl:tw-w-1/2 xl:tw-pl-2 {{ $errors->has('email') ? ' has-error': '' }}">
                        <label>Email:</label>
                        <input class="form-control" type="email" name="email" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="form-group {{ $errors->has('password') ? ' has-error': '' }}">
                    <label>Contreseña</label>
                    <input class="form-control" type="password" name="password">
                </div>

                <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error': '' }}">
                    <label>Repetir Contraseña</label>
                    <input class="form-control" type="password" name="password_confirmation">
                </div>

                <div class="form-group {{ $errors->has('birthdate') ? 'has-error': '' }}">
                    <label>Fecha Nacimiento</label>
                    <input class="form-control datepicker" type="text" name="birthdate" value="{{ old('birthdate') }}">
                    @if ($errors->has('birthdate'))
                        <span class="help-block">{{ $errors->first('birthdate') }}</span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('gender') ? 'has-error': '' }}">
                    <label>Género</label>
                    <select name="gender" class="form-control">
                        <option disabled selected>Seleccionar género</option>
                        <option value="male">Masculino</option>
                        <option value="feminine">Femenino</option>
                    </select>
                    @if ($errors->has('gender'))
                        <span class="help-block">{{ $errors->first('gender') }}</span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('level_id') ? 'has-error': '' }}">
                    <label>Nivel</label>
                    <select name="level_id" class="form-control">
                        <option disabled selected>Seleccionar nivel</option>
                        @foreach($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('level_id'))
                        <span class="help-block">{{ $errors->first('level_id') }}</span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('medical_observations') ? 'has-error': '' }}">
                    <label>Observaciones Médicas</label>
                    <textarea class="form-control" type="text" name="medical_observations">{{ old('birthdate') }}</textarea>
                    @if ($errors->has('medical_observations'))
                        <span class="help-block">{{ $errors->first('medical_observations') }}</span>
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
        })
    </script>
@endpush

