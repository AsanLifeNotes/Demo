<?php
        require_once("../server/manageDB/crud.php");		
        $s = directlyCommand("SELECT `UID`,`name` from `system_item_list` WHERE `UID`=2");        
        echo $s;
        
        echo $s[1]["name"];
        
        
 

?>