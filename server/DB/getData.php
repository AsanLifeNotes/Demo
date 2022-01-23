<?php
	function accountCheck($id, $pw){
		$conn = new mysqli("localhost", "getter", "getter", "demo");
		if($conn->connect_error){
			file_put_contents("../log.txt", "Connection failed: " . $conn->connect_error . "\n", FILE_APPEND);
		}else{
			$sql = "SELECT id, pw FROM `account` WHERE ID='".$id."' AND PW='".$pw."'";			
			$result = $conn->query($sql);		
			if($result->num_rows<1){ echo 0;}
			else{ echo 1; }
		}		
	}	
	function getBox($id){
		
	}	
?>