<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Card</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            color-scheme: light dark;
            --bg: #f5f7fb;
            --surface: rgba(255, 255, 255, 0.9);
            --surface-strong: rgba(255, 255, 255, 0.96);
            --text: #0f172a;
            --muted: #64748b;
            --line: rgba(15, 23, 42, 0.1);
            --primary: #0f4c81;
            --primary-soft: rgba(15, 76, 129, 0.12);
            --shadow: 0 24px 60px rgba(15, 23, 42, 0.12);
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --bg: #09111b;
                --surface: rgba(12, 19, 31, 0.82);
                --surface-strong: rgba(17, 26, 39, 0.94);
                --text: #f8fafc;
                --muted: #cbd5e1;
                --line: rgba(148, 163, 184, 0.2);
                --primary: #76c7ff;
                --primary-soft: rgba(118, 199, 255, 0.12);
                --shadow: 0 28px 70px rgba(0, 0, 0, 0.34);
            }
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Manrope', sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, var(--primary-soft), transparent 26%),
                linear-gradient(rgba(9, 17, 27, 0.3), rgba(9, 17, 27, 0.55)),
                url('{{ $data['background_front'] ?? ($data['background_back'] ?? asset('images/certificate_template.png')) }}') center / cover no-repeat fixed;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            pointer-events: none;
        }

        .page {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .shell {
            width: min(1120px, 100%);
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            gap: 24px;
        }

        .panel {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 28px;
            box-shadow: var(--shadow);
        }

        .summary {
            padding: 32px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 999px;
            background: var(--surface-strong);
            border: 1px solid var(--line);
            color: var(--primary);
            font-size: 0.78rem;
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

        h1 {
            margin: 18px 0 12px;
            font-size: clamp(2rem, 5vw, 3.8rem);
            line-height: 0.95;
            letter-spacing: -0.05em;
        }

        .lede {
            margin: 0;
            font-size: 1.02rem;
            line-height: 1.75;
            color: var(--muted);
        }

        .meta-grid {
            margin-top: 24px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .meta-card,
        .detail-row {
            padding: 16px 18px;
            border-radius: 20px;
            background: var(--surface-strong);
            border: 1px solid var(--line);
        }

        .meta-card span,
        .detail-label {
            display: block;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--muted);
            font-weight: 700;
        }

        .meta-card strong,
        .detail-value {
            display: block;
            margin-top: 8px;
            font-size: 1rem;
            line-height: 1.5;
        }

        .actions {
            margin-top: 24px;
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
        }

        .button-primary {
            color: #fff;
            background: linear-gradient(135deg, #0f4c81, #0b2f50);
            box-shadow: 0 16px 30px rgba(15, 76, 129, 0.26);
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

        .details h2 {
            margin: 4px 4px 8px;
            font-size: 1.35rem;
            letter-spacing: -0.04em;
        }

        .preview-card {
            overflow: hidden;
            border-radius: 24px;
            background: #0f172a;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .preview-front {
            position: relative;
            min-height: 320px;
            padding: 24px;
            background:
                linear-gradient(155deg, rgba(248, 250, 252, 0.94), rgba(241, 245, 249, 0.74)),
                url('{{ $data['background_front'] ?? ($data['background_back'] ?? asset('images/certificate_template.png')) }}') center / cover no-repeat;
        }

        .preview-brand {
            font-size: 0.76rem;
            font-weight: 800;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #475569;
        }

        .preview-title {
            margin-top: 12px;
            font-size: 2rem;
            font-weight: 800;
            line-height: 1;
            color: #0f172a;
        }

        .preview-issuer {
            margin-top: 8px;
            color: #475569;
        }

        .preview-main {
            margin-top: 24px;
            display: grid;
            grid-template-columns: 110px minmax(0, 1fr);
            gap: 18px;
            align-items: start;
        }

        .preview-photo {
            height: 138px;
            border-radius: 20px;
            overflow: hidden;
            background: rgba(148, 163, 184, 0.26);
            border: 1px solid rgba(15, 23, 42, 0.08);
        }

        .preview-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-photo-placeholder {
            height: 100%;
            display: grid;
            place-items: center;
            color: #64748b;
            font-weight: 700;
        }

        .preview-label {
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 0.78rem;
            font-weight: 800;
        }

        .preview-name {
            margin-top: 8px;
            font-size: 2rem;
            line-height: 1;
            font-weight: 800;
            color: #0f172a;
        }

        .preview-role {
            margin-top: 10px;
            font-size: 1rem;
            font-weight: 700;
            color: #1e293b;
        }

        .preview-org {
            margin-top: 8px;
            color: #475569;
        }

        .preview-meta {
            margin-top: 18px;
            display: grid;
            gap: 10px;
        }

        .footer {
            text-align: center;
            color: var(--muted);
            font-size: 0.92rem;
        }

        .footer a {
            color: inherit;
            font-weight: 800;
        }

        @media (max-width: 960px) {
            .shell {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .page {
                padding: 16px;
            }

            .summary,
            .details {
                padding: 20px;
            }

            .meta-grid {
                grid-template-columns: 1fr;
            }

            .preview-main {
                grid-template-columns: 1fr;
            }

            .preview-photo {
                max-width: 170px;
            }
        }
    </style>
</head>

<body>
    <main class="page">
        <div style="width:min(1120px,100%);display:flex;flex-direction:column;gap:18px;">
            <section class="shell">
                <article class="panel summary">
                    <div class="eyebrow">Verified Identity Card</div>
                    <h1>{{ $data['nama_pemegang'] }}</h1>
                    <p class="lede">
                        Card ini terverifikasi dan diterbitkan oleh {{ $data['instansi_penerbit'] }}. Gunakan halaman ini
                        untuk mencocokkan identitas, masa berlaku, dan tautan dokumen resmi.
                    </p>

                    <div class="meta-grid">
                        <div class="meta-card">
                            <span>Nomor Identitas</span>
                            <strong>{{ $data['nomor_identitas'] }}</strong>
                        </div>
                        <div class="meta-card">
                            <span>Jabatan</span>
                            <strong>{{ $data['jabatan'] }}</strong>
                        </div>
                        <div class="meta-card">
                            <span>Instansi</span>
                            <strong>{{ $data['instansi'] }}</strong>
                        </div>
                        <div class="meta-card">
                            <span>{{ $data['masa_berlaku_label'] ?? 'Masa Berlaku' }}</span>
                            <strong>{{ $data['masa_berlaku'] }}</strong>
                        </div>
                    </div>

                    <div class="actions">
                        <a class="button button-primary" href="{{ $data['download_link'] }}" target="_blank"
                            rel="noopener noreferrer">Lihat Card</a>
                        <a class="button button-secondary" href="{{ $data['qr_code_path'] }}" target="_blank"
                            rel="noopener noreferrer">Tautan Validasi</a>
                    </div>
                </article>

                <aside class="panel details">
                    <div>
                        <h2>Ringkasan Data Card</h2>
                    </div>

                    <div class="preview-card">
                        <div class="preview-front">
                            <div class="preview-brand">Identity Card</div>
                            <div class="preview-title">{{ $data['nama_kartu'] }}</div>
                            <div class="preview-issuer">{{ $data['instansi_penerbit'] }}</div>

                            <div class="preview-main">
                                <div class="preview-photo">
                                    @if (!empty($data['foto']))
                                        <img src="{{ $data['foto'] }}" alt="Foto pemegang">
                                    @else
                                        <div class="preview-photo-placeholder">Foto</div>
                                    @endif
                                </div>
                                <div>
                                    <div class="preview-label">Pemegang kartu</div>
                                    <div class="preview-name">{{ $data['nama_pemegang'] }}</div>
                                    <div class="preview-role">{{ $data['jabatan'] }}</div>
                                    <div class="preview-org">{{ $data['instansi'] }}</div>

                                    <div class="preview-meta">
                                        <div class="detail-row">
                                            <span class="detail-label">Nama Kartu</span>
                                            <span class="detail-value">{{ $data['nama_kartu'] }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Penandatangan</span>
                                            <span class="detail-value">{{ $data['nama_penandatangan'] }} ·
                                                {{ $data['jabatan_penandatangan'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </section>

            <footer class="footer">
                © {{ now()->year }} {{ config('app.name') }}™. All Rights Reserved. Made with ❤️ by
                <a href="https://yubawi.com" target="_blank" rel="noopener noreferrer">yubawi</a>
            </footer>
        </div>
    </main>
</body>

</html>
