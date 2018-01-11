/*jshint esversion: 6 */

class MemoryGame {
    constructor(ID, player1Name) {
        this.gameID = ID;
        this.gameEnded = false;
        this.gameStarted = false;
        this.player1Name = player1Name;
        this.player2Name = '';
        this.player1TurnOver = 0;
        this.player2TurnOver = 0;
        this.playerTurn = 1;
        this.winner = 0;
        this.playerClick = 1;
        this.firstIndex = -1;
        this.board = [0,2,0,2,3,1,4,3,1,4,7,5,7,5,6,6];
        this.boardStatus = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
    }

    join(player2Name){
        this.player2= player2Name;
        this.gameStarted = true;
    }

    allTurned(){
        for (let value of this.boardStatus) {
            if (value === 0) {
                return false;
            }
        }
    }

    checkGameEnded(){
        if (this.allTurned() && player1TurnOver > player2TurnOver) {
            this.winner = 1;
            this.gameEnded = true;
            return true;
        } else if (this.allTurned() && player1TurnOver < player2TurnOver) {
            this.winner = 2;
            this.gameEnded = true;
            return true;
        } else if (this.allTurned() && player1TurnOver == player2TurnOver) {
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
        if (this.board[index] !== 0) {
            return false;
        }

        if (this.playerClick == 1) {
            this.boardStatus[index] = playerNumber;
            this.firstIndex = index;
            this.playerClick = 2;
            return true;
        }

        if (this.playerClick == 2) {
            this.boardStatus[index] = playerNumber;
            this.playerClick = 1;

            if (checkDouble(this.firstIndex, index)) {
                if (playerNumber == 1) {
                    this.player1TurnOver++;
                } else if (playerNumber == 2) {
                    this.player2TurnOver++;
                }
            } else {
                this.boardStatus[this.firstIndex] = 0;
                this.boardStatus[this.index] = 0;
                this.firstIndex = -1;
                return false;
            }

            if (!this.checkGameEnded()) {
                this.playerTurn = this.playerTurn == 1 ? 2 : 1;
            }
            return true;
        }
    }

    checkDouble(firstIndex, secondIndex){
        if (this.board[firstIndex] == this.board[secondIndex]) {
            return true;
        }
        return false;
    }

}

module.exports = MemoryGame;
