@php
    $currentRoute = Route::currentRouteName();

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
                <li><a href="{{ route('about') }}" class="{{ $currentRoute === 'about' ? 'active' : '' }}">Tentang Kami</a></li>
            </ul>
        </nav>

        <div class="header-right">
            <a href="{{ route('produk.showall') }}" class="icon-search">
                <i class="fas fa-search"></i>
            </a>

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
                    AKUN SAYA
                </a>
            @else
                <a href="{{ route('login') }}" class="akun-link">
                    <i class="fas fa-user"></i>
                    AKUN SAYA
                </a>
            @endauth
        </div>

        <button class="mobile-menu-toggle" id="mobileMenuToggle" type="button" aria-label="Buka menu">
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
                gap: 42px;
            }

            .nav-list a {
                font-size: 1.08rem;
                font-weight: 600;
                padding: 10px 0;
            }

            .header-right {
                display: flex;
                align-items: center;
                justify-self: end;
                justify-content: flex-end;
                margin-left: auto;
                gap: 22px;
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
            }

            .icon-search:hover {
                color: #4CAF50;
                background: rgba(76, 175, 80, 0.1);
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

            .mobile-menu-toggle {
                border: 0;
                background: transparent;
                color: #333;
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

                .cart-text {
                    display: none;
                }

                .akun-link span {
                    display: none;
                }

                .akun-link {
                    padding: 8px;
                    width: 40px;
                    height: 40px;
                    justify-content: center;
                    border-radius: 50%;
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
                    width: 38px;
                    height: 38px;
                }
            }
        </style>
    </div>
</header>


<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');

        if (!mobileMenuToggle || !mobileMenu) {
            return;
        }

        mobileMenuToggle.addEventListener('click', function () {
            mobileMenu.classList.toggle('active');

            const icon = this.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-times');
            }
        });

        mobileMenu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                mobileMenu.classList.remove('active');

                const icon = mobileMenuToggle.querySelector('i');
                if (icon) {
                    icon.classList.add('fa-bars');
                    icon.classList.remove('fa-times');
                }
            });
        });
    });
</script>
