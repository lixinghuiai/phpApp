<?php
namespace app\admin\controller;
use think\Controller;
//后台基础类
class Base extends Controller
{
    //初始化方法
    public function _initialize()
    {
        //判断登录
          $isLogin = $this->isLogin();
          if(!$isLogin){
          return $this->redirect('login/index');
          }
     }
     public function isLogin(){
         $user = session(config('admin.session_user'),'',config('admin.session_user_scope'));
         if($user && $user->id){
            return true;
         }else{
            return false;
         }
        
     }
}
