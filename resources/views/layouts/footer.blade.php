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

<a href="https://wa.me/6281318409870?text=Halo%20Admin%20KMS%20Dukuhwaluh%2C%0A%0ASaya%20(Nama)%20mengunjungi%20website%20KMS%20dan%20ingin%20bertanya%20seputar%20produk%20olahan%20lokal%20Anda.%0A%0APertanyaan%20saya%3A%5BSilakan%20tulis%20pertanyaan%20Anda%20di%20sini%5D%0A%0ATerima%20kasih!" class="floating-wa-button" target="_blank" rel="noopener noreferrer">
    <span class="wa-icon"><i class="fab fa-whatsapp"></i></span>
</a>

<style>
.floating-wa-button {
    position: fixed;
    right: 20px;
    bottom: 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #25D366;
    color: white;
    padding: 14px;
    width: 64px;
    height: 64px;
    border-radius: 50%;
    box-shadow: 0 16px 36px rgba(0,0,0,0.22);
    text-decoration: none;
    z-index: 9999;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.floating-wa-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.24);
}
.floating-wa-button .wa-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #075E54;
}
.floating-wa-button .wa-icon i {
    font-size: 20px;
}
@media (max-width: 768px) {
    .floating-wa-button {
        right: 14px;
        bottom: 14px;
        padding: 12px;
        width: 56px;
        height: 56px;
    }
    .floating-wa-button .wa-icon {
        width: 34px;
        height: 34px;
    }
}
</style>
