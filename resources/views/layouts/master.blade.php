<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Online Inventory System | ADMIN </title> <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="/css/app.css">
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-bell" style="font-size: 1.3em;"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
    </ul>
    <!-- SEARCH FORM -->
    {{-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> --}}

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="./img/random_k_logo.jpg" alt="Random K Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Random K</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 mb-3 d-flex pb-0">
        <div class="image">
          <img src="./img/{{ Auth::user()->photo }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <router-link to="/profile" tag="a" exact>
            <p>
              {{ Auth::user()->name }}
            </p>
          </router-link>
        </div>
      </div> 

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               
          <li class="nav-item">
            <router-link to="/dashboard" tag="a" class="nav-link" active-class="active" exact>
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </router-link>
          </li>
          <li class="nav-header">PRODUCTS</li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-clipboard"></i>
              <p>
                Product Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/add_product" tag="a" class="nav-link" active-class="active" exact>
                  <i class="nav-icon fas fa-plus-circle"></i>
                  <p>Product</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/add_category" tag="a" class="nav-link" active-class="active" exact>
                  <i class="nav-icon fas fa-plus-circle"></i>
                  <p>Product Category</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/add_supplier" tag="a" class="nav-link" active-class="active" exact>
                  <i class="nav-icon fas fa-plus-circle"></i>
                  <p>Supplier</p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>
                Stock Inventory
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/stock_entry" tag="a" class="nav-link" active-class="active" exact>
                  <i class="nav-icon fas fa-plus-circle"></i>
                  <p>Stock entry</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/view_stocks" tag="a" class="nav-link" active-class="active" exact>
                  <i class="nav-icon fas fa-clipboard-list"></i>
                  <p>View stocks</p>
                </router-link>
              </li>
            </ul>
          </li>
          
          <li class="nav-header">POINT OF SALE </li>
          <li class="nav-item">
            <router-link to="/pos" tag="a" class="nav-link" active-class="active" exact>
              <i class="nav-icon fas fa-fax"></i>
              <p>
                POS | Sales Orders
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/invoices" tag="a" class="nav-link" active-class="active" exact>
              <i class="nav-icon fas fa-clipboard"></i>
              <p>
                Invoices
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/customers" tag="a" class="nav-link" active-class="active" exact>
              <i class="nav-icon fas fa-users"></i>
              <p>
                Customers
              </p>
            </router-link>
          </li>


          <li class="nav-header">SETTINGS</li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/users" tag="a" class="nav-link" active-class="active" exact>
                  <i class="nav-icon fas fa-users"></i>
                  <p>Admin Users</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/systemlogs" tag="a" class="nav-link" active-class="active" exact>
                  <i class="nav-icon fas fa-file-archive"></i>
                  <p>System Logs</p>
                </router-link>
              </li>
            </ul>
          </li>
          
          <li class="nav-header"></li>
                  
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">                              
              <i class="nav-icon fas fa-power-off red"></i>
              <p> {{ __('Logout') }} </p>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <router-view></router-view>
        <vue-progress-bar></vue-progress-bar>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Version 0.0.3
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2020 <a href="/">RANDOM K</a> |</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<script src="/js/app.js"></script>
</body>
</html>
