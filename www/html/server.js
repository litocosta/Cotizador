const cotizadorConfig = require("./config.js");
const fs = require("fs");
const mysql = require("mysql");
const fastcsv = require("fast-csv");
//var execPhp = require('exec-php');


// Read the contents of the directory /usr/local/bin asynchronously.
// The callback will be invoked once the operation has either completed
// or failed.
console.log("\n--El archivo recibo.txt cambio!!!");
if (fs.existsSync('usados/')) {
    var bandera = 0;
    console.log('El directorio existe')
    fs.watchFile('usados/', function (curr, prev) {
       
        fs.readdir('usados/', (err, files) => {
            // On error, show it and return
            if (err) return console.error(err);
            // files is an array containing the names of all entries
            // in the directory, excluding '.' (the directory itself)
            // and '..' (the parent directory).

            var archivo = files.join(' ');
           
            console.log('ARCHIVO: '+archivo);
            var recorte = archivo.indexOf(" ");
            if(recorte>0){
                console.log("son 2 o mas");
                var nuevoarchivo = archivo.substr(0,recorte);
                console.log(nuevoarchivo);
                archivo = nuevoarchivo;
            }
            else{
                console.log("Es solo 1");
            }
                //console.log(archivo);
            if(archivo!=''){
            let stream = fs.createReadStream('usados/'+archivo);
            let csvData = [];
            let csvStream = fastcsv
                .parse()
                .on("data", function (data) {
                    csvData.push(data);
                })
                .on("end", function () {
                    // remove the first line: header
                    csvData.shift();

                    // create a new connection to the database
                    const connection = mysql.createConnection({
                        host: cotizadorConfig('DB_HOST_2'),
                        user: cotizadorConfig('DB_USER'),
                        password: cotizadorConfig('DB_PASSWORD'),
                        port: '3306',
                        database: cotizadorConfig('DB_NAME')
                    });

                    // open the connection
                    connection.connect(error => {
                        if (error) {
                            console.error(error);
                        } else {
                            let borra =
                                "DELETE FROM usados";
                                connection.query(borra, [csvData], (error, response) => {
                                console.log(error || response);
                            });
                            let query =
                                "INSERT INTO usados (id_usados_proyaut,empresa,descripcion,anio,color,km,valor_sugerido,id_cotizados,ubicacion,patente,tipousado,ordenfoto) VALUES ?";
                                connection.query(query, [csvData], (error, response) => {
                                console.log(error || response);
                                  
                            });
                           
                            fs.unlinkSync('usados/' + archivo);
                            connection.end(); 
                            /*var oldPath = archivo;
                            var newPath = 'porlas/'+archivo;
                            fs.rename(oldPath, newPath, function (err) { 
                             
                                console.log('Successfully renamed - AKA moved!') 
                              
                            });*/
                        };
                    });
                });

            stream.pipe(csvStream); 
            console.log('TERMNMOOOOOOOOOOOOOOOOOOO: '+bandera)   ;
            
            }
            /*try {
                fs.statSync('usados/' + archivo);
                console.log('file or directory exists');
                fs.unlinkSync('usados/' + archivo);
            }
            catch (err) {
                if (err.code === 'ENOENT') {
                    console.log('file or directory does not exist');
                }
            }*/
         

            /*fs.stat('usados/'+archivo, function (err) {
                if (!err) {
                    console.log('file or directory exists');
                    console.log(bandera);
                    if(bandera==0){
                        fs.unlinkSync('usados/'+archivo);
                        bandera = 1;
                    }
                }
                else if (err.code === 'ENOENT') {
                    console.log('file or directory does not exist');
                }
            });*/
        });
        
        
    });
    
}