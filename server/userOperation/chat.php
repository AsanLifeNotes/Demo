<?php
    header("Content-Type: text/event-stream");    
    header('Cache-Control: no-cache');        
    session_start();
    if(isset($_REQUEST["data"])){               
        $obj = json_decode($_REQUEST["data"], false);    
        switch($obj->remote){
            case "putChat":
                putChat($obj);
            break;
            case "getChat":   
                getChat($obj);
            break;
            
        }
    }   
    
    function putChat($obj){
        require_once("../manageDB/crud.php");
        unset($obj->remote);        
        echo addData("system_chatroom",array("name"=>$_SESSION["ID"],"text"=>$obj->msg));
    }
    function getChat($obj){
        require_once("../manageDB/crud.php");        
        if($obj->num===-1){
            echo getData("system_chatroom",array()," ORDER BY `UID` DESC LIMIT 10");
        }else{
            echo getData("system_chatroom",array()," WHERE `UID`>".$obj->num);
        }
    }
    
?>