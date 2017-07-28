<?php

namespace CoreCMF\corecmf\Validator;

use CoreCMF\core\Support\Validator\Rules as coreRules;
class InstallRules extends coreRules
{
    public function admin(){
        $this->mobile('请输入管理员手机号码');
        return [
            'admin_account'=> [
                ['required' => true,  'message' => '请输入管理员账号', 'trigger'=> 'blur'],
                [ 'min' => 4, 'max' => 16, 'message' => '长度在 4 到 16 个字符', 'trigger' => 'blur' ]
            ],
            'admin_password'=> [
                [ 'required'=> true, 'message'=> '请输入管理员密码', 'trigger'=> 'blur' ],
                [ 'min' => 6, 'max' => 16, 'message' => '长度在 6 到 16 个字符', 'trigger' => 'blur' ]
            ],
            'admin_email'=> [
                ['required' => true,  'message' => '请输入管理员邮箱', 'trigger'=> 'blur'],
                [ 'type' => 'email', 'message' => '请输入正确的邮箱地址', 'trigger' => 'blur,change' ]
            ],
            'admin_mobile'=> [
                [ 'required'=> true, 'validator'=> $this->mobile,'trigger'=> 'blur' ]
            ],
        ];
    }
    public function database(){
        return [
            'sitename'=> [
                ['required' => true,  'message' => '请输入网站名称', 'trigger'=> 'blur']
            ],
            'database_engine'=> [
                [ 'required'=> true, 'message'=> '请选择数据库引擎', 'trigger'=> 'blur' ]
            ],
            'database_host'=> [
                ['required' => true,  'message' => '请输入数据库地址', 'trigger'=> 'blur']
            ],
            'database_port'=> [
                [ 'required'=> true, 'message'=> '请输入数据库端口', 'trigger'=> 'blur' ]
            ],
            'database_name'=> [
                ['required' => true,  'message' => '请输入数据库名称', 'trigger'=> 'blur']
            ],
            'database_username'=> [
                [ 'required'=> true, 'message'=> '请输入数据库用户名', 'trigger'=> 'blur' ]
            ],
            'database_password'=> [
                ['required' => true,  'message' => '请输入数据库密码', 'trigger'=> 'blur']
            ],
        ];
    }
}
