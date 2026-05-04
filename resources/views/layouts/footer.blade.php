<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-section footer-section-brand">
                <h3>Toko Online</h3>
                <p>
                    Karya Mandiri Sejahtera,<br>
                    Produk Olahan Lokal, Kualitas Maksimal!!.
                </p>
            </div>
            <div class="footer-section footer-section-category">
                <h3>Kategori</h3>
                <ul class="footer-links">
                    <li>
                        <a href="{{ route('produk.showall') }}">
                            Semua Produk
                        </a>
                    </li>
                    @foreach($footerCategories as $category)
                        <li>
                            <a href="{{ route('produk.kategori', $category->id) }}">
                                {{ $category->nama }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="footer-section footer-section-contact">
                <h3>Hubungi Kami</h3>
                <ul class="contact-info">
                    <li><i class="fas fa-map-marker-alt"></i> Desa Dukuhwaluh, Kecamatan Kembaran, Kabupaten Banyumas, Jawa Tengah</li>
                    <li><i class="fas fa-phone"></i> +62 813-1840-9870</li>
                    <li><i class="fas fa-envelope"></i> karyamandirisejahtera.dkw@gmail.com</li>
                    <li><i class="fas fa-clock"></i> Buka: 08:00 - 22:00 WIB</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p class="footer-copyright">&copy; {{ date('Y') }} Karya Mandiri Sejahtera. All rights reserved.</p>
        </div>
    </div>
</footer>

<a href="https://wa.me/6281318409870?text=Halo%20Bu%20Lina%2C%20saya%20ingin%20konfirmasi%20pesanan" class="floating-wa-button" target="_blank" rel="noopener noreferrer">
    <span class="wa-icon"><i class="fab fa-whatsapp"></i></span>
    <span class="wa-label">WA Konfirmasi</span>
</a>

<style>
.floating-wa-button {
    position: fixed;
    right: 20px;
    bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    background: #25D366;
    color: white;
    padding: 12px 16px;
    border-radius: 999px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.18);
    text-decoration: none;
    font-weight: 700;
    z-index: 9999;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.floating-wa-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 16px 34px rgba(0,0,0,0.22);
}
.floating-wa-button .wa-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: #075E54;
}
.floating-wa-button .wa-icon i {
    font-size: 18px;
}
@media (max-width: 768px) {
    .floating-wa-button {
        right: 14px;
        bottom: 14px;
        padding: 10px 14px;
    }
    .floating-wa-button .wa-label {
        display: none;
    }
}
</style>
