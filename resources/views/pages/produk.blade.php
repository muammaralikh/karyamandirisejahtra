@extends('layouts.app')

@section('title', $title)

@section('content')
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
    <section id="produk" class="featured-products">
        <div class="container">
            <div class="section-header">
                <h2>Semua Produk</h2>
            </div>
            <div class="product-grid">
                @foreach($Allproducts as $product)
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ asset('storage/'. $product->gambar) }}" alt="{{ $product['nama'] }}">
                        </div>
                        <div class="product-info">
                            <span class="product-category">{{ $product->kategori->nama }}</span>
                            <h3>{{ $product['nama'] }}</h3>
                            <p class="product-price">Rp {{ number_format($product['harga'], 0, ',', '.') }}</p>
                            <p class="product-stock">
                                Stok:
                                <strong>{{ $product->stok ?? 0 }}</strong>
                                {{ ($product->stok ?? 0) > 0 ? 'tersedia' : 'habis' }}
                            </p>
                            <p class="product-desc">{{ $product['deskripsi'] }}</p>
                            <form action="{{ route('user.account.cart.add') }}" method="POST" class="product-form">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $product->id }}">
                                @if(($product->stok ?? 0) > 0)
                                    <button type="submit" class="btn-cart">
                                        <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                                    </button>
                                @else
                                    <button type="button" class="btn-cart" disabled>
                                        <i class="fas fa-box-open"></i> Stok Habis
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    


@endsection

@push('scripts')
    <script>
        
        document.addEventListener('DOMContentLoaded', function () {
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const mobileMenu = document.getElementById('mobileMenu');

            if (mobileMenuToggle && mobileMenu) {
                mobileMenuToggle.addEventListener('click', function () {
                    mobileMenu.classList.toggle('active');
                    this.querySelector('i').classList.toggle('fa-bars');
                    this.querySelector('i').classList.toggle('fa-times');
                });
            }

            setInterval(updateCountdown, 1000);
            updateCountdown();

            const cartForms = document.querySelectorAll('.product-form');
            cartForms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    const button = this.querySelector('.btn-cart');
                    const originalText = button.innerHTML;
                    button.innerHTML = '<i class="fas fa-check"></i> Ditambahkan!';
                    button.style.backgroundColor = '#4CAF50';

                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.style.backgroundColor = '';
                    }, 2000);
                });
            });
        });
    </script>
@endpush
