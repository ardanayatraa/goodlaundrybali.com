<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class SimpleRouteListCommand extends Command
{
    protected $signature = 'route:simple';
    protected $description = 'Menampilkan daftar route yang lebih ringkas';

    public function handle()
    {
        $routes = Route::getRoutes();
        $data = [];

        foreach ($routes as $route) {
            $data[] = [
                'METHOD' => implode('|', $route->methods()),
                'URI' => $route->uri(),
                'NAME' => $route->getName() ?: '-',
            ];
        }

        $this->table(['METHOD', 'URI', 'NAME'], $data);
    }
}
