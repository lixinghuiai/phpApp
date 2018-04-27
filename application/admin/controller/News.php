<?php
namespace app\admin\controller;

use think\Controller;

class News extends Base
{
    public function index()
    {
        
        echo '21';
    }

    public function add() {
       if(request()->isPost()){
           $data= input('post.');
           //入库操作
           try{
             $id=  model('News')->add($data);
           }catch(\Exception $e){
               return $this->result('',0,'新增失败');
           }
           if($id){
               return $this->result(['jump_url'=>url('news/index')],1,'OK');
           }else{
            return $this->result('',0,'失败');
           }
       }else{
        return $this->fetch('', [
            'cats' => config('cat.lists')
        ]);
       }
       
        
    }
    
}
