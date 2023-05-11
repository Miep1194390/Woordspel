<!DOCTYPE html>
<html>
<head>
    <title>Typewriter Game</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Typewriter Game</h1>
        <div id="game-container">
            <div id="game-board">
                <!-- Game board will be dynamically updated here -->
            </div>
            <form id="game-form">
                <input type="text" id="input-field" placeholder="Type something...">
                <button type="submit" id="submit-btn">Submit</button>
            </form>
            <div id="game-result" style="display: none;"></div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        // JavaScript code to handle game logic and AJAX requests
        document.addEventListener('DOMContentLoaded', function () {
            const gameBoard = document.getElementById('game-board');
            const gameForm = document.getElementById('game-form');
            const inputField = document.getElementById('input-field');
            const submitBtn = document.getElementById('submit-btn');
            const gameResult = document.getElementById('game-result');

            // Function to update the game board with current game state
            function updateGameBoard(gameState) {
                gameBoard.innerHTML = ''; // Clear the existing board

                // Add each input to the game board
                gameState.forEach(function (input) {
                    const inputElement = document.createElement('div');
                    inputElement.innerText = input;
                    gameBoard.appendChild(inputElement);
                });
            }

            // Function to handle the game result
            function handleGameResult(winner) {
                if (winner) {
                    gameResult.innerText = 'Winner: ' + winner;
                    gameResult.style.display = 'block';
                    inputField.disabled = true;
                    submitBtn.disabled = true;
                }
            }

            // Event listener for the game form submission
            gameForm.addEventListener('submit', function (event) {
                event.preventDefault();

                const userInput = inputField.value.trim();

                // Make an AJAX request to the server
                axios.post('/game/submit', {
                    input: userInput
                })
                .then(function (response) {
                    const gameState = response.data.game_state;
                    const winner = response.data.winner;

                    // Update the game board and handle the game result
                    updateGameBoard(gameState);
                    handleGameResult(winner);

                    // Clear the input field
                    inputField.value = '';
                })
                .catch(function (error) {
                    console.log(error);
                });
            });
        });
    </script>
</body>
</html>
