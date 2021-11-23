window.addEventListener("load", function () {

    var tabla1=document.getElementById("tablaPre")
    var tabla2=document.getElementById("tablaPost")
    var izquierda=document.getElementById("izquierda")
    var derecha=document.getElementById("derecha")
    var checkBox = document.getElementsByName("sel");

    pedirPregunas();


    function pedirPregunas() {
        const ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(ajax.responseText);
                if (respuesta.preguntas.length > 0) {
                    for (let i = 0; i < respuesta.preguntas.length; i++) {
                        crearContenido(respuesta.preguntas[i].id_pregunta,respuesta.preguntas[i].enunciado, respuesta.preguntas[i].descripcion_tem);
                       
                    }
                }
            }
        }
        ajax.open("POST", "../php/pedirPreguntas.php");
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

        // tr.onclick=function(){
        //     crearContenidoEx(this.id,this.children[1].innerHTML,this.children[2].innerHTML);
        //     this.setAttribute("style","display:none;");
        // }
        tabla1.appendChild(tr);
    }

    derecha.onclick=function() {
        for (let i = 0; i < checkBox.length; i++) {
            if (checkBox[i].checked) {
                var id=checkBox[i].parentNode.parentNode.id;
                var enun=checkBox[i].parentNode.parentNode.children[1].innerHTML;
                var tem=checkBox[i].parentNode.parentNode.children[2].innerHTML;
        
                crearContenidoEx(id,enun,tem);
                checkBox[i].parentNode.parentNode.setAttribute("style","display:none;")
                checkBox[i].checked=false;
            }
        }
    }

    izquierda.onclick=function () {
        for (let i = 0; i < tabla1.children.length; i++) {
            tabla1.children[i].setAttribute("style","display:;");
        }
        tabla2.innerHTML = "";
    }


    function crearContenidoEx(id_preg,enunciado, tematica) {
        var count2=tabla2.children.length;

        var tr=document.createElement("tr");
        var td1=document.createElement("td");
        var td2=document.createElement("td");
        var td3=document.createElement("td");

        tr.setAttribute("id",id_preg);
        td1.innerHTML=count2+1;
        td2.innerHTML=enunciado;
        td3.innerHTML=tematica;

        tr.ondblclick=function(){
            for (let i = 0; i < tabla1.children.length; i++) {
                if (tabla1.children[i].id==this.id) {
                    tabla1.children[i].setAttribute("style","display:;");
                    tabla2.deleteRow(this.children[0].innerText-1);
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
        ids=tabla2.children.length;
        for (let i = 0; i < ids; i++) {
            tabla2.children[i].children[0].innerHTML=i+1;            
        }
        
    }






})