@extends('layouts.app')

@section('contentheader_title')
    Detalles Membresía - N# {{ $membership->id }}
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datepicker/bootstrap-datepicker3.min.css') }}">
@endpush

@section('main-content')
    <div class="box">
        <div class="box-header tw-mb-3 tw-py-0 tw-mb-2">
            <h2 class="tw-text-base">Detalles de la membresía</h2>
        </div>
        <div class="box-body p">
            <div class="tw-shadow tw-rounded-lg tw-overflow-hidden">
                <h2 class="tw-bg-grey-light tw-px-4 tw-text-black tw-py-3 tw-text-lg">Cliente</h2>
                <div class="tw-px-6 tw-py-6 tw-flex tw-items-center ">
                    <div class="tw-rounded-full tw-overflow-hidden tw-w-32 tw-inline-block tw-mr-8 tw-border-4 tw-border-grey-light">
                        <img src="{{ asset("storage/avatars/{$customer->avatar}") }}" alt="Logo">
                    </div>
                    <div>
                        <h3 class="tw-mb-px">{{ $customer->full_name }}</h3>
                        <a class="tw-inline-block tw-mb-3">
                            <i class="fa fa-envelope tw-mr-1"></i>
                            {{ $customer->email }}
                        </a>
                        <p class="tw-mb-1">
                            <i class="fa fa-phone tw-mr-2"></i>
                            {{ $customer->phone }} / {{ $customer->cell_phone }}
                        </p>
                        <p>
                            <i class="fa fa-address-book tw-mr-1"></i>
                            {{ $customer->address }}
                        </p>
                    </div>
                </div><!-- ./End tw-flex-->
                <table class="table table-striped tw-table-auto tw-mb-0">
                    <tr>
                        <td class="tw-font-semibold tw-inline-block tw-ml-6 tw-uppercase tw-text-xs">Plan</td>
                        <td class="tw-uppercase tw-text-xs">{{ $plan->name }}</td>
                    </tr>
                    <tr>
                        <td class="tw-font-semibold tw-inline-block tw-ml-6 tw-uppercase tw-text-xs">Precio unitario:</td>
                        <td>${{ $plan->price_in_dollars }}</td>
                    </tr>
                    <tr>
                        <td class="tw-font-semibold tw-inline-block tw-ml-6 tw-uppercase tw-text-xs">Cantidad:</td>
                        <td>{{ $payment->membership_quantity }}</td>
                    </tr>
                    <tr>
                        <td class="tw-font-semibold tw-inline-block tw-ml-6 tw-uppercase tw-text-xs">Precio Total</td>
                        <td>${{ $payment->total_price_in_dollars }}</td>
                    </tr>
                    <tr>
                        <td class="tw-font-semibold tw-inline-block tw-ml-6 tw-uppercase tw-text-xs">Premium</td>
                        <td>{{ $plan->is_premium ? 'Si' : 'No' }}</td>
                    </tr>
                    <tr>
                        <td class="tw-font-semibold tw-inline-block tw-ml-6 tw-uppercase tw-text-xs">Fecha Pago</td>
                        <td>{{ $membership->date_start->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td class="tw-font-semibold tw-inline-block tw-ml-6 tw-uppercase tw-text-xs">Fecha expiracion</td>
                        <td>{{ $membership->date_end->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td class="tw-font-semibold tw-inline-block tw-ml-6 tw-uppercase tw-text-xs">Creada por:</td>
                        <td>{{ $payment->user->name }} {{ $payment->user->last_name }}</td>
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

