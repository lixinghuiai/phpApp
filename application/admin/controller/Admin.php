<?php
namespace app\admin\controller;
use think\Controller;

class Admin extends Controller
{
    public function add()
    {    //判断post
        if(request()->isPost()){
        //打印  halt() = dump();exit;
       // dump(input('post.'));
       $data=input('post.');
     
       $validate= validate('AdminUser');
// dump($validate);
       if(!$validate->check($data)){
           $this->error($validate->getError());
       }
            $data['password'] = md5($data['password'].'_#sing_ty');
            $data['status'] =1;
            try{
               $id = model('AdminUser')->add($data);
            }catch(\Exception $e){
                  $this->error($e->getMessage());
            }
           if($id){
               $this->success('id='.$id.'用户 新增成功');
           }else{
               $this->error('error');
           }

        //validate
        }else{
            return $this->fetch();
        }
        
     }
    
}
