<?php

return [
    'storage_key_path' => storage_path('app/license.key'),
    'manifest_path' => base_path('bootstrap/cache/config_validation.php'),
    'protected_files' => [
        'app/Support/SystemBoot.php',
        'app/Services/License/LicenseService.php',
        'app/Http/Middleware/VerifyConfigIntegrity.php',
        'app/Http/Controllers/LicenseController.php',
        'app/Providers/AppServiceProvider.php',
        'app/Providers/Filament/AdminPanelProvider.php',
        'resources/views/custom/footer.blade.php',
        'resources/views/tree.blade.php',
        'resources/views/certificate/validation.blade.php',
        'resources/views/certificate/template.blade.php',
        'app/Http/Controllers/CardController.php',
        'app/Filament/Resources/CardResource.php',
        'resources/views/card/validation.blade.php',
        'resources/views/card/template.blade.php',
    ],
];
