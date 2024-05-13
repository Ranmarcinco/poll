<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vote</title>
<style>
     body {
          background-image:url('USAPA.png');
          font-family: Arial, sans-serif;
          margin: 0;
          padding: 0;
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh; /* Ensure full viewport height */
          color: #efedf5;
     }

     .container {
          text-align: center;
          opacity: 5.5;
          padding: 20px;
          border-radius: 10px;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
     }

     h1 {
          font-size: 36px;
          color: #2fb851;
     }

     #options {
          display: flex;
          justify-content: center;
          flex-wrap: wrap;
          margin-top: 20px;
     }

     .vote-option {
          margin: 5px;
     }

     button {
          background-color: #4CAF50;
          color: white;
          padding: 10px 20px;
          border: none;
          border-radius: 5px;
          cursor: pointer;
          transition: background-color 0.3s ease;
          margin-bottom: 10px;
     }

     button:hover {
          background-color: #1d115f;
     }

     #voteMessage {
          margin-top: 20px;
          color: #6e0e4e;
     }
     
     /* Styling for displaying vote results */
     #voteResults {
          position: absolute;
          top: 20px;
          right: 20px;
          text-align: left;
     }

     #voteResults h2 {
          margin-bottom: 10px;
     }

     .vote-result {
          margin-bottom: 5px;
     }

     /* Styling for displaying user votes */
     #userVotes {
          position: absolute;
          top: 20px;
          left: 20px;
          text-align: left;
     }

     #userVotes h2 {
          margin-bottom: 10px;
     }

     .user-vote {
          margin-bottom: 5px;
     }

     .back-button {
          background-color: #f44336;
          margin-top: 20px;
     }
</style>
</head>
<body>
<div class="container">
     <h1 id="pollQuestion"></h1>
     <div id="options"></div>
     <p id="voteMessage"></p>
     <button class="back-button" onclick="goBack()">Back</button>
</div>

<div id="voteResults"></div>
<div id="userVotes"></div>

<script>
     // Retrieve question and choices from sessionStorage
     const question = sessionStorage.getItem("question");
     const choicesString = sessionStorage.getItem("choices");

     // Display question
     document.getElementById("pollQuestion").textContent = question;

     // Create options based on choices
     const choices = choicesString.split(",");
     const optionsDiv = document.getElementById("options");
     choices.forEach(choice => {
          const optionDiv = document.createElement("div");
          optionDiv.classList.add("vote-option");

          const button = document.createElement("button");
          button.type = "button";
          button.value = choice.trim();
          button.textContent = choice.trim();
          button.addEventListener("click", updateVoteResults); // Listen for click event
          optionDiv.appendChild(button);

          optionsDiv.appendChild(optionDiv);
     });

     // Function to update vote results when an option is selected
     function updateVoteResults(event) {
          const selectedValue = event.target.value;
          const userName = prompt("Please enter your name:"); // Prompt the user to enter their name

          // Check if the user has already voted
          if (sessionStorage.getItem('hasVoted')) {
               document.getElementById("voteMessage").textContent = "You've already voted!";
               return;
          }

          // Update vote count
          let votes = JSON.parse(sessionStorage.getItem('votes')) || {};
          votes[selectedValue] = (votes[selectedValue] || 0) + 1;
          sessionStorage.setItem('votes', JSON.stringify(votes));

          // Store user's vote with their name
          let userVotes = JSON.parse(sessionStorage.getItem('userVotes')) || [];
          userVotes.push({ name: userName, vote: selectedValue });
          sessionStorage.setItem('userVotes', JSON.stringify(userVotes));

          // Set flag indicating that the user has voted
          sessionStorage.setItem('hasVoted', true);

          // Disable voting buttons after voting
          disableVotingButtons();

          // Display confirmation message
          document.getElementById("voteMessage").textContent = "Thank you for voting!";

          // Display vote results
          displayVoteResults();

          // Display user votes
          displayUserVotes();
     }

     // Function to display vote results
     function displayVoteResults() {
          const votes = JSON.parse(sessionStorage.getItem('votes')) || {};
          const totalVotes = Object.values(votes).reduce((total, vote) => total + vote, 0);
          const voteResultsDiv = document.getElementById("voteResults");
          voteResultsDiv.innerHTML = "<h2>Vote Results</h2>";

          for (const [choice, voteCount] of Object.entries(votes)) {
               const percentage = totalVotes === 0 ? 0 : (voteCount / totalVotes) * 100;
               const resultText = `${choice}: ${voteCount} votes (${percentage.toFixed(2)}%)`;

               const resultElement = document.createElement("div");
               resultElement.classList.add("vote-result");
               resultElement.textContent = resultText;

               voteResultsDiv.appendChild(resultElement);
          }
     }

     // Function to display user votes
     function displayUserVotes() {
          const userVotes = JSON.parse(sessionStorage.getItem('userVotes')) || [];
          const userVotesDiv = document.getElementById("userVotes");
          userVotesDiv.innerHTML = "<h2>User Votes</h2>";

          userVotes.forEach(userVote => {
               const userVoteText = `${userVote.name}: Voted for ${userVote.vote}`;

               const userVoteElement = document.createElement("div");
               userVoteElement.classList.add("user-vote");
               userVoteElement.textContent = userVoteText;

               userVotesDiv.appendChild(userVoteElement);
          });
     }

     // Function to disable voting buttons after the user has voted
     function disableVotingButtons() {
          const buttons = document.querySelectorAll(".vote-option button");
          buttons.forEach(button => {
               button.disabled = true;
          });
     }

     // Display initial vote results
     displayVoteResults();

     // Function to go back to the previous page
     function goBack() {
          window.history.back();
     }

     // Function to show voters
     function showVoters() {
          // Retrieve voters data from sessionStorage
          const voters = JSON.parse(sessionStorage.getItem('voters')) || {};

          // Display voters
          alert("Voters:\n" + JSON.stringify(voters, null, 2));
     }
</script>
</body>
</html>
<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"]) && isset($_POST["choice"])) {
    // Retrieve voter name and choice from the form
    $name = $_POST["name"];
    $choice = $_POST["choice"];

    // Database configuration
    $servername = "localhost"; // Replace with your server name
    $username = "root"; // Replace with your database username
    $password = ""; // Replace with your database password
    $database = "poll"; // Replace with your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to insert voter data into the database
    $sql = "INSERT INTO voters (name, choice) VALUES ('$name', '$choice')";

    if ($conn->query($sql) === TRUE) {
        echo "Voter data inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
} else {
    echo "Invalid request";
}
?>

