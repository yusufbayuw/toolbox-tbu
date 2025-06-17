<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CertificateParticipant;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function generate(string $urlx) 
    {
        $participant = CertificateParticipant::where('uuid', $urlx)->first();
        $certificate = $participant->certificate;
        
        $data = [
            'jenis_sertifikat' => $certificate->jenis,
            'nomor_sertifikat' => $participant->nomor,
            'nama_penerima' => $participant->nama_penerima,
            'asal_penerima' => $participant->asal_penerima,
            'deskripsi_sertifikat' => $certificate->deskripsi,
            'lokasi' => $certificate->lokasi,
            'tanggal_penerbitan' => $certificate->tanggal_terbit,
            'nama_penandatangan' => $certificate->nama_penandatangan,
            'jabatan_penandatangan' => $certificate->jabatan_penandatangan,
            'file_tandatangan' => Storage::disk('public')->url($certificate->file_tandatangan),//config('base_urls.base_cert').'/storage/'.$certificate->file_tandatangan,
            'qr_code_path' => config('base_urls.base_cert_val').'/'.$participant->uuid_val,
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
        $certificate = $participant->certificate;
        
        $data = [
            'jenis_sertifikat' => $certificate->jenis,
            'nomor_sertifikat' => $certificate->prefix_nomor.$participant->nomor,
            'nama_penerima' => $participant->nama_penerima,
            'asal_penerima' => $participant->asal_penerima,
            'deskripsi_sertifikat' => $certificate->deskripsi,
            'lokasi' => $certificate->lokasi,
            'tanggal_penerbitan' => $certificate->tanggal_terbit,
            'nama_penandatangan' => $certificate->nama_penandatangan,
            'jabatan_penandatangan' => $certificate->jabatan_penandatangan,
            'file_tandatangan' => Storage::disk('public')->url($certificate->file_tandatangan),//config('base_urls.base_cert').'/storage/'.$certificate->file_tandatangan,
            'qr_code_path' => config('base_urls.base_cert_val').'/'.$participant->uuid_val,
            'download_link' => config('base_urls.base_cert').'/'.$participant->uuid,
            'background_image' => Storage::disk('public')->url($certificate->background_image),
        ];

        return view('certificate.validation', ['data' => $data]);
    }
}
