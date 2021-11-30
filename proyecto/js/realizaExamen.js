window.addEventListener("load", function () {
    var pre = document.getElementById("pregunta");


    // var contenido = document.getElementById("contenido");
    // var titulo = document.getElementById("titulo_preg");
    // var enun = document.getElementById("enunciado");
    var n_preguntas = document.getElementById("n_preguntas");
    var duracion = document.getElementById("duracion");
    var opcion1 = document.getElementById("opcion1");
    var opcion2 = document.getElementById("opcion2");
    var opcion3 = document.getElementById("opcion3");
    var opcion4 = document.getElementById("opcion4");


    var current_level = 0;


    var countdownTimer = setInterval(timer, 1000);

    pideExamen();


    function pideExamen() {
        const ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var examen = JSON.parse(ajax.responseText);
                desordenaArray(examen.exam[0].n_preguntas);
                desRespuestas(examen);
                creaPregunta(examen);
                // cambiaPregunta(0, examen);
                crearNumeros(examen);

                var seg = parseInt(examen.exam[0].duracion.substr(0, 2)) * 3600;
                var min = parseInt(examen.exam[0].duracion.substr(3, 2)) * 60;
                var tiempo = seg + min;
                current_level = tiempo;

            }
        }
        ajax.open("POST", "../php/pedirExamen.php?exa=2");
        ajax.send();
    }

    function desRespuestas(params) {
        for (let i = 0; i < params.exam[0].n_preguntas.length; i++) {
            desordenaArray(params.exam[0].n_preguntas[i][2]);
        }
    }


    function desordenaArray(params) {
        var desor = params.sort(function () { return Math.random() - 0.5 });
        return desor;
    }

    // function crearPregunta(pregunta) {
    //     // titulo.innerText=pr;

    // }

    function crearNumeros(pregunta) {

        var totalfilas = Math.ceil(pregunta.exam[0].n_preguntas.length / 10)

        for (let i = 0; i < totalfilas; i++) {
            var tr = document.createElement("tr");

            for (let i = 0; i < pregunta.exam[0].n_preguntas.length; i++) {

                var td = document.createElement("td");
                td.setAttribute("href", "#");
                td.setAttribute("id", pregunta.exam[0].n_preguntas[i][0]);
                td.innerText = i + 1;
                td.onclick = function () {
                    cambiaPregunta(this.id,pregunta);
                }

                tr.appendChild(td);
            }
            n_preguntas.appendChild(tr);
        }
    }

    // sort(function() { return Math.random() - 0.5 });

    function cambiaPregunta(id,pregunta) {
        for (let i = 0; i < pregunta.exam[0].n_preguntas.length; i++) {
            var preg = document.getElementById("preg"+pregunta.exam[0].n_preguntas[i][0]);
            preg.setAttribute("style","display:none;");           
        }
        var preg = document.getElementById("preg"+id);

        preg.setAttribute("style","display:;");

    

        // contenido.setAttribute("style","display:block;");


    }


    function creaPregunta(pregunta) {
        var todo = document.createElement("div");
        var tamano = pregunta.exam[0].n_preguntas.length;

        for (let i = 0; i < tamano; i++) {


            var contenido = document.createElement("div");
            var enunciado = document.createElement("p");
            enunciado.setAttribute("id", "enunciado")
            enunciado.innerText = pregunta.exam[0].n_preguntas[i][1];

            contenido.appendChild(enunciado);

            for (let j = 0; j < 4; j++) {
                var radio = document.createElement("input");
                radio.setAttribute("type", "radio");
                radio.setAttribute("id", "opcion" + (j + 1));
                radio.setAttribute("name", "radio" + i);
                var span = document.createElement("span");
                span.setAttribute("id", j);
                span.innerText = pregunta.exam[0].n_preguntas[i][2][j].enunciado;
                var br = document.createElement("br");

                contenido.appendChild(radio);
                contenido.appendChild(span);
                contenido.appendChild(br);

                contenido.setAttribute("id","preg"+pregunta.exam[0].n_preguntas[i][0])
                contenido.setAttribute("style","display:none;")


            }

            todo.appendChild(contenido);
            pre.appendChild(todo);


           

        }
        
    }




    function timer() {

        var days = Math.floor(current_level / 86400);
        var remainingDays = current_level - (days * 86400);

        //if (days <= 0){
        //    days = current_level;
        //}

        var hours = Math.floor(remainingDays / 3600);
        var remainingHours = remainingDays - (hours * 3600);

        //if (hours >= 24){
        //     hours = 23;
        //}

        var minutes = Math.floor(remainingHours / 60);
        var remainingMinutes = remainingHours - (minutes * 60);

        //if (minutes >= 60) {
        //     minutes = 59;
        //}

        var seconds = remainingMinutes;

        duracion.innerHTML = hours + ":" + minutes + ":" + seconds;

        //if (seconds == 0) {
        //    clearInterval(countdownTimer);
        //     duracion.innerHTML = "Completed";
        //}

        current_level--;

        if (current_level < 1) {
            // alert("FIN");
            // document.location = '../php/tablaExamen.php';
        }
    }

})