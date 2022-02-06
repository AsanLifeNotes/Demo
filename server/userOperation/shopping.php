<?php
    session_start();
	$obj = json_decode($_REQUEST["data"], false);
	switch($obj->remote){
		case "getStore":
			getStore($obj);
		break;
		case "updateStore":
			updateStore($obj);
		break;
		case "initStore":
			initStore($obj);
		break;
	}

    function getStore($obj){
        require_once("../manageDB/crud.php");		
        $shop="";
        switch ($obj->type){
            case "coinShop":
                $shop="user_store_coin";
            break;
            case "crystalShop":
                $shop="user_store_crystal";
            break;
            case "worldShop":
                $shop="user_store_world";
            break;
        }
        echo getData($shop,array());
        //echo directlyCommand("SELECT `UID`,`".$shop."_state` from user_personal_game_data WHERE `account_UID`=".$_SESSION["UID"]);
        //echo $_SESSION[$shop."_state"];
    }

    function updateStore($obj){
        require_once("../manageDB/crud.php");		
        unset($obj->remote);
        $shop="";
        $tbname="";
        $costType="";
        switch ($obj->type){
            case "coinShop":
                $shop="user_store_coin";
                $tbname="system_store_coin";
                $costType="coin";
            break;
            case "crystalShop":
                $shop="user_store_crystal";
                $tbname="system_store_crystal";
                $costType="crystal";
            break;
            case "worldShop":
                $shop="user_store_world";
                $tbname="system_store_world";            
                $costType="crystal";
            break;
        }
        directlyCommand("UPDATE `".$shop."` SET `quantity`=`quantity`-1 WHERE `UID`=".$obj->listUID);
        directlyCommand("UPDATE `user_personal_game_data` SET `".$costType."`=`".$costType."`-".$obj->price." WHERE `UID`=".$_SESSION["UID"]);
        $s = getData("user_box",array("account_UID"=>$_SESSION["UID"]));
        unset($s["UID"]);
        unset($s["account_UID"]);        
        foreach($s as $k =>$v){
            if($v==0){
                $s=$k;
                break;
            }
        }
        $n=getData("system_item_list",array("UID"=>$obj->itemUID));        
        directlyCommand("UPDATE `user_box` SET `".$s."`='".$n["name"]."' WHERE `UID`=".$_SESSION["UID"]);
        echo 1;
    }

    function initStore($obj){
        require_once("../manageDB/crud.php");	
        $shop="";
        $tbname="";
        switch ($obj->type){
            case "coinShop":
                $shop="user_store_coin";
                $tbname="system_store_coin";
            break;
            case "crystalShop":
                $shop="user_store_crystal";
                $tbname="system_store_crystal";
            break;
            case "worldShop":
                $shop="user_store_world";
                $tbname="system_store_world";
            break;
        }        
        directlyCommand("INSERT INTO `".$shop."` SELECT * FROM `".$tbname."`;");             
        echo 1;
    }
?>