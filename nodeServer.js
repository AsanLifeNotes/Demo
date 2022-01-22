//透過http模組啟動web server服務
const express = require("express");
const app = express();

app.listen(3000);

app.use(express.static(__dirname + "/client"));
app.use(express.static(__dirname + "/server"));

app.get("/", function(req,res){
	res.sendFile(__dirname + "/client/html/index.html");
})