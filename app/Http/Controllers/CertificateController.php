<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CertificateParticipant;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function generate(string $urlx) 
    {
        $participant = CertificateParticipant::where('uuid', $urlx)->first();

        if (!$participant) {
            abort(404);
        }

        $certificate = $participant->certificate;
        if (!$certificate) {
            abort(404);
        }
        
        $data = [
            'jenis_sertifikat' => $certificate->jenis,
            'nomor_sertifikat' => $participant->nomor.'/'.$certificate->prefix_nomor,
            'nama_penerima' => $participant->nama_penerima,
            'asal_penerima' => $participant->asal_penerima,
            'deskripsi_sertifikat' => $certificate->deskripsi,
            'lokasi' => $certificate->lokasi,
            'tanggal_penerbitan' => $certificate->tanggal_terbit,
            'nama_penandatangan' => $certificate->nama_penandatangan,
            'background_image' => $this->imageSourceFromDisk($certificate->background_image),
            'jabatan_penandatangan' => $certificate->jabatan_penandatangan,
            'file_tandatangan' => $this->imageSourceFromDisk($certificate->file_tandatangan),
            'qr_code_path' => $this->imageSourceFromDisk($participant->qrcode_val),
            'download_link' => config('base_urls.base_cert').'/'.$participant->uuid,
        ];
        //dompdf
        $pdf = Pdf::loadView('certificate.template', $data)
        ->setPaper('a4', 'landscape');
        return $pdf->stream($certificate->jenis.'-'.$participant->nomor.'-'.$participant->nama_penerima.'.pdf');

    }

    public function validate(string $urlx)
    {
        $participant = CertificateParticipant::where('uuid_val', $urlx)->first();

        if (!$participant) {
            abort(404);
        }

        $certificate = $participant->certificate;
        $disk = Storage::disk(config('base_urls.default_disk'));

        if (!$certificate) {
            abort(404);
        }
        
        $data = [
            'jenis_sertifikat' => $certificate->jenis,
            'nomor_sertifikat' => $participant->nomor.'/'.$certificate->prefix_nomor,
            'nama_penerima' => $participant->nama_penerima,
            'asal_penerima' => $participant->asal_penerima,
            'deskripsi_sertifikat' => $certificate->deskripsi,
            'background_image' => $disk->url($certificate->background_image),
            'lokasi' => $certificate->lokasi,
            'tanggal_penerbitan' => $certificate->tanggal_terbit,
            'nama_penandatangan' => $certificate->nama_penandatangan,
            'jabatan_penandatangan' => $certificate->jabatan_penandatangan,
            'file_tandatangan' => $disk->url($certificate->file_tandatangan),
            'qr_code_path' => config('base_urls.base_cert_val').'/'.$participant->uuid_val,
            'download_link' => config('base_urls.base_cert').'/'.$participant->uuid,
        ];

        return view('certificate.validation', ['data' => $data]);
    }

    private function imageSourceFromDisk(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        $disk = Storage::disk(config('base_urls.default_disk'));

        if (!$disk->exists($path)) {
            return null;
        }

        $mimeType = $disk->mimeType($path) ?: 'application/octet-stream';
        $contents = $disk->get($path);

        return 'data:'.$mimeType.';base64,'.base64_encode($contents);
    }
}
