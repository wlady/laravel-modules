<?php

namespace Nwidart\Modules;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Factory;

class BaseServiceProvider extends ModulesServiceProvider
{
    protected $basePath = '';
    protected $baseName = '';
    protected $baseNameLowerCase = '';

    /**
     * Booting the package.
     */
    public function boot()
    {
        $this->baseNameLowerCase = strtolower($this->baseName);
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom($this->basePath . '/../Database/Migrations');
    }

    protected function registerServices()
    {
    }

    protected function registerConfig()
    {
        if (file_exists($this->basePath . '/../Config/config.php')) {
            $this->publishes([
                $this->basePath . '/../Config/config.php' => config_path($this->baseNameLowerCase . '.php'),
            ], 'config');
            $this->mergeConfigFrom(
                $this->basePath . '/../Config/config.php', $this->baseNameLowerCase
            );
        }
    }

    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->baseNameLowerCase);

        $sourcePath = $this->basePath . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/' . $this->baseNameLowerCase;
        }, Config::get('view.paths')), [$sourcePath]), $this->baseNameLowerCase);
    }

    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->baseNameLowerCase);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->baseNameLowerCase);
        } else {
            $this->loadTranslationsFrom($this->basePath . '/../Resources/lang', $this->baseNameLowerCase);
        }
    }

    public function registerFactories()
    {
        if ( ! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

}
