<?php
namespace app\common\lib;

class IAuth {
    public static function setPassword($data){
        return md5($data.config('app.password_pre'));
    }
}
