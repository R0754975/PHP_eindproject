<?php
    use imdmedia\Feed\Post;
    use imdmedia\Auth\Security;
    use imdmedia\Auth\User;
    use imdmedia\Feed\ReportPost;
    use imdmedia\Feed\Comment;
    use imdmedia\Feed\Like;

    require __DIR__ . '/vendor/autoload.php';

    session_start();
    $auth = Security::checkLoggedIn();
    Security::onlyLoggedInUsers();


    //add search function
    if(isset($_GET['search'])){
        header("Location: index.php?search=" . $_GET['search']);
    }

    if(isset($_GET['Post'])){
        try { 
            $postId = $_GET['Post'];
            $postDetails = Post::getPostById($postId);
            $tagArray = json_decode($postDetails['tags']);
            $posts = Post::getDetailPostsByTags($tagArray[0], $postId);
            $reportCheck = ReportPost::reportCheck($postId ,$_SESSION['user']['id']);
            if($postDetails['userid'] == $_SESSION['user']['id']){
                $ownProfile = true;
            }
            else $ownProfile = false;
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }
    }
    else (
        header("Location: index.php")
    );

   if (isset($_POST['confirm'])) {
       if ($_SERVER['REQUEST_METHOD'] == 'POST') {
           try {
               if ($_POST['confirm'] == 'Yes') {
                   Post::deletePostById($postId);
                   header("Location: index.php");
               }
           } catch (Throwable $e) {
               $error = $e->getMessage();
           }
       }
   }

    if(isset($_POST['changeTitle'])){
        try {
            $newTitle = $_POST["newTitle"];
            $postId = $_GET['Post'];
            $post = new Post();
            $changeTitle = $post->changeTitle($newTitle, $postId);
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }

    }

    if(isset($_POST['changeTag'])){
        try {
            $newTag = $_POST["newTag"];
            $postId = $_GET['Post'];
            $post = new Post();
            $post->setTags($_POST["newTag"]);
            $changeTag = $post->changeTag($postId);
        }   catch (Throwable $e) {
            $error = $e->getMessage();
        } 

    }
    $like = "Like";
    if(isset($_SESSION['user']['id'])){
            $checklike = Like::checkLiked($_SESSION['user']['id'], $postId);
             if($checklike == 1) {
                $like = "Unlike";
            }
            else {
                $like = "Like";
            }
    }
    
    $totalLikes = Like::getAll($postId);  



?><!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("inc/header.inc.php"); ?>
    <title><?php echo htmlspecialchars($postDetails['title']); ?></title>
</head>
<body>
    <?php include_once("inc/nav.inc.php"); ?>

<div class="detailsblock">
    <section class="postL">
        <section class="postImage">
            <div class="details__img">
                <img class="details__imgSRC" src="<?php echo $postDetails['filePath']; ?>" alt="<?php echo htmlspecialchars($postDetails['title']); ?>">
            </div>
        </section>
        <section class="feed profileFeed">
            <?php foreach ($posts as $key => $post): ?>
            <?php    
                
                $feedlike = "Like";
                    if(isset($_SESSION['user']['id'])){
                        $feedchecklike = Like::checkLiked($_SESSION['user']['id'], $post[('id')]);
                    if($feedchecklike == 1) {
                        $feedlike = "Unlike";
                     }
                    else {
                        $feedlike = "Like";
                    }
                }
    
                $feedtotalLikes = Like::getAll($post[('id')]);   
            ?>    
            <div class="post">
                <a href="postDetails.php?Post=<?php echo htmlspecialchars($post['id']); ?>">
                <img src="<?php echo $post['filePath']; ?>" alt="<?php echo htmlspecialchars($post['title']); ?>"></a>
                <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                <?php if ($auth == true): ?>
                <a href="account.php?Account=<?php echo htmlspecialchars($post['userName']); ?>" class="postUsername"><?php echo htmlspecialchars($post['userName']); ?></a>
                <?php $tags = json_decode($post['tags']); ?>
                <?php foreach ($tags as $tag): ?>
                <a href="index.php?search=<?php echo htmlspecialchars($tag); ?>" class="text__tags">#<?php echo htmlspecialchars($tag); ?></a>
                <?php endforeach ?>
                <?php endif ?>
                <p class="likes">
                        <a style="text-decoration: none;" href="#" 
                        id="likeButton-<?php echo htmlspecialchars($post[('id')]); ?>"
                        onclick="likePost(this, <?php echo htmlspecialchars($post[('id')]); ?>)" 
                        >
                        <?php echo $feedlike;?>
                        </a>
                            <span id="totalLikes-<?php echo htmlspecialchars($post[('id')]); ?>"><?php echo $feedtotalLikes;?></span>
                        </p>
                </p>
            </div>
            <?php endforeach; ?>        
        </section>
    </section>
    <section class="postDetails">
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
                                    <button class="report" data-check="reported" data-post="<?php echo htmlspecialchars($postId); ?>" data-id="<?php echo $_SESSION['user']['id'];?>">Undo report</button>
                                    <input class="session" type="hidden" value="">
                                <?php else: ?>
                                    <button class="report" data-check="report" data-post="<?php echo htmlspecialchars($postId); ?>" data-id="<?php echo $_SESSION['user']['id'];?>">Report this</button>
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
                    <p class="details__text details__text--description"><?php echo htmlspecialchars($postDetails['description']); ?> </p>
                <?php elseif(!isset($postDetails['description'])): ?>
                    <p class="details__text details__text--description" >No description given</p>
                <?php endif; ?>
            </div>

            <?php if ($auth == true): ?>
                <div class="postData">
                    <div>
                    <a style="text-decoration: none;" href="#" 
                        id="likeButton-<?php echo htmlspecialchars($postId); ?>"
                        onclick="likePost(this, <?php echo htmlspecialchars($postId); ?>)">
                        <?php echo $like;?>
                        </a>
                        <p id="totalLikes-<?php echo htmlspecialchars($postId); ?>"><?php echo $totalLikes;?></p>
                    </div>
                    <?php foreach ($tags as $tag): ?>
                        <a href="index.php?search=<?php echo htmlspecialchars($tag); ?>" class="details__text text__tags details__text--tags">#<?php echo htmlspecialchars($tag); ?></a>
                    <?php endforeach ?>
                </div>
                <?php if($ownProfile == true): ?>
                    <div class="changePostInfo">  
                    <form class="postForm" method="POST" action="" enctype="multipart/form-data"> 
                        <h2>Change title</h2>
                        <?php if (isset($error)) : ?>
                        <div class="error">
                            <p>
                                <?php echo $error; ?>
                            </p>
                        </div>
                        <?php endif; ?>	
                        <label for="pass">New Title</label>
                        <input type="title" id="newTitle" name="newTitle">

                        <button type="submit" name="changeTitle" class="upload__text__btn">Change Title</button>
                    </form>  
                    
                    <form id="changeTag" class="postForm" method="POST" action="" enctype="multipart/form-data"> 
                        <h2>Change tag</h2>
                        <?php if (isset($error)) : ?>
                        <div class="error">
                            <p>
                                <?php echo $error; ?>
                            </p>
                        </div>
                        <?php endif; ?>	
                        <label for="pass">New Tags</label>
                        <input type="tag" id="newTag" name="newTag">

                        <button type="submit" name="changeTag" class="upload__text__btn">Change Tags</button>
                    </form> 
                    </div>  
                <?php endif; ?>
                <div class="post__comments">
                    <div class="post__comments__form">
                        <input type="text" id="commentText" placeholder="Write a comment...">
                        <a href="#" class="upload__text__btn" id="btnAddComment"
                        data-post-Id="<?php echo htmlspecialchars($postId); ?>"
                        >Add comment</a>
                    </div>
                    <?php $comments = Comment::getAll($postId); ?>
                    <ul class="post__comments__list">
                    <?php foreach($comments as $comment): ?>
                    <?php $user = User::getUserById($comment['userId']); ?>    
                        <li class="comment">
                            <p><?php echo htmlspecialchars($user['username']);?></p>
                            <p><?php echo htmlspecialchars($comment['comment']);?></p>
                        </li>        
                    <?php endforeach; ?>    
                    </ul>

                </div>
            <?php endif ?>
        </div>
    </section>
</div>

    <script type="module" src="./js/sass.js"></script>
    <script src="js/deletePost.js"></script>
    <script src="js/postDetails.js"></script>
    <script src="js/comment.js"></script>
    <script src="js/like.js"></script>
</body>
</html>