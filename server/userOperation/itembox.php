<?php
    session_start();
	$obj = json_decode($_GET["data"], false);
	switch($obj->remote){
		case "getBox":
			getBox();
		break;
        case "extendBox":
            extendBox($obj);
        break;
	}
    function getBox(){
        require_once('../manageDB/crud.php');
        echo directlyCommand("SELECT * FROM `user_box` WHERE `account_UID`=".$_SESSION["UID"]);        
    }
    
    function extendBox($obj){        
        require_once('../manageDB/crud.php');
        $inventory = array("UID" => $_SESSION["UID"]);        
        $inventory += ["box_unlocked"=> $_SESSION["boxInfo"]["box_unlocked"]+$obj->numsOfOpen];
        $box = substr($obj->box_1,0,-1);           
        for($i=0;$i<$obj->numsOfOpen;$i++){            
            $n=intval($_SESSION["boxInfo"]["box_unlocked"])+$i;
            $box.=",\"box_".$n."\":0";            
        }
        $box.="}";
        $inventory+=["box_1"=>$box];         
        if(updateData("box",$inventory)){
            echo updateBox();
        }else{
            echo -1;
        }
    }
    function updateBox(){
        require_once('../manageDB/crud.php');
        $_SESSION["boxInfo"] = getData("user_personal_game_data",array("account_UID"=>$_SESSION['UID']));
        return 1;
    }

?>