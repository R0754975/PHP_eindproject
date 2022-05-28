<?php

    use imdmedia\Feed\Post;
    use imdmedia\Auth\Security;

    require __DIR__ . '/vendor/autoload.php';
    include_once("inc/functions.inc.php");
  
        boot();
        $auth = Security::checkLoggedIn();

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

        if(isset($_GET['search'])){
            $posts = Post::searchAll($_GET['search']);
            if (empty($posts)){
                $requestNotFound = true;
                $posts = Post::getPage($page);
            }

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
            <?php if (isset($requestNotFound)): ?>
                <h2>We didn't find an item with that title or tag. Please type another one.</h2>		
            <?php endif; ?>
            <section class="feed">
                <?php foreach ($posts as $key => $post): ?>
                <a href="postDetails.php?Post=<?php echo htmlspecialchars($post['id']); ?>">
                    <div class="post">
                        <img src="<?php echo $post['filePath']; ?>" alt="<?php echo $post['title']; ?>">
                        <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                        <?php if ($auth == true): ?>
                        <a href="account.php?Account=<?php echo htmlspecialchars($post['userName']); ?>" class="postUsername"><?php echo htmlspecialchars($post['userName']); ?></a>
                        <?php $tags = json_decode($post['tags']); ?>
                        <?php foreach ($tags as $tag): ?>
                        <a href="?tags=<?php echo htmlspecialchars($tag); ?>" class="text__tags">#<?php echo htmlspecialchars($tag); ?></a>
                        <?php endforeach ?>
                        <?php endif ?>
                    </div>
                </a>
                <?php endforeach; ?> 
                <p class="likes">
                            <a href="#" id="btnAddLike">&hearts;</a>
                            <span id="likes_counter">x</span> people like this
                        </p>

                <div class="post__comments">
                    <div class="post__comments__form">
                        <input type="text" id="commentText" style="color:black">
                        <a href="#" class="btn" id="btnAddComment" data-postId="<?php echo $_GET['post']?>">Add comment</a>
                    </div>  
                    
                    <ul class="post__comments__list">
                        <?php foreach($allComments as $c): ?>
                        <li><?php echo $c['message']; ?></li>  
                        <?php endforeach; ?>
                    </ul>
                </div>   
            </section>
            <?php include_once("inc/footer.inc.php"); ?>
            <script type="module" src="./js/sass.js"></script>
        </body>
        </html>