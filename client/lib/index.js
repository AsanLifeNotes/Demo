function login(){	
	//get result to server	
	//do something by result;
	const xhttp = new XMLHttpRequest();
	xhttp.onload = function() {
		var res = this.responseText;	
			console.log(res);
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

function showFailContent(){
	console.log("Got fail Content");
}

function postStyleSelect(){
	
}

function postBackLanguageSelect(){
	
}

function test(){
	const xhttp = new XMLHttpRequest();
	xhttp.onload = function() {
		const res = this.responseText;
		console.log(res);		
	};
	xhttp.open("GET", window.location.origin + "/demo/server/test.php");
	xhttp.send();			
}
