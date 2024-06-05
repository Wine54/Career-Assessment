/* logging out: used in profile */
function logout() {
    window.location.href = 'career_login.php';
}

/* enter assessment: used in 3 main dashboard */
function startAssessment() {
    window.location.href = 'career_assessment.php';
}

/* starts the assessment: used in assessment */
function startAssessmentTest() {
    window.location.href = 'career_assessment_test.php';
}

/* after test: used in the end of assessment_test */
function result() {
    window.location.href = "career_dashboard.php";
}

/* -------------------------------------------------- */

/* -------------------------------------------------- */

var currentQuestion = 1;
    var totalQuestions = 60;

    function nextQuestion() {
        document.getElementById('question' + currentQuestion).classList.remove('active');
        currentQuestion++;
        document.getElementById('question' + currentQuestion).classList.add('active');
        updateButtons();
    }

    function prevQuestion() {
        if (currentQuestion > 1) {
            document.getElementById('question' + currentQuestion).classList.remove('active');
            currentQuestion--;
            document.getElementById('question' + currentQuestion).classList.add('active');
            updateButtons();
        }
    }

    function updateButtons() {
        if (currentQuestion === 1) {
            document.getElementById('goBackButton').style.display = 'none';
        } else {
            document.getElementById('goBackButton').style.display = 'block';
        }

        if (currentQuestion === totalQuestions) {
            document.querySelector('.next_button').style.display = 'none';
            document.querySelector('.last_button').style.display = 'block';
        } else {
            document.querySelector('.next_button').style.display = 'block';
            document.querySelector('.last_button').style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateButtons();
    });