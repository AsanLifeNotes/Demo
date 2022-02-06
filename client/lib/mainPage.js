function switchContent(stat){
	switch (stat){
		case "Stage":			
			$("#terminal").attr("src","stage.html");			
		break;			
		case "ItemBox":
			$("#terminal").attr("src","itemBox.html");			
		break;
		case "Guild":
			$("#terminal").attr("src","guild.html");			
		break;
		case "Shop":
			$("#terminal").attr("src","shop.html");			
		break;
		case "Option":
			$("#terminal").attr("src","option.html");			
		break;
	}
}

function getUserData(){	
	dataPack={remote:"getGameData"};			
	dataPack=JSON.stringify(dataPack);
	$.get("../../server/userOperation/accountControl.php",{data:dataPack}).done((d)=>{		
		d=JSON.parse(d);				
		let UID=Object.keys(d)[0];		
		$("#coin").text(d["coin"]);
		$("#crystal").text(d["crystal"]);
	});
}

function joinStage(){
}

function showInfo(){
}

function throwAway(){
	
}

function putChat(){	
	if($("#msgInput").val()===""){return;}
	let dataPack={remote:"putChat",
					msg:$("#msgInput").val()};
	dataPack=JSON.stringify(dataPack);
	$.post("../../server/userOperation/chat.php",{data:dataPack}).done((data)=>{		
		reloadChat();
	});
	$("#msgInput").val("");
}

var chatNum=-1;
function reloadChat(){
	dataPack={ remote:"getChat",
				num:chatNum};
	dataPack=JSON.stringify(dataPack);
	$.post("../../server/userOperation/chat.php",{data:dataPack}).done((data)=>{		
		//console.log(JSON.parse(data));
		res=JSON.parse(data);
		$list="";
		for(i in res){			
			$list+="<p><label>"+res[i]["name"]+" : "+res[i]["text"]+"</label><span style=\"float:right\">"+res[i]["timeStamp"]+"</span></p>";			
			chatNum=res[i]["UID"];
		}		
		$("#chatRoom").append($list);		
		$("#chatRoom").scrollTop(document.getElementById("chatRoom").scrollHeight);		
	});
}

function buy(){

}

function sell(){

}

function getSetting(){

}

function updateSetting(){

}

function logout(){
	let data={remote:"deleteSession"};
	setSession(JSON.stringify(data));
    window.open("../html/index.html","_self");			
}

function openPage(evt, pageName){
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(pageName).style.display = "block";
  evt.currentTarget.className += " active";    
	switch (pageName) {
		case "manageItem":			
			getList("system_item_list");
			break;
		case "manageStore":			
			getList("storeitem");
			break;
		case "manageMob":
			getList("system_monster");
			break;
		case "manageStage":
			getList("stage");
			break;
		case "manageAccount":
			getList("user_account")
			break;
	}
}

var ck;
function checkLoginState(){		
	let datapack={remote:"getSession",el1:"loginState",el2:"permission"};	
	getSession(JSON.stringify(datapack));	
	if(getSessionFromPHP==="noData"){
		return;
	}	
	let v=JSON.parse(getSessionFromPHP);	
	if(v.loginState==="NULL"){		
		getSessionFromPHP="noData";
		window.open("../html/index.html","_self");		
	}else if(v.loginState==="1"){
		if(v.permission==="7"){
			$(".tab").css("display","inline");
		}
		clearInterval(ck);
	}	
}


window.onload=function(){
	/*const sse =new EventSource(
		//window.location.origin + "/demo/server/userOperation/chat.php",{ withCredentials: true });        
		window.location.origin + "/demo/server/userOperation/chat.php");        
        sse.addEventListener("message", function(e){
			console.log(e.data);
			$("#chatRoom").append("<li>"+e.data+"</li>");
			$("#chatRoom").scrollTop(document.getElementById("chatRoom").scrollHeight);								
		}, false);        		*/
		//$("$defaultOpen").click();
		getUserData();
		ck=setInterval("checkLoginState()",1000);	
		setInterval("reloadChat()",1000);	
		addEventListener("keydown",function(e){
			if(e.key === "Enter" && $("#msgInput").val()!==""){
				putChat();
			}
		});
}