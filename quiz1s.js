const questions = [
    {
        question: "1. Business  intelligence  system  provides  tools  and  methodologies  to knowledge workers to help them to take?",
        answers: [
            { text: "Both 1 and 2", correct: true },
            { text: "Timely decision", correct: false },
            { text: "Effective decision.", correct: false },
            { text: "Efficient Decision.", correct: false },
        ],
    },

    {
        question: "2. _________  is  the  outcome  of  extraction  and  processing  activities carried out on data. ",
        answers: [
            { text: "Knowledge", correct: false },
            { text: "Information ", correct: true },
            { text: "Data", correct: false },
            { text: "Wisdom", correct: false },
        ],
    },
    {
        question: "3.The objective of B.I is ",
        answers: [
            { text: "To support decision-making and complex problem solving.", correct: true },
            { text: "To support information gathering. ", correct: false },
            { text: "To support data collection.", correct: false },
            { text: "To support data analysis. ", correct: false },
        ],
    },

    {
        question: "4. Which  of  the  following  is  not  a  component  of  business  intelligence analysis cycle?",
        answers: [
            { text: "Analysis", correct: false },
            { text: "Insight", correct: false },
            { text: "Decision", correct: false },
            { text: "Design", correct: true },
        ],
    },
    {
        question: "5. In BI Architecture, It is used to gather and integrate the data stored in various primary and secondary sources.",
        answers: [
            { text: "Data Warehouse.", correct: false },
            { text: "Data mart", correct: false },
            { text: "Data Sources", correct: true },
            { text: "Data explosion", correct: false },
        ],
    },
    {
        question: "6. Extraction of information and knowledge from data is known as",
        answers: [
            { text: "Data mining", correct: true },
            { text: "Data mart", correct: false },
            { text: "Optimisation", correct: false },
            { text: "Data exploration", correct: false },
        ],
    },
    {
        question: "7.  Which  phases  is  used  for  planning  of  Development  of  a  business intelligence system.",
        answers: [
            { text: "Analysis and Design", correct: false },
            { text: "Planning", correct: true },
            { text: "Implementation and Control", correct: false },
            { text: " Maintenance", correct: false },
        ],
    },
    {
        question: "8. Decision making process is of ____________ phases. ",
        answers: [
            { text: "Three", correct: false },
            { text: " Five", correct: true },
            { text: "Two ", correct: false },
            { text: "Six", correct: false },
        ],
    },
    {
        question: "9. Well defined and recurring decision making procedure is called",
        answers: [
            { text: "Structured", correct: true },
            { text: "Semi-structured", correct: false },
            { text: " Operational", correct: false },
            { text: "Unstructured ", correct: false },
        ],
    },
    {
        question: "10.  In  ____________  approach,  a  decision  maker  considers  economic, tactical legal, ethical, procedural and political factors.",
        answers: [
            { text: "Absolute rationality approach", correct: false },
            { text: "Bounded rationality approach", correct: false },
            { text: " Rational approach", correct: true },
            { text: " Un-Bounded rationality approach", correct: false },
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
