<?php

namespace App\Http\Controllers;

use App\Models\CardHolder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class CardController extends Controller
{
    public function demoTemplate()
    {
        return view('card.template_card', $this->dummyData());
    }

    public function demoPdf()
    {
        return Pdf::loadView('card.template_card', $this->dummyData())
            ->setPaper([0, 0, 498, 153], 'landscape')
            ->stream('demo-card.pdf');
    }

    public function generate(string $uuid)
    {
        $holder = CardHolder::where('uuid', $uuid)->first();

        if (! $holder || ! $holder->card) {
            abort(404);
        }

        $card = $holder->card;
        $data = [
            'nama_kartu' => $card->nama_kartu,
            'deskripsi' => $card->deskripsi,
            'instansi_penerbit' => $card->instansi,
            'masa_berlaku_label' => $card->masa_berlaku_label,
            'nama_penandatangan' => $card->nama_penandatangan,
            'jabatan_penandatangan' => $card->jabatan_penandatangan,
            'file_tandatangan' => $this->imageSourceFromDisk($card->file_tandatangan),
            'background_front' => $this->imageSourceFromDisk($card->background_front),
            'background_back' => $this->imageSourceFromDisk($card->background_back),
            'nomor_identitas' => $holder->nomor_identitas,
            'nama_pemegang' => $holder->nama_pemegang,
            'jabatan' => $holder->jabatan,
            'instansi' => $holder->instansi ?: $card->instansi,
            'masa_berlaku' => $holder->masa_berlaku,
            'foto' => $this->imageSourceFromDisk($holder->foto),
            'qr_code_path' => $this->imageSourceFromDisk($holder->qrcode_val),
            'validation_link' => config('base_urls.base_card_val').'/'.$holder->uuid_val,
            'download_link' => config('base_urls.base_card').'/'.$holder->uuid,
        ];

        return Pdf::loadView('card.template', $data)
            ->setPaper([0, 0, 498, 153], 'landscape')
            ->stream($this->safeDownloadFilename(
                $card->nama_kartu,
                $holder->nomor_identitas,
                $holder->nama_pemegang
            ));
    }

    public function validate(string $uuid)
    {
        $holder = CardHolder::where('uuid_val', $uuid)->first();

        if (! $holder || ! $holder->card) {
            abort(404);
        }

        $card = $holder->card;
        $disk = Storage::disk(config('base_urls.default_disk'));

        return view('card.validation', [
            'data' => [
                'nama_kartu' => $card->nama_kartu,
                'deskripsi' => $card->deskripsi,
                'instansi_penerbit' => $card->instansi,
                'masa_berlaku_label' => $card->masa_berlaku_label,
                'nama_penandatangan' => $card->nama_penandatangan,
                'jabatan_penandatangan' => $card->jabatan_penandatangan,
                'background_front' => $card->background_front ? $disk->url($card->background_front) : null,
                'background_back' => $card->background_back ? $disk->url($card->background_back) : null,
                'nomor_identitas' => $holder->nomor_identitas,
                'nama_pemegang' => $holder->nama_pemegang,
                'jabatan' => $holder->jabatan,
                'instansi' => $holder->instansi ?: $card->instansi,
                'masa_berlaku' => $holder->masa_berlaku,
                'foto' => $holder->foto ? $disk->url($holder->foto) : null,
                'file_tandatangan' => $card->file_tandatangan ? $disk->url($card->file_tandatangan) : null,
                'qr_code_image' => $holder->qrcode_val ? $disk->url($holder->qrcode_val) : null,
                'qr_code_path' => config('base_urls.base_card_val').'/'.$holder->uuid_val,
                'download_link' => config('base_urls.base_card').'/'.$holder->uuid,
            ],
        ]);
    }

    private function imageSourceFromDisk(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        $disk = Storage::disk(config('base_urls.default_disk'));

        if (! $disk->exists($path)) {
            return null;
        }

        $mimeType = $disk->mimeType($path) ?: 'application/octet-stream';
        $contents = $disk->get($path);

        return 'data:'.$mimeType.';base64,'.base64_encode($contents);
    }

    private function imageSourceFromPublicPath(string $relativePath): ?string
    {
        $path = public_path($relativePath);

        if (! is_file($path)) {
            return null;
        }

        $mimeType = mime_content_type($path) ?: 'application/octet-stream';
        $contents = file_get_contents($path);

        if ($contents === false) {
            return null;
        }

        return 'data:'.$mimeType.';base64,'.base64_encode($contents);
    }

    private function dummyData(): array
    {
        $background = $this->imageSourceFromPublicPath('images/card_front_template.png');
        $photo = $this->imageSourceFromPublicPath('images/img_card_template.png');
        $qr_photo = $this->imageSourceFromPublicPath('storage/card/2026/03/qr/224ec7b50-cce9-4748-972c-0dd25924982b.png');

        return [
            'nama_kartu' => 'Kartu Mahasiswa',
            'deskripsi' => 'Kartu identitas ini digunakan sebagai bukti keanggotaan aktif dan akses verifikasi identitas mahasiswa.',
            'instansi_penerbit' => 'Taruna Bakti University',
            'masa_berlaku_label' => 'Berlaku hingga',
            'nama_penandatangan' => 'Master',
            'jabatan_penandatangan' => 'Kepala Bidang',
            'file_tandatangan' => null,
            'background_front' => $background,
            'background_back' => $background,
            'nomor_identitas' => '001/MHS/FO/292',
            'nama_pemegang' => 'Yusuf Bayu Wicaksono',
            'jabatan' => 'Mahasiswa',
            'instansi' => 'Informatika',
            'masa_berlaku' => '31 Desember 2026',
            'foto' => $photo,
            'qr_code_path' => $qr_photo,
            'validation_link' => config('base_urls.base_card_val').'/demo-validation',
            'download_link' => config('base_urls.base_card').'/demo-card',
        ];
    }

    private function safeDownloadFilename(?string ...$parts): string
    {
        $segments = collect($parts)
            ->filter()
            ->map(function (string $part): string {
                $sanitized = preg_replace('/[\\\\\\/\\:\\*\\?\\\"\\<\\>\\|]+/', '-', $part);
                $sanitized = preg_replace('/\\s+/', ' ', $sanitized ?? '');

                return trim($sanitized, " .-\t\n\r\0\x0B");
            })
            ->filter()
            ->values();

        $filename = $segments->isNotEmpty() ? $segments->implode('-') : 'card';

        return $filename.'.pdf';
    }
}
