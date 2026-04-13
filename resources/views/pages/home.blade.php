@extends('layouts.app')

@section('title', $title)
<style>
.category-grid {
    display: flex !important;
    justify-content: center !important;
    /* Kunci agar ke tengah */
    gap: 20px;
    flex-wrap: wrap;
    width: 100%;
    /* Pastikan container full width */
}

.category-card {
    /* Berikan lebar pasti agar kartu tidak kekecilan/kebesaran */
    width: 200px;
    /* Sisa style Anda biarkan sama */
    text-decoration: none;
    color: #000;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease;
}

.category-card:hover {
    transform: translateY(-5px);
}

.category-image img {
    width: 100%;
    height: 120px;
    object-fit: cover;
}

.category-card h3 {
    padding: 10px;
    font-size: 16px;
    font-weight: 600;
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
                    <p class="product-desc">{{ $product['deskripsi'] }}</p>
                    <form action="{{ route('user.account.cart.add') }}" method="POST" class="product-form">
                        @csrf
                        <input type="hidden" name="produk_id" value="{{ $product->id }}">
                        <button type="submit" class="btn-cart">
                            <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                        </button>
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