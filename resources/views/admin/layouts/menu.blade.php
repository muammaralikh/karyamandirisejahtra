
 <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #499159;">
      <!-- Brand Logo -->
      <a href="" class="brand-link text-center">
        <img src="{{ asset('logo/logo.kms.jpg.jpeg') }}" alt="Logo" style="height: 50px; width: auto;">
      </a>

      <!-- Sidebar -->
      <div class="sidebar"> 
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
              <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                  class="nav-link {{ ($Dashboard ?? '') == 'dashboard' ? 'active' : '' }}">
                  <i class="nav-icon fas fa-tachometer-alt text-white"></i>
                  <p class="text-white">Dashboard</p>
                </a>
              </li>
            <!-- Produk -->
            <li class="nav-item">
              <a href="{{ route('produk.index') }}"
                class="nav-link {{ ($activeProduk ?? '') == 'produk' ? 'active' : '' }}">
                <i class="nav-icon fas fa-box"></i>
                <p class="text-white">Produk</p>
              </a>
            </li>
            
            <!-- Laporan -->
            <li class="nav-item">
              <a href="{{ route(name: 'kategori.index') }}"
                class="nav-link {{ ($activeKategori ?? '') == 'kategori' ? 'active' : '' }}">
                <i class="nav-icon fas fa-file-alt"></i>
                <p class="text-white">Kategori</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route(name: 'pesanan.index') }}"
                class="nav-link {{ ($activePesanan ?? '') == 'pesanan' ? 'active' : '' }}">
                <i class="nav-icon fas fa-shopping-bag"></i>
                <p class="text-white">Pesanan</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route(name: 'daftar-user.index') }}"
                class="nav-link {{ ($activeUser ?? '') == 'user' ? 'active' : '' }}">
                <i class="nav-icon fas fa-user"></i>
                <p class="text-white">Daftar User</p>
              </a>
            </li>

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
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
