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

//Rapport Item (AJAX)
let reportBtn = document.querySelector(".report");
let postId = reportBtn.dataset.post;
let userId = reportBtn.dataset.id;
reportBtn.addEventListener("click", (e) => {

    e.preventDefault();
    /*
    let postId = e.target.dataset.post;
    let userId = e.target.dataset.id;
    console.log(userId);
    console.log(postId);
    */

    let data = new FormData();
    data.append("postId", postId);
    data.append("userId", userId);
    console.log(postId);
    console.log(data);
    console.log(data.status)


    fetch('ajax/reportItem.php', {
        method: 'POST', // or 'PUT' //nu wordt er een nieuwe aangemaakt in databank dus POST
        body: data
    })
    .then(response =>response.json())
    .then(data => {
        console.log("not an error");
        console.log(data.status)
        if(data.status === "success" && data.message === "report was successful"){
            console.log("loll");
            reportBtn.innerHTML = "You reported this!";
            data.status === "false";
        }else if(data.status === "success" && data.message === "Dereport was successful"){
            console.log("helllllooo");
            reportBtn.innerHTML = "Report";
        }else if(data.status === "error"){
            reportBtn.innerHTML = "loser";
            console.log("loser");
        }
    })
    .catch((error) => {
        console.log("error");
        console.error('Error:', error);
    });

    console.log(reportBtn.innerHTML);
    e.preventDefault();


});