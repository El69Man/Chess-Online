window.onload = function(){
  
    document.signupForm.username.addEventListener("blur",databaseCheck);
    function databaseCheck(){
        var username = document.getElementById("username").value;
        var datos = "username=" + encodeURIComponent(username);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "signupCheck.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var resultado = xhr.responseText; 
                if (resultado == "existe") {
                    // El valor existe, mostrar mensaje de error
                    document.getElementById("username").setCustomValidity("El usuario ya existe");
                } else {
                    // El valor no existe, borrar mensaje de error
                    document.getElementById("username").setCustomValidity("");
                }
            }
            
            
        }
        xhr.send(datos);
    }

}