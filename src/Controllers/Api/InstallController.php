<?php

namespace CoreCMF\corecmf\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InstallController extends Controller
{
    public function index(Request $Request)
    {
      $steps = 0;
      $stepsTitle = ['用户协议','检测环境','数据库设置','账户设置','安装完成'];
      $form = resolve('builderForm')
              ->item(['name' => 'steps',      'type' => 'steps',   'title'=>$stepsTitle, 'active'=>$steps])
              ->apiUrl('submit',route('api.install.index'))
              ->config('formStyle',['padding'=>'20px 10px' ])
              ->config('labelWidth','0');
      switch ($steps) {
        case 0:
          $form = $this->steps0($form);
          break;
        case 1:
          $form = $this->steps1($form);
          break;
        case 2:
          $form = $this->steps2($form);
          break;
        case 3:
          $form = $this->steps3($form);
          break;
        case 4:
          $form = $this->steps4($form);
          break;
        case 5:
          $form = $this->steps5($form);
          break;
      }
      $html = resolve('builderHtml')
                ->title('系统安装')
                ->item($form)
                ->response();
      return $html;
    }
    public function steps0($form){
        $form->item(['name' => 'agreement',  'type' => 'scrollbar', 'value' => config('corecmf.agreement'),])
             ->item(['name' => 'password',   'type' => 'password',    'placeholder' => '0']);
        return $form;
    }
    public function steps1($form){
        $form->item(['name' => 'agreement',  'type' => 'scrollbar', 'value' => config('corecmf.agreement'),])
             ->item(['name' => 'password',   'type' => 'password',    'placeholder' => '1']);
        return $form;
    }
    public function steps2($form){
        $form->item(['name' => 'agreement',  'type' => 'scrollbar', 'value' => config('corecmf.agreement'),])
             ->item(['name' => 'password',   'type' => 'password',    'placeholder' => '2']);
        return $form;
    }
    public function steps3($form){
        $form->item(['name' => 'agreement',  'type' => 'scrollbar', 'value' => config('corecmf.agreement'),])
             ->item(['name' => 'password',   'type' => 'password',    'placeholder' => '3']);
        return $form;
    }
    public function steps4($form){
        $form->item(['name' => 'agreement',  'type' => 'scrollbar', 'value' => config('corecmf.agreement'),])
             ->item(['name' => 'password',   'type' => 'password',    'placeholder' => '4']);
        return $form;
    }
    public function steps5($form){
        $form->item(['name' => 'agreement',  'type' => 'scrollbar', 'value' => config('corecmf.agreement'),])
             ->item(['name' => 'password',   'type' => 'password',    'placeholder' => '5']);
        return $form;
    }
}
