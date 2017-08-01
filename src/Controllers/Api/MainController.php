<?php

namespace CoreCMF\corecmf\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Container\Container;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    private $builderMain;
    private $container;
    /** return  CoreCMF\core\Builder\Main */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->builderMain = $container->make('builderCorecmfMain');        //全局统一实例
    }
    public function index()
    {
        $this->builderMain->route([
          'path'  =>  '/install',
          'name'  =>  'api.install',
          'apiUrl'  =>  route('api.install.index'),
          'children'  =>  null,
          'component' =>  '<corecmf-install/>'
        ]);

        return $this->container->make('builderHtml')->main($this->builderMain)->response();
    }
}
