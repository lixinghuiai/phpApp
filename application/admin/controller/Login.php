<?php
namespace app\admin\controller;
use app\common\validate\AdminUser;
use think\Controller;
use app\common\lib\IAuth;
class Login extends Base
{
    //覆盖base中初始化方法
    public function _initialize()
    {

    }
    public function index()
    {
        $isLogin = $this->isLogin();
        if($isLogin) {
            return $this->redirect('index/index');
        }else {
            // 如果后台用户已经登录了， 那么我们需要跳到后台页面
            return $this->fetch();
        }
    }
     
     public function check() {

       if(request()->isPost()){
        $data = input('post.');
         //校对验证码
         if(!captcha_check($data['code'])){
            $this->error('验证码不正确');
            //validate
        }


            try{
                $user = model('AdminUser')->get(['username'=>$data['username']]);
            }catch(\Exception $e){
                $this->error($e->getMessage());
            }
            if(!$user|| $user->status != 1){
                $this ->error('用户不存在');
            }
            if(IAuth::setPassword($data['password'])!= $user['password']){
                $this ->error('密码不正确');
            }
            //1  更新数据库 登录时间 ip2long
            $udata=[
                'last_login_time' => time(),
                'last_login_ip' =>request()->ip(),
            ];
            try{
            model('AdminUser')->save(
                $udata,['id'=>$user->id]
            );
        }catch(\Exception $e){
            $this->error($e->getMessage());
        }


        //2 session

          session(config('admin.session_user'),$user,config('admin.session_user_scope'));
          $this->success('登陆成功','index/index');
       }else{
        $this->error('请求不合法');
    }


    }
    public function logout(){
        session(null,config('admin.session_user_scope'));
        $this->redirect('login/index');
    }
}
