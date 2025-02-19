<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateViewCommand extends Command
{
    protected $signature = 'view:create {model}';
    protected $description = 'Membuat folder dan file view untuk model tertentu';

    public function handle()
    {
        $model = strtolower($this->argument('model')); // Nama model dalam huruf kecil
        $modelTitle = ucfirst($model); // Kapitalisasi pertama untuk tampilan
        $basePath = resource_path("views/page/{$model}");

        // Buat folder jika belum ada
        File::makeDirectory($basePath, 0777, true, true);

        // Template dasar untuk file Blade dengan nama model
        $bladeTemplateIndex = "<x-app-layout>\n    <div>\n        <h1>Daftar {$modelTitle}</h1>\n        Content here\n    </div>\n</x-app-layout>";

        $bladeTemplateAdd = "<x-app-layout>\n    <div>\n        <h1>Tambah {$modelTitle}</h1>\n        Content here\n    </div>\n</x-app-layout>";

        $bladeTemplateEdit = "<x-app-layout>\n    <div>\n        <h1>Edit {$modelTitle}</h1>\n        Content here\n    </div>\n</x-app-layout>";

        // Buat file index.blade.php, add.blade.php, dan edit.blade.php dengan isi template
        File::put("{$basePath}/index.blade.php", $bladeTemplateIndex);
        File::put("{$basePath}/add.blade.php", $bladeTemplateAdd);
        File::put("{$basePath}/edit.blade.php", $bladeTemplateEdit);

        $this->info("View untuk {$modelTitle} berhasil dibuat di resources/views/page/{$model}");
    }
}
