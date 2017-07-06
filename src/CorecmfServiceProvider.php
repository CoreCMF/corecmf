<?php

namespace CoreCMF\corecmf;

use Illuminate\Support\ServiceProvider;
use CoreCMF\core\Support\Builder\Main as builderCorecmfMain;

class CorecmfServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
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
    }

    public function initService()
    {
        //注册providers服务
        $this->registerProviders();
    }
    public function registerProviders()
    {
        $providers = config('core.providers');
        foreach ($providers as $provider) {
            $this->app->register($provider);
        }
    }
}
