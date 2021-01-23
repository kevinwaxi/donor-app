<template>
    <div>
        <div class="wrapper">

        <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
                </ul>

                <!-- SEARCH FORM -->
                <form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                    </div>
                </div>
                </form>


            </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
            <img src="/assets/img/Logo.png" alt="Donor Logo" class="brand-image img-circle elevation-3"
                style="opacity: .8">
            <span class="brand-text font-weight-light">Donor</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                <img src="#" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fab fa-elementor"></i>
                            <p>
                                Elements
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link to="site" href="#" class="nav-link">
                                    <i class="fas fa-store-alt nav-icon"></i>
                                    <p>Camp Site</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="donations" href="#" class="nav-link">
                                    <i class="fas fa-store-alt nav-icon"></i>
                                    <p>Donations</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="users" class="nav-link">
                                    <i class="fas fa-users nav-icon"></i>
                                    <p>Users</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-house-user nav-icon"></i>
                                    <p>Families</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <router-link to="agencies" class="nav-link">
                                    <i class="fas fa-building nav-icon"></i>
                                    <p>Agencies</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Settings
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link to="roles" class="nav-link">
                                <i class="fas fa-user-tag nav-icon"></i>
                                <p>Roles</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-id-badge nav-icon"></i>
                                    <p>My Profile</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-shield-alt nav-icon"></i>
                                    <p>Security</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="logout" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Log Out
                        </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <router-view></router-view>

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
            Anything you want
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </footer>
        </div>
    </div>
</template>
