<?php
$servername ="localhost";
$username  ="admin";
$password ="admin";
$dbname = "demo";

createDB($dbname);

$list = array("UID"=> "int AUTO_INCREMENT,PRIMARY KEY (UID) ",
              "ID" => "text DEFAULT NULL",
              "password" => "text DEFAULT NULL",
              "permission" => "int DEFAULT 1",
              "userName" => "text DEFAULT NULL",
              "google_account" => "text DEFAULT NULL",
              "FB_account" => "text DEFAULT NULL",
              "Twitter_account" => "text DEFAULT NULL",
              "firstName" => "text DEFAULT NULL",
              "lastName" => "text DEFAULT NULL",
              "email" => "text DEFAULT NULL",
              "phone" => "text DEFAULT NULL",
              "country" => "text DEFAULT NULL",
              "city" => "text DEFAULT NULL",
              "address" => "text DEFAULT NULL",
              "game_data_UID" => "text DEFAULT NULL");
              createTB("user_account",$list);

$list = array("UID"=> "int AUTO_INCREMENT,PRIMARY KEY (UID) ",
              "account_UID" => "int DEFAULT NULL",
              "coin" => "text DEFAULT NULL",
              "crystal" => "text DEFAULT NULL",
              "charater_set" => "text DEFAULT NULL",              
              "mail_set" => "text DEFAULT NULL",             
              "option_setting_list"=>"text DEFAULT NULL");
              createTB("user_personal_game_data",$list);

$list = array ("UID"=> "int AUTO_INCREMENT,PRIMARY KEY (UID)",
                "name" => "text DEFAULT NULL",
                "status" => "text DEFAULT NULL",
                "equipment" => "text DEFAULT NULL",
                "INFO" => "text DEFAULT NULL");
              createTB("system_character",$list);

$list = array("UID"=> "int AUTO_INCREMENT,PRIMARY KEY (UID)",
               "account_UID" => "text NULL");
               for($i=1;$i<51;$i++){
                 $list+=["inventory_".$i=>"text DEFAULT 0"];
               }
              createTB("user_box",$list);

$list = array("UID"=> "int AUTO_INCREMENT,PRIMARY KEY (UID)",              
              "from_sender" => "text DEFAULT NULL",
              "subject" => "text DEFAULT NULL",
              "content" => "text DEFAULT NULL",
              "attachment" => "text DEFAULT NULL", 
              "creator" => "text NULL");
              createTB("system_mail_list",$list);

$list = array("UID"=> "int AUTO_INCREMENT,PRIMARY KEY (UID)", //Make sure the item on the shelf won't be replace.              
              "item_UID" => "text NULL", 
              "item_name" => "text NULL", 
              "quantity" => "int DEFAULT 0",
              "price" => "int DEFAULT 0",
              "uploader" => "text NULL");
              createTB("system_store_coin",$list);

$list = array("UID"=> "int AUTO_INCREMENT,PRIMARY KEY (UID)", //Make sure the item on the shelf won't be replace.              
              "item_UID" => "text NULL", 
              "item_name" => "text NULL", 
              "quantity" => "int DEFAULT 0",
              "price" => "int DEFAULT 0",
              "uploader" => "text NULL");
              createTB("system_store_crystal",$list);

$list = array("UID"=> "int AUTO_INCREMENT,PRIMARY KEY (UID)", //Make sure the item on the shelf won't be replace.              
              "item_UID" => "text NULL", 
              "item_name" => "text NULL", 
              "quantity" => "int DEFAULT 0",
              "price" => "int DEFAULT 0",
              "uploader" => "text NULL");
              createTB("system_store_world",$list);

$list = array("UID"=> "int AUTO_INCREMENT,PRIMARY KEY (UID)", //Make sure the item on the shelf won't be replace.              
              "item_UID" => "text NULL", 
              "item_name" => "text NULL", 
              "quantity" => "int DEFAULT 0",
              "price" => "int DEFAULT 0",
              "uploader" => "text NULL");
              createTB("user_store_coin",$list);

$list = array("UID"=> "int AUTO_INCREMENT,PRIMARY KEY (UID)", //Make sure the item on the shelf won't be replace.              
              "item_UID" => "text NULL", 
              "item_name" => "text NULL", 
              "quantity" => "int DEFAULT 0",
              "price" => "int DEFAULT 0",
              "uploader" => "text NULL");
              createTB("user_store_crystal",$list);

$list = array("UID"=> "int AUTO_INCREMENT,PRIMARY KEY (UID)", //Make sure the item on the shelf won't be replace.              
              "item_UID" => "text NULL", 
              "item_name" => "text NULL", 
              "quantity" => "int DEFAULT 0",
              "price" => "int DEFAULT 0",
              "uploader" => "text NULL");
              createTB("user_store_world",$list);

$list = array("UID"=> "int AUTO_INCREMENT,PRIMARY KEY (UID)",
              "name" => "text NULL",
              "value" => "text NULL",
              "INFO" => "text NULL",
              "creator" => "text NULL");
              createTB("system_item_list",$list);

$list = array("UID"=> "int AUTO_INCREMENT,PRIMARY KEY (UID)",
                "name" => "text NULL",
                "value" => "text NULL",
                "INFO" => "text NULL",
                "creator" => "text NULL");
                createTB("system_monster",$list);

$list = array("UID"=> "int AUTO_INCREMENT,PRIMARY KEY (UID)",
                "name" => "text NULL",
                "value" => "text NULL",
                "INFO" => "text NULL",
                "creator" => "text NULL");
                createTB("system_skill",$list);

$list = array("UID"=> "int AUTO_INCREMENT,PRIMARY KEY (UID)",
                "name" => "text NULL",
                "text" => "text NULL",
                "timeStamp" => "text DEFAULT CURRENT_TIMESTAMP");
                createTB("system_chatroom",$list);

$permission = array("1"=>"SELECT","2"=>"INSERT","3"=>"UPDATE","4"=>"DELETE");
//createDBUser("setter","setter",$permission);

$permission = array("1"=>"SELECT","2"=>"SHOW VIEW");
//createDBUser("getter","getter",$permission);

createDefaultData();

function createDB($dbname){
  // Create connection
  $conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password']);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  
  // Create database
  $sql = "CREATE DATABASE ".$dbname.";";
  echo $sql;
  echo "\n\n";
  if ($conn->query($sql) === TRUE) {
    echo "Database created successfully\n";
  } else {
    echo "Error creating database: " . $conn->error;
  }
  $conn->close();
  }

function createTB($tbname, $list)
{
  $conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "CREATE TABLE `".$tbname."` (";
  foreach($list as $key=>$val){
    $sql.= $key." ".$val.",";
  }
  $sql = substr($sql, 0, -1);
  $sql.=");";
  //echo $sql;
  //echo "\n\n";
  if ($conn->query($sql) === TRUE) {
    echo "Table MyGuests created successfully \n";
  } else {
    echo "Error creating table: " . $conn->error;
  }
  $conn->close();
}

function createDBUser($id,$pw,$right){
  $conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password']);
  $sql="CREATE USER '".$id."'@'%' IDENTIFIED BY '".$pw."'";
  $conn->query($sql);
  $sql="GRANT ";
  foreach($right as $key => $val){
    $sql.=$val.",";
  }
  $sql = substr($sql, 0, -1);
  $sql.=" ON *.* TO `".$id."`@`%`;";
  $conn->query($sql);
  $conn->close();
}

function createDefaultData(){
  createGM("admin","admin");  
  for($i=1;$i<5;$i++){
    $name="item".$i;
    $value="{ATK:".($i*10).",DEF:".($i*5)."}";
    $info="It is a default item.";
    createItem($name,$value,$info);
  }
  for($i=1;$i<4;$i++){
    $name="mob".$i;
    $value="{ATK:".($i*10).",DEF:".($i*5)."}";
    $info="It is a default mob.";
    createMob($name,$value,$info);
  }
  for($i=1;$i<4;$i++){
    $name="character".$i;
    $status="{ATK:".($i*10).",DEF:".($i*5)."}";    
    $info="It is a default character.";
    createCharacter($name,$status,"",$info);
  }
  for($i=1;$i<4;$i++){   
    setCoinStore("1",99,10);
    setCrystalStore("3",50,10);
    setWorldStore("4",50,10);
  }
}

function createGM($id,$pw){
  require_once("manageDB/crud.php");
  $list = array("ID"=>$id,"password"=>$pw,"permission"=>"7");
  addData("user_account",$list);
  createGMGameData();
}
function createGMGameData(){
  require_once("manageDB/crud.php");  
	$list = array("account_UID"=>1,"coin"=>9999,"crystal"=>9999);
	addData("user_personal_game_data",$list);	
  addData("user_box",array("account_UID"=>1));
}

function createItem($name,$value,$info){
  require_once("manageDB/crud.php");
  $list = array("name"=>$name,"value"=>$value,"INFO"=>$info);
  addData("system_item_list",$list);
}

function createMob($name,$value,$info){
  require_once("manageDB/crud.php");
  $list = array("name"=>$name,"value"=>$value,"INFO"=>$info);
  addData("system_monster",$list);
}

function createCharacter($name,$status,$equip,$info){
  require_once("manageDB/crud.php");
  $list = array("name"=>$name,"status"=>$status,"equipment"=>$equip,"INFO"=>$info);
  addData("system_character",$list);
}

function setCoinStore($UID,$price,$num){
  require_once("manageDB/crud.php");
  $s = directlyCommand("SELECT `UID`,`name` from `system_item_list` WHERE `UID`=".$UID);
  $s=json_decode($s,true);
  $name="";
  foreach($s as $i){
      $name=$i["name"];
  }
  $list = array("item_UID"=>$UID,"item_name"=>$name,"price" => $price,"quantity" => $num);
  addData("system_store_coin",$list);
}
function setCrystalStore($UID,$price,$num){
  require_once("manageDB/crud.php");
  $s = directlyCommand("SELECT `UID`,`name` from `system_item_list` WHERE `UID`=".$UID);
  $s=json_decode($s,true);
  $name="";
  foreach($s as $i){
      $name=$i["name"];
  }
  $list = array("item_UID"=>$UID,"item_name"=>$name,"price" => $price,"quantity" => $num);
  addData("system_store_crystal",$list);
  
}
function setWorldStore($UID,$price,$num){
  require_once("manageDB/crud.php");
  $s = directlyCommand("SELECT `UID`,`name` from `system_item_list` WHERE `UID`=".$UID);
  $s=json_decode($s,true);
  $name="";
  foreach($s as $i){
      $name=$i["name"];
  }
  $list = array("item_UID"=>$UID,"item_name"=>$name,"price" => $price,"quantity" => $num);
  addData("system_store_world",$list);  
}

?>