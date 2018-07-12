@extends('layouts.app')

@section('contentheader_title')
    Membresía {{ $membershipType->name  }}
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datepicker/bootstrap-datepicker3.min.css') }}">
@endpush

@section('main-content')
    <div class="box tw-px-4 tw-py-4">
        <div class="box-header tw-mb-3 lg:tw-flex lg:tw-items-center">
            <h2 class="box-title tw-uppercase">Lenar el formulario para agregar una membresía </h2>
        </div>
        <div class="box-body">
            <form action="{{ route('admin.membership.store') }}" method="post" autocomplete="off">
                @csrf
                <input type="hidden" name="membership_type_id" value="{{ $membershipType->id }}">
                <div class="form-group {{  $errors->has('customer_id') ? 'has-error': '' }}">
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
                </div>


                <div class="form-group {{ $errors->has('membership_quantity') ? ' has-error': '' }}">
                    <label>Cantidad</label>
                    <input class="form-control" type="number" name="membership_quantity" value="{{ old('membership_quantity') }}">
                    @if ($errors->has('membership_quantity'))
                        <span class="help-block">{{ $errors->first('membership_quantity') }}</span>
                    @endif
                </div>
                @if( $membershipType->is_premium)
                    <div class="form-group {{ $errors->has('total_days') ? ' has-error': '' }}">
                        <label>Días Totales</label>
                        <input class="form-control" type="number" name="total_days" value="{{ old('total_days') }}">
                        @if ($errors->has('total_days'))
                            <span class="help-block">{{ $errors->first('total_days') }}</span>
                        @endif
                    </div>
                @endif

                <div class="form-group date {{ $errors->has('date_start') ? ' has-error': '' }}">
                    <label>Fecha de Inicio</label>
                    <input name="date_start" type="text" class="form-control datepicker" value="{{ old('date_start') }}">
                    @if ($errors->has('date_start'))
                        <span class="help-block">{{ $errors->first('date_start') }}</span>
                    @endif
                </div>

                <div class="form-group date {{ $errors->has('date_end') ? ' has-error': '' }}">
                    <label>Fecha de Caducidad</label>
                    <input name="date_end" type="text" class="form-control datepicker" value="{{ old('date_end') }}">
                    @if ($errors->has('date_end'))
                        <span class="help-block">{{ $errors->first('date_end') }}</span>
                    @endif
                </div>

                <button type="submit" class="btn tw-bg-indigo tw-text-white tw-text-base hover:tw-text-white">
                    <i class="fa fa-save"></i>
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

