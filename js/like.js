function likePost(e, postId) {

    let post = postId;

    let updateLikes = document.querySelector(`#totalLikes-${post}`);
    let updateLikeButton = document.querySelector(`#likeButton-${post}`);

    console.log(post);

    let formData = new FormData();
    formData.append("postId", post);

    fetch("ajax/savelike.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if(result.body == "1"){
            updateLikeButton.innerHTML = "Unlike";
            updateLikes.innerHTML = result.likes;
        }
        else if(result.body == "0"){
            updateLikeButton.innerHTML = "Like";
            updateLikes.innerHTML = result.likes;
        }
    })
    .catch(error => {
        console.error("Error:", error);
    });
        
};    