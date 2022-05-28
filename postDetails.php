<?php
    use imdmedia\Feed\Post;
    use imdmedia\Auth\Security;
    use imdmedia\Auth\User;
use imdmedia\Feed\ReportPost;

    require __DIR__ . '/vendor/autoload.php';
    include_once("inc/functions.inc.php");
    
    boot();
    $auth = Security::checkLoggedIn();

    if(isset($_GET['Post'])){
        $postId = $_GET['Post'];
        $postDetails = Post::getPostById($postId);
        $posts = Post::getPostByTags($postDetails['tags']);
        $reportCheck = ReportPost::reportCheck($postId ,$_SESSION['user']['id']);
        if($postDetails['userid'] == $_SESSION['user']['id']){
            $ownProfile = true;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST['confirm'] == 'Yes') {
            Post::deletePostById($postId);
            header("Location: index.php");
        }
    }

    if(isset($_POST['changeTitle'])){
        $newTitle = $_POST["newTitle"];
        $postId = $_GET['Post'];
        $post = new Post();
        $changeTitle = $post->changeTital($newTitle, $postId);


    }

    if(isset($_POST['changeTag'])){
        $newTag = $_POST["newTag"];
        $postId = $_GET['Post'];
        $post = new Post();
        $changeTag = $post->changeTag($newTag, $postId);


    }



?><!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("inc/header.inc.php"); ?>
    <title><?php echo $postDetails['title']; ?></title>
</head>
<body>
    <?php include_once("inc/nav.inc.php"); ?>

    <section class="details">
        <div class="details__img">
            <img class="details__imgSRC" src="<?php echo $postDetails['filePath']; ?>" alt="<?php echo $postDetails['title']; ?>">
        </div>
        <div class="details__details">
            <div class="details__header">
                <div>
                    <h3 class="details__text details__text__title"><?php echo htmlspecialchars($postDetails['title']); ?></h3>
                </div>
                <div class="details__drop">
                    <button class="dropbtn"><img class="details__dropbtn" src="https://res.cloudinary.com/dzhrxvqre/image/upload/v1653723484/IMDMedia_Pictures/extra.png" alt="extra"></button>
                    <div class="dropdownContent details__dropdownContent"> 
                        <?php if($postDetails['userName'] === $_SESSION['user']['username']): ?>
                            <button class="deleteBtn">Delete post</button>
                            <form class="delete" action="" method="post">
                                <div class="confirmation">
                                <p>Are you sure?</p>
                                <div class="deleteBtns">
                                    <input class="yesBtn confirmationBtn" type="submit" name="confirm" value="Yes">
                                    <input class="noBtn confirmationBtn" type="submit" name="confirm" value="No">
                                </div>
                                </div>
                            </form>
                            <?php endif; ?>
                            <?php if($postDetails['userName'] !== $_SESSION['user']['username']): ?>
                                <?php if ($reportCheck): ?>
                                    <button class="report" data-check="reported" data-post="<?php echo $postId; ?>" data-id="<?php echo $_SESSION['user']['id'];?>">Undo report</button>
                                    <input class="session" type="hidden" value="">
                                <?php else: ?>
                                    <button class="report" data-check="report" data-post="<?php echo $postId; ?>" data-id="<?php echo $_SESSION['user']['id'];?>">Report this</button>
                                    <input class="session" type="hidden" value="">
                                <?php endif; ?>
                            <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php if ($auth == true): ?>
                <a class="details__text details__text--account"href="account.php?Account=<?php echo htmlspecialchars($postDetails['userName']); ?>" class="postUsername"><?php echo htmlspecialchars($postDetails['userName']); ?></a>
            <?php $tags = json_decode($postDetails['tags']); ?>
            <?php endif; ?>
            <div class="details__text details__description">
                <p class="details__text details__text__subtitle details__text__subtitle--description">Description</p>
                <?php if(isset($postDetails['description'])): ?>
                    <p class="details__text details__text--description"><?php echo $postDetails['description']; ?> </p>
                <?php elseif(!isset($postDetails['description'])): ?>
                    <p class="details__text details__text--description" >No description given</p>
                <?php endif; ?>
            </div>

            <?php if ($auth == true): ?>
            <?php foreach ($tags as $tag): ?>
            <a href="?tags=<?php echo htmlspecialchars($tag); ?>" class="details__text text__tags details__text--tags">#<?php echo htmlspecialchars($tag); ?></a>
            <?php endforeach ?>
            <?php if(isset($ownProfile)): ?>
            <button class="deleteBtn">Delete</button>
            <form class="delete" action="" method="post">
                <div class="confirmation">
                <p>Are you sure?</p>
                <div class="deleteBtns">
                    <input class="yesBtn confirmationBtn" type="submit" name="confirm" value="Yes">
                    <input class="noBtn confirmationBtn" type="submit" name="confirm" value="No">
                </div>
                </div>
            </form>
            <?php if ($reportCheck): ?>
                <p class="report" data-check="reported" data-post="<?php echo $postId; ?>" data-id="<?php echo $_SESSION['user']['id'];?>">You reported this!</p>
                <input class="session" type="hidden" value="">
            <?php else: ?>
                <p class="report" data-check="report" data-post="<?php echo $postId; ?>" data-id="<?php echo $_SESSION['user']['id'];?>">Report this</p>
                <input class="session" type="hidden" value="">
            <?php endif; ?>
            <?php endif; ?>
            <?php endif ?>
        </div>
    </section>

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
        </div>
        <?php endforeach; ?>
         
        
        <form class="postForm" method="POST" action="" enctype="multipart/form-data"> 
            <h2>Change title</h2>
            <div class="error">
                <?php echo $error ?>
            </div>
            <label for="pass">New Title</label>
            <input type="title" id="newTitle" name="newTitle">

            <button type="submit" name="changeTitle">Change Title</button>
        </form>  
        
        <form class="postForm" method="POST" action="" enctype="multipart/form-data"> 
            <h2>Change tag</h2>
            <div class="error">
                <?php echo $error ?>
            </div>
            <label for="pass">New Tags</label>
            <input type="tag" id="newTag" name="newTag">

            <button type="submit" name="changeTag">Change Tags</button>
        </form> 
        
    </section>

    <script type="module" src="./js/sass.js"></script>
    <script src="js/deletePost.js"></script>
    <script src="js/postDetails.js"></script>
</body>
</html>