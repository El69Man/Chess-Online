// Configuración del servidor
const io = require('socket.io')(8080); // Puerto del servidor

let currentPort = 8080; // Puerto inicial
const maxUsers = 2; // Máximo de jugadores permitidos
let userCount = 0; // Contador de usuarios

// Manejador de conexiones
io.on('connection', (socket) => {
  // Verificar si el puerto actual alcanzó el límite de usuarios
  if (userCount >= maxUsers) {
    // Encontrar el siguiente puerto disponible
    const nextPort = findNextAvailablePort();

    if (nextPort === null) {
      // No se encontró un puerto disponible, cerrar la conexión
      socket.disconnect();
      return;
    }

    currentPort = nextPort;
  }

  // Almacenar el puerto utilizado para esta conexión
  socket.port = currentPort;
  userCount++;

  console.log(`New connection! Socket ID: ${socket.id}, Port: ${socket.port}`);

  // Manejador de desconexiones
  socket.on('disconnect', () => {
    userCount--;
    console.log(`Socket ID: ${socket.id} has disconnected`);
  });
});

// Función para encontrar el siguiente puerto disponible
function findNextAvailablePort() {
  let nextPort = currentPort + 1;

  while (nextPort < 65535) { // 65535 es el número máximo de puertos
    if (getUserCount(nextPort) < maxUsers) {
      return nextPort;
    }

    nextPort++;
  }

  return null; // No se encontró un puerto disponible
}

// Función para contar el número de usuarios en un puerto específico
function getUserCount(port) {
  let count = 0;

  Object.values(io.sockets.sockets).forEach((socket) => {
    if (socket.port === port) {
      count++;
    }
  });

  return count;
}

// Función para determinar el color de las piezas de cada jugador
function determinarColorPiezas(jugadorActual, jugadores) {
    const colores = ['blancas', 'negras'];
    
    // Verificar si ya hay un jugador asignado al color contrario
    const otroJugador = jugadores.find(jugador => jugador.color !== null && jugador !== jugadorActual);
    if (otroJugador) {
      return colores.find(color => color !== otroJugador.color);
    }
  
    // Si no hay otro jugador asignado al color contrario, asignar un color aleatorio
    const colorAleatorio = colores[Math.floor(Math.random() * colores.length)];
    return colorAleatorio;
  }
  
  // Ejemplo de uso
  const jugadores = [
    { nombre: 'Jugador 1', color: null },
    { nombre: 'Jugador 2', color: null }
  ];
  
  // Asignar colores a los jugadores
  jugadores.forEach(jugador => {
    jugador.color = determinarColorPiezas(jugador, jugadores);
  });
  
  // Mostrar los resultados
  jugadores.forEach(jugador => {
    console.log(`${jugador.nombre}: ${jugador.color}`);
  });