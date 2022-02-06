<?php
    session_start();
    $obj = json_decode($_REQUEST["data"], false);
	switch($obj->remote){
		case "addListObject":
			addListObject($obj);
		break;
        case "getList":
            getList($obj);
        break;
        case "updateListObject":
            updateListObject($obj);
        break;
        case "deleteListObject":
            deleteListObject($obj);
        break;
        case "shopRefresh":
            shopRefresh($obj);
        break;
        case "banAccount":
            banAccount($obj);
        break;
	}

    function addListObject($obj){        
        if(isset($obj->UID)){
            if(preg_match("/[a-z]/i", $obj->UID)||$obj->name===""){
                echo "Invalid!";
                return -1;
            }
        }
        unset($obj->remote);
        $tbname=$obj->type;
        unset($obj->type);
        
        require_once('../manageDB/crud.php');
        $check=null;
        if(isset($obj->UID)){        
            if($obj->UID!=""){
                $check=getData($tbname,array("UID"=>$obj->UID));            
            }
        }
        if(isset($check)!=null){echo -1;}
        else{                 
            if($tbname==="system_store_coin"||$tbname==="system_store_crystal"||$tbname==="system_store_world"){
                if($obj->item_UID==""){$obj->item_UID=getData("system_item_list",array("name"=>$obj->item_name))["UID"];}
                $obj->item_name=getData("system_item_list",array("UID"=>$obj->item_UID))["name"];
                $obj->uploader=$_SESSION["ID"];
            }else{
                $obj->creator=$_SESSION["ID"];
            }
            echo addData($tbname,(array)$obj);
        }
    }
    
    function getList($obj){
        require_once('../manageDB/crud.php');
        unset($obj->remote);        
        echo getData($obj->type,array());        
    }

    function updateListObject($obj){
        require_once('../manageDB/crud.php');
        $check=getData($obj->type,array($obj->UID));
        if(isset($check)==null){echo -1;}
        else{

        }
    }

    function deleteListObject($obj){
        require_once('../manageDB/crud.php');
        $check=getData($obj->type,array("UID"=>$obj->UID));
        if(isset($check)==null){echo -1;}
        else{
            echo deleteData($obj->type,array("UID"=>$obj->UID));
        }
    }

    function shopRefresh($obj){
        require_once("../manageDB/crud.php");	
        directlyCommand("DELETE FROM `user_store_".$obj->type."`");  
        directlyCommand("INSERT INTO `user_store_".$obj->type."` SELECT * FROM `system_store_".$obj->type."`;");             
        echo 1;
    }

    function banAccount($obj){
        //echo "UPDATE `".$obj->type."` SET `permission`=1 WHERE `UID`=".$obj->UID;
        require_once("../manageDB/crud.php");        
        if($obj->Action==1){            
            directlyCommand("UPDATE `".$obj->type."` SET `permission`=0 WHERE `UID`=".$obj->UID);
        }else{            
            directlyCommand("UPDATE `".$obj->type."` SET `permission`=1 WHERE `UID`=".$obj->UID);
        }
        echo 1;
    }
?>