<?php

    use imdmedia\Feed\Post;
    use imdmedia\Auth\Security;
    use imdmedia\Feed\Like;

    require __DIR__ . '/vendor/autoload.php';
  
        session_start();
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
                $pageNumber = (($page - 1) * $maxResults);
                $posts = Post::getPage($pageNumber);
            }

        }else{
            $pageNumber = (($page - 1) * $maxResults);
            $posts = Post::getPage($pageNumber);
        }
     
    
        ?><!DOCTYPE html>
        <html lang="en">
        <head>
            <?php include_once("inc/header.inc.php"); ?>
            <title>IMDMedia</title>
        </head>
        <body>
            <?php include_once("inc/nav.inc.php"); ?>
            <div class="centerError">
                <?php if (isset($requestNotFound)): ?>
                    <h2 class="errorPostNotFound">We didn't find an item with that title or tag. Please type another one.</h2>		
                <?php endif; ?>
            </div>
            <?php if(isset($_GET['search'])): ?>
            <div>
               <a href="index.php" style="text-decoration:none;"><button class="formbtn">reset filters</button></a>
            </div>
            <?php endif; ?>
            <section class="feed">
                <?php foreach ($posts as $key => $post): ?> 
                <?php    
                
                $like = "Like";
                    if(isset($_SESSION['user']['id'])){
                        $checklike = Like::checkLiked($_SESSION['user']['id'], $post[('id')]);
                    if($checklike == 1) {
                        $like = "Unlike";
                     }
                    else {
                        $like = "Like";
                    }
                }
    
                $totalLikes = Like::getAll($post[('id')]);   
                ?>
                <?php
                    if($auth == true) {
                        $url = "postDetails.php?Post=" . htmlspecialchars($post['id']);
                    }
                    else $url = "#"
                ?>
                <a href="<?php echo $url; ?>">
                    <div class="post">
                        <img src="<?php echo $post['filePath']; ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                        <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                        <?php if ($auth == true): ?>
                        <a href="account.php?Account=<?php echo htmlspecialchars($post['userName']); ?>" class="postUsername"><?php echo htmlspecialchars($post['userName']); ?></a>
                        <?php $tags = json_decode($post['tags']); ?>
                        <?php foreach ($tags as $tag): ?>
                        <a href="?search=<?php echo htmlspecialchars($tag); ?>" class="text__tags">#<?php echo htmlspecialchars($tag); ?></a>
                        <?php endforeach ?>
                        <?php endif ?>
                        <p class="likes">
                        <a style="text-decoration: none;" href="#" id="likeButton-<?php echo htmlspecialchars($post[('id')]); ?>"
                        onclick="likePost(this, <?php echo htmlspecialchars($post[('id')]); ?>)" 
                        >
                        <?php echo $like;?>
                        </a>
                            <span id="totalLikes-<?php echo htmlspecialchars($post[('id')]); ?>"><?php echo $totalLikes;?></span>
                        </p>

                    </div>
                </a>
                <?php endforeach; ?> 
                  
            </section>
            <?php include_once("inc/footer.inc.php"); ?>
            <script type="module" src="./js/sass.js"></script>
            <script src="js/like.js"></script>
        </body>
        </html>