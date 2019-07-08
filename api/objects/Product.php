<?php 
class Product{
	private $conn;
	private $table = "products";
	public $id;
	public $name;
	public $price;
	public $id_merchant;

	function __construct($db){
		$this->conn = $db;
	}

	function post_product(){
		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->price = htmlspecialchars(strip_tags($this->price));
		$this->id_merchant = htmlspecialchars(strip_tags($this->id_merchant));
		$query = "INSERT INTO ".$this->table." (name,price,id_merchant) VALUES ('".$this->name."','".$this->price."','".$this->id_merchant."')";
		if(mysqli_query($this->conn,$query)){
			return true;
		}else{
			return false;
		}
	}

	function delete_product(){
		$this->id = htmlspecialchars(strip_tags($this->id));
		$this->id_merchant = htmlspecialchars(strip_tags($this->id_merchant));
		$query1 = "SELECT * FROM ".$this->table." WHERE id=".$this->id." AND id_merchant=".$this->id_merchant;		
		$check = mysqli_num_rows(mysqli_query($this->conn,$query1));
		if($check>0){
			$query2 = "DELETE FROM ".$this->table." WHERE id=".$this->id." AND id_merchant=".$this->id_merchant;
			if(mysqli_query($this->conn,$query2)){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	function update_product(){
		$this->id = htmlspecialchars(strip_tags($this->id));
		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->price = htmlspecialchars(strip_tags($this->price));
		$this->id_merchant = htmlspecialchars(strip_tags($this->id_merchant));		
		$query1 = "SELECT * FROM ".$this->table." WHERE id=".$this->id." AND id_merchant=".$this->id_merchant;		
		$check = mysqli_num_rows(mysqli_query($this->conn,$query1));
		if($check>0){
			$query2 = "UPDATE ".$this->table." SET name='".$this->name."', price='".$this->price."' WHERE id=".$this->id." AND id_merchant=".$this->id_merchant;
			if(mysqli_query($this->conn,$query2)){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	function show_products(){	
		$query = "SELECT p.id,p.name,p.price,u.fullname AS merchant FROM ".$this->table." p JOIN users u ON p.id_merchant=u.id WHERE u.role='merchant'";
		if($data = mysqli_query($this->conn,$query)){
			$sp = array();
			$i=0;
			while($d = mysqli_fetch_array($data)){
				$sp[$i]['id'] = $d['id'];
				$sp[$i]['name'] = $d['name'];
				$sp[$i]['price'] = $d['price'];
				$sp[$i]['merchant'] = $d['merchant'];
				$i++;
			}
			return $sp;
		}else{
			return false;
		}
	}

	function show_a_product(){
		$this->id = htmlspecialchars(strip_tags($this->id));
		$query = "SELECT p.id,p.name,p.price,u.fullname AS merchant FROM ".$this->table." p JOIN users u ON p.id_merchant=u.id WHERE u.role='merchant' AND p.id=".$this->id;
		if($data = mysqli_query($this->conn,$query)){
			$sp = array();
			$i=0;
			while($d = mysqli_fetch_array($data)){
				$sp[$i]['id'] = $d['id'];
				$sp[$i]['name'] = $d['name'];
				$sp[$i]['price'] = $d['price'];
				$sp[$i]['merchant'] = $d['merchant'];
				$i++;
			}
			return $sp;
		}else{
			return false;
		}
	}
}
?>