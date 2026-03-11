<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta property="og:title" content="{{ $linkx->name }}">
    <meta property="og:description" content="{{ $linkx->name }}">
    @if ($logo)
        <meta property="og:image" content="{{ $logo }}">
    @endif
    <meta property="og:url" content="{{ config('app.url') . '/' . $linkx->url_slug }}">
    <meta property="og:type" content="website">
    <meta property="og:image:width" content="630">
    <meta property="og:image:height" content="630">

    @if ($logo)
        <link rel="icon" type="image/x-icon" href="{{ $logo }}">
    @endif

    @vite('resources/css/app.css')
    <style>
        :root {
            --surface: {{ $palette['surface'] }};
            --accent: {{ $palette['accent'] }};
            --strong: {{ $palette['strong'] }};
            --strong-hover: {{ $palette['strong_hover'] }};
            --text-on-strong: #f8fafc;
            --text-muted: rgba(248, 250, 252, 0.78);
            --shell-shadow: 0 30px 80px rgba(15, 23, 42, 0.12);
            --card-shadow: 0 18px 34px rgba(15, 23, 42, 0.12);
            --panel: rgba(255, 255, 255, 0.86);
            --line: rgba(15, 23, 42, 0.08);
            --page-glow: rgba(255, 255, 255, 0.18);
        }

        body {
            min-height: 100vh;
            margin: 0;
            background:
                radial-gradient(circle at top center, var(--page-glow), transparent 38%),
                linear-gradient(180deg, var(--surface) 0%, var(--surface) 100%);
            color: var(--strong);
        }

        .page-shell {
            width: min(920px, calc(100% - 32px));
            margin: 28px auto 48px;
            border-radius: 36px;
            overflow: hidden;
            box-shadow: var(--shell-shadow);
            background: var(--panel);
            border: 1px solid var(--line);
        }

        .hero {
            position: relative;
            padding: 32px 28px 28px;
            background: linear-gradient(140deg, var(--strong), var(--strong-hover));
            text-align: center;
        }

        .hero::after {
            content: '';
            position: absolute;
            inset: auto 0 0;
            height: 86px;
            background: linear-gradient(180deg, transparent, rgba(0, 0, 0, 0.12));
            pointer-events: none;
        }

        .hero-inner {
            position: relative;
            z-index: 1;
        }

        .eyebrow {
            display: inline-block;
            margin-bottom: 14px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.10);
            color: var(--text-muted);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
        }

        .hero h1 {
            margin: 0;
            color: var(--text-on-strong);
            font-size: clamp(2.2rem, 4vw, 4rem);
            line-height: 1.05;
            font-weight: 800;
            letter-spacing: -0.04em;
        }

        .hero p {
            width: min(620px, 100%);
            margin: 14px auto 0;
            color: var(--text-muted);
            font-size: 1rem;
            line-height: 1.7;
        }

        .content {
            padding: 28px 22px 30px;
        }

        .identity {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: -56px;
            margin-bottom: 28px;
            position: relative;
            z-index: 2;
        }

        .identity-badge {
            width: 134px;
            height: 134px;
            display: grid;
            place-items: center;
            border-radius: 999px;
            background: #ffffff;
            border: 5px solid var(--accent);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.16);
            overflow: hidden;
        }

        .identity-badge img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .link-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            gap: 16px;
        }

        .link-item {
            margin: 0;
        }

        .link-card {
            display: block;
            padding: 22px 24px;
            border-radius: 22px;
            text-decoration: none;
            background: linear-gradient(180deg, var(--accent), var(--strong-hover));
            color: var(--text-on-strong);
            box-shadow: var(--card-shadow);
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .link-card:hover {
            transform: translateY(-2px);
            background: linear-gradient(180deg, var(--strong), var(--strong-hover));
            box-shadow: 0 22px 40px rgba(15, 23, 42, 0.18);
        }

        .link-card-title {
            margin: 0;
            font-size: clamp(1.25rem, 2vw, 1.9rem);
            line-height: 1.2;
            font-weight: 800;
            letter-spacing: -0.03em;
        }

        .link-card-desc {
            margin: 8px 0 0;
            font-size: 1rem;
            line-height: 1.65;
            color: var(--text-muted);
        }

        .footer {
            margin-top: 26px;
            padding: 6px 8px 8px;
            text-align: center;
        }

        .footer-inner {
            display: inline-block;
            color: var(--strong);
        }

        .footer-inner a {
            color: inherit;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 700;
        }

        .footer-inner a:hover {
            text-decoration: underline;
        }

        @media (max-width: 640px) {
            .page-shell {
                width: min(100%, calc(100% - 16px));
                margin: 10px auto 24px;
                border-radius: 24px;
            }

            .hero {
                padding: 24px 18px 70px;
            }

            .content {
                padding: 18px 14px 20px;
            }

            .identity {
                margin-top: -48px;
                margin-bottom: 18px;
            }

            .identity-badge {
                width: 108px;
                height: 108px;
                border-width: 4px;
            }

            .link-card {
                padding: 18px 16px;
                border-radius: 18px;
            }
        }
    </style>
    <title>{{ $linkx->name }}</title>
</head>

<body>
    <main class="page-shell">
        <section class="hero">
            <div class="hero-inner">
                <span class="eyebrow">Link Directory</span>
                <h1>{{ $linkx->name }}</h1>
                <p>Pilih tujuan yang ingin Anda buka. Semua tautan dikurasi dalam satu halaman agar lebih ringkas dan
                    mudah diakses.</p>
            </div>
        </section>

        <section class="content">
            @if ($linkx->logo)
                <div class="identity">
                    <div class="identity-badge">
                        <img src="{{ $logo }}" alt="Logo {{ $linkx->name }}">
                    </div>
                </div>
            @endif

            <ul class="link-list">
                @foreach ($linkx->links as $link)
                    <li class="link-item">
                        <a class="link-card" href="{{ $link['link_url'] }}" target="_blank" rel="noopener noreferrer">
                            <h2 class="link-card-title">{{ $link['link_name'] }}</h2>
                            @if (!empty($link['link_desc']))
                                <p class="link-card-desc">{{ $link['link_desc'] }}</p>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>

            <footer class="footer">
                <div class="footer-inner">
                    &copy; {{ now()->year }} {{ config('app.name') }}&trade;. All Rights Reserved. Made with ❤️ by
                    <a href="https://yubawi.com" target="_blank" rel="noopener noreferrer">yubawi</a>
                </div>
            </footer>
        </section>
    </main>
</body>

</html>
