/*jshint esversion: 6 */

class MemoryGame {
    constructor(ID, player1Name) {
        this.gameID = ID;
        this.gameEnded = false;
        this.gameStarted = false;
        this.player1Name = player1Name;
        this.player2Name = '';
        this.player1Pairs = 0;
        this.player2Pairs = 0;
        this.playerTurn = 1;
        this.winner = 0;
        this.playerClick = 1;
        this.firstIndex = -1;
        this.boardStatus = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        this.board = this.createRandomBoard();
        //this.board = [9,2,9,2,3,8,4,3,8,4,7,5,7,5,6,6];
    }

    createRandomBoard(){
        let randomBoard =  [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
                let randomValues = [];
                for (let i = 0; i < 8 ; i++) {
                    let randomValue ;
                    do {
                        randomValue = Math.floor((Math.random() * 20) + 1);
                    } while(randomValues.includes(randomValue))
                    randomValues.push(randomValue);
                }

                for (let i = 0; i < 8 ; i++) {
                    let randomPosition ;
                    let randomPosition2;
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
                return randomBoard;
    }

    join(player2Name){
        this.player2Name = player2Name;
    }

    startGame(){
        if (this.player2Name !== '') {
            this.gameStarted = true;
        }
    }

    allTurned(){
        let auxEnd = true;
        for (let value of this.boardStatus) {
            if (value === 0) {
                auxEnd = false;
            }
        }
        if (auxEnd){
            return true;
        }
        return false;
    }

    checkGameEnded(){
        if (this.allTurned() && this.player1Pairs > this.player2Pairs) {
            this.winner = 1;
            this.gameEnded = true;
            return true;
        } else if (this.allTurned() && this.player1Pairs < this.player2Pairs) {
            this.winner = 2;
            this.gameEnded = true;
            return true;
        } else if (this.allTurned() && this.player1Pairs == this.player2Pairs) {
            this.winner = 0;
            this.gameEnded = true;
            return true;
        }
        return false;
    }

    play(playerNumber, index){
        if (!this.gameStarted) {
            return false;
        }
        if (this.gameEnded) {
            return false;
        }
        if (playerNumber != this.playerTurn) {
            return false;
        }
        if (this.boardStatus[index] !== 0) {
            return false;
        }

        if (this.playerClick === 1) {
            this.boardStatus[index] = playerNumber;
            this.firstIndex = index;
            this.playerClick = 2;

            return true;
        }

        if (this.playerClick === 2) {
            this.boardStatus[index] = playerNumber;

            if (this.checkDouble(this.firstIndex, index)) {
                console.log('double');
                if (playerNumber === 1) {
                    this.player1Pairs++;
                } else if (playerNumber === 2) {
                    this.player2Pairs++;
                }
                this.playerClick = 1;
                if (this.checkGameEnded()){
                    return true;
                }
                return true;
            } else {
                console.log('not double');
                this.boardStatus[this.firstIndex] = 0;
                this.boardStatus[index] = 0;
                this.firstIndex = -1;
                this.playerClick = 1;
                this.playerTurn = this.playerTurn == 1 ? 2 : 1;
                return true;
            }
        }
    }

    checkDouble(firstIndex, secondIndex){
        if (this.board[firstIndex] === this.board[secondIndex]) {
            return true;
        }
        return false;
    }
}

module.exports = MemoryGame;
