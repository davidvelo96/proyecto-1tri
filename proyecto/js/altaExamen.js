window.addEventListener("load", function () {

    var tabla1 = document.getElementById("tablaPre")
    var tabla2 = document.getElementById("tablaPost")
    var izquierda = document.getElementById("izquierda")
    var derecha = document.getElementById("derecha")
    var checkBox = document.getElementsByName("sel");
    var duracion = document.getElementById("duracion");
    var desc_examen = document.getElementById("descripcion");
    var busq_tematica = document.getElementById("busq_tematica");

    var enviar = document.getElementById("enviar");

    pedirPregunas();
    
    desc_examen.addEventListener("keypress", function (event) {
        var regex = new RegExp("^[a-zA-ZÀ-ÿ \u00f1\u00d1]+$");
        var key = event.key;
        if (!regex.test(key) || event.repeat|| desc_examen.value.length>29) {
            event.preventDefault();
        }
    });

    duracion.addEventListener("keyup", function (event) {
        var regex = new RegExp("^[0-9]+$");
        var key = event.key;
        if (!regex.test(key) || event.repeat || duracion.value.length>3) {
            event.preventDefault();
        }
        if (duracion.value>1400) {
            duracion.value=1399;
        }
    });

    function pedirPregunas() {
        const ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(ajax.responseText);
                if (respuesta.preguntas.length > 0) {
                    for (let i = 0; i < respuesta.preguntas.length; i++) {
                        crearContenido(respuesta.preguntas[i].id_pregunta, respuesta.preguntas[i].enunciado, respuesta.preguntas[i].descripcion_tem);
                    }
                }
            }
        }
        ajax.open("POST", "../php/pedirPreguntas.php");
        ajax.send();
    }


    function crearContenido(id_preg, enunciado, tematica) {


        var tr = document.createElement("tr");
        var td1 = document.createElement("td");
        var td2 = document.createElement("td");
        var td3 = document.createElement("td");
        var check = document.createElement("input");
        check.setAttribute("type", "checkbox");
        check.setAttribute("name", "sel");

        tr.setAttribute("id", id_preg);
        td1.appendChild(check);
        td2.innerHTML = enunciado;
        td3.innerHTML = tematica;

        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);

        tabla1.appendChild(tr);
    }

    derecha.onclick = function () {
        for (let i = 0; i < checkBox.length; i++) {
            if (checkBox[i].checked) {
                var id = checkBox[i].parentNode.parentNode.id;
                var enun = checkBox[i].parentNode.parentNode.children[1].innerHTML;
                var tem = checkBox[i].parentNode.parentNode.children[2].innerHTML;

                crearContenidoEx(id, enun, tem);
                checkBox[i].parentNode.parentNode.setAttribute("style", "display:none;")
                checkBox[i].checked = false;
            }
        }
    }

    izquierda.onclick = function () {
        if (tabla2.children.length > 0) {
            for (let i = 0; i < tabla1.children.length; i++) {
                tabla1.children[i].setAttribute("style", "display:;");
            }
            tabla2.innerHTML = "";
            busq_tematica.value=busq_tematica[0].value;
        }

    }


    function crearContenidoEx(id_preg, enunciado, tematica) {
        var count2 = tabla2.children.length;

        var tr = document.createElement("tr");
        var td1 = document.createElement("td");
        var td2 = document.createElement("td");
        var td3 = document.createElement("td");

        tr.setAttribute("id", id_preg);
        td1.innerHTML = count2 + 1;
        td2.innerHTML = enunciado;
        td3.innerHTML = tematica;

        tr.ondblclick = function () {
            for (let i = 0; i < tabla1.children.length; i++) {
                if (tabla1.children[i].id == this.id) {
                    tabla1.children[i].setAttribute("style", "display:;");
                    tabla2.deleteRow(this.children[0].innerText - 1);
                }
            }
            reiniciaIDS();
        }

        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);

        tabla2.appendChild(tr);
    }

    function reiniciaIDS() {
        ids = tabla2.children.length;
        for (let i = 0; i < ids; i++) {
            tabla2.children[i].children[0].innerHTML = i + 1;
        }

    }


    function convertirMinAhorasMin(mins) {
        if (mins > 1400) {
            mins = 1399;
        }
        let h = Math.floor(mins / 60);
        let m = mins % 60;
        h = h < 10 ? '0' + h : h;
        m = m < 10 ? '0' + m : m;
        return `${h}:${m}`;
    }



    function EnviarEx() {
        var n_preguntas = tabla2.children.length;
        if (n_preguntas != 0) {
            var ids_preg = [];
            for (let i = 0; i < n_preguntas; i++) {
                ids_preg.push(tablaPost.children[i].id);
            }
            var miObjeto = new Object();

            expresion_regular_desc = /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ \u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/;

            if (expresion_regular_desc.test(desc_examen.value) == true) {
                miObjeto.desc = desc_examen.value;
                miObjeto.duracion = convertirMinAhorasMin(duracion.value);
                miObjeto.n_preguntas = n_preguntas;
                miObjeto.id_preguntas = ids_preg;


                var myString = JSON.stringify(miObjeto);
                var f = new FormData();
                f.append("datos", myString);
                const ajax = new XMLHttpRequest();

                ajax.onreadystatechange = function () {
                    if (ajax.readyState == 4 && ajax.status == 200) {
                        var respuesta = ajax.responseText;
                        if (respuesta == "OK") {
                            desc_examen.focus();
                        }
                    }
                }
                ajax.open("POST", "../php/insertaExamen.php");
                ajax.send(f);
            }
        }
    }

    enviar.onclick = function () {
        EnviarEx();
    }



    busq_tematica.onchange = function () {

        var busq = busq_tematica.value;

        for (let i = 0; i < tabla1.children.length; i++) {
            if (tabla1.children[i].children[2].innerText.search(busq.toUpperCase()) != -1) {

                if (tabla2.children.length > 0) {
                    for (let j = 0; j < tabla2.children.length; j++) {

                        if (tabla1.children[i].id == tabla2.children[j].id) {
                            tabla1.children[i].setAttribute("style", "display:none;")
                            i++;
                        } else {
                            tabla1.children[i].setAttribute("style", "display:;")
                        }
                    }
                } else {
                    tabla1.children[i].setAttribute("style", "display:;")
                }

            } else {
                tabla1.children[i].setAttribute("style", "display:none;")
            }
        }
    }



})