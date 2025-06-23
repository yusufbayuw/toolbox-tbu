<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Sertifikat</title>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Figtree', ui-sans-serif, system-ui, sans-serif;
            background-image: linear-gradient(rgba(30, 41, 59, 0.6), rgba(30, 41, 59, 0.6)), url('{{ $data['background_image'] }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            padding: 2.5rem 2rem;
            max-width: 480px;
            width: 100%;
            animation: fadeInUp 0.8s cubic-bezier(.39,.575,.565,1) both;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(40px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
            letter-spacing: 1px;
        }

        hr {
            border: none;
            border-top: 2px solid #3b82f6;
            margin: 1rem 0 2rem 0;
            width: 60px;
            margin-left: auto;
            margin-right: auto;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.5rem;
        }

        th {
            text-align: left;
            color: #64748b;
            font-weight: 600;
            padding: 0.5rem 0.75rem;
            font-size: 1rem;
            width: 45%;
        }

        td {
            color: #1e293b;
            font-weight: 500;
            padding: 0.5rem 0.75rem;
            font-size: 1rem;
            background: rgba(255,255,255,0.7);
            border-radius: 8px;
        }

        tr:not(:last-child) td, tr:not(:last-child) th {
            border-bottom: 1px solid #e2e8f0;
        }

        .download-btn {
            display: inline-block;
            margin-top: 2rem;
            background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%);
            color: #fff;
            font-weight: 600;
            padding: 0.75rem 2.5rem;
            border-radius: 999px;
            font-size: 1.1rem;
            letter-spacing: 1px;
            box-shadow: 0 4px 24px rgba(59, 130, 246, 0.15);
            border: none;
            transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
            text-decoration: none;
        }

        .download-btn:hover {
            background: linear-gradient(90deg, #2563eb 0%, #3b82f6 100%);
            transform: translateY(-2px) scale(1.04);
            box-shadow: 0 8px 32px rgba(59, 130, 246, 0.25);
        }

        @media (max-width: 600px) {
            .glass-card {
                padding: 1.2rem 0.5rem;
                max-width: 98vw;
            }
            h2 {
                font-size: 1.3rem;
            }
            th, td {
                font-size: 0.95rem;
                padding: 0.4rem 0.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="glass-card">
        <h2>Validasi Sertifikat</h2>
        <hr>
        <table>
            <tbody>
                <tr>
                    <th>Jenis Sertifikat</th>
                    <td>{{ $data['jenis_sertifikat'] }}</td>
                </tr>
                <tr>
                    <th>Nomor Sertifikat</th>
                    <td>{{ $data['nomor_sertifikat'] }}</td>
                </tr>
                <tr>
                    <th>Nama Penerima</th>
                    <td>{{ $data['nama_penerima'] }}</td>
                </tr>
                <tr>
                    <th>Asal Penerima</th>
                    <td>{{ $data['asal_penerima'] }}</td>
                </tr>
                <tr>
                    <th>Deskripsi Sertifikat</th>
                    <td>{{ $data['deskripsi_sertifikat'] }}</td>
                </tr>
                <tr>
                    <th>Lokasi</th>
                    <td>{{ $data['lokasi'] }}</td>
                </tr>
                <tr>
                    <th>Tanggal Penerbitan</th>
                    <td>{{ $data['tanggal_penerbitan'] }}</td>
                </tr>
                <tr>
                    <th>Nama Penandatangan</th>
                    <td>{{ $data['nama_penandatangan'] }}</td>
                </tr>
                <tr>
                    <th>Jabatan Penandatangan</th>
                    <td>{{ $data['jabatan_penandatangan'] }}</td>
                </tr>
            </tbody>
        </table>
        <div style="text-align:center;">
            <a href="{{ $data['download_link'] }}" class="download-btn">Download Sertifikat</a>
        </div>
    </div>
</body>

</html>