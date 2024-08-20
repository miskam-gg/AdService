<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    protected function mapApiRoutes()
    {
        Route::middleware('api')
             ->prefix('api')
             ->group(base_path('routes/api.php'));
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->group(base_path('routes/web.php'));
    }
}
