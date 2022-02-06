
window.onload = () => {
    // $("#defaultOpen").click();
}

function openPage(evt, pageName) {
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
    getList(pageName);
}

function getList(pageName) {
    dataPack = { remote: "getStore", type: pageName };
    $.get("../../server/userOperation/shopping.php", { data: JSON.stringify(dataPack) }).done((d) => {
        //console.log(d);
        //console.log("getList");
        res = JSON.parse(d);
        let check = "";
        switch (pageName) {
            case "coinShop":
                check = "coin_shop_state";
                break;
            case "crystalShop":
                check = "crystal_shop_state";
                break;
            case "worldShop":
                check = "world_shop_state";
                break;
        }
        
        if (res == "") {            
            initStore(pageName);
        } else {            
            showData(pageName,res);
        }
    });
}

function initStore(pageName) {
    dataPack = {
        remote: "initStore",
        type: pageName
    };
    $.get("../../server/userOperation/shopping.php", { data: JSON.stringify(dataPack) }).done((d) => {
        //console.log(d);
        //console.log("initStore");
        if (parseInt(d) === 1) {            
            getList(pageName);
        }
    });
}

function showData(pageName,dataList) {    
    let list="";        
    for(i in dataList){
        let itemUID=dataList[i]['item_UID'];
        let listUID=dataList[i]['UID'];
        delete dataList[i]['UID'];
        delete dataList[i]['uploader'];                
        delete dataList[i]['item_UID'];   
        list+="<tr>\n";        
        for(j in dataList[i]){            
            list+= "<td style='table-layout: fixed;'>"+dataList[i][j]+"</td>\n";
        }        
        list+="<td><button onclick=\"buyObject('"+pageName+"','"+itemUID+"','"+listUID+"','"+dataList[i]["price"]+"')\">Buy</button></td>\n";        
        list+="</tr>\n";
    }
    $("#" + pageName).html("");
    $("#" + pageName).append("<thead><tr><th>Name</th><th>Quantity</th><th>Price</th><th>Control</th></tr></thead>");
    $("#" + pageName).append(list);
}

function buyObject(_pageName,it_UID,li_UID,_price){
    dataPack = {
        remote: "updateStore",
        type: _pageName,
        itemUID: it_UID,
        listUID: li_UID,
        price: _price,                
    }
    $.get("../../server/userOperation/shopping.php",{data:JSON.stringify(dataPack)}).done((d)=>{
        //console.log(d);
        //console.log(JSON.parse(d));
        //console.log(JSON.parse(d)[1]);
        if(parseInt(d)===1){
            getList(_pageName); 
            parent.getUserData();                       
        }
    });
}

