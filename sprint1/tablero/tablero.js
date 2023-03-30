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

	//una sola fila de 8 valores
	let coordenadas=new Array(8);

	//una columna de 8 valores para cada valor de la fila (se convierte en matriz 8x8)
	for(let i=0;i<coordenadas.length;i++){
		coordenadas[i]=new Array(8);
	}

	//cada valor de la matriz se convierte en un array de 2 valores (casilla con coordenadas x,y)
	for(let i=0;i<8;i++){
		for(let j=0;j<8;j++){
			coordenadas[i][j]=new Array(2);
		}
	}

	//cada casilla recibe valores numéricos (desde [0,0] hasta [7,7])
	for(let i=0;i<8;i++){
		for(let j=0;j<8;j++){
			coordenadas[i][j]=[i,j];
		}
	}	


};