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
$user->fullname = $data->fullname;
$user->username = $data->username;
$user->password = $data->password;
$user->role = $data->role;

if(!empty($user->fullname) && !empty($user->username) && !empty($user->password) && !empty($user->role) && $user->create()){
	http_response_code(200);
	echo json_encode(array("message" => "Account successfully created"));
}else{
	http_response_code(400);
	echo json_encode(array("message"=> "Unable to create account"));
}
?>