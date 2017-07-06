<?php

namespace CoreCMF\corecmf\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class MainController extends Controller
{
    private $builderMain;
    /** return  CoreCMF\core\Builder\Main */
    public function __construct()
    {
        $this->builderMain = resolve('builderCorecmfMain');        //全局统一实例
    }
    public function index()
    {
        $builderMain = $this->builderMain;
        $builderMain->route([
          'path'  =>  '/install',
          'name'  =>  'api.install',
          'apiUrl'  =>  route('api.install.index'),
          'children'  =>  null,
          'component' =>  '<corecmf-index/>'
        ]);

        return $builderMain->response();
    }
}
