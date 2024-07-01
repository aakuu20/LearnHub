const questions = [
    {
        question: "1.Which of the following is not a core step of Six Sigma?",
        answers: [
            { text: "Define", correct: false },
            { text: "Control", correct: true },
            { text: "Measure", correct: false },
            { text: "Analyse", correct: false },
        ],
    },

    {
        question: "2.Boundary value analysis belong to?",
        answers: [
            { text: "White Box Testing  ", correct: false },
            { text: "Black Box Testing", correct: true },
            { text: " White Box & Black Box Testing", correct: false },
            { text: "None of the mentioned", correct: false },
        ],
    },
    {
        question: "3.What are the various Testing Levels?",
        answers: [
            { text: "Unit Testing ", correct: false },
            { text: "System Testing", correct: false },
            { text: "Integration Testing", correct: false },
            { text: "All of the mentioned", correct: true },
        ],
    },

    {
        question: "4.Which of the following is non-functional testing?",
        answers: [
            { text: "Black box testing", correct: false },
            { text: "Performance testing", correct: true },
            { text: "Unit testing", correct: false },
            { text: " None of the mentioned", correct: false },
        ],
    },
    {
        question: "5.Which of the following is black box testing",
        answers: [
            { text: "Basic path testing", correct: false },
            { text: "Boundary value analysis", correct: true },
            { text: "Code path analysis", correct: false },
            { text: "None of the mentioned", correct: false },
        ],
    },
    {
        question: "6.SDLC stands for ________",
        answers: [
            { text: "Software development life cycle", correct: true },
            { text: "System development life cycle", correct: false },
            { text: "Software design life cycle", correct: false },
            { text: "System design life cycle", correct: false },
        ],
    },
    {
        question: "7.„Q? organizations are less quality conscious organizations.",
        answers: [
            { text: "true", correct: false },
            { text: "false", correct: true },
        ],
    },
    {
        question: "8.Acceptance testing is also known as ",
        answers: [
            { text: "Grey box testing ", correct: false },
            { text: "White  box testing ", correct: false },
            { text: "Alpha  Testing ", correct: false },
            { text: " Beta testing", correct: true },
        ],
    },
    {
        question: "9.Quality can be defined as Conformance to _________.",
        answers: [
            { text: "Specification ", correct: true },
            { text: "Market", correct: false },
            { text: " Developer", correct: false },
            { text: "Company", correct: false },
        ],
    },
    {
        question: "10'Quality is fitness for purpose'. This is called as the ______ view of quality.",
        answers: [
            { text: "Product", correct: false },
            { text:  "User", correct: true },
            { text: "Transcendental", correct: false },
            { text: "Manufacturing", correct: false },
        ],
    },
];

let currentQuestionIndex = 0;
let userScore = 0;

const startButtonEl = document.querySelector(".start-btn");
const welcomeScreenEl = document.querySelector(".welcome-screen");
const quizScreenEl = document.querySelector(".quiz-screen");
const questionEl = document.querySelector(".question");
const answersButtons = document.querySelector(".answers-container");
const nextButtonEl = document.querySelector(".next-btn");

startButtonEl.addEventListener("click", startQuiz);

function startQuiz() {
    welcomeScreenEl.style.display = "none";
    // quizScreenEl.style.display = "block";
    quizScreenEl.style.display = "flex";
    currentQuestionIndex = 0;
    userScore = 0;
    nextButtonEl.innerHTML = "Next";
    nextButtonEl.style.display = "none";
    displayQuestion();
}

function displayQuestion() {
    resetContainer();
    questionEl.textContent = questions[currentQuestionIndex].question;
    questions[currentQuestionIndex].answers.forEach((answer) => {
        const buttonEl = document.createElement("button");
        buttonEl.innerHTML = answer.text;
        buttonEl.classList.add("ans-btn");
        answersButtons.appendChild(buttonEl);

        if (answer.correct) {
            buttonEl.dataset.correctAns = answer.correct;
        }

        // console.log(buttonEl);

        buttonEl.addEventListener("click", checkAnswer);
    });
}

function checkAnswer(e) {
    const selectedButton = e.target;
    if (selectedButton.dataset.correctAns) {
        userScore++;
        console.log(userScore);
        selectedButton.classList.add("correct-ans");
    } else {
        selectedButton.classList.add("wrong-ans");
    }

    Array.from(answersButtons.children).forEach((button) => {
        if (button.dataset.correctAns === "true") {
            button.classList.add("correct-ans");
        }
        button.disabled = "true";
    });

    nextButtonEl.style.display = "block";
}

function displayResult() {
    resetContainer();
    questionEl.innerHTML = `Quiz is Completed! <br> Your Score: <span class="score">${userScore}/${questions.length}</span>`;

    nextButtonEl.innerHTML = "Restart Quiz";
}

function nextQuestion() {
    currentQuestionIndex++;
    if (currentQuestionIndex < questions.length) {
        displayQuestion();
        nextButtonEl.style.display = "none";
    } else {
        displayResult();
    }
}

nextButtonEl.addEventListener("click", function () {
    if (currentQuestionIndex < questions.length) {
        nextQuestion();
    } else {
        startQuiz();
    }
});

function resetContainer() {
    questionEl.textContent = "";
    answersButtons.innerHTML = "";
}
