function myHideUnhideFunction() {
    var x = document.getElementById("login_password");
    var y = document.getElementById("hide_unhide");

    if (x.type === "password") {
        x.type = "text";
        y.src = "img/unhide.png";
    } else {
        x.type = "password";
        y.src = "img/hide.png";
    }
  }