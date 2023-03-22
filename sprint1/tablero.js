window.onload=function(){

	let canvas = document.getElementById('tablero');
   	let ctx = canvas.getContext("2d");

	let casillasClaras="#f0d8ce";
	let casillasOscuras="#824830";

	ctx.strokeStyle = "black";
   	ctx.strokeRect(0, 0, 400, 400);

   	ctx.fillStyle = casillasClaras;
   	ctx.fillRect(0, 0, 50, 50);

   	ctx.fillStyle = casillasOscuras;
   	ctx.fillRect(50, 0, 50, 50);

   	let x = 100;
	let y = 100;
	let anchoTablero = canvas.width;
	let altoTablero = canvas.height;
	let casilla = anchoTablero / 8;

	for (let i = 1; i <= 8; i++) {
	   for (let j = 1; j <= 8; j++) {
	      ctx.fillStyle = (i + j) % 2 == 0 ? casillasClaras : casillasOscuras;
	      ctx.fillRect(
	         x + casilla * (i - 1),
	         y + casilla * (j - 1),
	         casilla,
	         casilla
	      );
	   }
	}
};