<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Storage::url(Auth::user()->avatar) }}" class="img-circle" alt="User Image" />
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
            <li class="{{ request()->is('/') ? 'active' : '' }}">
                <a  href="/">
                    <i class='fa fa-home'></i> <span>Inicio</span>
                </a>
            </li>
            <li class="{{ request()->is('admin/customers') || request()->is('admin/customers/*') ? 'active' : '' }}">
                <a href="#">
                    <i class='fa fa-street-view'></i> <span>Clientes</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.customers.index') }}"><i class="fa fa-circle-o"></i>Todos los clientes</a></li>
                    <li><a href="{{ route('admin.customers.create') }}"><i class="fa fa-circle-o"></i>Añadir Nuevo</a></li>
                </ul>
            </li>
            <li class="treeview {{ request()->is('admin/memberships') || request()->is('admin/memberships/*') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                    <span>Membresías</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.memberships.index') }}"><i class="fa fa-circle-o"></i>Administrar membresías</a></li>
                    <li><a href="{{ route('plans.index') }}"><i class="fa fa-circle-o"></i>Añadir nueva</a></li>
                </ul>
            </li>
            <li class="treeview {{ request()->is('admin/plans') || request()->is('admin/plans/*') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-file-text" aria-hidden="true"></i>
                    <span>Planes</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.plans.index') }}"><i class="fa fa-circle-o"></i>Administrar planes</a></li>
                    <li><a href="{{ route('admin.plans.create') }}"><i class="fa fa-circle-o"></i>Añadir nuevo</a></li>
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
            <li class="treeview {{ request()->is('admin/levels') || request()->is('admin/levels/*') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-level-up" aria-hidden="true"></i>
                    <span>Niveles</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('levels.index') }}"><i class="fa fa-circle-o"></i>Administrar niveles</a></li>
                    <li><a href="{{ route('levels.create') }}"><i class="fa fa-circle-o"></i>Nuevo</a></li>
                </ul>
            </li>
            <li class="{{ request()->is('admin/payments') ? 'active' : '' }}">
                <a href="{{ route('admin.payments.index') }}"><i class='fa fa-money'></i> <span>Pagos</span></a>
            </li>
            <li class="{{ request()->is('admin/attendances') || request()->is('admin/attendances/*') ? 'active' : '' }}">
                <a href="{{ route('admin.attendances.index') }}"><i class='fa fa-calendar'></i> <span>Asistencia</span></a>
            </li>
            <li class="{{ request()->is('admin/reports') ? 'active' : '' }}">
                <a href="{{ route('admin.reports.index') }}"><i class='fa fa-file-pdf-o'></i> <span>Reportes</span></a>
            </li>
            <li class="{{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                <a href="{{ route('admin.users.index') }}"><i class='fa fa-users'></i> <span>Usuarios</span></a>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
