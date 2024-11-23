const player = document.getElementById("player");
const fallingObject = document.getElementById("falling-object");
const scoreDisplay = document.getElementById("score");

let score = 0;
let playerPosition = 130; // Initial player position
let fallingObjectTop = 0;
let fallingObjectLeft = Math.random() * 280; // Random starting position

// Move the player
document.addEventListener("keydown", (event) => {
  if (event.key === "ArrowLeft" && playerPosition > 0) {
    playerPosition -= 20;
  } else if (event.key === "ArrowRight" && playerPosition < 260) {
    playerPosition += 20;
  }
  player.style.left = `${playerPosition}px`;
});

// Animate the falling object
function moveFallingObject() {
  fallingObjectTop += 5;
  fallingObject.style.top = `${fallingObjectTop}px`;
  fallingObject.style.left = `${fallingObjectLeft}px`;

  // Check if the object reaches the bottom
  if (fallingObjectTop > 400) {
    fallingObjectTop = 0;
    fallingObjectLeft = Math.random() * 280; // Reset to random position
  }

  // Check for collision
  if (
    fallingObjectTop > 360 &&
    fallingObjectLeft > playerPosition - 20 &&
    fallingObjectLeft < playerPosition + 40
  ) {
    score++;
    scoreDisplay.textContent = `Score: ${score}`;
    fallingObjectTop = 0;
    fallingObjectLeft = Math.random() * 280; // Reset position
  }

  requestAnimationFrame(moveFallingObject);
}

// Start the game
moveFallingObject();
