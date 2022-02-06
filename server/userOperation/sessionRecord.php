<?php
    //session_name($_COOKIE["PHPSESSID"]);
    session_start();
    if(isset($_REQUEST["data"])){               
        $obj = json_decode($_REQUEST["data"], false);    
        switch($obj->remote){
            case "setSession":
                setSession($obj);
            break;
            case "getSession":                                         
                getSession($obj);
            break;
            case "deleteSession":
                deleteSession();
            break;
        }
    }   

    function checkSession(){

    }    
    function setSession($list){       
        unset($list->remote); 
        foreach($list as $lsKey => $lsVal){            
                $_SESSION[$lsKey] = $lsVal;            
        }       
        echo json_encode($_SESSION);
    }
    function getSession($list){
        unset($list->remote); 
        $res=[];
        foreach($list as $lsKey => $lsVal){            
            if(isset($_SESSION[$lsVal])){
                $res+=[$lsVal=>$_SESSION[$lsVal]];
            }else{
                $res+=[$lsVal=>"NULL"];
            }
            
        }
        echo json_encode($res);
    }
    function deleteSession(){
        session_destroy();
    }
?>

