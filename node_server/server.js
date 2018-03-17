var app = require('express')();

var server = require('http').Server(app);

var io = require('socket.io')(server);

var redis = require('redis');

server.listen(3000);

console.log("Servidor funcionando en http://localhost:3000/");

io.on('connection', function(socket) {

	var redisClient = redis.createClient();
	redisClient.subscribe('message');

	redisClient.on('message', function(channel, message) {
		socket.emit(channel, message);
	});

});