<?php 
header("Access-Control-Allow-Origin: http://localhost/majumundur_api/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once 'config/DB_Connect.php';
include_once 'objects/User.php';
$db = new DB_Connect();
$user = new User($db->connect());

$data = json_decode(file_get_contents("php://input"));
$user->username = $data->username;
$username_exists = $user->check_user();

include_once 'config/auth.php';
require __DIR__ . '/libs/vendor/autoload.php';
use \Firebase\JWT\JWT;

if($username_exists && password_verify($data->password, $user->password)){
	$token = array(
		"iss" => $iss,
		"aud" => $aud,
		"iat" => $iat,
		"nbf" => $nbf,
		"data" => array(
				"id" => $user->id,
				"fullname" => $user->fullname,
				"username" => $user->username,
				"role" => $user->role
			)
	);
	http_response_code(200);

	$jwt = JWT::encode($token,$key);

	echo json_encode(array(
		"Message" => "Successful Login",
		"jwt" => $jwt
	));
}else{
	http_response_code(401);
	echo json_encode(array("message"=>"Login failed"));
}
?>