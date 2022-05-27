document.querySelector("#followbtn").addEventListener("click", function() {

    let followingUser = this.dataset.followingUser;
    let followedUser = this.dataset.followedUser;
    let follow = this.dataset.follow;

    console.log(followingUser);
    console.log(followedUser);


    let formData = new FormData();
    formData.append("followingUser", followingUser);
    formData.append("followedUser", followedUser);
    formData.append("follow", follow);

    fetch("ajax/follow.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        this.dataset.follow = result.body;
        if(result.body == "1"){
            document.querySelector('#followTxt').innerHTML = "unfollow";
        }
        else if(result.body == "0"){
            document.querySelector('#followTxt').innerHTML = "follow";
        }
    })
    .catch(error => {
        console.error("Error:", error);
    });


});