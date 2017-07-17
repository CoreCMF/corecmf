<?php

namespace CoreCMF\corecmf\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use CoreCMF\core\Support\Http\Request as CoreRequest;
use CoreCMF\core\Support\Contracts\Prerequisite;
use CoreCMF\core\Support\Commands\Install;

class InstallController extends Controller
{
    protected $builderForm;
    protected $prerequisite;
    protected $install;
    protected $request;

    public function __construct(Prerequisite $prerequisite, Install $install,Request $request)
    {
        $this->builderForm = resolve('builderForm');
        $this->prerequisite = $prerequisite;
        $this->install = $install;
        $this->request = $request;
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
             ->item([
               'name' => 'sitename',
               'type' => 'text',
               'label'=>'网站名称',
               'placeholder' => '请输入网站名称',
               'style' => ['max-width'=>'300px']
             ])
             ->item([
               'name' => 'database_engine',
               'type' => 'radio',
               'label'=>'数据库引擎',
               'value' => 'mysql',
               'options' => ['pgsql'=>'PostgreSQL', 'mysql'=>'MySql', 'sqlite'=>'SQLite3',]
             ])
             ->item([
               'name' => 'database_host',
               'type' => 'text',
               'label'=>'数据库地址',
               'value' => 'localhost',
               'style' => ['max-width'=>'250px']
             ])
             ->item([
               'name' => 'database_port',
               'type' => 'text',
               'label'=>'数据库端口',
               'value' => '3306',
               'style' => ['max-width'=>'100px']
             ])
             ->item([
               'name' => 'database_name',
               'type' => 'text',
               'label'=>'数据库名称',
               'placeholder' => '请输入数据库名称',
               'style' => ['max-width'=>'250px']
             ])
             ->item([
               'name' => 'database_username',
               'type' => 'text',
               'label'=>'数据库用户名',
               'placeholder' => '请输入数据库用户名',
               'style' => ['max-width'=>'200px']
             ])
             ->item([
               'name' => 'database_password',
               'type' => 'text',
               'label'=>'数据库密码',
               'placeholder' => '请输入数据库密码',
               'style' => ['max-width'=>'200px']
             ]);
    }
    public function steps3(){
        $this->validate($this->request, [
            'database_engine'   => 'required',
            'database_host'     => 'required',
            'database_port'     => 'required',
            'database_name'     => 'required',
            'database_password' => 'required',
            'database_username' => 'required',
            'sitename'          => 'required',
        ], [
            'database_engine.required'   => '必须选择数据库引擎',
            'database_host.required'     => '必须填写数据库地址',
            'database_port.required'     => '必须填写数据库端口',
            'database_name.required'     => '必须填写数据库名称',
            'database_password.required' => '必须填写数据库密码',
            'database_username.required' => '必须填写数据库用户名',
            'sitename.required'          => '必须填写网站名称',
        ]);
        $command = $this->install->getCommand('corecmf:install');
        $command->setSqlController($this->request->all());
        $command->setEnv();
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
