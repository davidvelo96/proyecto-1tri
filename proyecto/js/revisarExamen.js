window.addEventListener("load", function () {

    var queryString = window.location.search;
    var urlParams = new URLSearchParams(queryString);
    var exam = urlParams.get('exa');


    var pre = document.getElementById("pregunta");

    var titulo = document.getElementById("titulo_preg");
    var n_preguntas = document.getElementById("n_preguntas");
 
    var n_preguntas;


    pideExamen();



    function pideExamen() {
        const ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4 && ajax.status == 200) {
                examen = JSON.parse(ajax.responseText);
                creaPregunta(examen);
                crearNumeros(examen);
                cambiaPregunta(examen.exam[0].n_preguntas[0][0], examen, 1);

                n_preguntas = examen.exam[0].n_preguntas.length;
            }
        }
        ajax.open("GET", "../zona_alumno/pedirExamenHecho.php?exa=" + exam);
        ajax.send();
    }



    function crearNumeros(pregunta) {

        var totalfilas = Math.ceil(pregunta.exam[0].n_preguntas.length / 10)

        for (let i = 0; i < totalfilas; i++) {
            var tr = document.createElement("tr");

            for (let i = 0; i < pregunta.exam[0].n_preguntas.length; i++) {

                var td = document.createElement("td");
                td.setAttribute("id", pregunta.exam[0].n_preguntas[i][0]);
                td.setAttribute("class", "");

                td.innerText = i + 1;
                td.onclick = function () {
                    cambiaPregunta(this.id, pregunta, this.innerText);
                }

                tr.appendChild(td);
            }
            n_preguntas.appendChild(tr);
        }
    }


    function cambiaPregunta(id, pregunta, tituloP) {
        for (let i = 0; i < pregunta.exam[0].n_preguntas.length; i++) {
            var preg = document.getElementById("preg" + pregunta.exam[0].n_preguntas[i][0]);
            preg.setAttribute("style", "display:none;");

            var num = document.getElementsByTagName("td")[i];
            num.setAttribute("class", "");
        }


        titulo.innerText = "Pregunta " + tituloP;
        var preg = document.getElementById("preg" + id);
        preg.setAttribute("style", "");
        for (let i = 0; i < pregunta.exam[0].n_preguntas.length; i++) {
            if (document.getElementsByTagName("td")[i].id == id) {
                var num = document.getElementsByTagName("td")[i];
                num.setAttribute("class", "marcado");
            }

        }

    }


    function creaPregunta(pregunta) {
        var todo = document.createElement("div");
        var tamano = pregunta.exam[0].n_preguntas.length;

        for (let i = 0; i < tamano; i++) {


            var contenido = document.createElement("div");
            var imag = document.createElement("div");
            var resp = document.createElement("div");

            imag.setAttribute("id", "imagen_preg");
            var enunciado = document.createElement("p");
            var imagen = document.createElement("img");

            imagen.setAttribute("width", "500px");
            imagen.setAttribute("height", "350px");
            imagen.setAttribute("src", "../"+pregunta.exam[0].n_preguntas[i][3]);

            enunciado.setAttribute("id", "enunciado");
            enunciado.innerText = pregunta.exam[0].n_preguntas[i][1];

            imag.appendChild(imagen);
            contenido.appendChild(imag);
            resp.appendChild(enunciado);


            for (let j = 0; j < 4; j++) {
                var radio = document.createElement("input");
                radio.setAttribute("type", "radio");
                radio.setAttribute("id", pregunta.exam[0].n_preguntas[i][2][j].id);
                radio.setAttribute("name", "radio" + i);
                if (pregunta.exam[0].respuestas_seleccionadas[i]==pregunta.exam[0].n_preguntas[i][2][j].id) {
                    radio.checked=true;
                }
                radio.disabled=true;
                var span = document.createElement("span");
                
                span.setAttribute("id", pregunta.exam[0].n_preguntas[i][2][j].id);
                span.innerText = pregunta.exam[0].n_preguntas[i][2][j].enunciado;
                var spancorrect = document.createElement("span");
                if (pregunta.exam[0].n_preguntas[i][2][j].id==pregunta.exam[1][i]) {
                    spancorrect.innerText = " correcta";
                    spancorrect.setAttribute("class","correcta");
                }
                var br = document.createElement("br");

                resp.setAttribute("id", "resp_preg");
                resp.appendChild(radio);
                resp.appendChild(span);
                resp.appendChild(spancorrect);
                resp.appendChild(br);

                contenido.setAttribute("id", "preg" + pregunta.exam[0].n_preguntas[i][0])
                contenido.setAttribute("style", "display:none;")
                contenido.appendChild(resp);

            }

            todo.appendChild(contenido);
            pre.appendChild(todo);



        }

    }


    // function timer() {


    //     var days = Math.floor(current_level / 86400);
    //     var remainingDays = current_level - (days * 86400);

    //     //if (days <= 0){
    //     //    days = current_level;
    //     //}

    //     var hours = Math.floor(remainingDays / 3600);
    //     var remainingHours = remainingDays - (hours * 3600);

    //     //if (hours >= 24){
    //     //     hours = 23;
    //     //}

    //     var minutes = Math.floor(remainingHours / 60);
    //     var remainingMinutes = remainingHours - (minutes * 60);

    //     //if (minutes >= 60) {
    //     //     minutes = 59;
    //     //}

    //     var seconds = remainingMinutes;

    //     if (hours < 10) {
    //         hours = "0" + hours;
    //     }
    //     if (minutes < 10) {
    //         minutes = "0" + minutes;
    //     }
    //     if (seconds < 10) {
    //         seconds = "0" + seconds;
    //     }
    //     duracion.innerHTML = hours + ":" + minutes + ":" + seconds;

    //     //if (seconds == 0) {
    //     //    clearInterval(countdownTimer);
    //     //     duracion.innerHTML = "Completed";
    //     //}

    //     current_level--;

    //     if (current_level < 1) {
    //         finalizarExamen();
    //     }


    // }

})