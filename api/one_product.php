<?php 
header("Access-Control-Allow-Origin: http://localhost/majumundur_api/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once 'config/DB_Connect.php';
include_once 'objects/Product.php';

$db = new DB_Connect();
$product = new Product($db->connect());
$data = json_decode(file_get_contents("php://input"));
$product->id = $data->id;
$show = $product->show_a_product();
if($show){
	http_response_code(200);
	echo json_encode(array("data"=>$show));
}else{
	http_response_code(401);
	echo json_encode(array("message"=>"no products available"));
}
?>