<?php

namespace Nwidart\Modules;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

class BaseRouteServiceProvider extends RouteServiceProvider
{
    protected $basePath = '';
    protected $baseName = '';

    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = '';

    public function boot()
    {
        $this->moduleNamespace = sprintf('Modules\%s\Http\Controllers', $this->baseName);
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapAdminRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->moduleNamespace)
             ->group($this->basePath . '/../Routes/web.php');
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->moduleNamespace)
             ->group($this->basePath . '/../Routes/api.php');
    }

    /**
     * Define the "admin" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::prefix(config('admin.route.prefix'))
             ->middleware(config('admin.route.middleware'))
             ->namespace($this->moduleNamespace . '\Admin')
             ->group($this->basePath . '/../Routes/admin.php');
    }
}
