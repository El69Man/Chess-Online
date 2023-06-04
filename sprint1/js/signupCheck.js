window.onload = function(){
  
    document.signupForm.username.addEventListener("blur",databaseCheck);
    document.signupForm.password.addEventListener("blur",passwordCheck);

    function databaseCheck(){
        var username = this;
        var usernameData = username.value;
        var datos = "username=" + encodeURIComponent(usernameData);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../php/userCheck.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var resultado = xhr.responseText; 
                if (resultado == "existe") {
                    // El valor existe, mostrar mensaje de error
                    username.setCustomValidity("El usuario ya existe");
                    username.reportValidity();
                    username.style.border = "2px solid red";
                } else {
                    // El valor no existe, borrar mensaje de error
                    username.setCustomValidity("");
                    username.style.border = "2px solid green";
                }
            }
            
            
        }
        xhr.send(datos);
    }

    function passwordCheck(){
        var password = this;
        var passwordData = password.value;

        if (meter.value <= 2) {
            password.setCustomValidity("Contrasenya insegura");
            password.reportValidity();
            password.style.border = "2px solid red";
        }
        
        else {
            // El valor no existe, borrar mensaje de error
            password.setCustomValidity("");
            password.style.border = "2px solid green";
        }

    }
    //Barra de força de contrasenya
    var password = document.getElementById('password');
    var meter = document.getElementById('password-strength-meter');
    
    document.signupForm.password.addEventListener('input', function(){
        var val = password.value;
        var result = zxcvbn(val);
        
        // Canviem el valor del meter
        meter.value = result.score;   
    });
}