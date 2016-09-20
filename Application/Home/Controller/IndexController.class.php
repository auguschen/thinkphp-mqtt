<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
//         $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div>','utf-8');
// 		echo "建设中...";
		$name='Your Name';
		$this->assign('username',$name);
		$this->display();
    }
	public function i(){
		echo "Time: " . NOW_TIME . "<br/>";
		echo "Public Path: " . __PUBLIC__ . "<br/>";
		echo "ROOT: " . __ROOT__ . "<br/>";
		echo "APP: " . __APP__ . "<br/>";
		echo "MODULE: " . __MODULE__ . "<br/>";
		echo "CONTROLLER: " . __CONTROLLER__ . "<br/>";
		echo "ACTION: " . __ACTION__ . "<br/>";
		echo "SELF: " . __SELF__ . "<br/>";
		echo "INFO: " . __INFO__ . "<br/>";
		echo "EXT: " . __EXT__ . "<br/>";
//		phpinfo();
	}
}
