@extends('layouts.app')

@section('title', $title)
<style>
    .category-grid {
        display: grid !important;
        grid-template-columns: repeat(auto-fit, minmax(220px, 220px));
        justify-content: center;
        gap: 22px;
        width: 100%;
        margin: 0 auto;
    }

    .category-card {
        width: 220px;
        text-decoration: none;
        color: #1f2d1f;
        background: #fff;
        border-radius: 18px;
        overflow: hidden;
        text-align: center;
        box-shadow: 0 8px 24px rgba(21, 58, 32, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 14px 28px rgba(21, 58, 32, 0.14);
    }

    .category-image img {
        width: 100%;
        height: 140px;
        object-fit: cover;
    }

    .category-card h3 {
        padding: 16px 14px 18px;
        font-size: 1.32rem;
        font-weight: 700;
        line-height: 1.35;
    }

    @media (max-width: 768px) {
        .category-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            max-width: 520px;
            margin: 0 auto;
        }

        .category-card {
            width: 100%;
            border-radius: 16px;
        }

        .category-image img {
            height: 128px;
        }

        .category-card h3 {
            padding: 12px 10px 14px;
            font-size: 1rem;
        }

        .featured-products .product-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .featured-products .product-card {
            border-radius: 16px;
        }

        .featured-products .product-image {
            height: 128px;
        }

        .featured-products .product-info {
            padding: 14px 12px;
        }

        .featured-products .product-category,
        .featured-products .product-stock,
        .featured-products .product-desc {
            font-size: 0.82rem;
        }

        .featured-products .product-info h3 {
            font-size: 1rem;
            margin-bottom: 8px;
            line-height: 1.35;
        }

        .featured-products .product-price {
            font-size: 1.05rem;
            margin-bottom: 8px;
        }

        .featured-products .btn-cart {
            min-height: 40px;
            font-size: 0.82rem;
            padding: 9px 10px;
        }
    }

    @media (max-width: 480px) {
        .category-grid {
            max-width: 100%;
        }

        .featured-products .product-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .featured-products .product-image {
            height: 112px;
        }

        .featured-products .product-info {
            padding: 12px 10px;
        }

        .featured-products .product-category,
        .featured-products .product-stock,
        .featured-products .product-desc {
            font-size: 0.78rem;
        }

        .featured-products .product-info h3 {
            font-size: 0.94rem;
        }

        .featured-products .product-price {
            font-size: 1rem;
        }

        .featured-products .btn-cart {
            font-size: 0.76rem;
            gap: 4px;
        }
    }
</style>
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session('
    success ') }}',
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
    text: '{{ session('
    error ') }}'
});
</script>
@endif
<section class="hero">
    <div class="hero-content">
        <h1>Lele Premium, <br> Diolah Istimewa Untuk Keluarga Anda</h1>
        <a href="#produk" class="btn-primary">Lihat Semua Produk</a>
    </div>
</section>
<section class="categories">
    <div class="container">
        <h2>Kategori</h2>

        <div class="category-grid">
            @foreach($categories as $category)
            <a href="{{ route('produk.kategori', $category->id) }}" class="category-card">

                <div class="category-image">
                    <img src="{{ asset('storage/' . $category->gambar) }}" alt="{{ $category->nama }}">
                </div>

                <h3>{{ $category->nama }}</h3>

            </a>
            @endforeach
        </div>
    </div>
</section>

<section id="produk" class="featured-products">
    <div class="container">
        <div class="section-header">
            <h2>Produk</h2>
            <a href="{{ route('produk.showall') }}" class="view-all">Lihat Semua <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="product-grid">
            @foreach($featuredProducts as $product)
            <div class="product-card">
                <div class="product-image">
                    <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product['nama'] }}">
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
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mobileMenu = document.getElementById('mobileMenu');

    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('active');
            this.querySelector('i').classList.toggle('fa-bars');
            this.querySelector('i').classList.toggle('fa-times');
        });
    }

    setInterval(updateCountdown, 1000);
    updateCountdown();

    const cartForms = document.querySelectorAll('.product-form');
    cartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
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
