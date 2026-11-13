 // La siguiente funcion valida el elemento input
    function validar(id) {
      // Variable que usaremos para determinar si el input es valido
      let isValid = false;

      // El input que queremos validar
      //alert(id);
      const input = document.forms['validationForm'][id];

      //El div con el mensaje de advertencia:
      const message = document.getElementById('message');

      input.willValidate = false;

      // El tamaño maximo para nuestro input
      const maximo = 35;

      // El pattern que vamos a comprobar
      //const pattern = new RegExp('^[A-Z]+$', 'i');
      const pattern = new RegExp('^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$', 'i');

      // Primera validacion, si input esta vacio entonces no es valido
      if(!input.value) {
        isValid = false;
      } else {
        // Segunda validacion, si input es mayor que 35
        if(input.value.length > maximo) {
          isValid = false;
        } else {
          // Tercera validacion, si input contiene caracteres diferentes a los permitidos
          if(!pattern.test(input.value)){ 
          // Si queremos agregar letras acentuadas y/o letra ñ debemos usar
          // codigos de Unicode (ejemplo: Ñ: \u00D1  ñ: \u00F1)
            isValid = false;
          } else {
            // Si pasamos todas la validaciones anteriores, entonces el input es valido
            isValid = true;
          }
        }
      }

      //Ahora coloreamos el borde de nuestro input
      if(!isValid) {
        // rojo: no es valido
        input.style.borderColor = 'salmon'; // me parece que 'salmon' es un poco menos agresivo que 'red'
        // mostramos mensaje
        message.hidden = false;
      } else {
        // verde: si es valido
        input.style.borderColor = 'palegreen'; // 'palegreen' se ve mejor que 'green' en mi opinion
        // ocultamos mensaje;
        message.hidden = true;
      }

      // devolvemos el valor de isValid
      return isValid;
    }
    function validar2(id) {
        const maximo = 8;
    
        // Variable que usaremos para determinar si el input es valido
        let isValid = false;

        // El input que queremos validar
        const input = document.forms['validationForm'][id];

        //El div con el mensaje de advertencia:
        const message2 = document.getElementById('message2');

        input.willValidate = false;
  
        // El pattern que vamos a comprobar
        //const pattern = new RegExp('^[A-Z]+$', 'i');
        const pattern = new RegExp('^[0-9]+$', 'i');

        // Primera validacion, si input esta vacio entonces no es valido
        if (!input.value) {
            isValid = false;
        } else {
            // Segunda validacion, si input es mayor que 35
            if (input.value.length > maximo) {
                isValid = false;
            } else {
                // Tercera validacion, si input contiene caracteres diferentes a los permitidos
                if (!pattern.test(input.value)) {
                    // Si queremos agregar letras acentuadas y/o letra ñ debemos usar
                    // codigos de Unicode (ejemplo: Ñ: \u00D1  ñ: \u00F1)
                    isValid = false;
                } else {
                    // Si pasamos todas la validaciones anteriores, entonces el input es valido
                    isValid = true;
                }
            }
        }

        //Ahora coloreamos el borde de nuestro input
        if (!isValid) {
            // rojo: no es valido
            input.style.borderColor = 'salmon'; // me parece que 'salmon' es un poco menos agresivo que 'red'
            // mostramos mensaje
            message2.hidden = false;
        } else {
            // verde: si es valido
            input.style.borderColor = 'palegreen'; // 'palegreen' se ve mejor que 'green' en mi opinion
            // ocultamos mensaje;
            message2.hidden = true;
        }

        // devolvemos el valor de isValid
        return isValid;
    }

    function validar3(id) {
        const maximo = 6;

        // Variable que usaremos para determinar si el input es valido
        let isValid = false;

        // El input que queremos validar
        const input = document.forms['validationForm'][id];

        //El div con el mensaje de advertencia:
        const message4 = document.getElementById('message4');

        input.willValidate = false;

        // El pattern que vamos a comprobar
        //const pattern = new RegExp('^[A-Z]+$', 'i');
        const pattern = new RegExp('^[0-9]+$', 'i');

        // Primera validacion, si input esta vacio entonces no es valido
        if (!input.value) {
            isValid = false;
        } else {
            // Segunda validacion, si input es mayor que 35
            if (input.value.length > maximo) {
                isValid = false;
            } else {
                // Tercera validacion, si input contiene caracteres diferentes a los permitidos
                if (!pattern.test(input.value)) {
                    // Si queremos agregar letras acentuadas y/o letra ñ debemos usar
                    // codigos de Unicode (ejemplo: Ñ: \u00D1  ñ: \u00F1)
                    isValid = false;
                } else {
                    // Si pasamos todas la validaciones anteriores, entonces el input es valido
                    isValid = true;
                }
            }
        }

        //Ahora coloreamos el borde de nuestro input
        if (!isValid) {
            // rojo: no es valido
            input.style.borderColor = 'salmon'; // me parece que 'salmon' es un poco menos agresivo que 'red'
            // mostramos mensaje
            message4.hidden = false;
        } else {
            // verde: si es valido
            input.style.borderColor = 'palegreen'; // 'palegreen' se ve mejor que 'green' en mi opinion
            // ocultamos mensaje;
            message4.hidden = true;
        }

        // devolvemos el valor de isValid
        return isValid;
    }

    function validarPatente(patente) {

        const input = document.forms['validationForm']['patente'];
        
        const pattern = new RegExp('^[a-z]+$', 'i');
        const patternN = new RegExp('^[0-9]+$', 'i');

        const message3 = document.getElementById('message3');

        isValid = false;
        //alert(patente);
        if(patente.length==6 || patente.length==7){
            if(patente.length==6){
                //alert(patente.substr(0,3)); 
                //alert(patente.substr(-3));
                if (!pattern.test(patente.substr(0,3))) {
                    
                    isValid = false;
                } else {
                    if (!patternN.test(patente.substr(-3))) {
                        isValid = false;
                       
                    }
                    else{
                        isValid = true;
                    }
                }
                if (!isValid) {
                    // rojo: no es valido
                    input.style.borderColor = 'salmon'; // me parece que 'salmon' es un poco menos agresivo que 'red'
                    // mostramos mensaje
                    message3.hidden = false;
                } else {
                    // verde: si es valido
                    input.style.borderColor = 'palegreen'; // 'palegreen' se ve mejor que 'green' en mi opinion
                    // ocultamos mensaje;
                    message3.hidden = true;
                }
                if (!isValid) {
                    // rojo: no es valido
                    input.style.borderColor = 'salmon'; // me parece que 'salmon' es un poco menos agresivo que 'red'
                    // mostramos mensaje
                    message3.hidden = false;
                } else {
                    // verde: si es valido
                    input.style.borderColor = 'palegreen'; // 'palegreen' se ve mejor que 'green' en mi opinion
                    // ocultamos mensaje;
                    message3.hidden = true;
                }
           }
           
           else{
                ////alert(patente.substr(0, 2));
                //alert(patente.substr(-2));
               // alert(patente.substr(2,3));
                if (!pattern.test(patente.substr(0, 2))) {
                    //alert(patente.substr(0, 2))
                    isValid = false;
                } 
                else {
                    if (!pattern.test(patente.substr(-2))) {
                        //alert(patente.substr(-2));
                        isValid = false;
                        //alert(patente);
                    }
                    else{
                        if (!patternN.test(patente.substr(2,3))) {
                            //alert(patente.substr(-2));
                            isValid = false;
                            //alert(patente);
                        }
                        else{
                            isValid = true;
                        }

                    }

                }
                if (!isValid) {
                    // rojo: no es valido
                    input.style.borderColor = 'salmon'; // me parece que 'salmon' es un poco menos agresivo que 'red'
                    // mostramos mensaje
                    message3.hidden = false;
                } else {
                    // verde: si es valido
                    input.style.borderColor = 'palegreen'; // 'palegreen' se ve mejor que 'green' en mi opinion
                    // ocultamos mensaje;
                    message3.hidden = true;
                }

           }


        }
        else{
            if (!isValid) {
                // rojo: no es valido
                input.style.borderColor = 'salmon'; // me parece que 'salmon' es un poco menos agresivo que 'red'
                // mostramos mensaje
                message3.hidden = false;
            } else {
                // verde: si es valido
                input.style.borderColor = 'palegreen'; // 'palegreen' se ve mejor que 'green' en mi opinion
                // ocultamos mensaje;
                message3.hidden = true;
            }
        }

    }

    // Por último, nuestra función que verifica si el campo es válido antes de realizar cualquier otra acción.
    function verificar() {
      const valido = validar();
      if (!valido) {
        alert('El campo no es válido.');
      } else {
        alert('El campo es válido');
      }
    }
