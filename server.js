var app = require('express')();

var session = require('express-session');
var sharedSession = require("express-socket.io-session");

app.use(session({
	secret: 'abcdefghijklmñopqrstuvwxyz',
	resave: true,
    saveUninitialized: true
}));

var server = require('http').Server(app);

var io = require('socket.io')(server);


io.use(sharedSession(session({
	secret: 'abcdefghijklmñopqrstuvwxyz',
	resave: true,
    saveUninitialized: true
}), {
	autoSave: true
}));

var redis = require('redis');

server.listen(3000);

var redisClient = redis.createClient();

io.on('connection', function(socket) {
	redisClient.subscribe('message');

	redisClient.on('message', function(channel, message) {
		let user = socket.handshake.session.user;

		if (!user) {
			return;
		}

		message = JSON.parse(message);

		user = message.conversation.users.find((userConversation) => {
			if (userConversation.id == user.id) {
				return user;
			}
		});

		if (!user) {
			return;
		}

		socket.emit(channel, message);
	});

	socket.on('session', function(user) {
		if (!socket.handshake.session.user) {
			socket.handshake.session.user = user;
		}

		return;
	});

});