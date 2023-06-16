var board;
var game;
window.onload = function () {
	initGame();

	function initGame() {
		var cfg = {
			draggable: true,
			position: 'start',
			onDrop: handleMove
		};
	};

	board = ChessBoard('board', cfg);
	game = new Chess();

	function handleMove(source, target) {
		var move = game.move({ from: source, to: target });
		if (move === null) return 'snapback';
		else socket.emit('move', move)
	};

	socket.on('move', function (msg) {
		game.move(msg);
		board.position(game.fen());
	});

};