function hide(obj){
    var coll = document.getElementsByClassName("active");
    for(var i = 0; i < coll.length; i++){
        var c = coll[i].nextElementSibling;
        c.style.maxHeight = null;
        coll[i].classList.toggle("active");
    }

    obj.classList.toggle("active");
    var content = obj.nextElementSibling;
    if (content.style.maxHeight){
        content.style.maxHeight = null;
    } else {
        content.style.maxHeight = content.scrollHeight + "px";
    }
}