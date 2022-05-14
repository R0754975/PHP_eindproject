let deleteBtn = document.querySelector(".deleteBtn");
let confirmation = document.querySelector(".delete");
let notConfirmd = document.querySelector(".noBtn");

deleteBtn.addEventListener("click", showConfirmation);
notConfirmd.addEventListener("click", removeConfirmation);

function showConfirmation(){
    console.log("ok")
    confirmation.style.display = "block"
}

function removeConfirmation(){
    confirmation.style.display = "none";
}
