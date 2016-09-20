<?php
namespace Home\Controller;
use Think\Controller;

class UpdateWebController extends Controller {
	public function index(){
// 		echo "App Path: " . APP_PATH . "<br/>";
// 		echo "Think Path: " . THINK_PATH . "<br/>";
// 		echo $_SERVER["DOCUMENT_ROOT"] . "<br/>";
// 		echo "ROOT: " . __ROOT__ . "<br/>";
		$this->display();
	}
	
	public function update() {
		$doc_root = $_SERVER['DOCUMENT_ROOT'];
		$cmd = $doc_root . "/gitpullweb.sh";
		$a = exec($cmd,$out,$status);
		echo "return Code: " . $status;
		echo "<br/>";
		if ($status == 127) {
			echo "Updated!";
		} else {
			echo "Something Wrong!";
		}
	}
	
	public function updateweb() {
		$doc_root = $_SERVER['DOCUMENT_ROOT'];
		$cmd = $doc_root . "/gitpullweb.sh";
		$a = exec($cmd,$out,$status);
		echo $status;
		
// 		echo "return Code: " . $status;
// 		echo "<br/>";
// 		if ($status == 127) {
// 			echo "Updated!";
// 		} else {
// 			echo "Something Wrong!";
// 		}
		
	}
}