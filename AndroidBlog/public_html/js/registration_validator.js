function validate_form() {
    if (!validate_email()) {
        return false;
    }

    if (!validate_name()) {
        return false;
    }

    return validate_password();
}

function validate_email() {
    var email_edit = document.forms["main"]["email"];
    var x = email_edit.value;
    var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (x == null || x == "" || !re.test(x)) {
        email_edit.style.backgroundColor = "red";
        return false;
    }
    else {
        email_edit.style.backgroundColor = "white";
    }
    return true;
}

function validate_name() {
    //TODO: remove first and last spaces in input
    var name_edit = document.forms["main"]["name"];
    var x = name_edit.value;
    if (x == null || x.length < 5) {
        name_edit.style.backgroundColor = "red";
        return false;
    }
    else {
        name_edit.style.backgroundColor = "white";
    }
    return true;
}

function validate_password() {
    var password_edit = document.forms["main"]["password"];
    var x = password_edit.value;
    if (x == null || x.length < 5) {
        password_edit.style.backgroundColor = "red";
        return false;
    }
    else {
        password_edit.style.backgroundColor = "white";
    }
    return true;
}