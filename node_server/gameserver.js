/*jshint esversion: 6 */

var app = require('http').createServer();

// CORS TRIALS
// var app = require('http').createServer(function(req,res){
// 	// Set CORS headers
// 	res.setHeader('Access-Control-Allow-Origin', 'http://dad.p6.dev');
// 	res.setHeader('Access-Control-Request-Method', '*');
// 	res.setHeader('Access-Control-Allow-Methods', 'OPTIONS, GET');
// 	res.setHeader('Access-Control-Allow-Credentials', true);
// 	res.setHeader('Access-Control-Allow-Headers', req.header.origin);
// 	if ( req.method === 'OPTIONS' ) {
// 		res.writeHead(200);
// 		res.end();
// 		return;
// 	}
// });

var io = require('socket.io')(app);

var MemoryGame = require('./gamemodel.js');
var GameList = require('./gamelist.js');

app.listen(8080, function(){
	console.log('listening on *:8080');
});

// ------------------------
// Estrutura dados - server
// ------------------------

let games = new GameList();

io.on('connection', function (socket) {
    console.log('client has connected');

    socket.on('create_game', function (data){
    	console.log('A new game is about to be created');
    	let game = games.createGame(data.playerName, socket.id);
    	// Use socket channels/rooms
		socket.join(game.gameID);
		// Notification to the client that created the game
		socket.emit('my_active_games_changed');
		// Notification to all clients
		io.emit('lobby_changed');
    });

    socket.on('load-lobby', function () {
		let lobbyGames = games.getLobbyGamesOf(socket.id);
		socket.emit('lobby_games', lobbyGames);
	});

	socket.on('load-active', function () {
		let activeGames = games.getConnectedGamesOf(socket.id);
		socket.emit('active_games', activeGames);
	});

	socket.on('join-game', function (data) {
		let currentGame = games.joinGame(data.game.gameID, data.playerName, socket.id);

		socket.join(currentGame.gameID);
		io.to(currentGame.gameID).emit('my_active_games_changed');

		// Notification to all clients
		io.emit('lobby_changed');
	});

	socket.on('play', function (data) {
		if (data.game['player'+data.game.playerTurn+'SocketID'] == socket.id) {
			let currentGame = games.gameByID(data.game.gameID);

			currentGame.play(data.game.playerTurn, data.index);
			io.to(currentGame.gameID).emit('my_active_games_changed');
		} else {
			socket.emit('message',
				{
					type: 'invalid-play',
				 	text: 'Invalid Player!',
				 	gameID: data.game.gameID
				}
			);
		}
	});

	socket.on('close', function (game) {
		games.removeGame(game.gameID, socket.id);
		io.to(game.gameID).emit('my_active_games_changed');
	});

	socket.on('start', function (game) {
		if (game['player'+game.playerTurn+'SocketID'] == socket.id) {
			let currentGame = games.gameByID(game.gameID);

			currentGame.startGame();
			io.to(currentGame.gameID).emit('my_active_games_changed');
		} else {
			socket.emit('message',
				{
					type: 'invalid-start',
				 	text: "Can't start the game!",
				 	gameID: game.gameID
				}
			);
		}
	});
});
