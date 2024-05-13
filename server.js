    const express = require('express');
    const bodyParser = require('body-parser');

    let polls = []; // Store polls data

    function createPoll(question, choices) {
        const newPoll = {
            question: question,
            choices: choices.split(",").map(choice => ({ option: choice.trim(), count: 0 }))
        };
        polls.push(newPoll);
        return newPoll;
    }

    function vote(pollIndex, choiceIndex) {
        polls[pollIndex].choices[choiceIndex].count++;
    }

    function getPolls() {
        return polls;
    }

    const app = express();
    const port = 3000;

    app.use(bodyParser.json());

    // Create a poll
    app.post('/create-poll', (req, res) => {
        const { question, choices } = req.body;
        const poll = createPoll(question, choices);
        res.json({ poll });
    });

    // Vote for a choice in a poll
    app.post('/vote', (req, res) => {
        const { pollIndex, choiceIndex } = req.body;
        vote(pollIndex, choiceIndex);
        res.json({ poll: getPolls()[pollIndex] });
    });

    app.listen(port, () => {
        console.log(`Server is listening at http://localhost:${port}`);
    });
