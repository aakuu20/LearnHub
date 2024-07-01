const questions = [
    {
        question: "1.GIS stands for",
        answers: [
            { text: "Geographic Information System", correct: false },
            { text: "Generic Information System", correct: false },
            { text: "Geological Information System", correct: true },
            { text: "Geographic Information Sharing", correct: false },
        ],
    },

    {
        question: "2.By ‘spatial data’ we mean data that has",
        answers: [
            { text: "Complex values", correct: false },
            { text: "Positional values", correct: true },
            { text: "Graphic values", correct: false },
            { text: "Decimal values", correct: false },
        ],
    },
    {
        question: "3.What is ‘Metadata’ ?",
        answers: [
            { text: "It is ‘ data about data’", correct: true},
            { text: "It is ‘meteorological data’", correct: false },
            { text: "It is ‘oceanic data’", correct: false },
            { text: "It is ‘contour data’", correct: false },
        ],
    },

    {
        question: "4.Fields can be",
        answers: [
            { text: "Discrete only", correct: false },
            { text: "Continuous only", correct: false },
            { text: "Discrete or continuous", correct: true},
            { text: "Discrete analysis", correct: false },
        ],
    },
    {
        question: "5.TIN stands for",
        answers: [
            { text: "Traffic Internet Network", correct: false },
            { text: "Triangulated Irregular Network", correct: false },
            { text: "Temporal Interest Network", correct: true},
            { text: "Temperature Interface Node", correct: false },
        ],
    },
    {
        question: "6.SDI stands for",
        answers: [
            { text: "Spatial Data Interface", correct: false },
            { text: "Spatial Data Infrastructure", correct: true },
            { text: "Spatial Data Intention", correct: false },
            { text: "Spatial Data International", correct: false },
        ],
    },
    {
        question: "7.Which of the following is related to GIS",
        answers: [
            { text: "Euclidean space", correct: true },
            { text: "Ramanujan space", correct: false},
            { text: "Pythagorian space", correct: false },
            { text: "None of the above", correct: false },
        ],
    },
    {
        question: "8.The ‘boundary model’ is sometimes also called",
        answers: [
            { text: "Topological data model", correct: true },
            { text: "Temporal data model", correct: false },
            { text: "Topological discrete model", correct: false },
            { text: "Temporal discrete model", correct: false },
        ],
    },
    {
        question: "9.Which of the following statements is false about the capabilities of GIS",
        answers: [
            { text: "Data capture and preparation", correct:false },
            { text: "Data management, including storage and maintenance", correct: false },
            { text: "Data manipulation and analysis", correct: false },
            { text: "Data presentation", correct: false },
            { text:  "All above mentioned", correct: true },
        ],
    },
    {
        question: "10.A polygon-on-polygon overlay method that preserves all features from the input layers.",
        answers: [
            { text: "Intersection", correct: false },
            { text: "Union", correct: true },
            { text: "Crosses", correct: false },
            { text: "Split", correct: false },
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
