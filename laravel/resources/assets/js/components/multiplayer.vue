<template>
	<div>
        <div>
            <h3 class="text-center">{{ title }}</h3>
            <br>
            <h2>Current Player : {{ currentPlayer }}</h2>
            <p>Set current player name <input v-model.trim="currentPlayer"></p>
            <p><em>Player name replaces authentication! Use different names on different browsers, and don't change it frequently.</em></p>
            <hr>
            <h3 class="text-center">Lobby</h3>
            <p><button class="btn btn-xs btn-success" v-on:click.prevent="createGame">Create a New Game</button></p>
            <hr>
            <h4>Pending games (<a @click.prevent="loadLobby">Refresh</a>)</h4>
            <lobby :games="lobbyGames" @join-click="join"></lobby>
            <template v-for="game in activeGames">
                <game :game="game"
                      :socketId="socketId"
                      @click_piece="play"
                      @click_close="close"
                      :ref = "'gameComponents'+game.gameID">
                </game>
            </template>
        </div>
    </div>
</template>

<script type="text/javascript">
    import Lobby from './lobby.vue';
    import GameTicTocToe from './game.vue';

	export default {
        data: function(){
			return {
                title: 'Multiplayer Memory Game',
                currentPlayer: 'Player X',
                lobbyGames: [],
                activeGames: [],
                socketId: ""
            }
        },
        sockets:{
            connect(){
                console.log('socket connected');
                this.socketId = this.$socket.id;
            },
            disconnect(){
                console.log('socket disconnected');
                this.socketId = "";
            },
            lobby_changed(){
                // For this to work, websocket server must emit a message
                // named "lobby_changed"
                this.loadLobby();
            },
            lobby_games(games){
                this.lobbyGames = games;
            },
            my_active_games_changed(){
                this.loadActiveGames();
            },
            active_games(games){
                this.activeGames = games;
            },
            message(data){
                if (data.type == 'invalid-play') {
                    //martelanço
                    this.$refs['gameComponents'+data.gameID][0].invalidMessageText = data.text;
                    this.$refs['gameComponents'+data.gameID][0].invalidMessageTextShow = true;
                }
            }
        },
        methods: {
            loadLobby(){
                this.$socket.emit('load-lobby');
            },
            loadActiveGames(){
                this.$socket.emit('load-active');
            },
            createGame(){
                // For this to work, server must handle (on event) the "create_game" message
                if (this.currentPlayer == "") {
                    alert('Current Player is Empty - Cannot Create a Game');
                    return;
                }
                else {
                    this.$socket.emit('create_game', { playerName: this.currentPlayer });
                }
            },
            join(game){
                var data = {
                    game: game,
                    playerName: this.currentPlayer
                };
                this.$socket.emit('join-game', data);
            },
            play(game, index){
                var data = {
                    game: game,
                    index: index
                }
                this.$socket.emit('play',data);
            },
            close(game){
                this.$socket.emit('close', game);
            }
        },
        components: {
            'lobby': Lobby,
            'game': GameTicTocToe,
        },
        mounted() {
            this.loadLobby();
        }

    }
</script>

<style>

</style>