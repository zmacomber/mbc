var express     = require('express'),
    mysql       = require('mysql'),
    app         = express(),
    connection  = mysql.createConnection({ host:'localhost', database:'midcoast_db', user:'mbc_user', password:'password' });

connection.connect();

/** Get home page article */
app.get('/api/home_page_article', function(req,res){

    var results;

    connection.query("select id, title, category, author, image_id, content, date_format(create_date,'%W, %b %d, %Y') AS article_date from articles where       put_on_home_page = 'Y'", function(err, rows, fields) {
        if (err) throw err;
        results = rows;
        res.type('application/json');
        res.send(results);
    });

});

app.listen(80);
