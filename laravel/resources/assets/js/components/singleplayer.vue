<template>
	<div>
        <div>
            <h3 class="text-center">{{ title }}</h3>
            <br>
            <h2>Singleplayer Mode</h2>
            <br>
        </div>
        <div class="game-zone-content">
            <div class="alert alert-success" v-if="showSuccess">
                <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
                <strong>{{ successMessage }} &nbsp;&nbsp;&nbsp;&nbsp;<a v-show="gameEnded" v-on:click.prevent="restartGame">Restart</a></strong>
            </div>

            <div class="board">
                <div v-for="(piece, key) of board" >
                    <img v-bind:src="pieceImageURL(piece, key)" v-on:click="clickPiece(key)">
                </div>
            </div>
            <hr>
        </div>
    </div>
</template>

<script type="text/javascript">
	export default {
        data: function(){
			return {
                title: 'Memory Game',
                showSuccess: false,
                showFailure: false,
                successMessage: '',
                failMessage: '',
                currentValue: 1,
                gameEnded:false,
                board: [9,2,9,2,3,8,4,3,8,4,7,5,7,5,6,6],
                boardStatus: [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
                imgSrcs : [],
                imgs: [],
                hiddenImage : [],
                playerClick : 1,
                firstIndex : -1,
                playerTurn : 1,
            }
        },
        beforeMount() {
            this.loadImages();
            },
        mounted() {
            this.cloneImgs();
            this.board = this.generateRandomBoard();
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
            pieceImageURL: function (piece, value) {
                if (this.boardStatus[value] == 0) 
                {
                    return this.hiddenImage;
                }
                else 
                {
                    return this.imgs[piece];
                } 
            },
            redraw: function() {
                this.$forceUpdate();
            },
            clickPiece: function(index) {
                console.log();
                if (this.gameEnded) {
                    return false;
                }
                if (this.boardStatus[index] !== 0) {
                    return false;
                }
                if (this.playerClick == 1) {
                    this.boardStatus[index] = 1;
                    this.firstIndex = index;
                    this.playerClick = 2;
                    this.redraw();
                    return true;
                }

                if (this.playerClick == 2) {
                    this.boardStatus[index] = 1;
                    this.playerClick = 1;

                    if (!this.checkDouble(this.firstIndex, index)) {
                        this.boardStatus[this.firstIndex] = 0;
                        this.boardStatus[index] = 0;
                        this.firstIndex = -1;
                        this.redraw();
                        return true;
                    } else {
                        this.redraw(); 
                    }

                    if (this.checkGameEnded()) {
                        this.successMessage = 'You won the game';
                        this.showSuccess = true;
                        this.gameEnded = true;
                        this.redraw(); 
                        return true;
                    }
                    return true;
                }

            },
            checkDouble: function (firstIndex, secondIndex) {
                if (this.board[firstIndex] === this.board[secondIndex]) {
                    return true;
                }
                return false;
            },
            generateRandomBoard: function(){
                var randomBoard =  [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
                var randomValues = [];
                for (var i = 0; i < 8 ; i++) {
                    var randomValue ;
                    do {
                        randomValue = Math.floor((Math.random() * 20) + 1);
                    } while(randomValues.includes(randomValue))
                    randomValues.push(randomValue);
                }

                for (var i = 0; i < 8 ; i++) {
                    var randomPosition ;
                    var randomPosition2;
                    do {
                        randomPosition = Math.floor(Math.random() * 16);
                        randomPosition2 = Math.floor(Math.random() * 16);
                    } while(randomPosition === randomPosition2 || randomBoard[randomPosition] != 0 || randomBoard[randomPosition2] != 0);

                    console.log('randomPosition   ' + randomPosition + 'value' + randomBoard[randomPosition]);
                    console.log('randomPosition2' + randomPosition2 + 'value' + randomBoard[randomPosition2]);
                    randomBoard[randomPosition] = randomValues[i];
                    randomBoard[randomPosition2] = randomValues[i];
                }
                console.log(randomBoard);
/*
                for(let value of randomValues) {
                    var i = 0;
                    for (let boardValue of randomBoard) {
                        if (value == boardValue) {
                            i++;
                        }
                    }
                    if(i < 3) {
                        do {
                            var randomPosition = Math.floor((Math.random() * 16) + 1);
                        } while(randomBoard[randomPosition] != 0);
                    }
                }
                console.log(randomBoard[0]);
                console.log(randomBoard);
                                console.log(randomValues);
*/
                return randomBoard;
            },
            restartGame:function(){
                console.log('restartGame');
                this.board = this.generateRandomBoard();
                this.boardStatus =  [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
                this.showSuccess= false;
                this.showFailure= false;
                this.successMessage= '';
                this.failMessage= '';
                this.currentValue= 1;
                this.gameEnded= false;
                this.redraw();
            },
            // ----------------------------------------------------------------------------------------
            // GAME LOGIC - START
            // ----------------------------------------------------------------------------------------
            checkGameEnded: function(){
                for (let value of this.boardStatus) {
                    if (value === 0) {
                        return false;
                    }
                }
                return true;
            },
            // ----------------------------------------------------------------------------------------
            // GAME LOGIC - END
            // ----------------------------------------------------------------------------------------
        },
        computed:{
        },
    }
</script>

<style>

</style>