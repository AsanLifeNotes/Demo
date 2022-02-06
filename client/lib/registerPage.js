function smt() {
    if ($("#userName").val() === "" || $("#password").val() === "" ||
        $("#passwordConfirm").val() === "" || $("#email").val() === "") {
        if ($("#star").length === 0) {
            errMsg("Please fill the required imformation!");
            $(".required").after("<label id='star'style=color:red>*<label>");
        }
        return;
    }
    if ($("#password").val().length < 8) {
        errMsg("Password length needs more than 8");
        return;
    }
    if ($("#password").val() !== $("#passwordConfirm").val()) {
        errMsg("Wrong password");
        return;
    }
    postData();

}

function errMsg(msg) {
    $("#errMsg").text(msg);
    $("#errMsg").attr("style", "visibility:visible");
    $("#errMsg").attr("style", "color:red");
}

function showPassword() {
    if ($("#showPasswordCheck").prop("checked")) {
        $("#password").attr("type", "text");
        $("#passwordConfirm").attr("type", "text");
    } else {
        $("#password").attr("type", "password");
        $("#passwordConfirm").attr("type", "password");
    }
}

function postData() {
    let datapack = {
        remote:"register",
        firstName: $("#firstName").val(),
        lastName: $("#lastName").val(),
        ID: $("#userName").val(),
        userName: $("#userName").val(),
        password: $("#password").val(),
        email: $("#email").val(),
        phone: $("#phone").val(),
        country: $("#country").val(),
        city: $("#city").val(),
        address: $("#address").val()
    }
    datapack=JSON.stringify(datapack);
    $.post("../../server/userOperation/accountControl.php",{data:datapack}).done((e)=>{   
        console.log(e);     
        if(parseInt(e)===-1){errMsg("Email account already exists!");}
        //else if(parseInt(e)===1){window.open("../html/index.html","_self");}        
    });
}

function setInfo() {
    $("#firstName").val("demo");
    $("#lastName").val("demo");
    $("#userName").val("demoAccount");
    $("#password").val("1234567890");
    $("#passwordConfirm").val("1234567890");
    $("#email").val("demo@demo.com");
    $("#phone").val("0900000000");
    $("#country").val("Taiwan");
}
window.onload = () => {    
}