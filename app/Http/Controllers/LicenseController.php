<?php

namespace App\Http\Controllers;

use App\Services\License\LicenseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LicenseController extends Controller
{
    public function __construct(
        private readonly LicenseService $licenseService,
    ) {
    }

    public function show(): View
    {
        return view('license.activate', [
            'status' => $this->licenseService->status(),
        ]);
    }

    public function activate(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'license_key' => ['required', 'string'],
        ]);

        $result = $this->licenseService->activate($validated['license_key']);

        if (!$result['valid']) {
            return back()->withErrors([
                'license_key' => $result['message'],
            ])->withInput();
        }

        $message = $result['env_override_active'] ?? false
            ? 'Lisensi valid dan tersimpan, namun LICENSE_KEY di .env sedang aktif sebagai override.'
            : 'Lisensi berhasil diaktivasi.';

        return redirect()->route('license.status')->with('status_message', $message);
    }

    public function status(): View
    {
        return view('license.status', [
            'status' => $this->licenseService->status(),
        ]);
    }
}
