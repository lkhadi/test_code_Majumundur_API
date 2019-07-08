<?php 
class User{
	private $conn;
	private $table = "users";
	public $id;
	public $fullname;
	public $username;
	public $password;
	public $role;

	function __construct($db){
		$this->conn = $db;
	}

	function create(){
		$this->fullname = htmlspecialchars(strip_tags($this->fullname));
		$this->username = htmlspecialchars(strip_tags($this->username));
		$this->password = htmlspecialchars(strip_tags($this->password));
		$this->role = htmlspecialchars(strip_tags($this->role));
		$this->password = password_hash($this->password, PASSWORD_DEFAULT);
		$query = "INSERT INTO ".$this->table." (fullname,username,password,role) VALUES ('".$this->fullname."','".$this->username."','".$this->password."','".$this->role."')";
		if(mysqli_query($this->conn,$query)){
			return true;
		}else{
			return false;
		}
	}

	function check_user(){
		$this->username = htmlspecialchars(strip_tags($this->username));
		$query = "SELECT * FROM ".$this->table." WHERE username='".$this->username."'";
		if($data = mysqli_query($this->conn,$query)){
			$get_data = mysqli_fetch_array($data);
			$this->id = $get_data['id'];
			$this->fullname = $get_data['fullname'];
			$this->username = $get_data['username'];
			$this->password = $get_data['password'];
			$this->role = $get_data['role'];
			return true;
		}else{
			false;
		}
	}
}
?>