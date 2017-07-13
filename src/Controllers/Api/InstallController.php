<?php

namespace CoreCMF\corecmf\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use CoreCMF\core\Support\Http\Request as CoreRequest;

class InstallController extends Controller
{
    private $builderForm;

    public function __construct()
    {
        $this->builderForm = resolve('builderForm');
    }
    public function index(CoreRequest $request)
    {
      $steps        = $request->get('steps',0);
      $stepsTitle = ['用户协议','检测环境','数据库设置','账户设置','安装完成'];
      $this->builderForm->item(['name' => 'steps',      'type' => 'steps',   'title'=>$stepsTitle, 'active'=>$steps])
              ->apiUrl('submit',route('api.install.index'))
              ->config('formStyle',['padding'=>'20px 10px' ])
              ->config('labelWidth','0')
              ->config('formReset',['hidden'=>true ])
              ->config('formSubmit',[ 'name'=>'下一步', 'style'=> ['width'=>'38.2%'] ]);
      switch ($steps) {
        case 0:
          $this->steps0();
          break;
        case 1:
          $this->steps1();
          break;
        case 2:
          $this->steps2();
          break;
        case 3:
          $this->steps3();
          break;
        case 4:
          $this->steps4();
          break;
        case 5:
          $this->steps5();
          break;
      }
      $html = resolve('builderHtml')
                ->title('系统安装')
                ->item($this->builderForm)
                ->config('refresh',false)
                ->response();
      return $html;
    }
    public function steps0(){
        $this->builderForm->item([
                'name' => 'agreement',
                'type' => 'scrollbar',
                'value' => config('corecmf.agreement'),]
             )
             ->item([
               'name' => 'userAgreement',
               'type' => 'checkbox',
               'value'=>[],
               'options' => [
                 'userAgreement' => [
                   'name'=>'我同意相关用户协议',
                   'eventEnable'=>['submitButton']
                 ]
               ]
             ])
             ->item(['name' => 'steps','type' => 'hidden','value' => 1,])
             ->config('formSubmit',[ 'name'=>'安装', 'disabled'=> true, 'style'=> ['width'=>'38.2%'] ]);
    }
    public function steps1(){
        $this->builderForm
             ->item(['name' => 'agreement',  'type' => 'scrollbar', 'value' => config('corecmf.agreement'),])
             ->item(['name' => 'password',   'type' => 'password',    'placeholder' => '2'])
             ->item(['name' => 'steps','type' => 'hidden','value' => 2,])
             ->config('formPrevious',[
               'name'=>'上一步',
               'value'=>'steps',
               'hidden'=>false,
               'style'=> ['width'=>'38.2%']
             ]);
    }
    public function steps2(){
        $this->builderForm
             ->item(['name' => 'agreement',  'type' => 'scrollbar', 'value' => config('corecmf.agreement'),])
             ->item(['name' => 'password',   'type' => 'password',    'placeholder' => '3'])
             ->item(['name' => 'steps','type' => 'hidden','value' => 3,]) ->config('formPrevious',[
                'name'=>'上一步',
                'value'=>'steps',
                'hidden'=>false,
                'style'=> ['width'=>'38.2%']
              ]);
    }
    public function steps3(){
        $this->builderForm
             ->item(['name' => 'agreement',  'type' => 'scrollbar', 'value' => config('corecmf.agreement'),])
             ->item(['name' => 'password',   'type' => 'password',    'placeholder' => '3'])
             ->item(['name' => 'steps','type' => 'hidden','value' => 4,]) ->config('formPrevious',[
                'name'=>'上一步',
                'value'=>'steps',
                'hidden'=>false,
                'style'=> ['width'=>'38.2%']
              ]);
    }
    public function steps4(){
        $this->builderForm
             ->item(['name' => 'agreement',  'type' => 'scrollbar', 'value' => config('corecmf.agreement'),])
             ->item(['name' => 'password',   'type' => 'password',    'placeholder' => '4'])
             ->item(['name' => 'steps','type' => 'hidden','value' => 5,]) ->config('formPrevious',[
                'name'=>'上一步',
                'value'=>'steps',
                'hidden'=>false,
                'style'=> ['width'=>'38.2%']
              ]);
    }
    public function steps5(){
        $this->builderForm
             ->item(['name' => 'agreement',  'type' => 'scrollbar', 'value' => config('corecmf.agreement'),])
             ->item(['name' => 'password',   'type' => 'password',    'placeholder' => '5']) ->config('formPrevious',[
                'name'=>'上一步',
                'value'=>'steps',
                'hidden'=>false,
                'style'=> ['width'=>'38.2%']
              ])
              ->config('formSubmit',[ 'hidden'=>false ]);
    }
}
