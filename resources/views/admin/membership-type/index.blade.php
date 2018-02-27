@extends('layouts.app')

@section('contentheader_title')
    Tipos de Mebresías
@endsection

@section('main-content')
    <div class="spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Lista</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body ">
                        @foreach($membershipTypes as $membershipType)
                            {{ $membershipType->name }}
                            {{ $membershipType->price_in_dollars }}
                        @endforeach
                    </div><!-- /.end box-body -->
                </div>
            </div>
        </div>
    </div>
@endsection

