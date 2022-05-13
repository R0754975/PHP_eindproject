<?php 
    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
        $username = $user['username'];
    }

  if (!empty($_POST)) {
    try {
        $value = $_POST["search"];
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
          <?php if(isset($user)): ?>
            <a href="upload.php" class="primarybtn">Upload project</a>
          <?php endif; ?>
          <div class="account">
              <button class="dropbtn"><img src="https://res.cloudinary.com/dzhrxvqre/image/upload/v1651321618/IMDMedia_Pictures/searchIcon.png" alt="ProfilePic"></button>
              <div class="dropdownContent"> 
                  <?php if(isset($username)): ?>
                    <a href="./account.php?Account=<?php echo $username; ?>">Profile</a>
                    <a href="./settings.php">Settings</a>
                    <hr>
                    <a href="./logout.php">Logout</a>
                  <?php endif; ?>
                    <?php if(!isset($user)): ?>
                  <a href="./login.php">Login</a>
                  <?php endif; ?>
              </div>
          </div>
      </div>
  </div>