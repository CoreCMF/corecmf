<?php

namespace CoreCMF\corecmf\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository;
use App\Http\Controllers\Controller;
use CoreCMF\core\Support\Http\Request as CoreRequest;
use CoreCMF\core\Support\Contracts\Prerequisite;
use CoreCMF\core\Support\Commands\Install;
use CoreCMF\corecmf\Validator\InstallRules;

class InstallController extends Controller
{
    protected $builderForm;
    protected $builderHtml;
    protected $prerequisite;
    protected $install;
    protected $request;
    protected $container;
    protected $repository;
    protected $rules;

    public function __construct(
      Prerequisite $prerequisite,
      Install $install,
      Request $request,
      Container $container,
      Repository $repository,
      Rules $rules
    )
    {
        $this->prerequisite = $prerequisite; //环境检测
        $this->install = $install;  //安装
        $this->request = $request;
        $this->rules = $rules; //前端验证规则
        $this->repository = $repository; //config
        $this->container = $container; //服务容器
        $this->builderForm = $this->container->make('builderForm');//自动构建 builderForm
        $this->builderHtml = $this->container->make('builderHtml');//自动构建 builderHtml
    }
    public function index(CoreRequest $request)
    {
      $steps = $this->eventHandler($request);
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
      $html = $this->builderHtml->title('系统安装')
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
             ->rules($this->rules->database())
             ->config('labelWidth','120px')
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
      $this->builderForm
              ->rules($this->rules->admin())
              ->config('labelWidth','110px')
              ->item([
                'name' => 'admin_account',
                'type' => 'text',
                'label'=>'管理员账号',
                'placeholder' => '请输入管理员账号',
                'style' => ['max-width'=>'300px']
              ])
              ->item([
                'name' => 'admin_password',
                'type' => 'text',
                'label'=>'管理员密码',
                'placeholder' => '请输入管理员密码',
                'style' => ['max-width'=>'300px']
              ])
              ->item([
                'name' => 'admin_email',
                'type' => 'text',
                'label'=>'管理员邮箱',
                'placeholder' => '请输入管理员邮箱',
                'style' => ['max-width'=>'300px']
              ])
              ->item([
                'name' => 'admin_mobile',
                'type' => 'text',
                'label'=>'管理员手机',
                'placeholder' => '请输入管理员手机',
                'style' => ['max-width'=>'300px']
              ]);
    }
    public function steps4(){
      $this->builderForm->config('labelWidth','120px')
                        ->item(['name' => 'success',  'type' => 'alert', 'title' => '恭喜你！安装成功！', 'itemType'=>'success'])
                        ->item(['name' => 'webindex',  'type' => 'link', 'label'=>'网站首页', 'value' => url('')])
                        ->item(['name' => 'webadmin',  'type' => 'link', 'label'=>'后台管理页面', 'value' => url('admin')])
                        ->config('formPrevious',['hidden'=>true,])
                        ->config('formSubmit',[ 'hidden'=>true ]);
    }
    public function eventHandler($request)
    {
        $steps = $request->get('steps',0);
        switch ($steps) {
          case 3:
            if (!$this->databaseCheck()) {
                $steps=2;
            }else{
                $this->databaseInstall();
                $this->install->installModule('core');
                $this->install->installModule('admin');
            }
            break;
          case 4:
            if (!$this->adminCheck()) {
                $steps = 3;
            }else{
                $this->adminInstall();
            }
            break;
        }
        return  $steps;
    }
    /**
     * 数据库配置设置前的检查
     */
    public function databaseCheck()
    {
      if ($this->request->input('database_engine') != 'sqlite') {
          $this->repository->set('database.default',$this->request->input('database_engine'));
          $sql = '';
          switch ($this->request->input('database_engine')) {
              case 'mysql':
                  $this->repository->set('database.connections.mysql', [
                      'driver'    => 'mysql',
                      'host'      => $this->request->input('database_host'),
                      'database'  => $this->request->input('database_name'),
                      'username'  => $this->request->input('database_username'),
                      'password'  => $this->request->input('database_password'),
                      'charset'   => 'utf8',
                      'collation' => 'utf8_unicode_ci',
                      'prefix'    => $this->request->input('database_prefix'),
                      'port'      => $this->request->input('database_port') ?: 3306,
                      'strict'    => true,
                      'engine'    => null,
                  ]);
                  $sql = 'show tables';
                  break;
              case 'pgsql':
                  $this->repository->set('database.connections.pgsql', [
                      'driver'   => 'pgsql',
                      'host'     => $this->request->input('database_host'),
                      'database' => $this->request->input('database_name'),
                      'username' => $this->request->input('database_username'),
                      'password' => $this->request->input('database_password'),
                      'charset'  => 'utf8',
                      'prefix'   => $this->request->input('database_prefix'),
                      'port'     => $this->request->input('database_port') ?: 5432,
                      'schema'   => 'public',
                  ]);
                  $sql = "select * from pg_tables where schemaname='public'";
                  break;
          }
          try {
              $results = collect($this->container->make('db')->reconnect()->select($sql));
              if ($results->count()) {
                  $error = '数据库[' . $this->request->input('database_name') . ']已经存在数据表，请先清空数据库！';
              } else {
                  return true;
              }
          } catch (Exception $exception) {
              switch ($exception->getCode()) {
                  case 7:
                      $error = '数据库账号或密码错误，或数据库不存在！';
                      break;
                  case 1045:
                      $error = '数据库账号或密码错误！';
                      break;
                  case 1049:
                      $error = '数据库[' . $this->request->input('database_name') . ']不存在，请先创建数据库！';
                      break;
                  default:
                      $error = array_merge((array)$exception->getCode(), (array)$exception->getMessage());
                      break;
              }
          }
          $this->builderHtml->message([
                    'message'   => $error,
                    'type'      => 'error',
                ]);
          return false;
      }
    }
    public function databaseInstall()
    {
        $command = $this->install->getCommand('corecmf:install');
        $command->setSqlController($this->request->all());
        $setEnv = $command->setEnv();
        if ($setEnv) {
            $this->builderHtml->message([
                        'message'   => '数据库设置成功!',
                        'type'      => 'success',
                    ]);
        }
    }
    public function adminCheck()
    {
        try {
            $this->validate($this->request, [
                'admin_email'     => 'required',
                'admin_account' => 'required',
                'admin_password' => 'required',
                'admin_mobile' => 'required',
            ], [
                'admin_email.required'     => '必须填写管理员邮箱',
                'admin_account.required' => '必须填写管理员账户',
                'admin_password.required' => '必须填写管理员密码',
                'admin_mobile.required' => '必须填写管理员密码',
            ]);
            return true;
        } catch (Exception $exception) {
            $this->builderHtml->message([
                      'message'   => '输入的信息不符合后端要求',
                      'type'      => 'error',
                  ]);
            return false;
        }
    }
    public function adminInstall()
    {
        $command = $this->install->getCommand('corecmf:install');
        $command->setAdminController($this->request->all());
        $setEnv = $command->setAdmin();
        if ($setEnv) {
            $this->builderHtml->message([
                        'message'   => '设置管理员成功!',
                        'type'      => 'success',
                    ]);
        }
    }
}
