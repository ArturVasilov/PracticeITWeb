function validate_form() {
    if (!validate_email()) {
        return false;
    }

    return validate_password();
}

function validate_email() {
    var email_edit = document.forms["log_in"]["email"];
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

function validate_password() {
    var password_edit = document.forms["log_in"]["password"];
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

/*
function change_visibility() {
    var form = document.getElementById('log_in_div');
    if (form.style.display === 'none' || form.style.display === '') {
        form.style.display = 'block';
    }
    else {
        form.style.display = 'none';
    }
}
*/