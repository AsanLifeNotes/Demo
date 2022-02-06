let boxItems;
window.onload=()=>{getItem();}

function getItem(){
    const xhttp = new XMLHttpRequest();	
	let data={"remote":"getBox"};
	let convData=JSON.stringify(data);		
	$.get("../../server/userOperation/itembox.php",{data:convData}).done((d)=>{
		//console.log(d);				
		res= JSON.parse(d);
		let UID=Object.keys(res)[0];
		//console.log(res[UID]);		
		setItem(res[UID]);
	});
}

function updateBoxWindow(box){	
	let showBox="<tr>";
	let col=5;
	//box=JSON.parse(box);	
	for(let i in box){						
			if(col%5===0) showBox+="<tr>";				
			showBox+="<td>";
			showBox+=box[i];
			showBox+="</td>";
			col++;
			if(col%5===0) showBox+="</tr>";									
	}
	if(col%5!==0){
		showBox+="<td><button onclick='openSlots()'>+</button></td>";
		showBox+="</tr>";
	}else{
		showBox+="<tr><td><button onclick='openSlots()' disabled>+</button></td></tr>";
	}
	$("#inventory").html(showBox);
}

function setItem(itemlist){
	delete itemlist["UID"];
	delete itemlist["account_UID"];
	boxItems=itemlist;
	updateBoxWindow(boxItems);	
}

function openSlots(){
	//console.log("openSlots");
	const xhttp = new XMLHttpRequest();		
	let data={"remote":"extendBox",				
				"numsOfOpen":5,
				"box_1":boxItems.box_1};
	let convData=JSON.stringify(data);			
	xhttp.open("PUT", window.location.origin + "/demo/server/userOperation/itembox.php?data="+convData);
	xhttp.send();
	xhttp.onload = function() {		
		//console.log(this.responseText);
		getItem();
	};
}

function getEmptyInventoryName(){
	for(i in boxItems){
		if(boxItems[i]==0){
			return i;
		}
	}
}
