<?php

	include "Database.php";

	class Customer {

		// GET All Customer
		public static function getCustomer() {
			$sql 	= "SELECT * FROM customer";
			$stmt 	= DB::prepare($sql);
			$stmt->execute();

			$data = array();
			if ($stmt->rowCount() > 0) {
				
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					$sub_data = array();
					$sub_data["id"] 	= $row["id"];
					$sub_data["name"] 	= $row["name"];
					$sub_data["mobile"] = $row["mobile"];
					$sub_data["email"] 	= $row["email"];
					$data[] = $sub_data;
				}
				echo json_encode($data);
			} else {
				echo '{ "result": "No data found" }';
			}
		}

		// GET Customer by Customer ID
		public static function getCustomerByID($id) {

		}

		// CREATE Customer
		public static function createCustomer($data) {
			$sql = "INSERT INTO customer(name, mobile, email) VALUES (:name, :mobile, :email)";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(":name", 	$data['name']);
			$stmt->bindParam(":mobile", $data['mobile']);
			$stmt->bindParam(":email", 	$data['email']);
			$stmt->execute();
			if($stmt->rowCount() > 0){
				echo '{ "result": "Successfully Customer Created" }';
			}else{
				echo '{ "result": "Something wrong" }';
			}
		}

		// UPDATE Customer by Customer ID
		public static function updateCustomer($data) {
			$sql = "UPDATE `customer` SET `name`=:name, `mobile`=:mobile, `email`=:email WHERE `id` = :id";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(":name", 	$data['name']);
			$stmt->bindParam(":mobile", $data['email']);
			$stmt->bindParam(":email", 	$data['mobile']);
			$stmt->bindParam(":id", 	$data['id']);
			$stmt->execute();

			if($stmt->rowCount() > 0){
				echo '{ "result": "Successfully Customer Updated" }';
			}else{
				echo '{ "result": "Something wrong" }';
			}
		}

		// DELETE Customer by Customer ID
		public static function deleteCustomer($data) {
			$id 	= $data['id'];
			$sql 	= "DELETE FROM customer WHERE id = :id";
			$stmt 	= DB::prepare($sql);
			$stmt->bindParam(":id", $id);
			$stmt->execute();
			if($stmt->rowCount() > 0){
				echo '{ "result": "Successfully Customer Deleted" }';
			}else{
				echo '{ "result": "Something wrong" }';
			}
		}
	}


	header("content-type: application/json");
	$request = $_SERVER["REQUEST_METHOD"];
	
	switch($request) {
		case "GET":
			Customer::getCustomer();
			break;
		case "POST":
			$data = json_decode(file_get_contents('php://input'), true);
			Customer::createCustomer($data);
			break;
		case "PUT":
			$data = json_decode(file_get_contents('php://input'), true);
			Customer::updateCustomer($data);
			break;
		case "DELETE":
			$data = json_decode(file_get_contents('php://input'), true);
			Customer::deleteCustomer($data);
			break;
		case "PATCH":
			echo '{"Method": "PATCH"}';
			break;
		default:
			break;
	}



?>
