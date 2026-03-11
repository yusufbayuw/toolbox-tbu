<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivasi Lisensi</title>
    <style>
        body{margin:0;font-family:system-ui,sans-serif;background:#0f172a;color:#e2e8f0}
        .wrap{max-width:820px;margin:48px auto;padding:0 16px}
        .card{background:#111827;border:1px solid #334155;border-radius:18px;padding:24px;box-shadow:0 20px 50px rgba(0,0,0,.25)}
        .title{font-size:32px;font-weight:800;margin:0 0 8px}
        .muted{color:#94a3b8;line-height:1.7}
        .grid{display:grid;gap:16px;margin-top:22px}
        .meta{background:#0b1220;border:1px solid #233047;border-radius:14px;padding:16px}
        .meta code{word-break:break-all;color:#f8fafc}
        label{display:block;font-size:14px;font-weight:700;margin:18px 0 8px}
        textarea{width:100%;min-height:140px;border-radius:14px;border:1px solid #334155;background:#020617;color:#f8fafc;padding:14px;font:inherit}
        button{margin-top:14px;border:0;border-radius:999px;background:#4f46e5;color:#fff;padding:12px 20px;font-weight:800;cursor:pointer}
        .status{margin-top:20px;padding:14px 16px;border-radius:14px;background:#0b1220;border:1px solid #233047}
        .ok{border-color:#14532d;background:#052e16}
        .bad{border-color:#7f1d1d;background:#450a0a}
        .error{color:#fecaca;font-size:14px;margin-top:8px}
        a{color:#93c5fd}
    </style>
</head>

<body>
    <main class="wrap">
        <section class="card">
            <h1 class="title">Aktivasi Lisensi</h1>
            <p class="muted">Aplikasi ini membutuhkan lisensi valid yang terikat pada domain dan path instalasi. Kirim
                system signature berikut ke developer untuk dibuatkan license key.</p>

            <div class="grid">
                <div class="meta">
                    <div class="muted">System Signature</div>
                    <code>{{ $status['system_signature'] }}</code>
                </div>
                <div class="meta">
                    <div class="muted">Status Saat Ini</div>
                    <strong>{{ strtoupper($status['status']) }}</strong>
                    <div class="muted" style="margin-top:6px">{{ $status['message'] }}</div>
                    <div class="muted" style="margin-top:6px">Sumber lisensi:
                        {{ $status['license_source'] ?? 'belum ada' }}</div>
                    @if ($status['env_override_active'])
                        <div class="muted" style="margin-top:6px">LICENSE_KEY di .env sedang aktif sebagai override.
                        </div>
                    @endif
                </div>
            </div>

            <form method="POST" action="{{ route('license.activate') }}">
                @csrf
                <label for="license_key">License Key</label>
                <textarea id="license_key" name="license_key">{{ old('license_key') }}</textarea>
                @error('license_key')
                    <div class="error">{{ $message }}</div>
                @enderror
                <button type="submit">Aktivasi Lisensi</button>
            </form>

            <div class="status {{ $status['valid'] ? 'ok' : 'bad' }}">
                <strong>Integrity:</strong> {{ strtoupper($status['integrity']['status']) }}<br>
                <span class="muted">{{ $status['integrity']['message'] }}</span>
            </div>

            <p class="muted" style="margin-top:18px">Lihat detail status di <a
                    href="{{ route('license.status') }}">halaman status lisensi</a>.</p>
        </section>
    </main>
</body>

</html>
