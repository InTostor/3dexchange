function notavailable(){
    var warn = document.createElement('h6');
    warn.textContent = "Пока не доступно";
    warn.style.position = "fixed";
    warn.style.top = "40vh";
    warn.style.left = "40%";
    warn.style.fontSize = "50px";
    document.body.appendChild(warn);
    setTimeout(function() {warn.remove();},2000);
    
}