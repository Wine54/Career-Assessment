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