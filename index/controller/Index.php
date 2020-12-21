<?php
namespace app\index\controller;

use app\index\model\Article;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return Article::select();
    }
//    收藏接口开发
    public function coll(){
//        接收参数
        $id=input('id');
        $user_id=input('user_id');
//        验证传过来的id是否为纯数字
        if (!is_numeric($id)){
            return json(['code'=>403,'msg'=>'参数格式不正确','data'=>null]);
        }
        if (!is_numeric($user_id)){
            return json(['code'=>403,'msg'=>'参数格式不正确','data'=>null]);
        }
        $coll=Article::where('id',$id)
            ->where('user_id',$user_id)
            ->value('article_coll');
//        如果用户重复点击收藏，那么就提示用户已经收藏过了
        if($coll==1){
            return json(['code'=>403,'msg'=>'对不起您已经收藏过了','data'=>null]);
        }
        $num=Article::where('id',$id)
            ->where('user_id',$user_id)
            ->value('article_num');
        $a=$num+1;
//        根据接收过来的参数当前用户点击收藏
//        用户收藏那一列为1表示已收藏
//        还要修改收藏总数加一
        $data=Article::update(['article_coll'=>1,'article_num'=>$a],['id'=>$id,'user_id'=>$user_id]);
        if($data){
            return json(['code'=>200,'msg'=>'已收藏','data'=>$id]);
        }else{
            return json(['code'=>403,'msg'=>'收藏失败','data'=>null]);
        }
    }
}
