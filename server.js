var express     = require('express'),
    mysql       = require('mysql'),
    app         = express(),
    connection  = mysql.createConnection({ host:'localhost', database:'midcoast_db', user:'mbc_user', password:'password' });

/** Connect to the DB */
connection.connect();

/** Get all news */
app.get('/api/news', function(req,res){

    var results;

    connection.query('SELECT * from news', function(err, rows, fields) {
        if (err) throw err;
        results = rows;
        res.type('application/json');
        res.send(results);
    });

});

app.listen(3000);
