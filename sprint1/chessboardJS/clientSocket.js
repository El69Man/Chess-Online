const net = require('net');

// Set server IP address and port number
const serverIP = '127.0.0.1';
const serverPort = 9001;

// Create a client socket
const clientSocket = new net.Socket();

// Connect to the server socket
clientSocket.connect(serverPort, serverIP, function() {
  console.log('Connected to server');
  
  // Send data to the server
  const message = 'Hello, server!';
  clientSocket.write(message);
});

// Receive data from the server
clientSocket.on('data', function(data) {
  const response = data.toString();
  console.log('Server response: ' + response);
});

// Handle socket closure
clientSocket.on('close', function() {
  console.log('Connection closed');
});
