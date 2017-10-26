<?php
namespace app\index\controller;
use app\config\model\menggu;
use \think\Request;
use think\Controller;
use \think\View;
class Index extends Controller {
    public function index(){
//        return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
        return view('index');
    }
    public function select_json(){
        $content = Request::instance()->get('content','');
        if ($content == ''){
            echo 'queryList({"q":"","p":false,"bs":"","csor":"0","status":770,"s":[]});';
        }else{
            $ladin = array('like',$content.'%');
            $allcn = preg_match("/^[".chr(0xa1)."-".chr(0xff)."]+$/",$content[0]);
//            $where = array();
            $menggu_model = new menggu();
            if ($allcn){
                $where['ciyu'] = $ladin;
                $list = $menggu_model->get_Cmdic1List($where);
                $text = '';
                foreach ($list as $item) {
                    $text = $text.'"'.$item['ciyu'].'",';
                }
            } else {
                $where['ladin'] = $ladin;
                $list = $menggu_model->get_Cmdic1List($where);
                $text = '';
                foreach ($list as $item) {
                    $text = $text.'"'.$item['ladin'].'",';
                }
            }

            echo 'queryList({q:"123",p:false,s:['.$text.']});';
        }
    }
    public function select_show(){

        $content = Request::instance()->get('content','');
        $allcn = preg_match("/^[".chr(0xa1)."-".chr(0xff)."]+$/",$content[0]);
        if ($allcn){
            $where['ciyu'] = $content;
        } else {
            $where['ladin'] = $content;
        }
        $menggu_model = new menggu();
        $list = $menggu_model->get_Cmdic1Info($where);
        $this->assign('list',$list);
        return view('show');
    }

}
