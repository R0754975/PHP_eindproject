<?php
    use imdmedia\Feed\Post;
    use imdmedia\Auth\Security;
    use imdmedia\Auth\User;
    require __DIR__ . '/vendor/autoload.php';
    include_once("inc/functions.inc.php");
    
    boot();
    $auth = Security::checkLoggedIn();

    if(isset($_GET['Post'])){
        $postId = $_GET['Post'];
        $postDetails = Post::getPostById($postId);
        $posts = Post::getPostByTags($postDetails['tags']);

        
        if($postDetails['userid'] == $_SESSION['user']['id']){
            $ownProfile = true;
        }
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
        <img src="<?php echo $postDetails['filePath']; ?>" alt="<?php echo $postDetails['title']; ?>">
        <h3><?php echo htmlspecialchars($postDetails['title']); ?></h3>
        <?php if ($auth == true): ?>
        <a href="account.php?Account=<?php echo htmlspecialchars($postDetails['userName']); ?>" class="postUsername"><?php echo htmlspecialchars($postDetails['userName']); ?></a>
        <?php $tags = json_decode($postDetails['tags']); ?>
        <?php foreach ($tags as $tag): ?>
        <a href="?tags=<?php echo htmlspecialchars($tag); ?>" class="postTags">#<?php echo htmlspecialchars($tag); ?></a>
        <?php endforeach ?>
        <?php if(isset($ownProfile)): ?>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if ($_POST['confirm'] == 'Yes') {
                    var_dump("delete");
                    //delete_record($_REQUEST['id']); // From GET or POST variables
                }else{
                    //redirect($_POST['referer']);
                    var_dump("not delete");
                }
            }
            ?>

<form action="" method="post">
    <p>Are you sure?</p>
    <input type="submit" name="confirm" value="Yes">
    <input type="submit" name="confirm" value="No">
</form>

        <?php endif; ?>
        <?php endif ?>

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
    </section>

    <script type="module" src="main.js"></script>
</body>
</html>