function loginDetection() {
    let username = $('#name').val();
    let password = $('#psw').val();
    let hasError = false;
    if(username.length<=0) {
        $('#uid_result').html("UserName cannot be empty!");
        hasError = true;
    } else {
        $('#uid_result').html("");
    }

    if(password.length<=0) {
        $('#psw_result').html("Password cannot be empty!");
        hasError = true;
    } else {
        $('#psw_result').html("");
    }

    if(!hasError){
        $('#form').submit();
    }
}