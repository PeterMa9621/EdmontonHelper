function checkPassword(str) {
    let tips = "";
    if(str.length<6){
        tips = "<font color='#a52a2a'>Your password is less than six characters</font>";
    }
    document.getElementById("psw_result").innerHTML = tips;
}