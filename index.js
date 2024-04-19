const express = require("express");

const app = express();

app.set("view engine", "ejs");

app.get("/", function(req, res){
    res.render("public/indexed.html")
});

app.listen(3000, function(){
    console.log("Servidor creado http://localhost:3000");
});