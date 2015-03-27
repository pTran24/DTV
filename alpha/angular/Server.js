var express = require("express");
var mysql   = require("mysql");
var app     = express();
var fs      = require('fs');
var router = express.Router();
/*
* Configure MySQL parameters.
*/
var config  = JSON.parse(
    fs.readFileSync('mysql.conf')
);

var connection = mysql.createConnection({
    host : config.mysql.host,
    user : config.mysql.user,
    password : config.mysql.pass,
    database : "lisacatalog"
});
/*Connecting to Database*/
connection.connect(function(error){
    if (error) {
        console.log("Problem with MySQL"+error);
    } else {
        console.log("Connected with Database");
    }
});
var sqlSelect = "select d.environment as Environment, d.hostip as HostIP, l.serviceName as ServiceName, l.status as Status, l.starttime as StartTime, l.capacity as Capacity, l.txncnt as Txn, l.errors as Errors, m.build as Build, m.lisaproject as Project, IFNULL(m.author, 'NULL') as Author, IFNULL(m.modifydate, 'NULL') as ModifyDate, l.port as Port, l.basepath as BasePath FROM domain d INNER JOIN lisalog l ON l.hostip = d.hostip LEFT JOIN lisamar m ON l.servicename = m.modelname AND l.hostip = m.hostip;";
/*
* Define Routers
*/
app.use(express.static(__dirname + '/public'));

app.get('/load',function(req,res){
    connection.query(sqlSelect ,function(err,rows){
        if(err){
            console.log("Problem with MySQL"+err);
        }
        else{
            res.end(JSON.stringify(rows));
        }
    });
});

/*Start the Server*/

app.listen(3000, function() {
    console.log("It's Started on PORT 3000");
});
