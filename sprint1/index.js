$(document).ready(function() {
  iniciarTablero();

    //Reiniciamos el tablero
    //Limpiamos el texto de la notación
    document.getElementById('startBtn').addEventListener('click', function() {
        //location.reload();
        document.getElementById('playLog').innerHTML = "";
        iniciarTablero();

    });
    
    $(".valid").on('click', function() {
        window.location.href="socketServer/socketServer.php";
    });
    





    //Logica de ajedrez
function iniciarTablero() {
  var board = null
  var game = new Chess()
  var whiteSquareGrey = '#a9a9a9'
  var blackSquareGrey = '#696969'
  var $status = $('#status')
  var $fen = $('#fen')
  var $pgn = $('#pgn')
  var contColor = 1;
  var contPrint = 1;

  var config = {
    draggable: true,
    position: 'start',
    onDragStart: onDragStart,
    onDrop: onDrop,
    onMouseoutSquare: onMouseoutSquare,
    onMouseoverSquare: onMouseoverSquare,
    onSnapEnd: onSnapEnd
  }

  board = Chessboard('board1', config)

  updateStatus()

  function removeGreySquares () {
    $('#board1 .square-55d63').css('background', '')
  }

  function greySquare (square) {
    var $square = $('#board1 .square-' + square)

    var background = whiteSquareGrey
    if ($square.hasClass('black-3c85d')) {
      background = blackSquareGrey
    }

    $square.css('background', background)
  }


  function onDragStart (source, piece, position, orientation) {
    // do not pick up pieces if the game is over
    if (game.game_over()) return false

    // only pick up pieces for the side to move
    if ((game.turn() === 'w' && piece.search(/^b/) !== -1) ||
        (game.turn() === 'b' && piece.search(/^w/) !== -1)) {
      return false
    }
  }

  function onDrop (source, target) {
    removeGreySquares();
    
    // see if the move is legal
    var move = game.move({
      from: source,
      to: target,
      promotion: 'q' // NOTE: always promote to a queen for example simplicity
    })
    
    // illegal move
    if (move === null) return 'snapback'
    updateStatus()

    //Printamos la notacion
    
    if (contColor%2==0){
      //El movimiento es de negras
    document.getElementById('playLog').innerHTML += move.san+ " ";
    contColor++;
    contPrint++;
    }
    else{
      //El movimiento es de blanca
      document.getElementById('playLog').innerHTML +=contPrint+"."+ move.san+" ";
      contColor++;
    }
  }

  function onMouseoverSquare (square, piece) {
    // get list of possible moves for this square
    var moves = game.moves({
      square: square,
      verbose: true
    })

    // exit if there are no moves available for this square
    if (moves.length === 0) return

    // highlight the square they moused over
    greySquare(square)

    // highlight the possible squares for this piece
    for (var i = 0; i < moves.length; i++) {
      greySquare(moves[i].to)
    }
  }

  function onMouseoutSquare (square, piece) {
    removeGreySquares()
  }
  // update the board position after the piece snap
  // for castling, en passant, pawn promotion
  function onSnapEnd () {
    board.position(game.fen())
  }

  function updateStatus () {
    var status = ''
    var isCheck = false
    var isCheckMate = false
    var moveColor = 'White'

    if (game.turn() === 'b') {
     moveColor = 'Black'
   }

    // checkmate?
    if (game.in_checkmate()) {
      status = 'Game over, ' + moveColor + ' is in checkmate.'
      isCheckMate = true
      alert(status);
    }

    // draw?
    else if (game.in_draw()) {
      status = 'Game over, drawn position'
      alert(status);
      
    }

    // game still on
    else {
      status = moveColor + ' to move'

      // check?
      if (game.in_check()) {
        status += ', ' + moveColor + ' is in check'
        isCheck = true;
      }
    }

    // Capture the move event
   /* game.on('drop', function(source, target, piece, newPos, oldPos, orientation) {
      // Prepare the move data
      var moveData = {
          source: source,
          target: target,
          piece: piece,
          // additional data if needed
      };

        // Convert move data to JSON
        var moveJSON = JSON.stringify(moveData);

        // Send the move data to the server
        socket.send(moveJSON);
      });*/


    $status.html(status)
    $fen.html(game.fen())
    $pgn.html(game.pgn())
    

  }

}

  });