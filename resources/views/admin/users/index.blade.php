@extends('layouts.app')

@section('contentheader_title')
    Lista de Usuarios
@endsection


@section('main-content')
    <div class="spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Condensed Full Width Table</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body ">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th>ID/th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Estado</th>
                                    <th>Última sesión</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->role}}</td>
                                        <td>{{$user->status}}</td>
                                        <td>{{$user->last_login}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>
@endsection
