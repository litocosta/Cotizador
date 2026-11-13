const cotizadorConfig = require("./config.js");
const fs = require('fs');
const mysql = require("mysql");
const fastcsv = require("fast-csv");
const fs_extra = require('fs-extra');
const csvtojson = require('csvtojson'); 
var exec = require("child_process").exec;

// Database credentials 
const hostname = cotizadorConfig('DB_HOST'),
    username = cotizadorConfig('DB_USER'),
    password = cotizadorConfig('DB_PASSWORD'),
    databsename = cotizadorConfig('DB_NAME')

// Read the contents of the directory /usr/local/bin asynchronously.
// The callback will be invoked once the operation has either completed
// or failed.
console.log("\n--El archivo recibo.txt cambio!!!");
if (fs.existsSync('usados/')) {
    console.log('El directorio existe')
    fs.watchFile('usados/', function (curr, prev) {
        fs.readdir('usados/', (err, files) => {
            // On error, show it and return
            if (err) return console.error(err);
            // files is an array containing the names of all entries
            // in the directory, excluding '.' (the directory itself)
            // and '..' (the parent directory).

            var archivo = files.join(' ');
            // Display directory entries
            console.log(archivo);

            // Establish connection to the database 
            let con = mysql.createConnection({
                host: hostname,
                user: username,
                password: password,
                database: databsename,
            }); 
            con.connect((err) => {
                if (err) return console.error(
                    'error: ' + err.message);

                con.query("DROP TABLE usados",
                    (err, drop) => {

                        // Query to create table "sample" 
                        var createStatament =
                            "CREATE TABLE usados(id_usados_proyaut int(255), " +
                            "empresa char(255), descripcion char(255), anio int(4)," +
                            "color char(255), km int(10), valor_sugerido char(255), id_cotizados int(255)," +
                            "ubicacion char(255), patente char(7), tipousado char(1))"

                        // Creating table "sample" 
                        con.query(createStatament, (err, drop) => {
                            if (err)
                                console.log("ERROR: ", err);
                        });
                    });
            }); 
            // CSV file name 
            //const fileName = archivo;
            //console.log('camino: '.fileName);
            csvtojson().fromFile(archivo).then(source => {

                // Fetching the data from each row  
                // and inserting to the table "sample" 
                //console.log('registros: '.source.length);
                for (var i = 0; i < source.length; i++) {
                    var Name = source[i]["id_usados_proyaut"],
                        Email = source[i]["empresa"],
                        Age = source[i]["descripcion"],
                        City = source[i]["anio"],
                        Color = source[i]["color"],
                        Km = source[i]["km"],
                        Valor = source[i]["valor_sugerido"],
                        Id = source[i]["id_cotizados"],
                        Ubicacion = source[i]["ubicacion"],
                        Patente = source[i]["patente"],
                        Tipo = source[i]["tipousado"]


                    var insertStatement =
                        'INSERT INTO usados values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
                    var items = [Name, Email, Age, City, Color, Km, Valor, Id, Ubicacion, Patente, Tipo];

                    // Inserting data of current row 
                    // into database 
                    con.query(insertStatement, items,
                        (err, results, fields) => {
                            if (err) {
                                console.log(
                                    "Unable to insert item at row ", i + 1);
                                return console.log(err);
                            }
                        });
                }
                console.log("All items stored intodatabase successfully");
            }); 

            //exec("wget -q -O - http://localhost/info/token.php");
            
        });
    });
}