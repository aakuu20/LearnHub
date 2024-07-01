const questions = [
    {
        question: "1.What model was an open model",
        answers: [
            { text: "Government model", correct: false },
            { text: "Academic model", correct: true },
            { text: "Both Gov. and academic", correct: false },
            { text: "Modern security model", correct: false },
        ],
    },

    {
        question: "2.Three D's of the security are as follows:",
        answers: [
            { text: "Defence , Dynamic, Does", correct: false },
            { text: "Detect, Display, Dynamic", correct: false },
            { text: "Defence , Detection, Deterrence", correct: true },
            { text: "Defence , Definition ,Do", correct: false },
        ],
    },
    {
        question: "3.________ is the process of determining who is the user",
        answers: [
            { text: "Authentication", correct: true },
            { text: "Availability", correct: false },
            { text: "Identification", correct: false },
            { text: "Validation", correct: false},
        ],
    },

    {
        question: "4.Username and password is __________ type of authentication",
        answers: [
            { text: "MFA", correct: false },
            { text: "SFA", correct: true },
            { text: "Two factor authentication", correct: false },
            { text: "PPF", correct: false },
        ],
    },
    {
        question: "5.One time password system is a method of _________",
        answers: [
            { text: "Authentication", correct: true },
            { text: "Authorization", correct: false },
            { text: "Verification", correct: false },
            { text: "All the above", correct: false },
        ],
    },
    {
        question: "6.IPV6 addresses are ______bit in a size",
        answers: [
            { text: "48", correct: false },
            { text: "128", correct: true },
            { text: "16", correct: false },
            { text: "22", correct: false },
        ],
    },
    {
        question: "7.IPS stands for _______",
        answers: [
            { text: "Intrusion protection system", correct: false },
            { text: "Intrusion prevention sytem", correct: true },
            {text: "Intrusion private system", correct: false },
            {text: "Internet public service", correct: false },
        ],
    },
    {
        question: "8.Creating computer within a computer is known as _________",
        answers: [
            { text: "Virtual Machine", correct: false },
            { text: "Nested Computer", correct: false },
            { text: "Computer in Computer", correct: false },
            { text: "Computing", correct: true },
        ],
    },
    {
        question: "9.SDL stands for_______",
        answers: [
            { text: "Software development life cycle", correct: false },
            { text: "Secure development life cycle", correct: true },
            { text: "Standard life cycle", correct: false },
            { text: "Standard Data Linker", correct: false },
        ],
    },
    {
        question: "10.Kerberos is a method of _________",
        answers: [
            { text: "Authentication", correct: true },
            { text:  "Authorization", correct: false},
            { text: "Both the above", correct: false },
        
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
