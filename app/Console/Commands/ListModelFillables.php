<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ListModelFillables extends Command
{
    protected $signature = 'model:fillables';
    protected $description = 'List all models and their fillable attributes';

    public function handle()
    {
        $modelsPath = app_path('Models');
        $models = File::allFiles($modelsPath);

        foreach ($models as $modelFile) {
            $modelClass = 'App\\Models\\' . $modelFile->getFilenameWithoutExtension();
            
            if (class_exists($modelClass)) {
                $modelInstance = new $modelClass();

                if (property_exists($modelInstance, 'fillable')) {
                    $this->line("Model: <info>{$modelClass}</info>");
                    $this->line("Fillable: " . implode(', ', $modelInstance->getFillable()));
                    $this->line(str_repeat('-', 40));
                }
            }
        }

        return 0;
    }
}
