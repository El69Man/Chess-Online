$(document).ready(function() {
    let config={
        draggable:true,
        dropOffBoard:'snapback',
        position:'start',
    };

          var board1 = Chessboard('board1', config);

    $('#startBtn').on('click', board1.start);
    $('#startBtn').on('click', );
    
  });