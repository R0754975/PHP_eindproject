<?php 
  $username = $_SESSION['user'];

  if (!empty($_POST)) {
    try {
        $value = $_POST["search"];
        header("Location: search.php?search=".$value);
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}

?><div class="nav">
      <div>
          <a href="./index.php"><img src="./images/computer.png" alt="IMDMedia logo" class="logo"></a>
      </div>
      <div>
          <form action="" method="post" class="searchBar">
              <div class="form__field">
                  <input type="text" name="search" placeholder="search posts">
              </div>
              <button type="submit">
                  <img src="https://res.cloudinary.com/dzhrxvqre/image/upload/v1651321618/IMDMedia_Pictures/searchIcon.png" alt="IMDMedia logo" class="searchIcon"/>
              </button>
          </form>
      </div>
      <div class="navRight">
          <a href="#" class="primarybtn">Upload project</a>
          <div class="account">
              <button class="dropbtn"><img src="https://res.cloudinary.com/dzhrxvqre/image/upload/v1651321618/IMDMedia_Pictures/searchIcon.png" alt="ProfilePic"></button>
              <div class="dropdownContent"> 
                  <a href="#">Profile</a>
                  <a href="./settings.php">Settings</a>
                  <hr>
                  <a href="./logout.php">Logout</a>
              </div>
          </div>
      </div>
  </div>