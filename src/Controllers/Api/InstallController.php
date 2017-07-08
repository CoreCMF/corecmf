<?php

namespace CoreCMF\corecmf\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InstallController extends Controller
{
    public function index(Request $Request)
    {
      $rules = [
          'username'=> [
              ['required' => true,  'message' => '请输入用户名/手机/邮箱', 'trigger'=> 'blur'],
          ],
          'password'=> [
              [ 'required'=> true, 'message'=> '请输入账户密码', 'trigger'=> 'blur' ],
          ],
      ];
      $stepsTitle = ['用户协议','检测环境','数据库设置','账户设置','安装完成'];
      $form = resolve('builderForm')
              ->item(['name' => 'steps',      'type' => 'steps',   'title'=>$stepsTitle])
              ->item(['name' => 'agreement',  'type' => 'scrollbar', 'value' => config('corecmf.agreement'),])
              ->item(['name' => 'password',   'type' => 'password',    'placeholder' => '请输入账户密码'])
              // ->rules($rules)
              ->apiUrl('submit',route('api.admin.auth.login'))
              ->config('formStyle',['padding'=>'20px 10px' ])
              ->config('formSubmit',[ 'name'=>'登陆', 'style'=> ['width'=>'100%'] ])
              ->config('formReset',['style'=> ['display'=>'none'] ])
              ->config('labelWidth','0');
      $html = resolve('builderHtml')
                ->title('系统安装')
                ->item($form)
                ->response();
      return $html;
    }
}
