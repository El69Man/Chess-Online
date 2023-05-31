window.addEventListener("load",function(){

    const socket=new WebSocket("ws://localhost:8080");
    const tablero=document.getElementsByClassName("board-b72b1")[0];
    const botonJugar=document.getElementById("playBtn");

    socket.onopen=function(){
        console.log("socket.onopen ejecutado");
    };

    socket.onmessage=function(event){
        console.log(event.data);
    };

    socket.onclose=function(){
        console.log("socket.onclose ejecutado");
    };

    socket.onerror=function(error){
        console.log(error);
    };
});