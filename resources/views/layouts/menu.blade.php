@php
    $currentRoute = Route::currentRouteName();

@endphp

<header class="site-header">
    <div class="container header-flex">

        <!-- Logo -->
        <div class="logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('logo/logo.kms.jpg.jpeg') }}" alt="Logo">
            </a>
        </div>
        <!-- Kanan -->
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

        <style>
            .header-right {
                display: flex;
                align-items: center;
                gap: 20px;
            }

            .icon-search {
                color: #555;
                font-size: 1.2rem;
                transition: color 0.3s;
                padding: 8px;
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
                padding: 8px 15px;
                border-radius: 20px;
                transition: all 0.3s;
                position: relative;
                background: #f8f9fa;
                gap: 8px;
            }

            .cart-link:hover {
                color: #4CAF50;
                background: rgba(76, 175, 80, 0.1);
                transform: translateY(-2px);
            }

            .cart-text {
                font-size: 0.9rem;
                font-weight: 500;
            }

            .cart-badge {
                position: absolute;
                top: -8px;
                right: -8px;
                background: #ff5722;
                color: white;
                font-size: 0.7rem;
                font-weight: bold;
                min-width: 18px;
                height: 18px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0 4px;
            }

            .akun-link {
                display: flex;
                align-items: center;
                gap: 8px;
                background: #4CAF50;
                color: white;
                padding: 8px 20px;
                border-radius: 20px;
                text-decoration: none;
                font-weight: 500;
                font-size: 0.9rem;
                transition: all 0.3s;
            }

            .akun-link:hover {
                background: #45a049;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
            }

            .akun-link i {
                font-size: 0.9rem;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .header-right {
                    gap: 15px;
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
            }
        </style>


    </div>
</header>


<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
    <ul>
        <li>
            <a href="{{ route('cart') }}">
                <i class="fas fa-shopping-cart"></i>
                Keranjang
                <span class="cart-badge">3</span>
            </a>
        </li>
    </ul>
</div>