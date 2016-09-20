<?php
namespace Home\Controller;
use Think\Controller;
use Org\phpMQTT;

class MQTTController extends Controller {
// 	首页
	public function index() {
		$this->display();
	}
// 	列表处理后消息
	public function listmesg() {
		$this->display();
	}
	
// 	send a message from url. usr GET method. and for screnn output only.
	public function newmesg() {
		vendor('MQTT.phpMQTT');
		$topic = $_GET["t"];
		$message = $_GET['m'];
		$client_id = $_GET['cl'];
		
		$MQTT_Message = array();
		$payload = array();
		
		$MQTT_Message['isSuccessful'] = True;
		$MQTT_Message['errorMessage'] = "";
		
		if (isset($client_id)){
			if (empty($client_id)){
				$client_id = C('MQTT_CLIENT_ID');
			}
		}else{
			$client_id = C('MQTT_CLIENT_ID');
		}
		$MQTT_Message['client_id'] = $client_id;
				
		if (isset($topic)){
			if (empty($topic)){
				$topic = "tmp";
			}
		}else{
			$topic = "tmp";
		}
		$MQTT_Message['topic'] = $topic;
				
		if (isset($message)){
			if (empty($message)){
				srand(mktime());
				$message = "auto message with random number: " . rand();
			}
		}else{
				srand(mktime());
			$message = "auto message with random number: " . rand();
		}
		$MQTT_Message['message'] = $message;

		$payload["client_id"]  = $client_id;
		$payload["message"] = $message;
		$payload["topic"] = $topic;
		$payload["message_datetime"] = date("Y-m-d H:i:s");
		
		
		try {
			$mqttclient = new \phpMQTT(C('MQTT_HOST'),C('MQTT_PORT'),$client_id);
			
			if ($mqttclient->connect()) {
				$mqttclient->publish(c('MQTT_INPUT_TOPIC_PREFIX')."/".$topic, json_encode($payload));
				$mqttclient->close();
			}
		} catch (Exception $e) {
			$MQTT_Message['isSuccessful'] = False;
			$MQTT_Message['errorMessage'] = $e->getMessage();
			
		}

		$this->assign("retData",$MQTT_Message);		
		$this->display();
		
	} 
	
// 	send a message from from. use POST method
	public function send() {
		vendor('MQTT.phpMQTT');
		
		$topic = $_POST["topic"];
		$message = $_POST["message"];
		$client_id = $_POST["client_id"];
		$message_datetime = $_POST["message_datetime"];
		
		$MQTT_Message = array();
		$payload = array();
		
		$MQTT_Message['isSuccessful'] = True;
		$MQTT_Message['errorMessage'] = "";
		
		if (isset($client_id)){
			if (empty($client_id)){
				$client_id = C('MQTT_CLIENT_ID');
			}
		}else{
			$client_id = C('MQTT_CLIENT_ID');
		}
		$MQTT_Message['client_id'] = $client_id;
				
		if (isset($topic)){
			if (empty($topic)){
				$topic = "tmp";
			}
		}else{
			$topic = "tmp";
		}
		$MQTT_Message['topic'] = $topic;
				
		if (isset($message)){
			if (empty($message)){
				srand(mktime());
				$message = "auto message with random number: " . rand();
			}
		}else{
				srand(mktime());
			$message = "auto message with random number: " . rand();
		}
		
		$MQTT_Message['message'] = $message;
		
		$payload["client_id"]  = $client_id;
		$payload["message"] = $message;
		$payload["topic"] = $topic;
		$payload["message_datetime"] = $message_datetime;

		try {
			$mqttclient = new \phpMQTT(C('MQTT_HOST'),C('MQTT_PORT'),$client_id);
			
			if ($mqttclient->connect()) {
				$mqttclient->publish(c('MQTT_INPUT_TOPIC_PREFIX')."/".$topic, json_encode($payload));
				$mqttclient->close();
			
			}
		} catch (Exception $e) {
			$MQTT_Message['isSuccessful'] = False;
			$MQTT_Message['errorMessage'] = $e->getMessage();
				
		}
		$this->ajaxReturn(json_encode($MQTT_Message),'JSON');
	}
	
// 	列表主题，返回JSON
	public function topics() {
// 		$topic_pattern = $_POST["topic_pattern"];
		$returnArray = array();
		$returnArray["isSuccessful"] = True;
		$returnArray["errorMessage"] = "";
		try {
			$returnArray["res"] = M("Topics")->where("substr(topic,1,1)!='$'")->order("id")->select();
		} catch (Exception $e){
			$returnArray["isSuccessful"] = False;
			$returnArray["errorMessage"] = $e->getMessage();
			$returnArray["res"] = NULL;
		}
		$this->ajaxReturn(json_encode($returnArray),'JSON');
		
	}
	
// 	列表原始消息，返回JSON
	public function rawmessages(){
		$cnt = $_POST["cnt"];
		if (isset($cnt)) {
			if (empty($cnt)) {
				$cnt = 10;
			}
		} else {
			$cnt = 10;
		}
		$returnArray = array();
		$returnArray["isSuccessful"] = True;
		$returnArray["errorMessage"] = "";
		try {
			$returnArray["res"] = M("Rawmessages")->order("id desc")->limit($cnt)->select();
		} catch (Exception $e){
			$returnArray["isSuccessful"] = False;
			$returnArray["errorMessage"] = $e->getMessage();
			$returnArray["res"] = NULL;
		}
		$this->ajaxReturn(json_encode($returnArray),'JSON');
	}
	
	public function messages(){
		$cnt = $_POST["cnt"];
		if (isset($cnt)) {
			if (empty($cnt)) {
				$cnt = 10;
			}
		} else {
			$cnt = 10;
		}
		$returnArray = array();
		$returnArray["isSuccessful"] = True;
		$returnArray["errorMessage"] = "";
		try {
			$returnArray["res"] = M("Messages")->order("id desc")->limit($cnt)->select();
		} catch (Exception $e){
			$returnArray["isSuccessful"] = False;
			$returnArray["errorMessage"] = $e->getMessage();
			$returnArray["res"] = NULL;
		}
		$this->ajaxReturn(json_encode($returnArray),'JSON');
	}
	
// 	新增频道页面
	public function newtopic(){
		$this->display();
	}
	
// 	注册用户页面
	public function registeuser(){
		$this->display();
	}
	
// 	参数管理页面
	public function params(){
		$this->display();
	}
	
// 	新建、更新用户等等操作
	public function users(){
		$act = $_POST['action'];
		
		$returnArray = array();
		$returnArray["isSuccessful"] = false;
		
		switch ($act){
			case "new":
				{
					$userdata['username'] = $_POST['username'];
					$userdata['nickname'] = $_POST['username'];
					$userdata['password'] = md5($_POST['password']);
					$userdata['valid'] = true;
					try {
						$User = M("User");
						$map['username'] = $_POST['username'];
						$u_in_db = $User->where($map)->find();
						if ($u_in_db === false) {
							$returnArray["errorMessage"] = "query error.";
						} else {
							if (is_null($u_in_db)){
								$newuser = $User->create($userdata);
								$User->add();
								$returnArray['res'] = $newuser;
								$returnArray['isSuccessful'] = true;
							} else {
								$returnArray["errorMessage"] = "user exist.";
								$returnArray["u_in_db"] = $u_in_db;
							}
						}
					} catch (Exception $e) {
						$returnArray["errorMessage"] = $e->getMessage();
					}
				}
				break;
			case "modi":
				{
				}
				break;
			default:
				{
					$returnArray["errorMessage"] = "No Action !";
				}
		}
		
		$this->ajaxReturn(json_encode($returnArray),'JSON');
	}
	
// 	参数设置操作
	public function modifyparams(){
		
	}
}

