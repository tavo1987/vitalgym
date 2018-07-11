<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ asset('storage/avatars/'.Auth::user()->avatar) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->full_name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">MENU PRINCIPAL</li>
            <!-- Optionally, you can add icons to the links -->
            <li>
                <a href="#">
                    <i class='fa fa-street-view'></i> <span>Clientes</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.membership-types') }}"><i class="fa fa-circle-o"></i>Todos</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i>Nuevo</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                    <span>Membresías</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.membership-types') }}"><i class="fa fa-circle-o"></i>Todas</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file-text" aria-hidden="true"></i>
                    <span>Tipos de Membresías</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.membership-types') }}"><i class="fa fa-circle-o"></i>Todas</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i>Nueva</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class='fa fa-archive'></i>
                    <span>Rutinas</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i>Todas</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i>Nueva</a></li>
                </ul>
            </li>
            <li><a href="#"><i class='fa fa-money'></i> <span>Pagos</span></a></li>
            <li><a href="#"><i class='fa fa fa-file-text-o'></i> <span>Fichas</span></a></li>
            <li><a href="#"><i class='fa fa-calendar'></i> <span>Asistencia</span></a></li>
            <li class="active"><a href="{{ route('users.index') }}"><i class='fa fa-users'></i> <span>Usuarios</span></a></li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
