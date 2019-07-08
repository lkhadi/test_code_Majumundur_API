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

$data = json_decode(file_get_contents("php://input"));
$jwt = (isset($data->jwt) ? $data->jwt : "");
if($jwt){
	try{
		$decoded = JWT::decode($jwt,$key,array('HS256'));
		if($decoded->data->role=="customer"){
			$trans->id_product = $data->id_product;
			$trans->id_customer = $decoded->data->id;			
			if($trans->transaction()){
				if($trans->add_points()){
					http_response_code(200);
					echo json_encode(array("message" => "Successfull to buy products"));
				}else{
					http_response_code(200);
					echo json_encode(array("message" => "Successfull to buy products but did not receive points"));
				}
			}else{
				http_response_code(401);
				echo json_encode(array("message" => "Failed to buy products"));
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