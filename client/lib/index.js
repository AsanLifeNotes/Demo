function login(){	
	//get result to server	
	//do something by result;
	const xhttp = new XMLHttpRequest();
	xhttp.onload = function() {
		var res = this.responseText;				
		if(res==="-1"){
			showFailContent();
		}else if(res==="1"){			
			window.open("../html/mainPage.html","_self");			
		}
	};
	let id = $("#UserID").val();	
	let pw = $("#UserPW").val();	
	if(id===""||pw===""){showFailContent();}
	xhttp.open("GET", window.location.origin + "/demo/server/login.php?id="+id+"&pw="+pw);
	xhttp.send();			
}

function rememberSetting(){
	const d = new Date();
	d.setTime(d.getTime() + (30*24*60*60*1000));
	let expires = "expires="+ d.toUTCString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function showFailContent(){
	console.log("Got fail Content");
	$("#showEnterIDPW").css("visibility","visible");
}

function postStyleSelect(){
	
}

function postBackLanguageSelect(){
	
}

function testPHP(){
	console.log("Test PHP");
	const xhttp = new XMLHttpRequest();
	xhttp.onload = function() {
		const res = this.responseText;
		console.log(res);		
	};
	xhttp.open("GET", window.location.origin + "/demo/server/test.php");
	xhttp.send();			
}

function testJS(){
	console.log("Test JS");
	const d = new Date();
	console.log(d);
	d.setTime(d.getTime() + (30*24*60*60*1000));
	console.log(d);
	console.log(d.toUTCString());
}

