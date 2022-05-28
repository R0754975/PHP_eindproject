<?php 
    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
        $username = $user['username'];
        $profilePic = $user['profile_pic'];
    }

  if (!empty($_GET["search"])) {
    try {
        $value = $_GET["search"];
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}
?><div class="nav">
      <div class="logodiv">
          <a class="logo"href="./index.php"><img src="https://res.cloudinary.com/dzhrxvqre/image/upload/v1653685238/IMDMedia_Pictures/IMD_MEDIA.svg" alt="IMDMedia logo" class="logo"></a>
      </div>
      <div>
          <form action="" method="get" class="searchBar">
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
            <?php if(isset($profilePic)): ?>
              <button class="dropbtn"><img src="https://res.cloudinary.com/dzhrxvqre/image/upload/v1651321618/IMDMedia_Pictures/searchIcon.png" alt="ProfilePic"></button>
            <?php else: ?>
                <button class="dropbtn"><img src="https://res.cloudinary.com/dzhrxvqre/image/upload/v1653685238/IMDMedia_Pictures/IMD_MEDIA.svg" alt="ProfilePic"></button>
            <?php endif; ?>
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