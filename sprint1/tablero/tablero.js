window.onload=function(){

	let canvas = document.getElementById('tablero');
   	let ctx = canvas.getContext("2d");

	let casillasClaras="#f0d8ce";
	let casillasOscuras="#824830";

	ctx.strokeStyle = "black";
   	ctx.strokeRect(0, 0, 800, 800);

   	/*ctx.fillStyle = casillasClaras;
   	ctx.fillRect(0, 0, 75, 75);

   	ctx.fillStyle = casillasOscuras;
   	ctx.fillRect(75, 0, 75, 75);*/

   	let x = 100;
	let y = 100;
	let anchoTablero = canvas.width;
	let altoTablero = canvas.height;
	let casilla = anchoTablero / 8;

	for (let i = 0; i <= 7; i++) {
	   for (let j = 0; j <= 7; j++) {
	      ctx.fillStyle = (i + j) % 2 == 0 ? casillasClaras : casillasOscuras;
	      ctx.fillRect(
	         x + casilla * (i - 1),
	         y + casilla * (j - 1),
	         casilla,
	         casilla
	      );
	   }
	}

/*=========================Crear coordenadas del tablero=========================*/

	let coordenadas=new Array(8);

	for(let i=0;i<coordenadas.length;i++){
		coordenadas[i]=new Array(8);
	}

	for(let i=0;i<8;i++){
		for(let j=0;j<8;j++){
			coordenadas[i][j]=new Array(2);
		}
	}

	for(let i=0;i<8;i++){
		for(let j=0;j<8;j++){
			coordenadas[i][j]=[i,j];
		}
	}	

	console.log(coordenadas.length);
};