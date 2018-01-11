<template>
	<div class="gameseparator">
        <div>
            <h2 class="text-center">Game XXX</h2>
            <br>
        </div>
        <div class="game-zone-content">
            <div class="alert" :class="alerttype">
                <strong>{{ message }} &nbsp;&nbsp;&nbsp;&nbsp;
                    <a v-on:click.prevent="closeGame" v-if="game.gameEnded">Close Game</a>
                </strong>
            </div>
            <div class="board">
                <div v-for="(piece, key) of game.board" >
                    <img v-bind:src="pieceImageURL(key)" v-on:click="clickPiece(key)">
                </div>
            </div>
            <hr>
        </div>
    </div>
</template>

<script type="text/javascript">
	export default {
        props: ['game','socketId'],
        data: function(){
			return {
                alerttype: 'alert-info',
                invalidMessageText: '',
                invalidMessageTextShow: false,
                imgSrcs : [],
                imgs: [],
                hiddenImage : [],
            }
        },
        beforeMount() {
            this.loadImages();
            },
        mounted() {
            this.cloneImgs();
        },
        computed: {
            message(){
                if (this.invalidMessageTextShow) {
                    setInterval(()=>{
                        this.invalidMessageTextShow = false;
                    },2000);
                    return this.invalidMessageText;
                }

                if (this.game.gameEnded) {
                    if (this.game.winner == 0) {
                        this.alerttype = 'alert-warning';
                        return 'Game ended in a tie';
                    }
                    if (this.game['player'+this.game.winner+'SocketID'] == this.socketId) {
                        this.alerttype = 'alert-success';
                        return "You won the game";
                    }else{
                        this.alerttype = 'alert-danger';
                        return 'You lost the game';
                    }
                }

                if (!this.game.player2SocketID) {
                    return 'Waiting for second player.';
                }

                if (this.game['player'+this.game.playerTurn+'SocketID'] == this.socketId) {
                    return "It's your turn";
                }else{
                    return 'Waiting for other player';
                }
            },
        },
        methods: {
            loadImages() {
                var self = this;

                
                axios.get('api/images/hidden')
                    .then(response=>{
                        self.hiddenImage = response.data;
                });

                axios.get('api/images')
                    .then(response=>{
                        self.imgSrcs = response.data;
                        self.imgs = response.data;
                });
            },
            cloneImgs() {
                this.imgs = this.imgSrcs.slice(0);
                this.imgs.forEach(function(img) {
                   img = this.hiddenImage;
                });
            },
            closeGame (){
                this.$emit('click_close', this.game);
            },
            clickPiece(index){
                console.log('index'+index);
                if (this.game.boardStatus[index] == 0)
                    this.$emit('click_piece', this.game, index);
            },
            pieceImageURL(piece) {
                console.log(piece + ' ------- ' + this.game.boardStatus[piece]);
                if (this.game.boardStatus[piece] > 0)
                    return this.imgs[piece];
                else 
                    return this.hiddenImage;
            },
            getImage(piece) {
            }
        }
    }
</script>

<style scoped>
.gameseparator{
    border-style: solid;
    border-width: 2px 0 0 0;
    border-color: black;
}
</style>