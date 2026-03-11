<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Sertifikat</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            color-scheme: light dark;
            --bg: #f3efe7;
            --bg-accent: rgba(176, 138, 74, 0.16);
            --surface: rgba(255, 250, 241, 0.86);
            --surface-strong: rgba(255, 255, 255, 0.94);
            --text: #1f2937;
            --muted: #5b6472;
            --line: rgba(123, 92, 37, 0.18);
            --primary: #8a5a17;
            --primary-strong: #6f4510;
            --shadow: 0 24px 70px rgba(82, 55, 21, 0.16);
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --bg: #11161d;
                --bg-accent: rgba(240, 181, 72, 0.12);
                --surface: rgba(18, 24, 31, 0.82);
                --surface-strong: rgba(25, 32, 42, 0.94);
                --text: #f3f4f6;
                --muted: #b6bec8;
                --line: rgba(240, 181, 72, 0.18);
                --primary: #f0b548;
                --primary-strong: #ffd180;
                --shadow: 0 28px 80px rgba(0, 0, 0, 0.36);
            }
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            min-height: 100%;
        }

        body {
            font-family: 'Manrope', sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, var(--bg-accent), transparent 32%),
                radial-gradient(circle at bottom right, rgba(28, 113, 216, 0.12), transparent 24%),
                linear-gradient(rgba(7, 10, 16, 0.34), rgba(7, 10, 16, 0.54)),
                url('{{ $data['background_image'] }}') center / cover no-repeat fixed;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            pointer-events: none;
        }

        .page {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px;
        }

        .page-inner {
            width: min(1120px, 100%);
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .shell {
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            gap: 24px;
            align-items: stretch;
        }

        .panel {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 28px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .hero {
            position: relative;
            padding: 32px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 100%;
        }

        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.12), transparent 55%);
            pointer-events: none;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            width: fit-content;
            border-radius: 999px;
            background: var(--surface-strong);
            border: 1px solid var(--line);
            color: var(--primary);
            font-size: 0.8rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .eyebrow::before {
            content: '';
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            box-shadow: 0 0 0 6px rgba(34, 197, 94, 0.16);
        }

        .hero h1 {
            margin: 20px 0 14px;
            font-size: clamp(2rem, 5vw, 4.2rem);
            line-height: 0.95;
            letter-spacing: -0.05em;
        }

        .hero p {
            margin: 0;
            max-width: 40rem;
            color: var(--muted);
            font-size: 1.02rem;
            line-height: 1.7;
        }

        .meta-grid {
            margin-top: 28px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .meta-card {
            padding: 16px 18px;
            border-radius: 20px;
            background: var(--surface-strong);
            border: 1px solid var(--line);
        }

        .meta-card span {
            display: block;
            color: var(--muted);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .meta-card strong {
            display: block;
            font-size: 1rem;
            line-height: 1.5;
        }

        .actions {
            margin-top: 32px;
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 52px;
            padding: 0 20px;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 800;
            letter-spacing: -0.02em;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .button:hover {
            transform: translateY(-1px);
        }

        .button-primary {
            color: #fffaf2;
            background: linear-gradient(135deg, var(--primary), var(--primary-strong));
            box-shadow: 0 14px 30px rgba(138, 90, 23, 0.28);
        }

        .button-secondary {
            color: var(--text);
            background: var(--surface-strong);
            border: 1px solid var(--line);
        }

        .details {
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .details-header {
            padding: 8px 8px 14px;
        }

        .details-header h2 {
            margin: 0;
            font-size: 1.4rem;
            letter-spacing: -0.04em;
        }

        .details-header p {
            margin: 10px 0 0;
            color: var(--muted);
            line-height: 1.6;
        }

        .row {
            display: grid;
            grid-template-columns: 180px minmax(0, 1fr);
            gap: 16px;
            align-items: start;
            padding: 16px 18px;
            border-radius: 20px;
            background: var(--surface-strong);
            border: 1px solid var(--line);
        }

        .label {
            color: var(--muted);
            font-size: 0.88rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .value {
            font-size: 1rem;
            line-height: 1.7;
            word-break: break-word;
        }

        .footer-note {
            padding: 4px 8px 0;
            color: var(--muted);
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .site-footer {
            text-align: center;
            color: var(--muted);
            font-size: 0.92rem;
            line-height: 1.7;
            padding: 4px 12px 16px;
        }

        .site-footer a {
            color: var(--primary);
            font-weight: 800;
            text-decoration: none;
        }

        .site-footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 980px) {
            .shell {
                grid-template-columns: 1fr;
            }

            .hero {
                min-height: auto;
            }
        }

        @media (max-width: 640px) {
            .page {
                padding: 14px;
            }

            .hero,
            .details {
                padding: 18px;
            }

            .meta-grid {
                grid-template-columns: 1fr;
            }

            .row {
                grid-template-columns: 1fr;
                gap: 8px;
                padding: 14px;
            }

            .actions {
                flex-direction: column;
            }

            .button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <main class="page">
        <div class="page-inner">
            <section class="shell">
                <article class="panel hero">
                    <div>
                        <span class="eyebrow">Sertifikat Terverifikasi</span>
                        <h1>{{ $data['nama_penerima'] }}</h1>
                        <p>
                            Sertifikat ini terdaftar atas nama <strong>{{ $data['nama_penerima'] }}</strong> dari
                            <strong>{{ $data['asal_penerima'] }}</strong> untuk dokumen
                            <strong>{{ $data['jenis_sertifikat'] }}</strong>.
                        </p>

                        <div class="meta-grid">
                            <div class="meta-card">
                                <span>Nomor</span>
                                <strong>{{ $data['nomor_sertifikat'] }}</strong>
                            </div>
                            <div class="meta-card">
                                <span>Diterbitkan</span>
                                <strong>{{ $data['lokasi'] }}, {{ $data['tanggal_penerbitan'] }}</strong>
                            </div>
                            <div class="meta-card">
                                <span>Penandatangan</span>
                                <strong>{{ $data['nama_penandatangan'] }}</strong>
                            </div>
                            <div class="meta-card">
                                <span>Jabatan</span>
                                <strong>{{ $data['jabatan_penandatangan'] }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="actions">
                        <a href="{{ $data['download_link'] }}" class="button button-primary">Download Sertifikat</a>
                        <a href="{{ $data['download_link'] }}" target="_blank" rel="noopener noreferrer"
                            class="button button-secondary">Buka Dokumen</a>
                    </div>
                </article>

                <article class="panel details">
                    <header class="details-header">
                        <h2>Rincian Validasi</h2>
                        <p>Informasi di bawah ini digunakan untuk memastikan dokumen sesuai dengan data sertifikat yang
                            tersimpan pada sistem.</p>
                    </header>

                    <div class="row">
                        <div class="label">Jenis Sertifikat</div>
                        <div class="value">{{ $data['jenis_sertifikat'] }}</div>
                    </div>
                    <div class="row">
                        <div class="label">Nomor Sertifikat</div>
                        <div class="value">{{ $data['nomor_sertifikat'] }}</div>
                    </div>
                    <div class="row">
                        <div class="label">Nama Penerima</div>
                        <div class="value">{{ $data['nama_penerima'] }}</div>
                    </div>
                    <div class="row">
                        <div class="label">Asal Penerima</div>
                        <div class="value">{{ $data['asal_penerima'] }}</div>
                    </div>
                    <div class="row">
                        <div class="label">Deskripsi</div>
                        <div class="value">{{ $data['deskripsi_sertifikat'] }}</div>
                    </div>
                    <div class="row">
                        <div class="label">Lokasi</div>
                        <div class="value">{{ $data['lokasi'] }}</div>
                    </div>
                    <div class="row">
                        <div class="label">Tanggal Penerbitan</div>
                        <div class="value">{{ $data['tanggal_penerbitan'] }}</div>
                    </div>
                    <div class="row">
                        <div class="label">Nama Penandatangan</div>
                        <div class="value">{{ $data['nama_penandatangan'] }}</div>
                    </div>
                    <div class="row">
                        <div class="label">Jabatan Penandatangan</div>
                        <div class="value">{{ $data['jabatan_penandatangan'] }}</div>
                    </div>

                    <p class="footer-note">Pastikan nomor sertifikat, nama penerima, dan tanggal penerbitan sesuai
                        dengan dokumen yang Anda terima.</p>
                </article>
            </section>

            <footer class="site-footer">
                &copy; {{ now()->year }} {{ config('app.name') }}&trade;. All Rights Reserved. Made with ❤️ by
                <a href="https://yubawi.com" target="_blank" rel="noopener noreferrer">yubawi</a>
            </footer>
        </div>
    </main>
</body>

</html>
