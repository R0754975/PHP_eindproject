//delete post confirmation (js)
let deleteBtn = document.querySelector(".deleteBtn");
let confirmation = document.querySelector(".delete");
let notConfirmd = document.querySelector(".noBtn");

deleteBtn.addEventListener("click", showConfirmation);
notConfirmd.addEventListener("click", removeConfirmation);

function showConfirmation() {
    console.log("ok")
    confirmation.classList.toggle("show");
    confirmation.classList.toggle("delete");
}

function removeConfirmation() {
    console.log("nee");
    confirmation.style.display = "none";
    deleteBtn.addEventListener("click", showConfirmation);
}