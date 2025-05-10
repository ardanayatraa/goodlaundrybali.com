<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ListModelsCommand extends Command
{
    protected $signature = 'model:list';
    protected $description = 'Menampilkan daftar model yang ada di app/Models/';

    public function handle()
    {
        $modelsPath = app_path('Models');
        
        if (!File::exists($modelsPath)) {
            $this->error("Folder app/Models tidak ditemukan.");
            return;
        }

        $files = File::files($modelsPath);
        $models = [];

        foreach ($files as $file) {
            if ($file->getExtension() === 'php') {
                $models[] = $file->getFilenameWithoutExtension();
            }
        }

        if (empty($models)) {
            $this->info("Tidak ada model yang ditemukan di app/Models/");
        } else {
            $this->info("Daftar Model yang ditemukan:");
            foreach ($models as $model) {
                $this->line("- {$model}");
            }
        }
    }
}
