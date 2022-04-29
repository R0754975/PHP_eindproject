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
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>IMDMedia</title>
            <link rel="stylesheet" href="css/app.css">
        </head>
        <body>
            <?php if ($auth == true): ?>
            <a href="logout.php" class="navbar__logout">Hi, logout?</a>
            <?php endif ?>
            <?php if ($auth == false): ?>
            <a href="login.php" class="navbar__logout">Hi, would you like to Log in?</a>
            <?php endif ?>		
            <section>
                <div>
                    <h1>IMDMedia</h1>
                    <h2>Welcome to IMDMedia</h2>
                    <a href="post.php">new Post</a>
                </div>
                <?php foreach ($posts as $post): ?>
                <div class="post">
                    <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                    <img src="<?php echo $post['filePath']; ?>" alt="<?php echo $post['title']; ?>">
                    <?php if ($auth == true): ?>
                    <a href="account.php?Account=<?php echo htmlspecialchars($post['userName']); ?>"><?php echo htmlspecialchars($post['userName']); ?></a>
                    <?php $tags = json_decode($post['tags']); ?>
                    <?php foreach ($tags as $tag): ?>
                    <a href="?tags=<?php echo htmlspecialchars($tag); ?>">#<?php echo htmlspecialchars($tag); ?></a>
                    <?php endforeach ?>
                    <?php endif ?>
                </div>
                <?php endforeach; ?>    
            </section>

            <?php for ($page = 1; $page <= $pageCount; $page++): ?>
                <a href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
            <?php endfor; ?>    
        </body>
        </html>