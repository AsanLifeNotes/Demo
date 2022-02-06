function submitManageItem() {
    let dataPack = {
        remote: "addListObject",
        type: "system_item_list",
        UID: $("#itemUID").val(),
        name: $("#itemName").val(),
        value: $("#itemValue").val(),
        INFO: $("#itemINFO").val()};
    $.post("../../server/userOperation/GM_Operation.php", { data: JSON.stringify(dataPack) }).done((d) => {
        if (parseInt(d) === 1) {
            getList("system_item_list");
        } else {

        }
    });
}

function submitManageStore() {    
    if($("#storeQuantity").val()=="") return;
    if($("#storePrice").val()=="") return;
    let dataPack = {
        remote: "addListObject",
        type: $("#storeSelection").val(),        
        item_UID: $("#storeItemUID").val(),
        item_name: $("#storeItemName").val(),
        quantity: $("#storeQuantity").val(),
        price: $("#storePrice").val()};    
    $.post("../../server/userOperation/GM_Operation.php", { data: JSON.stringify(dataPack) }).done((d) => {
        console.log(d);
        if (parseInt(d) === 1) {
            getList("storeitem");
        } else {

        }
    });
}

function submitManageMob() {
    let dataPack = {
        remote: "addListObject",
        type: "system_monster",
        UID: $("#mobUID").val(),
        name: $("#mobName").val(),
        value: $("#mobValue").val(),
        INFO: $("#mobINFO").val()};
    $.post("../../server/userOperation/GM_Operation.php", { data: JSON.stringify(dataPack) }).done((d) => {
        if (parseInt(d) === 1) {
            getList("system_monster");
        } else {

        }
    });
}

function submitManageStage() {
    let dataPack = {
        remote: "addListObject",
        type: "stage",
        UID: $("#stageUID").val(),
        name: $("#stageName").val(),
        value: $("#stageValue").val(),
        INFO: $("#stageINFO").val()};
    $.post("../../server/userOperation/GM_Operation.php", { data: JSON.stringify(dataPack) }).done((d) => {
        if (parseInt(d) === 1) {
            getList("stage");
        } else {

        }
    });
}

function getList(listName){
    if(listName==="storeitem"){
        listName=$("#storeSelection").val();
    }
    let dataPack = {
        remote: "getList",
        type: listName};
    $.post("../../server/userOperation/GM_Operation.php", { data: JSON.stringify(dataPack) }).done((d) => {                       
        if (d !== "") {
            showList(listName,d);
        } else {
            console.log("No List Get!");
        }
    });
}

function showList(listName,dataList){    
    dataList=JSON.parse(dataList);
    let list="";
    
    for(i in dataList){
        if(listName=="user_account"){
            delete dataList[i]["password"];
            delete dataList[i]["Twitter_account"];
            delete dataList[i]["address"];
            delete dataList[i]["FB_account"];
            delete dataList[i]["city"];
            delete dataList[i]["country"];
            delete dataList[i]["firstName"];
            delete dataList[i]["lastName"];
            delete dataList[i]["google_account"];
            delete dataList[i]["phone"];
            delete dataList[i]["userName"];                        
        }        
        list+="<tr>\n";        
        for(j in dataList[i]){
            list+= "<td style='table-layout: fixed;'>"+dataList[i][j]+"</td>\n";
        }        
        if(listName=="user_account"){
            let b_nb;
            let btext;
            if(dataList[i]["permission"]=="1"){b_nb=1;btext="Ban";}else{b_nb=0;btext="Un_Ban";}
            list+="<td>";
            if(dataList[i]["permission"]=="7"){}else{
            list+="<button onclick=\"banAccount('"+listName+"','"+dataList[i]["UID"]+"','"+b_nb+"')\">"+btext+"</button>";}
            list+="<button onclick=\"deleteObject('"+listName+"','"+dataList[i]["UID"]+"')\">Delete</button></td>\n";
        }else{
            list+="<td><button onclick=\"deleteObject('"+listName+"','"+dataList[i]["UID"]+"')\">Delete</button></td>\n";
        }
        list+="</tr>\n";
    }
    switch (listName) {
		case "system_item_list":			
			listName="managedItemList";
			break;
		case "storeitem":
			listName="managedStoreList";
			break;
		case "system_monster":
			listName="managedMobList";
			break;
		case "stage":
			listName="managedStageList";
			break;
        case "system_store_coin":
            listName="managedStoreList";
            break;
        case "system_store_crystal":
            listName="managedStoreList";
            break;
        case "system_store_world":
            listName="managedStoreList";
            break;
        case "user_account":
            listName="managedAccountList";
            break;
	}    
    
    $("#"+listName).html("");
    $("#"+listName).append(generateTableHeader(listName));
    $("#"+listName).append(list);
}

function generateTableHeader(listName){
    switch (listName) {
		case "managedItemList":
            return "<thead><tr><th>UID</th><th>Name</th><th>Value</th><th>Information</th><th>Creator</th><th>Control</th></tr></thead>"
			break;
		case "managedStoreList":
            return "<thead><tr><th>UID</th><th>item_UID</th><th>item_name</th><th>Quantity</th><th>Price</th><th>Uploader</th></tr></thead>"
			break;
		case "managedMobList":
            return "<thead><tr><th>UID</th><th>Name</th><th>Value</th><th>Information</th></tr></thead>"
			break;
		case "managedStageList":
            return "<thead><tr><th>UID</th><th>Name</th><th>Value</th><th>Information</th></tr></thead>"
			break;
        case "managedAccountList":
            return "<thead><tr><th>UID</th><th>Account ID</th><th>Permission</th><th>E-mail</th><th>Game Data UID</th><th>Control</th></tr></thead>"
            break;
	}        
}

function deleteObject(listName, uid){
    let dataPack = {
        remote: "deleteListObject",
        type: listName,
        UID: uid};
    $.post("../../server/userOperation/GM_Operation.php", { data: JSON.stringify(dataPack) }).done((d) => {        
        if (parseInt(d) === 1) {
            getList(listName);
        } else {
            console.log("No Delete Object Get!");
        }
    });
}

function banAccount(listName,uid,ban_or_unban){
    let dataPack = {
        remote: "banAccount",
        type: listName,
        UID: uid,
        Action: ban_or_unban};
    $.post("../../server/userOperation/GM_Operation.php", { data: JSON.stringify(dataPack) }).done((d) => { 
        console.log(d);        
        if (parseInt(d) === 1) {
            getList(listName);
        } else {
            console.log("No Delete Object Get!");
        }
    });
}

function shopRefresh(shopType){    
    let dataPack={remote:"shopRefresh",
                    type:shopType}
    $.post("../../server/userOperation/GM_Operation.php",{data:JSON.stringify(dataPack)}).done((d)=>{        
        if(parseInt(d)===1){
            
        }
    });
}

function changeShop(){
    getList($("#storeSelection").val());
}