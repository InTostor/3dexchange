function notavailable(){
showMessage("Пока не доступно",2000);    
}

function showMessage(message,timeout=2000){
    var warn = document.createElement('h6');
    warn.textContent = message;
    warn.style.position = "fixed";
    warn.style.top = "40vh";
    warn.style.left = "40%";
    warn.style.fontSize = "50px";
    warn.style.zIndex=999;
    document.body.appendChild(warn);
    setTimeout(function() {warn.remove();},timeout);    
}