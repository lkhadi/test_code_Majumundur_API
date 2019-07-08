<?php 
header("Access-Control-Allow-Origin: http://localhost/majumundur_api/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once 'config/DB_Connect.php';
include_once 'objects/Transactions.php';
include_once 'config/auth.php';
require __DIR__.'/libs/vendor/autoload.php';
use Firebase\JWT\JWT;
$db = new DB_Connect();
$trans = new Transactions($db->connect());
$token = json_decode(file_get_contents("php://input"));
$jwt = (isset($token->jwt) ? $token->jwt : "");
if($jwt){
	try{
		$decoded = JWT::decode($jwt,$key,array('HS256'));
		if($decoded->data->role=="merchant"){
			$trans->id_merchant = $decoded->data->id;
			$data=$trans->my_customer();			
			if($data){
				http_response_code(200);
				echo json_encode(array("data" => $data));
			}else{
				http_response_code(401);
				echo json_encode(array("message" => "Failed to show customers"));
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