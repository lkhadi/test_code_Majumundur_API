<?php 
header("Access-Control-Allow-Origin: http://localhost/majumundur_api/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once 'config/DB_Connect.php';
include_once 'objects/Rewards.php';
include_once 'config/auth.php';
require __DIR__.'/libs/vendor/autoload.php';
use Firebase\JWT\JWT;
$db = new DB_Connect();
$reward = new Rewards($db->connect());

$data = json_decode(file_get_contents("php://input"));
$jwt = (isset($data->jwt) ? $data->jwt : "");
if($jwt){
	try{
		$decoded = JWT::decode($jwt,$key,array('HS256'));
		if($decoded->data->role=="customer"){
			$reward->id_customer = $decoded->data->id;			
			if($data->rewards==="A"){
				if($reward->check_points()){
					if($reward->check_points()>0 && $reward->check_points()>20){
						$reward->points = $reward->check_points()-20;
						$reward->update_points();
						http_response_code(200);
						echo json_encode(array("message" => "Successfull to buy reward A","points remaining" => $reward->points));
					}else{
						http_response_code(401);
						echo json_encode(array("message" => "You don't have enough points"));
					}
				}else{
					http_response_code(401);
					echo json_encode(array("message" => "You don't have enough points"));
				}
			}elseif($data->rewards==="B"){
				if($reward->check_points()){
					if($reward->check_points()>0 && $reward->check_points()>40){
						$reward->points = $reward->check_points()-40;
						$reward->update_points();
						http_response_code(200);
						echo json_encode(array("message" => "Successfull to buy reward B","points remaining" => $reward->points));
					}else{
						http_response_code(401);
						echo json_encode(array("message" => "You don't have enough points"));
					}
				}else{
					http_response_code(401);
					echo json_encode(array("message" => "You don't have enough points"));
				}
			}else{
				http_response_code(401);
				echo json_encode(array("message" => "Select rewards!"));
			}
		}else{
			http_response_code(401);
			echo json_encode(array("message" => "Access Denied"));
		}
	}catch(Exception $e){
		http_response_code(401);
		echo json_encode(array("message" => "Access Denied","error" => $e->getMessage()));
	}
}else{
	http_response_code(401);
	echo json_encode(array("message" => "Access Denied"));
}
?>