let cookies;

function setCookie(name , value , time = 86400){
    var expires = (new Date(Date.now()+ time*1000)).toUTCString();
    document.cookie =name +"="+value+";domain="+domain+";expires="+expires+";path=/";
}

function changeCookie(name , value){
    document.cookie =name +"="+value+";domain="+domain+";path=/";
}

function clearCookie(name){
    document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:01 GMT;domain="+domain+";path=/"
}

function getCookie(cName) {
    if (checkCookie(cName)) {
        cookies = decodeURIComponent(document.cookie).split(";");
        for (let i = 0; i < cookies.length; i++) {
            cookies[i] = cookies[i].split("=")
        }
        for (let i = 0; i < cookies.length; i++) {
            if (cookies[i][0].trim() == cName) {
                return cookies[i][1];
            }
        }
    } else {
        return "0";
    }
}

function checkCookie(cName) {
    cookies = decodeURIComponent(document.cookie).split(";");
    for (let i = 0; i < cookies.length; i++) {
        cookies[i] = cookies[i].split("=")
    }
    for (let i = 0; i < cookies.length; i++) {
        if (cookies[i][0].trim() == cName) {
            return true
        }
    }
    setCookie(cName , "0");
    return false;
}












