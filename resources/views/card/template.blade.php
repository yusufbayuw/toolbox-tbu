<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $nama_kartu ?? 'Card' }} - {{ $nama_pemegang ?? '' }}</title>
    <style>
        @page {
            margin: 0;
            size: 498pt 153pt;
        }
    </style>
</head>

<body style="margin: 0; font-family: DejaVu Sans, sans-serif; color: #0f172a;">
    <div style="position: relative; width: 498pt; height: 153pt; overflow: hidden;">
        <div
            style="position: absolute; top: 0; left: 0; width: 243pt; height: 153pt; overflow: hidden; border-radius: 12pt;">
            @if (!empty($background_front))
                <img style="position: absolute; inset: 0; width: 243pt; height: 153pt;" src="{{ $background_front }}"
                    alt="">
            @endif
            <div style="position: absolute; inset: 0;"></div>
            <div style="position: absolute; inset: 0; padding: 14pt;">
                <div style="position: absolute; left: 14pt; right: 14pt; top: 14pt;">
                    <div
                        style="font-size: 7pt; font-weight: bold; letter-spacing: 1.6pt; text-transform: uppercase; color: #64748b;">
                    </div>
                    <div
                        style="margin-top: 0pt; font-family: DejaVu Serif, serif; font-size: 13pt; font-weight: bold; line-height: 1.02; color: #0f172a;">
                        {{ $nama_kartu ?? 'Kartu Identitas' }}</div>
                    <div style="margin-top: 1pt; font-size: 7pt; color: #475569;">{{ $instansi_penerbit ?? ' ' }}
                    </div>
                </div>

                <div style="position: absolute; left: 14pt; right: 14pt; top: 58pt; bottom: 14pt;">
                    <div
                        style="position: absolute; left: 0; top: 0; width: 56pt; height: 72pt; overflow: hidden; border-radius: 8pt; background: rgba(148, 163, 184, 0.2); border: 1pt solid rgba(15, 23, 42, 0.08); text-align: center;">
                        @if (!empty($foto))
                            <img style="width: 56pt; height: 72pt; object-fit: cover;" src="{{ $foto }}"
                                alt="Foto">
                        @else
                            <div style="padding-top: 28pt; font-size: 8pt; color: #64748b;">Foto</div>
                        @endif
                    </div>

                    <div style="position: absolute; left: 68pt; right: 0; top: 0; bottom: 0;">
                        <div
                            style="font-size: 6.4pt; font-weight: bold; letter-spacing: 1.2pt; text-transform: uppercase; color: #64748b;"></div>
                        <div
                            style="margin-top: 2pt; font-family: DejaVu Serif, serif; font-size: {{ max(6, 9.4 - max(0, strlen($nama_pemegang) - 10) * 0.08) }}pt; font-weight: bold; line-height: 1.1; color: #0f172a; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                            {{ $nama_pemegang ?? ' ' }}</div>
                        <div
                            style="margin-top: 1pt; font-size: {{ max(7, 8.5 - max(0, strlen($jabatan) - 10) * 0.1) }}pt; font-weight: bold; color: #1e293b; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                            {{ $jabatan ?? ' ' }}</div>
                        <div
                            style="margin-top: 1pt; font-size: {{ max(5, 7.1 - max(0, strlen($instansi) - 10) * 0.12) }}pt; color: #475569; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                            {{ $instansi ?? ' ' }}</div>

                        <div style="text-align: right;">
                            <div
                                style="margin-top: 0pt; font-size: 6pt; font-weight: bold; letter-spacing: 1pt; text-transform: uppercase; color: #64748b;">
                                NOMOR IDENTITAS</div>
                            <div style="margin-top: 0pt; font-size: 7.4pt; color: #0f172a;">
                                {{ $nomor_identitas ?? ' ' }}</div>
                            <div
                                style="margin-top: 1pt; font-size: 6pt; font-weight: bold; letter-spacing: 1pt; text-transform: uppercase; color: #64748b;">
                                {{ $masa_berlaku_label ?? 'Masa Berlaku' }}</div>
                            <div style="margin-top: 0pt; font-size: 6.8pt; color: #0f172a;">{{ $masa_berlaku ?? ' ' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            style="position: absolute; top: 0; right: 0; width: 243pt; height: 153pt; overflow: hidden; border-radius: 12pt;">
            @if (!empty($background_back))
                <img style="position: absolute; inset: 0; width: 243pt; height: 153pt;" src="{{ $background_back }}"
                    alt="">
            @elseif (!empty($background_front))
                <img style="position: absolute; inset: 0; width: 243pt; height: 153pt;" src="{{ $background_front }}"
                    alt="">
            @endif
            <div style="position: absolute; inset: 0; background: rgba(15, 23, 42, 0.78);"></div>
            <div style="position: absolute; inset: 0; padding: 14pt; color: #e2e8f0;">
                <div style="position: absolute; left: 14pt; right: 14pt; top: 14pt;">
                    <div
                        style="font-size: 7pt; font-weight: bold; letter-spacing: 1.6pt; text-transform: uppercase; color: rgba(226, 232, 240, 0.76);"></div>
                    <div
                        style="margin-top: 2pt; font-family: DejaVu Serif, serif; font-size: 10pt; font-weight: bold; line-height: 1.02; color: #ffffff;">
                        {{ $nama_kartu ?? 'Kartu Identitas' }}</div>
                    <div style="margin-top: 1pt; font-size: 7pt; color: rgba(226, 232, 240, 0.76);">
                        {{ $instansi_penerbit ?? ' ' }}</div>
                </div>

                <div
                    style="position: absolute; left: 14pt; right: 84pt; top: 43pt; height: 34pt; font-size: 5.5pt; line-height: 1.45; color: rgba(226, 232, 240, 0.9); overflow: hidden;">
                    {{ $deskripsi ?? 'Kartu ini diterbitkan sebagai identitas resmi pemegang dan dapat diverifikasi melalui QR code yang tertera pada sisi belakang kartu.' }}
                </div>

                <div style="position: absolute; left: 14pt; bottom: 14pt; width: 118pt;">
                    <div style="font-size: 5.5pt; color: rgba(226, 232, 240, 0.72);">{{ $instansi_penerbit ?? ' ' }}
                    </div>
                    <div style="margin-top: 5pt; height: 24pt;">
                        @if (!empty($file_tandatangan))
                            <img style="max-width: 78pt; max-height: 24pt;" src="{{ $file_tandatangan }}"
                                alt="Tanda tangan">
                        @endif
                    </div>
                    <div
                        style="margin-top: 2pt; font-family: DejaVu Serif, serif; font-size: 5.5pt; font-weight: bold; color: #ffffff;">
                        {{ $nama_penandatangan ?? ' ' }}</div>
                    <div style="margin-top: 0pt; font-size: 5.5pt; color: rgba(226, 232, 240, 0.82);">
                        {{ $jabatan_penandatangan ?? ' ' }}</div>
                </div>

                <div style="position: absolute; right: 14pt; top: 60pt; width: 70pt; text-align: center;">
                    <div
                        style="width: 50pt; height: 50pt; border-radius: 4pt; margin: 0 auto 0; background: #ffffff; display: flex; justify-content: center; align-items: center;">
                        @if (!empty($qr_code_path))
                            <img style="width: 44pt; height: 44pt; object-fit: contain; margin-top: 3pt;" src="{{ $qr_code_path }}"
                                alt="QR Code">
                        @endif
                    </div>
                    <div
                        style="font-size: 5.2pt; font-weight: bold; letter-spacing: 0.6pt; margin-top: 0pt;text-transform: uppercase; color: rgba(226, 232, 240, 0.8); line-height: 1.2;">
                        Scan for<br>validation</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
