let dropdown_menu=document.getElementById("dropdown_menu");
let box=document.getElementById("box");
let flag=true;
dropdown_menu.addEventListener("click", function () {
   if(flag){
    box.style.display="block";
    flag=false;
   }else {
    box.style.display="none";
    flag=true;
   }
    

});

window.addEventListener("resize", function () {
    if (window.innerWidth >= 992) {
        box.style.display = "none";
        flag = true;
    }
});