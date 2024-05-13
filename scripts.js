// scripts.js

document.addEventListener("DOMContentLoaded", function () {
    const pollForm = document.getElementById("pollForm");
    const pollContainer = document.getElementById("pollContainer");

    pollForm.addEventListener("submit", function (event) {
        event.preventDefault();
        const question = pollForm.question.value;
        const choices = pollForm.choices.value;

        // Send poll data to server to create poll
        // Assuming you are using AJAX/fetch to communicate with server
        fetch("/create-poll", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ question, choices })
        })
        .then(response => response.json())
        .then(data => {
            // Assuming server responds with created poll object
            const poll = data.poll;
            displayPoll(poll);
        })
        .catch(error => console.error("Error creating poll:", error));
    });

    function displayPoll(poll) {
        const pollElement = document.createElement("div");
        pollElement.classList.add("poll");

        const pollQuestion = document.createElement("h2");
        pollQuestion.textContent = poll.question;
        pollElement.appendChild(pollQuestion);

        const choicesList = document.createElement("ul");
        poll.choices.forEach((choice, index) => {
            const choiceItem = document.createElement("li");
            choiceItem.textContent = `${choice.option} (${choice.count} votes)`;
            choiceItem.addEventListener("click", function () {
                vote(poll, index);
            });
            choicesList.appendChild(choiceItem);
        });
        pollElement.appendChild(choicesList);

        pollContainer.appendChild(pollElement);
    }

    function vote(poll, choiceIndex) {
        // Send vote data to server
        // Assuming you are using AJAX/fetch to communicate with server
        fetch("/vote", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ pollIndex: polls.indexOf(poll), choiceIndex })
        })
        .then(response => response.json())
        .then(data => {
            // Update UI with new vote count
            const updatedPoll = data.poll;
            const pollElement = pollContainer.querySelector(`.poll h2:contains("${updatedPoll.question}")`).parentNode;
            const choiceItem = pollElement.querySelectorAll("li")[choiceIndex];
            choiceItem.textContent = `${updatedPoll.choices[choiceIndex].option} (${updatedPoll.choices[choiceIndex].count} votes)`;
        })
        .catch(error => console.error("Error voting:", error));
    }
});
