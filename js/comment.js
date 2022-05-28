document.querySelector("#btnAddComment").addEventListener("click", function() {

let comment = document.querySelector("#commentText").value;
let postId = this.dataset.postId;

console.log(comment);
console.log(postId);

let formData = new FormData();
formData.append("comment", comment);
formData.append("postId", postId);

    fetch("ajax/savecomment.php", {
        method: "POST",
        body: formData
    })

        .then(response => response.json())
        .then(result => {
            let newComment = document.createElement("li");
            newComment.setAttribute('class','comment');
            document.querySelector(".post__comments__list").appendChild(newComment);
            let commentAuthor = document.createElement("p");
            commentAuthor.innerHTML = result.username;
            newComment.appendChild(commentAuthor);
            let commentText = document.createElement("p");
            commentText.innerHTML = result.body;
            newComment.appendChild(commentText);
        })
        .catch(error => {
            console.error("Error:", error);
        })

});
