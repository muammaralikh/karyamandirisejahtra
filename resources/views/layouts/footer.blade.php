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

<a href="https://wa.me/6281318409870?text=Halo%20Admin%20KMS%20Dukuhwaluh%2C%0ASaya%20(Nama)%20mengunjungi%20website%20KMS%20dan%20ingin%20bertanya%20seputar%20produk%20olahan%20lokal%20Anda.%0A%0APertanyaan%20saya%3A%5BSilakan%20tulis%20pertanyaan%20Anda%20di%20sini%5D%0A%0ATerima%20kasih!" class="floating-wa-button" target="_blank" rel="noopener noreferrer">
    <span class="wa-icon">
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <path fill="currentColor" d="M12.004 2.002c-5.532 0-10.002 4.474-10.002 10.004 0 1.766.462 3.497 1.337 5.02l-1.385 4.783 4.904-1.292a9.95 9.95 0 0 0 4.855 1.227h.009c5.532 0 10.002-4.474 10.002-10.003 0-5.53-4.47-10.01-10.01-10.01zm5.468 14.804c-.191.54-1.124 1.03-1.553 1.106-.398.072-.886.102-1.9-.175-3.742-1.1-6.179-4.189-6.371-4.39-.193-.201-1.574-1.605-1.574-3.07 0-1.465.78-2.192 1.059-2.492.276-.297.602-.364.802-.364.201 0 .401.001.576.001.188 0 .44-.072.688.556.247.627.839 2.164.914 2.329.073.166.12.362.024.58-.096.22-.144.356-.294.553-.149.196-.315.44-.451.594-.151.171-.312.36-.136.707.176.345.78 1.282 1.675 2.082 1.154 1.073 2.122 1.41 2.39 1.57.27.159.427.132.585-.079.158-.21.672-.776.857-1.043.181-.266.36-.223.599-.135.242.089 1.525.719 1.786.849.26.13.432.194.497.302.065.11.065.631-.126 1.17zm0 0"/>
        </svg>
    </span>
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
    width: 36px;
    height: 36px;
}
.floating-wa-button .wa-icon svg {
    width: 100%;
    height: 100%;
}
@media (max-width: 768px) {
    .floating-wa-button {
        right: 14px;
        bottom: 14px;
        width: 56px;
        height: 56px;
    }
    .floating-wa-button .wa-icon {
        width: 30px;
        height: 30px;
    }
}
</style>
