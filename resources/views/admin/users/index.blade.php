@extends('layouts.app')

@section('contentheader_title')
    Usuarios
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
                        <table class="table table-bordered table-hover table-striped responsive">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>name</th>
                                    <th>last_name</th>
                                    <th>Nickname</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Estado</th>
                                    <th>última sesión</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>
                                            <img  width="50" class="img-circle img-bordered-sm" src="{{$user->profile->avatar}}" alt="Avatar user profile">
                                            <span>{{$user->profile->name}}</span>
                                        </td>
                                        <td>{{$user->profile->last_name}}</td>
                                        <td>{{$user->profile->nick_name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td><span class="badge bg-purple">{{$user->role}}</span></td>
                                        <td>
                                            @if($user->active)
                                                <span class="badge bg-green">{{ $user->status }}</span>
                                            @else
                                                <span class="badge bg-orange">{{ $user->status }}</span>
                                            @endif
                                        </td>
                                        <td>{{$user->last_login}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info">Acciones</button>
                                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="#">Editar</a></li>
                                                    <li><a href="#">Eliminar</a></li>
                                                    <li><a href="#">Ver</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table><!-- /.end box-table -->
                    </div><!-- /.end box-body -->
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            {{$users->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
