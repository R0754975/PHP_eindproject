document.querySelector("#btnAddComment").addEventListener("click", function(){

    let postId = this.dataset.postId;
    let message = document.getElementById("commentText").Value;

    let formData = new FormData();

    formData.append('message', message);
    formData.append('postId', postId);

    fetch('ajax/saveComment.php', {
    method: 'POST',
    body: formData
    })
    .then(response => response.json())
    .then(formData => {
        console.log('ok1');
        let newComment = document.createElement('li');
        newComment.innerHTML = formData.body;
        document.querySelector("post__comments__list").appendChild(newComment);
    })
    .catch(error => {
    console.log('Error');
    });

});

document.querySelector("#btnAddLike").addEventListener("click", function(){

    let postId = this.dataset.postId;

    let formData = new FormData();

    formData.append('postId', postId);

    fetch('ajax/saveLike.php', {
    method: 'POST',
    body: formData
    })
    .then(response => response.json())
    .then(result => {
        let newLike = document.createElement('li');
        newLike.innerHTML = result.body;
        document.querySelector("likes_counter").appendChild(newLike);
    })
    .catch(error => {
    console.error('Error:', error);
    });

});