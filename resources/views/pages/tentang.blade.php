@extends('layouts.app')

@section('title', 'Tentang Kami - ' . config('app.name'))

@section('content')
    <style>
        :root {
            --about-green-900: #1f5a33;
            --about-green-800: #2f7a47;
            --about-green-700: #3d9856;
            --about-green-100: #eef8f0;
            --about-green-050: #f7fcf8;
            --about-text: #1f2d1f;
            --about-text-soft: #4f6651;
            --about-border: #d7eadb;
            --about-shadow: 0 12px 32px rgba(31, 90, 51, 0.12);
        }

        .about-page {
            background: linear-gradient(180deg, #fbfefb 0%, #f3f9f4 100%);
            color: var(--about-text);
        }

        .about-hero {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, rgba(31, 90, 51, 0.96) 0%, rgba(61, 152, 86, 0.92) 100%);
            color: #fff;
            padding: 92px 0 88px;
        }

        .about-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at top left, rgba(255, 255, 255, 0.16), transparent 32%),
                radial-gradient(circle at bottom right, rgba(255, 255, 255, 0.14), transparent 30%);
        }

        .about-hero::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: -1px;
            height: 120px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 200'%3E%3Cpath fill='%23f7fcf8' d='M0,128L80,144C160,160,320,192,480,181.3C640,171,800,117,960,106.7C1120,96,1280,128,1360,144L1440,160L1440,201L1360,201C1280,201,1120,201,960,201C800,201,640,201,480,201C320,201,160,201,80,201L0,201Z'/%3E%3C/svg%3E") bottom center / cover no-repeat;
        }

        .about-hero-content {
            position: relative;
            z-index: 1;
            max-width: 860px;
            margin: 0 auto;
            text-align: center;
        }

        .about-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
            padding: 8px 16px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .about-hero h1 {
            margin-bottom: 18px;
            font-size: 3.2rem;
            font-weight: 700;
            color: #fff;
        }

        .about-hero p {
            margin: 0 auto;
            max-width: 760px;
            font-size: 1.18rem;
            line-height: 1.9;
            color: rgba(255, 255, 255, 0.92);
        }

        .about-section {
            padding: 72px 0;
        }

        .about-card {
            background: #fff;
            border: 1px solid rgba(61, 152, 86, 0.14);
            border-radius: 26px;
            box-shadow: var(--about-shadow);
            padding: 38px 42px;
        }

        .section-heading {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 22px;
        }

        .section-marker {
            width: 6px;
            height: 36px;
            border-radius: 999px;
            background: linear-gradient(180deg, var(--about-green-700), var(--about-green-900));
        }

        .section-heading h2 {
            margin: 0;
            font-size: 2.35rem;
            color: var(--about-green-900);
        }

        .profile-copy p {
            margin-bottom: 24px;
            font-size: 1.1rem;
            line-height: 1.95;
            color: var(--about-text);
        }

        .vision-mission-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(0, 1.2fr);
            gap: 28px;
            align-items: stretch;
        }

        .vision-panel,
        .mission-panel {
            height: 100%;
        }

        .vision-panel {
            background: linear-gradient(180deg, #f3fbf4 0%, #e7f7ea 100%);
            border: 1px solid var(--about-border);
            border-radius: 24px;
            padding: 34px 32px;
        }

        .vision-title,
        .mission-title {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 22px;
        }

        .vision-icon,
        .mission-icon {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .vision-icon {
            background: rgba(61, 152, 86, 0.14);
            color: var(--about-green-900);
        }

        .mission-icon {
            background: rgba(47, 122, 71, 0.1);
            color: var(--about-green-800);
        }

        .vision-title h3,
        .mission-title h3 {
            margin: 0;
            font-size: 2rem;
            color: var(--about-green-900);
        }

        .vision-quote {
            margin: 0;
            font-size: 1.05rem;
            line-height: 1.9;
            color: #27452e;
            font-style: italic;
            font-weight: 600;
        }

        .mission-panel {
            padding: 10px 6px;
        }

        .mission-list {
            margin: 0;
            padding: 0;
            list-style: none;
            display: grid;
            gap: 18px;
        }

        .mission-list li {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            font-size: 1.06rem;
            line-height: 1.75;
            color: var(--about-text);
        }

        .mission-list li i {
            color: var(--about-green-700);
            margin-top: 5px;
            font-size: 1rem;
        }

        .closing-box {
            margin-top: 34px;
            padding: 26px 28px;
            border-radius: 22px;
            background: linear-gradient(135deg, rgba(61, 152, 86, 0.1), rgba(31, 90, 51, 0.12));
            border: 1px solid rgba(61, 152, 86, 0.16);
        }

        .closing-box p {
            margin: 0;
            font-size: 1.02rem;
            line-height: 1.85;
            color: var(--about-text-soft);
        }

        @media (max-width: 991px) {
            .about-hero h1 {
                font-size: 2.6rem;
            }

            .section-heading h2 {
                font-size: 2rem;
            }

            .vision-mission-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .about-hero {
                padding: 80px 0 78px;
            }

            .about-hero h1 {
                font-size: 2.15rem;
            }

            .about-hero p {
                font-size: 1rem;
                line-height: 1.8;
            }

            .about-section {
                padding: 56px 0;
            }

            .about-card {
                padding: 28px 22px;
                border-radius: 22px;
            }

            .section-heading h2 {
                font-size: 1.72rem;
            }

            .vision-title h3,
            .mission-title h3 {
                font-size: 1.6rem;
            }
        }
    </style>

    <div class="about-page">
        <section class="about-hero">
            <div class="container">
                <div class="about-hero-content">
                    <div class="about-badge">
                        <i class="fas fa-leaf"></i>
                        <span>Karya Mandiri Sejahtera</span>
                    </div>
                    <h1>Tentang Kami</h1>
                    <p>
                        KMS hadir sebagai wadah pemberdayaan ekonomi masyarakat Desa Dukuhwaluh
                        yang tumbuh dari semangat gotong royong, kemandirian usaha, dan pengembangan
                        potensi lokal secara berkelanjutan.
                    </p>
                </div>
            </div>
        </section>

        <section class="about-section">
            <div class="container">
                <div class="about-card">
                    <div class="section-heading">
                        <span class="section-marker"></span>
                        <h2>Profil Singkat</h2>
                    </div>

                    <div class="profile-copy">
                        <p>
                            Kelompok Usaha Bersama (KUB) Karya Mandiri Sejahtera (KMS) adalah wadah
                            pemberdayaan ekonomi masyarakat yang berpusat di Desa Dukuhwaluh, Kecamatan
                            Kembaran, Kabupaten Banyumas, berdiri sejak 2023 berdasarkan SK Kepala Desa
                            Dukuhwaluh No. 14 Thun 2023.
                        </p>
                        <p>
                            Didirikan oleh masyarakat Desa Dukuhwaluh yang memiliki semangat gotong royong
                            dan visi kemandirian ekonomi, KMS bergerak di sektor pertanian, peternakan,
                            perikanan, dan pengolahan hasil pertanian, dengan komoditas unggulan labu
                            kuning (waluh) sebagai ikon desa. KMS juga mengembangkan pendekatan integrated
                            farming yang berkelanjutan untuk meningkatkan produktivitas dan kesejahteraan
                            anggotanya.
                        </p>
                    </div>

                    <div class="vision-mission-grid">
                        <div class="vision-panel">
                            <div class="vision-title">
                                <span class="vision-icon">
                                    <i class="fas fa-eye"></i>
                                </span>
                                <h3>Visi Kami</h3>
                            </div>
                            <p class="vision-quote">
                                "Mewujudkan masyarakat Desa Dukuhwaluh yang mandiri, sejahtera, dan
                                berdaya saing melalui pengembangan usaha berbasis potensi lokal."
                            </p>
                        </div>

                        <div class="mission-panel">
                            <div class="mission-title">
                                <span class="mission-icon">
                                    <i class="fas fa-rocket"></i>
                                </span>
                                <h3>Misi Kami</h3>
                            </div>
                            <ul class="mission-list">
                                <li>
                                    <i class="fas fa-check"></i>
                                    <span>Mendorong kemandirian ekonomi anggota melalui unit usaha kolektif.</span>
                                </li>
                                <li>
                                    <i class="fas fa-check"></i>
                                    <span>Mengelola sumber daya alam desa secara produktif dan berkelanjutan.</span>
                                </li>
                                <li>
                                    <i class="fas fa-check"></i>
                                    <span>Mengembangkan produk unggulan desa, khususnya labu kuning dan hasil olahannya.</span>
                                </li>
                                <li>
                                    <i class="fas fa-check"></i>
                                    <span>Menjadi pusat edukasi pertanian terpadu (integrated farming) di tingkat desa.</span>
                                </li>
                                <li>
                                    <i class="fas fa-check"></i>
                                    <span>Menjalin kemitraan strategis dengan pemerintah dan swasta.</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="closing-box">
                        <p>
                            Dengan semangat kebersamaan dan penguatan ekonomi lokal, KMS berupaya menjadi
                            penggerak usaha desa yang tidak hanya menghasilkan produk unggulan, tetapi juga
                            membuka peluang tumbuh bagi masyarakat sekitar secara nyata dan berkelanjutan.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
