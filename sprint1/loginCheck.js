window.onload = function(){
  
    document.loginForm.username.addEventListener("blur",databaseCheck);
    //document.loginForm.password.addEventListener("blur",passwordCheck);

    function databaseCheck(){
        var username = this;
        var usernameData = username.value;
        var datos = "username=" + encodeURIComponent(usernameData);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "userCheck.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var resultado = xhr.responseText; 
                if (resultado == "existe") {
                    // El valor existe, borrar mensaje de error
                    username.setCustomValidity("");  
                    username.style.border = "2px solid green";  
                } 
                else {
                    // El valor no existe, mostrar mensaje de error
                    username.setCustomValidity("El usuario no existe");
                    username.reportValidity(); 
                    username.style.border = "2px solid red";
                }
            } 
        }
        xhr.send(datos);
    }
}