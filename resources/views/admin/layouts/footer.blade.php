
    <div class="content-wrapper">
      @yield('content')
    </div>

    <footer class="main-footer d-flex justify-content-between align-items-center px-3 py-2 text-white"
          style="background-color: rgba(73, 70, 70, 1);">
    </footer>

  </div>
  <!-- ./wrapper -->

  <script>
    function togglePosMenu(event) {
      event.preventDefault();
      let submenu = document.getElementById("subMenu");
      submenu.style.display = submenu.style.display === "none" ? "block" : "none";
    }
    
    function toggleStokMenu(event) {
      event.preventDefault();
      let submenu = document.getElementById("subMenuStok");
      submenu.style.display = (submenu.style.display === "none" || submenu.style.display === "")
        ? "block"
        : "none";
    }
  </script>

  <!-- jQuery UI 1.11.4 -->
  <script src="{{ asset('admin/assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- ChartJS -->
  <script src="{{ asset('admin/assets/plugins/chart.js/Chart.min.js') }}"></script>
  <!-- Sparkline -->
  <script src="{{ asset('admin/assets/plugins/sparklines/sparkline.js') }}"></script>
  <!-- JQVMap -->
  <script src="{{ asset('admin/assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
  <script src="{{ asset('admin/assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
  <!-- jQuery Knob Chart -->
  <script src="{{ asset('admin/assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
  <!-- daterangepicker -->
  <script src="{{ asset('admin/assets/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('admin/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{ asset('admin/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
  <!-- Summernote -->
  <script src="{{ asset('admin/assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
  <!-- overlayScrollbars -->
  <script src="{{ asset('admin/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('admin/assets/dist/js/adminlte.js') }}"></script>
  <!-- AdminLTE dashboard demo -->
  <script src="{{ asset('admin/assets/dist/js/pages/dashboard.js') }}"></script>
  <!-- PWA Install -->
</body>
</html>