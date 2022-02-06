function getCookie(name){ 
	return document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)')?.pop() || '';  
}
function setCookie(key,val,expireTime){
	const d = new Date();
	d.setTime(d.getTime() + (expireTime));
	let expires = "expires="+ d.toUTCString();
	document.cookie = key + "=" + val + ";" + expires + ";path=/";
}

function setSession(datapack){		
	$.post("../../server/userOperation/sessionRecord.php",{data:datapack});
}

function getSession(datapack){
	$.post("../../server/userOperation/sessionRecord.php",{data:datapack}).done(function recv(data){		
		getSessionFromPHP=data;
	});
}

var getSessionFromPHP="noData";