<?php
class Transactions{
	private $conn;
	private $table="transactions";
	private $table2="points";
	public $id_trans;
	public $id_customer;
	public $id_product;
	public $id_points;
	public $id_merchant;
	public $points;
	public $date_trans;

	function __construct($db){
		$this->conn = $db;
	}

	function transaction(){
		$this->id_customer = htmlspecialchars(strip_tags($this->id_customer));
		$this->id_product = htmlspecialchars(strip_tags($this->id_product));
		$this->date_trans = date('Y-m-d');
		$query = "INSERT INTO ".$this->table." (id_customer,id_product,date_trans) VALUES (".$this->id_customer.",".$this->id_product.",'".$this->date_trans."')";
		if(mysqli_query($this->conn,$query)){
			return true;
		}else{
			return false;
		}
	}

	function add_points(){
		$query2 = "SELECT points FROM ".$this->table2." WHERE id_customer=".$this->id_customer;
		if(mysqli_num_rows(mysqli_query($this->conn,$query2))>0){
			$data = mysqli_fetch_array(mysqli_query($this->conn,$query2));
			$this->points = $data['points']+1;
			$query3 = "UPDATE ".$this->table2." SET points=".$this->points." WHERE id_customer=".$this->id_customer;
			if(mysqli_query($this->conn,$query3)){
				return true;
			}else{
				return false;
			}
		}else{
			$this->points=1;
			$query3 = "INSERT INTO ".$this->table2." (points,id_customer) VALUES (".$this->points.",".$this->id_customer.")";
			if(mysqli_query($this->conn,$query3)){
				return true;
			}else{
				return false;
			}
		}		
	}

	function my_customer(){
		$query = "SELECT u.fullname as customer, p.name as product,t.date_trans as transaction FROM transactions t JOIN products p ON t.id_product=p.id JOIN users u ON u.id=t.id_customer WHERE p.id_merchant=".$this->id_merchant;
		$data = mysqli_query($this->conn,$query);
		if($data){
			$i=0;
			$customer = array();
			while($get_data = mysqli_fetch_array($data)){
				$customer[$i]['customer'] = $get_data['customer'];
				$customer[$i]['product'] = $get_data['product'];
				$customer[$i]['transaction'] = $get_data['transaction'];
				$i++;
			}
			return $customer;
		}else{
			return false;
		}
	}
}
?>