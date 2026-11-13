const fs = require('fs');

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
        });
    });
}