@extends('layouts.app')

@section('title', 'Keranjang Belanja - Toko Online')

@section('content')
    <div class="cart-page">
        <div class="container">
            <div class="page-header">
                <h1 class="page-title">Keranjang Belanja</h1>
                <p class="page-subtitle">Produk yang ada di keranjang Anda</p>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: '{{ session('success') }}',
                        timer: 2000,
                        showConfirmButton: false
                    });
                </script>
            @endif

            @if(session('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: '{{ session('error') }}'
                    });
                </script>
            @endif

            @if($cartItems->count() > 0)
                <div class="cart-container">
                    <!-- Cart Items -->
                    <div class="cart-items">
                        <div class="cart-header">
                            <div class="cart-header-product">Produk</div>
                            <div class="cart-header-price">Harga</div>
                            <div class="cart-header-qty">Kuantitas</div>
                            <div class="cart-header-subtotal">Subtotal</div>
                            <div class="cart-header-actions">Aksi</div>
                        </div>

                        @foreach($cartItems as $item)
                            <div class="cart-item" id="cart-item-{{ $item->id }}">
                                <div class="cart-item-product">
                                    <img src="{{ asset('storage/' . $item->produk->gambar) }}" alt="{{ $item->produk->nama }}"
                                        class="cart-item-image">
                                    <div class="cart-item-info">
                                        <h4 class="cart-item-name">{{ $item->produk->nama }}</h4>
                                        @if($item->attributes)
                                            <div class="cart-item-attributes">
                                                @foreach($item->attributes as $key => $value)
                                                    <span class="attribute-badge">{{ $key }}: {{ $value }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="cart-item-price">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </div>

                                <div class="cart-item-qty">
                                    <div class="qty-control">
                                        <button type="button" class="qty-btn minus"
                                            onclick="updateQty({{ $item->id }}, -1)">-</button>
                                        <input type="number" class="qty-input" value="{{ $item->qty }}" min="1" max="99"
                                            id="qty-{{ $item->id }}" onchange="updateQtyDirect({{ $item->id }})">
                                        <button type="button" class="qty-btn plus"
                                            onclick="updateQty({{ $item->id }}, 1)">+</button>
                                    </div>
                                </div>

                                <div class="cart-item-subtotal" id="subtotal-{{ $item->id }}">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </div>

                                <div class="cart-item-actions">
                                    <form action="{{ route('user.account.cart.remove', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus produk dari keranjang?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-remove">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach

                        <!-- Cart Actions -->
                        <div class="cart-actions">
                            <a href="{{ route('produk.showall') }}" class="btn-continue">
                                <i class="fas fa-arrow-left"></i> Lanjut Belanja
                            </a>
                            <form action="{{ route('user.account.cart.clear') }}" method="POST"
                                onsubmit="return confirm('Kosongkan seluruh keranjang?')">
                                @csrf
                                <button type="submit" class="btn-clear">
                                    <i class="fas fa-trash-alt"></i> Kosongkan Keranjang
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Cart Summary -->
                    <div class="cart-summary">
                        <div class="summary-card">
                            <h3 class="summary-title">Ringkasan Belanja</h3>

                            <div class="summary-row">
                                <span>Total Item:</span>
                                <span id="total-items">{{ auth()->user()->cart_count }}</span>
                            </div>

                            <div class="summary-row">
                                <span>Total Harga:</span>
                                <span class="total-price" id="total-price">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="summary-divider"></div>

                            <div class="summary-total">
                                <span>Total Bayar:</span>
                                <span class="total-amount" id="total-amount">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="summary-notes">
                                <p><i class="fas fa-info-circle"></i> Belum termasuk ongkos kirim</p>
                            </div>

                            <a href="{{ route('user.account.checkout.index') }}" class="btn-checkout">
                                <i class="fab fa-whatsapp"></i> Lanjut ke Checkout
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-cart">
                    <div class="empty-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3>Keranjang Belanja Kosong</h3>
                    <p>Belum ada produk di keranjang belanja Anda</p>
                    <a href="{{ route('produk.showall') }}" class="btn-shop">
                        <i class="fas fa-store"></i> Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </div>

    <style>
        .cart-page {
            padding: 40px 0;
            min-height: 70vh;
        }

        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-title {
            font-size: 2.2rem;
            color: #333;
            margin-bottom: 10px;
        }

        .page-subtitle {
            color: #666;
            font-size: 1rem;
        }

        .cart-container {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
        }

        .cart-items {
            background: white;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
            padding: 25px;
        }

        .cart-header {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 0.5fr;
            gap: 15px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .cart-item {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 0.5fr;
            gap: 15px;
            padding: 20px 0;
            border-bottom: 1px solid #f0f0f0;
            align-items: center;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-product {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .cart-item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .cart-item-name {
            font-size: 1rem;
            color: #333;
            margin-bottom: 5px;
        }

        .cart-item-attributes {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 5px;
        }

        .attribute-badge {
            background: #f0f0f0;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            color: #666;
        }

        .cart-item-price {
            font-weight: 500;
            color: #333;
        }

        .qty-control {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .qty-btn {
            width: 30px;
            height: 30px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .qty-btn:hover {
            background: #f0f0f0;
        }

        .qty-input {
            width: 50px;
            height: 30px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
            font-size: 0.9rem;
        }

        .cart-item-subtotal {
            font-weight: 600;
            color: #4CAF50;
        }

        .btn-remove {
            background: #ffebee;
            color: #f44336;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .btn-remove:hover {
            background: #f44336;
            color: white;
        }

        .cart-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
        }

        .btn-continue {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 25px;
            background: #f0f0f0;
            color: #333;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-continue:hover {
            background: #e0e0e0;
            transform: translateY(-2px);
        }

        .btn-clear {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 25px;
            background: #ffebee;
            color: #f44336;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-clear:hover {
            background: #f44336;
            color: white;
            transform: translateY(-2px);
        }

        /* Cart Summary */
        .cart-summary {
            position: sticky;
            top: 100px;
            height: fit-content;
        }

        .summary-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
            padding: 25px;
        }

        .summary-title {
            font-size: 1.3rem;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            color: #666;
        }

        .total-price {
            font-weight: 600;
            color: #333;
        }

        .summary-divider {
            height: 1px;
            background: #f0f0f0;
            margin: 20px 0;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-size: 1.2rem;
            font-weight: 700;
            color: #333;
        }

        .total-amount {
            color: #4CAF50;
        }

        .summary-notes {
            margin-top: 15px;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 6px;
            font-size: 0.85rem;
            color: #666;
        }

        .summary-notes i {
            color: #4CAF50;
            margin-right: 5px;
        }

        .btn-checkout {
            display: block;
            width: 100%;
            padding: 15px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            text-align: center;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            margin-top: 20px;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn-checkout:hover {
            background: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
        }

        .payment-methods {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
        }

        .payment-methods p {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .payment-icons {
            display: flex;
            gap: 15px;
            font-size: 1.5rem;
            color: #666;
        }

        /* Empty Cart */
        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
        }

        .empty-icon {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 20px;
        }

        .empty-cart h3 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 10px;
        }

        .empty-cart p {
            color: #666;
            margin-bottom: 30px;
        }

        .btn-shop {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 30px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-shop:hover {
            background: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .cart-container {
                grid-template-columns: 1fr;
            }

            .cart-summary {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .cart-header {
                display: none;
            }

            .cart-item {
                grid-template-columns: 1fr;
                gap: 15px;
                padding: 20px;
                border: 1px solid #f0f0f0;
                border-radius: 8px;
                margin-bottom: 15px;
            }

            .cart-item-product {
                flex-direction: column;
                text-align: center;
            }

            .cart-actions {
                flex-direction: column;
                gap: 15px;
            }

            .btn-continue,
            .btn-clear {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
    <script>
        function updateQty(itemId, change) {
            const input = document.getElementById('qty-' + itemId);
            let newQty = parseInt(input.value) + change;

            if (newQty < 1) newQty = 1;
            if (newQty > 99) newQty = 99;

            input.value = newQty;
            updateCart(itemId, newQty);
        }

        function updateQtyDirect(itemId) {
            const input = document.getElementById('qty-' + itemId);
            let newQty = parseInt(input.value);

            if (newQty < 1) newQty = 1;
            if (newQty > 99) newQty = 99;

            input.value = newQty;
            updateCart(itemId, newQty);
        }

        function updateCart(itemId, qty) {
            const qtyControl = document.querySelector('#qty-' + itemId).closest('.qty-control');
            qtyControl.classList.add('loading');
            const url = '{{ route("user.account.cart.update", ":id") }}'.replace(':id', itemId);

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    qty: qty,
                    _method: 'PUT'
                })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response:', data);

                    if (data.success) {
                        const subtotalEl = document.getElementById('subtotal-' + itemId);
                        if (subtotalEl) {
                            subtotalEl.textContent = 'Rp ' + data.subtotal;
                            subtotalEl.classList.add('updated');
                            setTimeout(() => subtotalEl.classList.remove('updated'), 300);
                        }
                        const totalPriceEl = document.getElementById('total-price');
                        const totalAmountEl = document.getElementById('total-amount');

                        if (totalPriceEl) {
                            totalPriceEl.textContent = 'Rp ' + data.cart_total;
                            totalPriceEl.classList.add('updated');
                            setTimeout(() => totalPriceEl.classList.remove('updated'), 300);
                        }

                        if (totalAmountEl) {
                            totalAmountEl.textContent = 'Rp ' + data.cart_total;
                            totalAmountEl.classList.add('updated');
                            setTimeout(() => totalAmountEl.classList.remove('updated'), 300);
                        }
                        const totalItemsEl = document.getElementById('total-items');
                        if (totalItemsEl) {
                            totalItemsEl.textContent = data.cart_count;
                            totalItemsEl.classList.add('updated');
                            setTimeout(() => totalItemsEl.classList.remove('updated'), 300);
                        }
                        updateCartBadge(data.cart_count);
                        showNotification('Quantity berhasil diupdate', 'success');
                    } else {
                        showNotification(data.message || 'Gagal update quantity', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Terjadi kesalahan: ' + error.message, 'error');
                    const input = document.getElementById('qty-' + itemId);
                    const previousValue = parseInt(input.getAttribute('data-previous') || input.value);
                    input.value = previousValue;
                })
                .finally(() => {
                    qtyControl.classList.remove('loading');
                });
        }

        function updateCartBadge(count) {
            let cartBadge = document.querySelector('.cart-badge');
            const cartLink = document.querySelector('.cart-link');

            if (count > 0) {
                if (!cartBadge && cartLink) {
                    // Create badge if doesn't exist
                    cartBadge = document.createElement('span');
                    cartBadge.className = 'cart-badge';
                    cartLink.appendChild(cartBadge);
                }
                if (cartBadge) {
                    cartBadge.textContent = count;
                    cartBadge.style.animation = 'pulse 0.5s';
                    setTimeout(() => cartBadge.style.animation = '', 500);
                }
            } else if (cartBadge) {
                cartBadge.remove();
            }
        }

        function showNotification(message, type = 'success') {
            // Buat notifikasi sederhana
            const notification = document.createElement('div');
            notification.className = `cart-notification ${type}`;
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                <span>${message}</span>
            `;

            document.body.appendChild(notification);
            setTimeout(() => notification.classList.add('show'), 10);

            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function () {
            // Simpan nilai awal quantity
            document.querySelectorAll('.qty-input').forEach(input => {
                input.setAttribute('data-previous', input.value);

                // Input change dengan debounce
                let debounceTimer;
                input.addEventListener('input', function () {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        const itemId = this.id.replace('qty-', '');
                        updateQtyDirect(itemId);
                    }, 800);
                });

                // Simpan nilai saat blur
                input.addEventListener('blur', function () {
                    this.setAttribute('data-previous', this.value);
                });
            });

            // Better touch handling untuk mobile
            if ('ontouchstart' in window) {
                document.querySelectorAll('.qty-btn').forEach(button => {
                    button.addEventListener('touchstart', function (e) {
                        e.preventDefault();
                        this.style.transform = 'scale(0.95)';
                        this.style.backgroundColor = '#4CAF50';
                        this.style.color = 'white';
                    });

                    button.addEventListener('touchend', function (e) {
                        e.preventDefault();
                        this.style.transform = '';
                        this.style.backgroundColor = '';
                        this.style.color = '';
                    });
                });
            }
        });
    </script>
@endsection