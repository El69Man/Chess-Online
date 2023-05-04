$(document).ready(function() {
    var maxZoom = 2.6;
    
    function resizeBoard() {
        var board = $("#board1");
        var boardWidth = board.width();
        var windowWidth = $(window).width();
        var zoom = Math.min(windowWidth / boardWidth, maxZoom);
        board.css("zoom", zoom);
      }
    
    // actualizaremos el zoom cuando la ventana cambie de tamaño
    $(window).on("resize", resizeBoard);
      
    // y al cargar la página
    resizeBoard();
  });