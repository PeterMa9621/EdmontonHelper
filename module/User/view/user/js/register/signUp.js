function signUp() {
    let psw = document.getElementById("psw").value;
    let email = document.getElementById("email").value;
    if(psw.length<6){
        alert("Your password is too short!");
        return;
    }
    if(email.length===0){
        alert("Your email cannot be empty!");
        return;
    }
    let form = document.getElementById("form");
    form.submit();
}