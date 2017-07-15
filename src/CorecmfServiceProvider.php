<?php

namespace CoreCMF\corecmf;

use Illuminate\Support\ServiceProvider;
use CoreCMF\core\Support\Builder\Main as builderCorecmfMain;
use CoreCMF\core\Support\Contracts\Prerequisite;
use CoreCMF\core\Support\Prerequisite\Composite;
use CoreCMF\core\Support\Prerequisite\PhpExtension;
use CoreCMF\core\Support\Prerequisite\PhpVersion;
use CoreCMF\core\Support\Prerequisite\WritablePath;

class CorecmfServiceProvider extends ServiceProvider
{
    protected $commands = [
        'CoreCMF\corecmf\Commands\InstallCommand',
        'CoreCMF\corecmf\Commands\UninstallCommand',
    ];
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        //加载artisan commands
        $this->commands($this->commands);
        // 加载配置
        $this->mergeConfigFrom(__DIR__.'/Config/config.php', 'corecmf');
        //配置路由
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/Routes/api.php');
        //视图路由
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'corecmf');
        //设置发布前端文件
        $this->publishes([
            __DIR__.'/../resources/mixes/vue-corecmf/dist/vendor/' => public_path('vendor'),
        ], 'public');

        $this->initService();
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('builderCorecmfMain', function () {
            return new builderCorecmfMain();
        });
        $this->app->singleton(Prerequisite::class, function () {
            return new Composite(
              new PhpVersion(config('corecmf.prerequisite.phpVersion')),
              new PhpExtension(config('corecmf.prerequisite.phpExtension')),
              new WritablePath(config('corecmf.prerequisite.writablePath'))
            );
        });
    }

    public function initService()
    {
        //注册providers服务
        $this->registerProviders();
    }
    public function registerProviders()
    {
        $providers = config('corecmf.providers');
        foreach ($providers as $provider) {
            $this->app->register($provider);
        }
    }
}
