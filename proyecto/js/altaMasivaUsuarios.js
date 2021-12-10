window.addEventListener("load", function () {

    var alta = document.getElementById("alta");

    alta.onclick = function () {
        var contenido = document.getElementById("usuarios").value;

        // en js validar formato, php si existe y devolver los que estan mal


        var csv_gen_usuarios = contenido.slice(contenido.indexOf("")).split("\n");
        var error_mail = [];

        for (let i = 0; i < csv_gen_usuarios.length; i++) {

            if (/[a-z0-9._%+-\u00f1\u00d1]+@[a-z0-9.-]+\.[a-z]{2,4}$/.test(csv_gen_usuarios[i]) == false) {
                error_mail.push(csv_gen_usuarios[i]);
            }

        }
        if (error_mail != "") {
            mostrar = error_mail.join("\n");
            alert("Los siguientes correos no tienen el formato correcto: \n" + mostrar);
        }
        else {
            var miObjeto = new Object();
            miObjeto.usuarios = csv_gen_usuarios;

            var usuarios = JSON.stringify(miObjeto);
            var users = new FormData();
            users.append("datos", usuarios);
            const ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function () {
                if (ajax.readyState == 4 && ajax.status == 200) {
                    var respuesta = JSON.parse(ajax.responseText);
                    if (respuesta != "") {
                        mostrar = respuesta.join("\n");
                        alert("Los siguientes correos ya existen y no se han insertado: \n" + mostrar);
                        document.getElementById("usuarios").value = mostrar;
                    }
                    else{window.location = "http://localhost/proyecto-1tri/proyecto/php/altaMasivaUsuarios.php"; }
                }
              
            }
            ajax.open("POST", "../php/inserta_alta_masiva_usuarios.php");
            ajax.send(users);
        }


    }






















});