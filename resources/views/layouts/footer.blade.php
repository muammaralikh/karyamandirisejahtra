<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-section">
                <h3>Toko Online</h3>
                <p>Karya Mandiri Sejahtera. Menyediakan produk berkualitas dengan harga terbaik.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Link Cepat</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('produk.index') }}">Semua Produk</a></li>
                    <li><a href="{{ route('about') }}">Tentang Kami</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Kategori</h3>
                <ul class="footer-links">
                    @foreach($categories as $category)
                    <li>
                        <a href="{{ route('kategori.index') }}?category={{ strtolower($category['name']) }}">
                            {{ $category['nama'] }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="footer-section">
                <h3>Hubungi Kami</h3>
                <ul class="contact-info">
                    <li><i class="fas fa-map-marker-alt"></i> Jl. </li>
                    <li><i class="fas fa-phone"></i> +62 813-1840-9870</li>
                    <li><i class="fas fa-envelope"></i> kms.dukuhwaluh@gmail.com</li>
                    <li><i class="fas fa-clock"></i> Buka: 08:00 - 22:00 WIB</li>
                </ul>
            </div>
        </div>
    </div>
</footer>