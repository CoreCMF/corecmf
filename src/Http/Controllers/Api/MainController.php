<?php

namespace CoreCMF\Corecmf\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use CoreCMF\Core\Support\Builder\Main;

class MainController extends Controller
{
    private $builderMain;
    /** return  CoreCMF\Core\Builder\Main */
    public function __construct(Main $builderMain)
    {
        $this->builderMain = $builderMain;        //全局统一实例
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

        return resolve('builderHtml')->main($this->builderMain)->response();
    }
}
