@php
    $currentRoute = Route::currentRouteName();
    $searchKeyword = request('search', '');
    $searchOpen = $currentRoute === 'produk.showall' && $searchKeyword !== '';
    $kategoriActive = $currentRoute === 'produk.kategori';
@endphp

<header class="site-header">
    <div class="container header-flex">
        <div class="logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('logo/logo.kms.jpg.jpeg') }}" alt="Logo">
            </a>
        </div>

        <nav class="main-nav" aria-label="Navigasi utama">
            <ul class="nav-list">
                <li><a href="{{ route('home') }}" class="{{ $currentRoute === 'home' ? 'active' : '' }}">Beranda</a></li>
                <li><a href="{{ route('produk.showall') }}" class="{{ $currentRoute === 'produk.showall' ? 'active' : '' }}">Produk</a></li>
                <li class="nav-dropdown">
                    <button type="button" class="nav-dropdown-toggle {{ $kategoriActive ? 'active' : '' }}">
                        Kategori Produk
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="nav-dropdown-menu">
                        @forelse($navbarCategories ?? [] as $navbarCategory)
                            <a href="{{ route('produk.kategori', $navbarCategory->id) }}" class="nav-dropdown-item">
                                {{ $navbarCategory->nama }}
                            </a>
                        @empty
                            <span class="nav-dropdown-empty">Belum ada kategori</span>
                        @endforelse
                    </div>
                </li>
                <li><a href="{{ route('about') }}" class="{{ $currentRoute === 'about' ? 'active' : '' }}">Tentang Kami</a></li>
            </ul>
        </nav>

        <div class="header-right">
            <div class="search-box {{ $searchOpen ? 'active' : '' }}" id="navbarSearchBox">
                <button class="icon-search search-toggle" id="navbarSearchToggle" type="button" aria-label="Buka pencarian">
                    <i class="fas fa-search"></i>
                </button>
                <form action="{{ route('produk.showall') }}" method="GET" class="search-form" role="search">
                    <input
                        type="text"
                        name="search"
                        class="search-input"
                        placeholder="Cari produk..."
                        value="{{ $searchKeyword }}"
                        autocomplete="off"
                    >
                    <button type="submit" class="search-submit" aria-label="Cari produk">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- Cart Link -->
            <a href="{{ route('user.account.cart.index') }}" class="cart-link">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-text">Keranjang</span>

                @auth
                    @php
                        $cartCount = auth()->user()->cart_count;
                    @endphp

                    @if($cartCount > 0)
                        <span class="cart-badge">{{ $cartCount }}</span>
                    @endif
                @else
                    <span class="cart-badge">0</span>
                @endauth
            </a>

            <!-- Account Link -->
            @auth
                <a href="{{ route('user.account.my-account') }}" class="akun-link">
                    <i class="fas fa-user"></i>
                    <span class="akun-link-label">AKUN SAYA</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="akun-link">
                    <i class="fas fa-user"></i>
                    <span class="akun-link-label">AKUN SAYA</span>
                </a>
            @endauth
        </div>

        <button class="mobile-menu-toggle" id="mobileMenuToggle" type="button" aria-label="Buka menu" aria-controls="mobileMenu" aria-expanded="false">
            <i class="fas fa-bars"></i>
        </button>

        <style>
            .site-header {
                padding: 18px 0;
            }

            .site-header .container.header-flex {
                max-width: 1380px;
                padding-left: 16px;
                padding-right: 16px;
                min-height: 92px;
                display: grid;
                grid-template-columns: 1fr auto 1fr;
                align-items: center;
                gap: 24px;
            }

            .logo {
                justify-self: start;
            }

            .logo img {
                height: 58px;
                width: auto;
                max-width: none;
            }

            .main-nav {
                justify-self: center;
                flex: initial;
            }

            .nav-list {
                display: flex;
                gap: 42px;
                align-items: center;
            }

            .nav-list a,
            .nav-dropdown-toggle {
                font-size: 1.08rem;
                font-weight: 600;
                padding: 10px 0;
                color: #333;
                text-decoration: none;
                background: transparent;
                border: 0;
                white-space: nowrap;
                font-family: inherit;
                line-height: 1.2;
            }

            .nav-dropdown {
                position: relative;
                display: flex;
                align-items: center;
            }

            .nav-dropdown-toggle {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                cursor: pointer;
                appearance: none;
            }

            .nav-dropdown-toggle i {
                font-size: 0.8rem;
                transition: transform 0.2s ease;
            }

            .nav-dropdown:hover .nav-dropdown-toggle i,
            .nav-dropdown:focus-within .nav-dropdown-toggle i {
                transform: rotate(180deg);
            }

            .nav-dropdown-toggle.active,
            .nav-dropdown-toggle:hover {
                color: #2a9d8f;
            }

            .nav-dropdown-menu {
                position: absolute;
                top: calc(100% + 14px);
                left: 50%;
                transform: translateX(-50%);
                min-width: 240px;
                padding: 10px;
                background: #fff;
                border: 1px solid rgba(76, 175, 80, 0.16);
                border-top: 4px solid #4CAF50;
                border-radius: 18px;
                box-shadow: 0 18px 36px rgba(22, 51, 44, 0.14);
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
                transition: opacity 0.22s ease, visibility 0.22s ease, transform 0.22s ease;
                z-index: 20;
            }

            .nav-dropdown:hover .nav-dropdown-menu,
            .nav-dropdown:focus-within .nav-dropdown-menu {
                opacity: 1;
                visibility: visible;
                pointer-events: auto;
            }

            .nav-dropdown-item,
            .nav-dropdown-empty {
                display: block;
                padding: 12px 14px;
                border-radius: 12px;
                font-size: 0.98rem;
                color: #30443a;
                text-decoration: none;
            }

            .nav-dropdown-item:hover {
                background: rgba(76, 175, 80, 0.08);
                color: #2f7a47;
            }

            .nav-dropdown-empty {
                color: #7b8a84;
                cursor: default;
            }

            .header-right {
                display: flex;
                align-items: center;
                justify-self: end;
                justify-content: flex-end;
                margin-left: auto;
                gap: 22px;
            }

            .search-box {
                position: relative;
                display: flex;
                align-items: center;
            }

            .icon-search {
                color: #555;
                font-size: 1.45rem;
                transition: color 0.3s;
                padding: 10px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                border: 0;
                background: transparent;
                cursor: pointer;
            }

            .icon-search:hover {
                color: #4CAF50;
                background: rgba(76, 175, 80, 0.1);
            }

            .search-form {
                position: absolute;
                top: 50%;
                right: calc(100% + 10px);
                transform: translateY(-50%);
                width: 0;
                opacity: 0;
                pointer-events: none;
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 0;
                overflow: hidden;
                background: #fff;
                border: 1px solid rgba(76, 175, 80, 0.18);
                border-radius: 999px;
                box-shadow: 0 14px 28px rgba(31, 90, 51, 0.12);
                transition: width 0.25s ease, opacity 0.25s ease, padding 0.25s ease;
            }

            .search-box.active .search-form {
                width: 300px;
                opacity: 1;
                pointer-events: auto;
                padding: 8px 10px 8px 16px;
            }

            .search-input {
                flex: 1;
                min-width: 0;
                border: 0;
                outline: none;
                background: transparent;
                font-size: 0.96rem;
                color: #23412c;
            }

            .search-input::placeholder {
                color: #7b8a84;
            }

            .search-submit {
                width: 40px;
                height: 40px;
                border: 0;
                border-radius: 50%;
                background: #4CAF50;
                color: #fff;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: background 0.2s ease, transform 0.2s ease;
            }

            .search-submit:hover {
                background: #3f9744;
                transform: translateY(-1px);
            }

            .cart-link {
                display: flex;
                align-items: center;
                color: #555;
                text-decoration: none;
                padding: 12px 20px;
                border-radius: 24px;
                transition: all 0.3s;
                position: relative;
                background: #f8f9fa;
                gap: 10px;
            }

            .cart-link:hover {
                color: #4CAF50;
                background: rgba(76, 175, 80, 0.1);
                transform: translateY(-2px);
            }

            .cart-text {
                font-size: 1rem;
                font-weight: 500;
            }

            .cart-badge {
                position: absolute;
                top: -8px;
                right: -8px;
                background: #ff5722;
                color: white;
                font-size: 0.74rem;
                font-weight: bold;
                min-width: 20px;
                height: 20px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0 4px;
                border: 2px solid #fff;
            }

            .akun-link {
                display: flex;
                align-items: center;
                gap: 8px;
                background: #4CAF50;
                color: white;
                padding: 12px 22px;
                border-radius: 24px;
                text-decoration: none;
                font-weight: 600;
                font-size: 1rem;
                transition: all 0.3s;
                letter-spacing: 0.01em;
            }

            .akun-link:hover {
                background: #45a049;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
            }

            .akun-link i {
                font-size: 1rem;
            }

            .akun-link-label {
                display: inline-block;
                white-space: nowrap;
            }

            .mobile-menu-toggle {
                border: 0;
                background: transparent;
                color: #333;
                display: none;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .site-header {
                    padding: 12px 0;
                }

                .site-header .container.header-flex {
                    display: flex;
                    gap: 12px;
                    min-height: auto;
                    padding-left: 14px;
                    padding-right: 14px;
                }

                .header-right {
                    gap: 10px;
                    margin-left: auto;
                    justify-self: auto;
                }

                .search-form {
                    top: calc(100% + 10px);
                    right: 0;
                    transform: none;
                }

                .search-box.active .search-form {
                    width: min(78vw, 260px);
                }

                .cart-text {
                    display: none;
                }

                .akun-link-label {
                    display: none;
                }

                .akun-link {
                    padding: 0;
                    width: 44px;
                    height: 44px;
                    justify-content: center;
                    border-radius: 50%;
                    flex-shrink: 0;
                    box-shadow: 0 8px 18px rgba(76, 175, 80, 0.22);
                }

                .akun-link i {
                    font-size: 1.02rem;
                    margin: 0;
                }

                .cart-link {
                    padding: 8px;
                    width: 40px;
                    height: 40px;
                    justify-content: center;
                    border-radius: 50%;
                }

                .mobile-menu-toggle {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    width: 42px;
                    height: 42px;
                    border-radius: 50%;
                    background: #f3f7f3;
                }
            }

            @media (max-width: 576px) {
                .logo img {
                    height: 44px;
                }

                .header-right {
                    gap: 8px;
                }

                .icon-search,
                .cart-link,
                .akun-link,
                .mobile-menu-toggle {
                    width: 40px;
                    height: 40px;
                }

                .search-box.active .search-form {
                    width: min(78vw, 230px);
                    padding-left: 12px;
                }
            }
        </style>
    </div>
</header>


<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu" aria-hidden="true">
    <ul>
        <li>
            <a href="{{ route('home') }}" class="{{ $currentRoute === 'home' ? 'active' : '' }}">
                <i class="fas fa-house"></i>
                Beranda
            </a>
        </li>
        <li>
            <a href="{{ route('produk.showall') }}" class="{{ $currentRoute === 'produk.showall' ? 'active' : '' }}">
                <i class="fas fa-store"></i>
                Produk
            </a>
        </li>
        <li class="mobile-menu-group">
            <div class="mobile-menu-category-title">
                <i class="fas fa-layer-group"></i>
                Kategori Produk
            </div>
            @forelse($navbarCategories ?? [] as $navbarCategory)
                <a href="{{ route('produk.kategori', $navbarCategory->id) }}" class="mobile-submenu-link {{ $kategoriActive && request()->route('id') == $navbarCategory->id ? 'active' : '' }}">
                    <i class="fas fa-chevron-right"></i>
                    {{ $navbarCategory->nama }}
                </a>
            @empty
                <span class="mobile-submenu-empty">Belum ada kategori</span>
            @endforelse
        </li>
        <li>
            <a href="{{ route('about') }}" class="{{ $currentRoute === 'about' ? 'active' : '' }}">
                <i class="fas fa-circle-info"></i>
                Tentang Kami
            </a>
        </li>
        <li>
            <a href="{{ route('user.account.cart.index') }}">
                <i class="fas fa-shopping-cart"></i>
                Keranjang
                @auth
                    @if(auth()->user()->cart_count > 0)
                        <span class="cart-badge">{{ auth()->user()->cart_count }}</span>
                    @endif
                @endif
            </a>
        </li>
        <li>
            @auth
                <a href="{{ route('user.account.my-account') }}">
                    <i class="fas fa-user"></i>
                    Akun Saya
                </a>
            @else
                <a href="{{ route('login') }}">
                    <i class="fas fa-right-to-bracket"></i>
                    Masuk
                </a>
            @endauth
        </li>
    </ul>
</div>

<style>
    .mobile-menu {
        display: block;
        position: fixed;
        top: calc(84px + env(safe-area-inset-top));
        left: 14px;
        right: 14px;
        width: auto;
        max-height: calc(100vh - 104px - env(safe-area-inset-top));
        overflow-y: auto;
        background: rgba(255, 255, 255, 0.98);
        border: 1px solid rgba(76, 175, 80, 0.12);
        border-radius: 22px;
        box-shadow: 0 18px 40px rgba(31, 90, 51, 0.16);
        backdrop-filter: blur(14px);
        z-index: 1200;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transform: translateY(-10px);
        transition: opacity 0.22s ease, transform 0.22s ease, visibility 0.22s ease;
    }

    .mobile-menu.active {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
        transform: translateY(0);
    }

    .mobile-menu ul {
        list-style: none;
        padding: 14px;
        margin: 0;
    }

    .mobile-menu li {
        margin: 6px 0;
    }

    .mobile-menu a {
        display: flex;
        align-items: center;
        gap: 10px;
        min-height: 48px;
        padding: 12px 14px;
        border-radius: 14px;
        color: #284431;
        text-decoration: none;
        font-weight: 600;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .mobile-menu a i {
        width: 20px;
        text-align: center;
        color: #4CAF50;
    }

    .mobile-menu a:hover,
    .mobile-menu a.active {
        background: rgba(76, 175, 80, 0.1);
        color: #2f7a47;
    }

    .mobile-menu-group {
        margin: 8px 0 14px;
        padding-top: 4px;
        border-top: 1px solid rgba(76, 175, 80, 0.08);
    }

    .mobile-menu-category-title {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 15px 6px;
        font-weight: 700;
        color: #31533a;
    }

    .mobile-submenu-link {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-left: 14px;
        padding-left: 14px;
        font-weight: 500 !important;
    }

    .mobile-submenu-link i {
        width: 16px !important;
        margin-right: 0 !important;
        font-size: 0.78rem;
    }

    .mobile-submenu-empty {
        display: block;
        padding: 8px 15px 8px 29px;
        color: #7b8a84;
        font-size: 0.92rem;
    }

    @media (min-width: 769px) {
        .mobile-menu {
            display: none !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        const searchBox = document.getElementById('navbarSearchBox');
        const searchToggle = document.getElementById('navbarSearchToggle');
        const searchInput = searchBox ? searchBox.querySelector('.search-input') : null;

        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', function () {
                const isActive = mobileMenu.classList.toggle('active');
                mobileMenuToggle.setAttribute('aria-expanded', isActive ? 'true' : 'false');
                mobileMenu.setAttribute('aria-hidden', isActive ? 'false' : 'true');

                const icon = this.querySelector('i');
                if (icon) {
                    icon.classList.toggle('fa-bars');
                    icon.classList.toggle('fa-times');
                }
            });

            mobileMenu.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', function () {
                    mobileMenu.classList.remove('active');
                    mobileMenuToggle.setAttribute('aria-expanded', 'false');
                    mobileMenu.setAttribute('aria-hidden', 'true');

                    const icon = mobileMenuToggle.querySelector('i');
                    if (icon) {
                        icon.classList.add('fa-bars');
                        icon.classList.remove('fa-times');
                    }
                });
            });

            document.addEventListener('click', function (event) {
                if (!mobileMenu.classList.contains('active')) {
                    return;
                }

                if (!mobileMenu.contains(event.target) && !mobileMenuToggle.contains(event.target)) {
                    mobileMenu.classList.remove('active');
                    mobileMenuToggle.setAttribute('aria-expanded', 'false');
                    mobileMenu.setAttribute('aria-hidden', 'true');

                    const icon = mobileMenuToggle.querySelector('i');
                    if (icon) {
                        icon.classList.add('fa-bars');
                        icon.classList.remove('fa-times');
                    }
                }
            });
        }

        if (searchBox && searchToggle && searchInput) {
            searchToggle.addEventListener('click', function () {
                const isActive = searchBox.classList.toggle('active');
                if (isActive) {
                    setTimeout(() => searchInput.focus(), 120);
                }
            });

            document.addEventListener('click', function (event) {
                if (!searchBox.contains(event.target)) {
                    searchBox.classList.remove('active');
                }
            });
        }
    });
</script>
