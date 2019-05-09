var xmlHttp;

function searchName(name) {
    document.getElementById("register").hidden = true;
    if(name.length<=0){
        document.getElementById("name_result").innerHTML = "";
        return;
    } else {
        document.getElementById("name_result").innerHTML = "Checking username...";
    }

    xmlHttp = getXmlHttpObject();
    if(xmlHttp==null){
        alert("Your browser does not support HTTP Request");
        return;
    }

    var url = "../user/checkusername/";

    //var data = "num1="+$("num1").value+"&operate="+$("operate").value+"&num2="+$("num2").value;
    var data = "name=" + name;
    xmlHttp.open("POST", url, true);
    xmlHttp.setRequestHeader("CONTENT-TYPE", "application/x-www-form-urlencoded");
    xmlHttp.onreadystatechange = onStateChange;
    xmlHttp.send(data);
}

//This method is using GET
/*
function searchName(name) {
    if(name.length<=0){
        document.getElementById("name_result").innerHTML = "A";
        return;
    }

    xmlHttp = getXmlHttpObject();
    if(xmlHttp==null){
        alert("Your browser does not support HTTP Request");
        return;
    }

    var url = "http://127.0.0.1/CodeIgniter/register/checkusername/";
    url += "?name=" + name;

    xmlHttp.open("GET", url, true);
    xmlHttp.onreadystatechange = onStateChange;
    xmlHttp.send(data);
}
 */
function onStateChange() {
    if(xmlHttp.readyState == 4 || xmlHttp.readyState == "complete"){
        if(xmlHttp.responseText == "true"){
            document.getElementById("name_result").innerHTML = "<font color='blue'>The user name is available!</font>";
            document.getElementById("register").hidden = false;
        } else {
            document.getElementById("name_result").innerHTML = "<font color='#a52a2a'>The user name has already existed!</font>";
            document.getElementById("register").hidden = true;
        }

    }
}

function getXmlHttpObject()
{
    var xmlHttp=null;
    try
    {
        // Firefox, Opera 8.0+, Safari
        xmlHttp=new XMLHttpRequest();
    }
    catch (e)
    {
        // Internet Explorer
        try
        {
            xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e)
        {
            xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttp;
}