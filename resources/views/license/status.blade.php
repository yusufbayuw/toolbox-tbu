<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Lisensi</title>
    <style>
        body{margin:0;font-family:system-ui,sans-serif;background:#020617;color:#e2e8f0}
        .wrap{max-width:900px;margin:48px auto;padding:0 16px}
        .card{background:#111827;border:1px solid #334155;border-radius:18px;padding:24px}
        .title{font-size:32px;font-weight:800;margin:0 0 8px}
        .muted{color:#94a3b8;line-height:1.7}
        .grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-top:24px}
        .panel{background:#0b1220;border:1px solid #233047;border-radius:14px;padding:16px}
        code{word-break:break-all;color:#f8fafc}
        a{color:#93c5fd}
        @media(max-width:700px){.grid{grid-template-columns:1fr}}
    </style>
</head>

<body>
    <main class="wrap">
        <section class="card">
            <h1 class="title">Status Lisensi</h1>
            @if (session('status_message'))
                <p class="muted">{{ session('status_message') }}</p>
            @endif

            <div class="grid">
                <div class="panel">
                    <strong>System Signature</strong>
                    <p><code>{{ $status['system_signature'] }}</code></p>
                    <p class="muted">Status: {{ strtoupper($status['status']) }}</p>
                    <p class="muted">{{ $status['message'] }}</p>
                    <p class="muted">Source: {{ $status['license_source'] ?? 'belum ada' }}</p>
                </div>
                <div class="panel">
                    <strong>Payload Lisensi</strong>
                    @if ($status['license']['payload'])
                        <p class="muted">Issued: {{ $status['license']['payload']['issued_at'] ?? '-' }}</p>
                        <p class="muted">Expires: {{ $status['license']['payload']['expires'] ?? 'never' }}</p>
                    @else
                        <p class="muted">Belum ada payload lisensi yang valid.</p>
                    @endif
                </div>
                <div class="panel">
                    <strong>Integrity</strong>
                    <p class="muted">Status: {{ strtoupper($status['integrity']['status']) }}</p>
                    <p class="muted">{{ $status['integrity']['message'] }}</p>
                    <p class="muted">Manifest: {{ $status['integrity']['manifest_path'] ?? '-' }}</p>
                </div>
                <div class="panel">
                    <strong>Activation</strong>
                    <p class="muted">LICENSE_KEY env override:
                        {{ $status['env_override_active'] ? 'active' : 'inactive' }}</p>
                    <p><a href="{{ route('license.show') }}">Kembali ke aktivasi lisensi</a></p>
                </div>
            </div>
        </section>
    </main>
</body>

</html>
