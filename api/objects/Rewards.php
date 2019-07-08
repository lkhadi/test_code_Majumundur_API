<?php 
Class Rewards{
	private $conn;
	public $id_customer;
	public $points;
	function __construct($db){
		$this->conn = $db;
	}

	function check_points(){
		$query = "SELECT points FROM points WHERE id_customer=".$this->id_customer;
		$query = mysqli_query($this->conn,$query);
		if($query){
			$data = mysqli_fetch_array($query);
			return $data['points'];
		}else{
			return false;
		}	

	}

	function update_points(){
		$query = "UPDATE points SET points=".$this->points." WHERE id_customer=".$this->id_customer;
		$query = mysqli_query($this->conn,$query);
		if($query){
			return true;
		}else{
			return false;
		}	
	}

}
?>