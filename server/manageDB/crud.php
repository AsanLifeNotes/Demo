<?php

function directlyCommand(string $words){			
	$conn = new mysqli("localhost", "setter", "setter", "demo");
	$result = $conn->query($words);	
	if(gettype($result)==="boolean"){return 1;}
	$res=[];
	while($row=$result->fetch_assoc()){		
		if($row!=null){
			//array_push($res,$row);
			$res+=[$row["UID"]=>$row];
		}
	}
	return json_encode($res);
	$conn->close();
}

function addData(string $tbname, array $list)
{
	$conn = new mysqli("localhost", "setter", "setter", "demo");
	$sql = "INSERT INTO `" . $tbname . "` ";	
	$col="(";
	$val="(";
	foreach ($list as $col_name => $col_val) {
		$col.="`".$col_name."`,";
		$val.="'".$col_val."',";	
	}
	$col=substr($col,0,-1);
	$col.=")";
	$val=substr($val,0,-1);
	$val.=")";
	$sql.=$col."VALUES".$val;			
	$conn->query($sql);
	$conn->close();
	return 1;
}

function getData(string $tbname, array $list=[], string $extendWord="")
{	
	$conn = new mysqli("localhost", "getter", "getter", "demo");	
	$sql = "SELECT * FROM `" . $tbname."`"; 
	if(count($list)!=0){	
		$sql.= " WHERE ";
		foreach ($list as $col_name => $col_val) {
			$sql .="`".$col_name . "`='" . $col_val . "' AND";
		}
	$sql = substr($sql, 0, -3);			
	}
	$sql.=$extendWord;			
	$result = $conn->query($sql);	
	$conn->close();
	if(count($list)==0){		
		$res=[];
		while($row=$result->fetch_assoc()){
			if($row!=null){
				$res+=[$row["UID"]=>$row];				
			}
		}		
		echo json_encode($res);				
	}else{
		return $result->fetch_assoc();
	}
}

function updateData(string $tbname, array $list, string $extendWord="")
{
	$conn = new mysqli("localhost", "setter", "setter", "demo");
	$sql = "UPDATE `" . $tbname . "` SET ";
	foreach ($list as $col_name => $col_val) {
		if ($col_name !== "UID") {
			$sql .= $col_name . "='" . $col_val . "',";
		}
	}	
	$sql = substr($sql, 0, -1);
	$sql .= " WHERE UID=" . $list["UID"] . ";";
	
	$conn->query($sql);
	$conn->close();
	return 1;
}

function deleteData(string $tbname, array $list)
{
	$conn = new mysqli("localhost", "setter", "setter", "demo");
	$sql="DELETE FROM `".$tbname."` WHERE `UID`='".$list["UID"]."'";	
	$conn->query($sql);
	$conn->close();
	return 1;
}

function getColumnName(string $dbname, string $tbname)
{
	$conn = new mysqli("localhost", "getter", "getter", "demo");
	$sql = "SELECT COLUMN_NAME " .
		"FROM INFORMATION_SCHEMA.COLUMNS " .
		"WHERE " . "TABLE_SCHEMA = '" . $dbname . "'" .
		"AND TABLE_NAME = '" . $tbname . "';";
	$result = $conn->query($sql);
	$res = [];
	while ($row = $result->fetch_assoc()) {		
		array_push($res,$row["COLUMN_NAME"]);
	}
	$conn->close();
	return $res;
	//echo "----------------------";
	//echo json_encode($res);
	
}

function getColumnCount(string $tbname){
	$conn = new mysqli("localhost", "getter", "getter", "demo");
	$sql = "SELECT COUNT(*) FROM `".$tbname."`;";
	return $conn->query($sql)->fetch_assoc()["COUNT(*)"];
}
