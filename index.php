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
            <title>IMDMedia</title>
        </head>
        <body>
            <?php include_once("inc/nav.inc.php"); ?>		
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