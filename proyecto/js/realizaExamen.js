window.addEventListener("load", function () {
    var contenido=document.getElementById("contenido");
    var titulo=document.getElementById("titulo");




pideExamen();






    function pideExamen() {
        const ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(ajax.responseText);

                // for (let i = 0; i < respuesta.preguntas.length; i++) {
                    //     crearContenido(respuesta.preguntas[i].id_pregunta,respuesta.preguntas[i].enunciado, respuesta.preguntas[i].descripcion_tem);
                       
                    // }
                
            }
        }
        ajax.open("POST", "../php/pedirExamen.php?exa=2");
        ajax.send();
    }




    function crearContenido(id_preg,enunciado, tematica) {

        var tr=document.createElement("tr");
        var td1=document.createElement("td");
        var td2=document.createElement("td");
        var td3=document.createElement("td");
        var check=document.createElement("input");
        check.setAttribute("type","checkbox");
        check.setAttribute("name","sel");

        tr.setAttribute("id",id_preg);
        td1.appendChild(check);
        td2.innerHTML=enunciado;
        td3.innerHTML=tematica;

        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);

        tabla1.appendChild(tr);
    }







})