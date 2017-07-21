<?php

namespace CoreCMF\corecmf\Validator;

use CoreCMF\core\Support\Validator\Rules as coreRules;
class Rules extends coreRules
{
    public function admin(){
        $adminMobile = $this->mobile('请输入管理员手机号码');
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
                [ 'required'=> true, 'validator'=> $adminMobile,'trigger'=> 'blur' ]
            ],
        ];
    }
}
