function login(){	
	//get result to server	
	//do something by result;
	let id = $("#UserID").val();	
	let pw = $("#UserPW").val();	
	if(id===""||pw===""){showFailContent();}
	let data={"remote":"login","id":id,"password":pw};
	let convData=JSON.stringify(data);	
	const xhttp = new XMLHttpRequest();
	//xhttp.open("GET", window.location.origin + "/demo/server/userOperation/accountControl.php?id="+id+"&pw="+pw);
	xhttp.open("GET", window.location.origin + "/demo/server/userOperation/accountControl.php?data="+convData);
	xhttp.send();	
	xhttp.onload = function() {
		let res = this.responseText;		
		console.log(res);
		if(parseInt(res)===-1){
			showFailContent();
		}else if(parseInt(res)===1){
			let data={remote:"setSession",loginState:"1","id":id};	
			setSession(JSON.stringify(data));
			window.open("../html/mainPage.html","_self");			
		}
	};		
}

function savePW(){
	if($("#rememberPW").prop("checked")){
		setCookie("savePW","1",30*24*60*60*1000);
		setCookie("id",$("#UserID").val(),30*24*60*60*1000);
		setCookie("pw",$("#UserPW").val(),30*24*60*60*1000);
	}else{
		setCookie("savePW","0",-1);
	}	
}

function showFailContent(){
	$("#showEnterIDPW").css("visibility","visible");
}

function postStyleSelect(){
	
}

function postBackLanguageSelect(){
	
}

function checkLoginState(){
	let datapack={remote:"getSession",el1:"loginState"};	
	getSession(JSON.stringify(datapack));	
	if(getSessionFromPHP==="noData"){
		return;
	}
	let v=JSON.parse(getSessionFromPHP);	
	if(v.loginState==="NULL"){		
		clearInterval(ck);
	}else if(v.loginState==="1"){
		getSessionFromPHP="noData";
		window.open("../html/mainPage.html","_self");
	}
}

var ck;
window.onload=()=>{
	if(getCookie("savePW")==="1"){		
		$("#rememberPW").prop("checked",true);		
		$("#UserID").val(getCookie("id"));	
		$("#UserPW").val(getCookie("pw"));	
	}else{
		$("#rememberPW").prop("checked",false);
	}	
	ck=setInterval("checkLoginState()",1000);
	//setInterval("testJS()",1000);
}






function testPHP(){
	console.log("Test PHP");
	const xhttp = new XMLHttpRequest();
	xhttp.onload = function() {
		const res = this.responseText;
		console.log(res);		
		//const myObj = JSON.parse(this.responseText);
		//console.log(myObj);		
	};
	xhttp.open("GET", window.location.origin + "/demo/test/test.php");
	xhttp.send();			
}

function testJS(){
	/*console.log("Test JS");
	const d = new Date();
	console.log(d);
	d.setTime(d.getTime() + (30*24*60*60*1000));
	console.log(d);
	console.log(d.toUTCString());*/
	let dp={a:"1",b:"2",c:"3"};
	dp=JSON.stringify(dp);
	$.post("../../test/test.php","").done((data)=>{
		console.log("From php");
		console.log(data);
		window.open(data,"_self");
	});
	console.log(document.cookie);
	for(i=0;i<10;i++){
		s=i*5+","+i*6+","+i*7;
		console.log(s);
		
	}
}
