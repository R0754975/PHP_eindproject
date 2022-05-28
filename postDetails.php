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
        var_dump(intval($postId));
        var_dump($_SESSION['user']['id']);
        var_dump($reportCheck);
        
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

    <section class="postDetails">
        <div class="postDetails__img">
            <img class="postDetails__imgSRC" src="<?php echo $postDetails['filePath']; ?>" alt="<?php echo $postDetails['title']; ?>">
        </div>
        <div>
        <h3><?php echo htmlspecialchars($postDetails['title']); ?></h3>
        <?php if ($auth == true): ?>
        <a href="account.php?Account=<?php echo htmlspecialchars($postDetails['userName']); ?>" class="postUsername"><?php echo htmlspecialchars($postDetails['userName']); ?></a>
        <?php $tags = json_decode($postDetails['tags']); ?>
        <?php foreach ($tags as $tag): ?>
        <a href="?tags=<?php echo htmlspecialchars($tag); ?>" class="postTags">#<?php echo htmlspecialchars($tag); ?></a>
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
    <script src="js/postDetails.js"></script>
</body>
</html>