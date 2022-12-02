function modify(id){
    scrollTo(top);
    document.getElementById("inputEmail").value = document.getElementById(id+"-1").textContent;;

    modifyAll(id);
}