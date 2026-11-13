const fs = require('fs')


fs.readdir('usados/', function (err, archivos) {
  if (err) {
    onError(err);
    return;
  }
  console.log(archivos);
});