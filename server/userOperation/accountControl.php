<?php
	function login(){
		require_once('DB/getData.php');
		$id = $_GET["id"];
		$pw = $_GET["pw"];			
		echo accountCheck($id,$pw);
	}
	
	function logout(){
	}
	
	function register(){
	}
	
	function deleteAccount(){
	}
?>
