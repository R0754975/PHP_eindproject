<?php
    use imdmedia\Feed\Post;

    require __DIR__ . '/vendor/autoload.php';
    include_once("inc/functions.inc.php");

    boot();
    $auth = checkLoggedIn();

    // determine how many items are allowed per page
    $maxResults = 10;
    // determine how many items are in the database
    $postCount = Post::getRowCount();
    // determine how many pages there are
    $pageCount = ceil($postCount / $maxResults);
    // determine which page number is currently being viewed
    if (!isset($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }
    // retrieve the posts for the current page

    $posts = Post::getPage($page);


?><!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("inc/header.inc.php"); ?>
    <title>IMD Media Account</title>
</head>
<body>
    <?php include_once("inc/nav.inc.php"); ?>

    <div class="info">
        <div class="globalInfo">
            <div class="pic">
                <div class="userPic"></div>
                <button class="changePic"></button>
            </div>
            <div class="bioInfo">
                <h1 class="profileUsername"><?php echo $_SESSION['user']['username']; ?></h1>
                <h3 class="profileEmail"><?php echo $_SESSION['user']['email']; ?></h3>
                <div class="bio">
                    <p class="bioInput">Bla bla bla bla bla bla </p>
                    <button class="changeButton"></button>
                </div>
            </div>
        </div>
        <div class="extraIfo">
            <div class="education">
                <h2>Education</h2>
                <ul>
                    <li>No education selected</li>
                </ul>
            </div>
            <div class="socialMedia">
                <h2>Social Media</h2>
                <div class="icons">
                    <a href="https://www.instagram.com/"><img src="https://res.cloudinary.com/dzhrxvqre/image/upload/v1652127860/IMDMedia_Pictures/instagramIcon.svg" alt="link to Instagram"></a>    
                    <a href="https://twitter.com/?lang=en"><img src="https://res.cloudinary.com/dzhrxvqre/image/upload/v1652128151/IMDMedia_Pictures/TwitterIcon.svg" alt="link to Twitter"></a>    
                    <a href="https://www.linkedin.com/feed/"><img src="https://res.cloudinary.com/dzhrxvqre/image/upload/v1652128088/IMDMedia_Pictures/LinkedInIcon.svg" alt="link to LinkedIn"></a>    
                </div>
            </div>
        </div>
    </div>
    <section class="feed profileFeed">
        <?php foreach ($posts as $key => $post): ?>
        <div class="post">
            <img src="<?php echo $post['filePath']; ?>" alt="<?php echo $post['title']; ?>">
            <h3><?php echo htmlspecialchars($post['title']); ?></h3>
            <?php if ($auth == true): ?>
            <a href="account.php?Account=<?php echo htmlspecialchars($post['userName']); ?>" class="postUsername"><?php echo htmlspecialchars($post['userName']); ?></a>
            <?php $tags = json_decode($post['tags']); ?>
            <?php foreach ($tags as $tag): ?>
            <a href="?tags=<?php echo htmlspecialchars($tag); ?>" class="postTags">#<?php echo htmlspecialchars($tag); ?></a>
            <?php endforeach ?>
            <?php endif ?>
        </div>
        <?php endforeach; ?>    
    </section>


    <div class="socials">
        <div class="socialPic"></div>
        <button class="changeSocialPic userSession"></button>
    </div>

    <script type="module" src="main.js"></script>
</body>
</html>