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

        if(isset($_POST['search'])){
            $posts = Post::searchAll($_POST['search']);

        }else{
            $posts = Post::getPage($page);
        }


        ?><!DOCTYPE html>
        <html lang="en">
        <head>
            <?php include_once("inc/header.inc.php"); ?>
            <title>IMDMedia</title>
        </head>
        <body>
            <?php include_once("inc/nav.inc.php"); ?>		
            <section class="feed">
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
            <div class="pageCounter">
                <?php for ($page = 1; $page <= $pageCount; $page++): ?>
                    <a href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                <?php endfor; ?>          
            </div>
        </body>
        </html>