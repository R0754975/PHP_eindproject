<?php
    use imdmedia\Feed\Post;

    require __DIR__ . '/vendor/autoload.php';
    include_once("inc/functions.inc.php");
    $searchValue= "project 1";
    session_start();

    $collectionId = $_GET['search'];
    $posts = Post::searchAll($collectionId);
    var_dump($posts);

?><!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("inc/header.inc.php"); ?>
    <title><?php echo $collectionId; ?></title>
</head>
<body>
    <?php include_once("inc/nav.inc.php"); ?>
    <section>
        <div>
            <h2>Posts about <?php echo $collectionId; ?></h2>
        </div>
        <?php foreach ($posts as $key => $post): ?>
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
</body>
</html>