<?php

namespace CoreCMF\corecmf\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use CoreCMF\core\Support\Http\Request as CoreRequest;
use CoreCMF\core\Support\Contracts\Prerequisite;

class InstallController extends Controller
{
    protected $builderForm;
    protected $prerequisite;

    public function __construct(Prerequisite $prerequisite)
    {
        $this->builderForm = resolve('builderForm');
        $this->prerequisite = $prerequisite;
    }
    public function index(CoreRequest $request)
    {
      $steps        = $request->get('steps',0);
      $stepsTitle = ['用户协议','检测环境','数据库设置','账户设置','安装完成'];
      $this->builderForm->item(['name' => 'steps',      'type' => 'steps',   'title'=>$stepsTitle, 'value'=>$steps])
              ->apiUrl('submit',route('api.install.index'))
              ->config('formStyle',['padding'=>'20px 10px' ])
              ->config('labelWidth','0')
              ->config('formReset',['hidden'=>true ])
              ->config('formPrevious',[
                'name'=>'上一步',
                'steps'=>'steps',
                'hidden'=>false,
                'style'=> ['width'=>'38.2%']
              ])
              ->config('formSubmit',[
                'name'=>'下一步',
                'steps'=>'steps',
                'style'=> ['width'=>'38.2%']
              ]);
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
             ->config('formPrevious',['hidden'=>true])
             ->config('formSubmit',[
               'name'=>'安装',
               'disabled'=> true,
               'steps'=>'steps',
               'style'=> ['width'=>'38.2%']
             ]);
    }
    public function steps1(){
        $this->prerequisite->check();
        $messages = $this->prerequisite->getMessages();
        foreach ($messages as $key => $message) {
          $this->builderForm->item(['name' => 'alert'.$key,  'type' => 'alert', 'title' => $message['message'], 'itemType'=>$message['type']]);
          if ($message['type'] == 'error') {
            $this->builderForm->config('formSubmit',[ 'name'=>'重新检测', 'style'=> ['width'=>'38.2%'] ]);
          }
        }
    }
    public function steps2(){
        $this->builderForm
             ->config('labelWidth','100px')
             ->item(['name' => 'agreement',  'type' => 'scrollbar', 'value' => config('corecmf.agreement'),])
             ->item(['name' => 'sitename',   'type' => 'text', 'label'=>'网站名称',  'placeholder' => '请输入网站名称']);
    }
    public function steps3(){
        $this->builderForm
             ->item(['name' => 'agreement',  'type' => 'scrollbar', 'value' => config('corecmf.agreement'),])
             ->item(['name' => 'password',   'type' => 'password',    'placeholder' => '3']);
    }
    public function steps4(){
        $this->builderForm
             ->item(['name' => 'agreement',  'type' => 'scrollbar', 'value' => config('corecmf.agreement'),])
             ->item(['name' => 'password',   'type' => 'password',    'placeholder' => '4'])
             ->config('formSubmit',[ 'hidden'=>true ]);
    }
}
