<?php

namespace App\Http\Middleware;

use App\Services\License\LicenseService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyConfigIntegrity
{
    public function __construct(
        private readonly LicenseService $licenseService,
    ) {
    }

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->routeIs('license.*') || $request->is('up')) {
            return $next($request);
        }

        $status = $this->licenseService->status();

        if ($status['valid']) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $status['message'],
                'status' => $status['status'],
            ], 423);
        }

        return redirect()->route('license.show');
    }
}
