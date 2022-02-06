<?php
	session_start();
	$obj = json_decode($_REQUEST["data"], false);
	switch($obj->remote){
		case "login":
			login($obj);
		break;
		case "register":
			register($obj);
		break;
		case "getGameData":
			getGameData();
		break;
	}
	
	function login($obj){		
		require_once("../manageDB/crud.php");		
		$check=getData("user_account",array("ID"=>$obj->id,"password"=>$obj->password));
		if(isset($check)==null){echo -1;}
		else{			
			$_SESSION["UID"]=$check["UID"];
			$_SESSION["ID"]=$check["ID"];
			$_SESSION["permission"]=$check["permission"];
			$dumpGameData = getData("user_personal_game_data",array("account_UID"=>$_SESSION["UID"]));
			foreach($dumpGameData as $k => $v){
				$_SESSION[$k]=$v;				
			}
			echo 1;
		}
	}
	
	function logout(){
	}
	
	function register($obj){		
		require_once("../manageDB/crud.php");		
		unset($obj->remote);				
		$check=getData("user_account",array("email"=>$obj->email));		
		if(isset($check)==null){
			$obj=(array)$obj;						
			echo addData("user_account",$obj);
			$res = getData("user_account",array("ID"=>$obj["ID"],"password"=>$obj["password"]));
			createCharater($res);
		}
		else{echo -1;}
	}
	
	function deleteAccount(){
		
	}

	function createCharater($obj){
		$box="{";
		for($i=1;$i<51;$i++){
			$box.="\"".$i."\": 0,";
		}
		$box = substr($box, 0, -1);			
		$box.="}";
		$list = array("account_UID"=>$obj["UID"],"coin"=>1000,"crystal"=>3000,"box_state"=>$box);
		addData("user_personal_game_data",$list);		
	}

	function getGameData(){		
		require_once("../manageDB/crud.php");
		echo json_encode(getData("user_personal_game_data",array("UID"=>$_SESSION["UID"])));
	}

?>

