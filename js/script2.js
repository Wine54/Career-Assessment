function myHideUnhideFunction(signup_confirmpassword, hideUnhide) {
    var x = document.getElementById(signup_confirmpassword);
    var y = document.getElementById(hideUnhide);

    if (x.type === "password") {
        x.type = "text";
        y.src = "img/unhide.png";
    } else {
        x.type = "password";
        y.src = "img/hide.png";
    }
}

function showLoading() {
    var loadingMessage = document.getElementById('loading_message');
    if (loadingMessage) {
        loadingMessage.style.display = 'block';
    }
}

function validateForm() {
    var fname = document.getElementById("signup_fname").value;
    var lname = document.getElementById("signup_lname").value;
    var email = document.getElementById("signup_email").value;
    var password = document.getElementById("signup_password").value;
    var confirm_password = document.getElementById("signup_confirmpassword").value;

    if (fname === "" || lname === "" || email === "" || password === "" || confirm_password === "") {
        document.getElementById("error_message").style.display = "block";
        return false;
    }
    return true;
}
