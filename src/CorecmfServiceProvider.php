<?php

namespace CoreCMF\corecmf;

use Artisan;
use Illuminate\Support\ServiceProvider;
use CoreCMF\core\Support\Builder\Main as builderCorecmfMain;

class CorecmfServiceProvider extends ServiceProvider
{
    protected $commands = [
        \CoreCMF\corecmf\Commands\InstallCommand::class,
        \CoreCMF\corecmf\Commands\UninstallCommand::class,
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
        if (!$this->isInstalled()) {
            //配置路由
            $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
            $this->loadRoutesFrom(__DIR__.'/Routes/api.php');
        }
        //视图路由
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'corecmf');
        //设置发布前端文件
        $this->publishes([
            __DIR__.'/../resources/mixes/vue-corecmf/dist/vendor/' => public_path('vendor'),
        ], 'corecmf');
        //加载依赖程序
        $this->initService();
        //发布前端资源
        $this->publish();
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
    public function publish()
    {
        if (!file_exists(public_path() . DIRECTORY_SEPARATOR . 'vendor'. DIRECTORY_SEPARATOR .'corecmf')) {
            Artisan::call('vendor:publish', [
                '--tag' => 'corecmf','--force' => true
            ]);
        }
    }
    /**
     * Get application installation status.
     *
     * @return bool
     */
    public function isInstalled()
    {
        if (!file_exists(storage_path() . DIRECTORY_SEPARATOR . 'installed')) {
            return false;
        }else{
            return true;
        }
    }
}
