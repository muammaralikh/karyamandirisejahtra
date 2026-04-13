<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="theme-color" content="#499159">
  <link rel="apple-touch-icon" href="{{ asset('assets/logo/logo.jpeg') }}">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('admin/assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet"
    href="{{ asset('admin/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('admin/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('admin/assets/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin/assets/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('admin/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('admin/assets/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('admin/assets/plugins/summernote/summernote-bs4.min.css') }}">
  <!-- jQuery -->
  <script src="{{ asset('admin/assets/plugins/jquery/jquery.min.js') }}"></script>

  <!-- Bootstrap 4 -->
  <script src="{{ asset('admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- AdminLTE -->
  <script src="{{ asset('admin/assets/dist/js/adminlte.min.js') }}"></script>

</head>
<style>
  .btn-logout {
    background-color: red;
    color: black;
    border: none;
    padding: 3px 12px;
    border-radius: 4px;
    font-weight: bold;
    cursor: pointer;
  }

  .btn-logout:hover {
    background-color: darkred;
    color: white;
  }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- NAVBAR -->
    <nav class="main-header navbar navbar-expand navbar-dark" style="background-color:#499159;">

      <!-- LEFT -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button">
            <i class="fas fa-bars"></i>
          </a>
        </li>
      </ul>

      <!-- RIGHT -->
      <ul class="navbar-nav ml-auto">

        <!-- JAM -->
        <li class="nav-item d-none d-md-block">
          <span class="nav-link text-white" id="clock"></span>
        </li>

        <!-- FULLSCREEN -->
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt text-white"></i>
          </a>
        </li>

        <!-- USER -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-user-circle text-white"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            

            <div class="dropdown-divider"></div>
            <a href="" class="dropdown-item">
              <i class="fas fa-user mr-2"></i> Profil
            </a>

            <div class="dropdown-divider"></div>

            <a href="#" class="dropdown-item text-danger"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </div>
        </li>

      </ul>
    </nav>

    <!-- SCRIPT JAM REALTIME -->
    <script>
      function updateClock() {
        const now = new Date();
        const options = {
          weekday: 'short',
          year: 'numeric',
          month: 'short',
          day: 'numeric',
          hour: '2-digit',
          minute: '2-digit',
          second: '2-digit'
        };
        document.getElementById('clock').innerHTML =
          now.toLocaleDateString('id-ID', options);
      }
      setInterval(updateClock, 1000);
      updateClock();

      // iPad specific touch enhancements
      document.addEventListener('DOMContentLoaded', function () {
        // Better touch support for dropdowns on iPad
        $('.dropdown-toggle').on('click touchstart', function (e) {
          e.preventDefault();
          $(this).dropdown('toggle');
        });

        // Prevent double tap zoom on buttons
        $('.nav-link, .dropdown-item').on('touchstart', function (e) {
          if ($(this).hasClass('dropdown-toggle')) {
            return;
          }
          var $link = $(this);
          var href = $link.attr('href');
          if (href && href !== '#') {
            window.location = href;
          }
        });
      });
    </script>

    