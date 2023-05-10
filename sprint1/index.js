$(document).ready(function() {
    //Configuramos el tablero
    let config={
        draggable:true,
        dropOffBoard:'snapback',
        position:'start',
    };
    //Pintamos el tablero
    var board1 = Chessboard('board1', config);
    //Reiniciamos el tablero
    $('#startBtn').on('click', board1.start);
    //Limpiamos el texto de la notación
    document.getElementById('startBtn').addEventListener('click', function() {
        document.getElementById('playLog').innerHTML = '';
    });
    //TODO
    
  });