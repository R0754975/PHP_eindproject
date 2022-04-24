<?php
    include_once("bootstrap.php");
    include_once("inc/functions.inc.php");
        boot();
        $auth = checkLoggedIn();
        
        $posts = Post::getAll();

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
            <?php if($auth == true): ?>
            <a href="logout.php" class="navbar__logout">Hi, logout?</a>
            <?php endif ?>
            <?php if($auth == false): ?>
            <a href="signup.php" class="navbar__logout">Hi, would you like to register?</a>
            <?php endif ?>		
            <section>
                <div>
                    <h1>IMDMedia</h1>
                    <h2>Welcome to IMDMedia</h2>
                    <a href="project.php">Upload a new project!</a>
                </div>
                <?php foreach($posts as $post): ?>
                <div class="post">
                    <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                    <img src="<?php echo $post['filePath']; ?>" alt="<?php echo $post['title']; ?>">
                    <?php if($auth == true): ?>
                    <p><?php echo htmlspecialchars($post['userName']); ?></p>
                    <?php endif ?>
                </div>
                <?php endforeach; ?>    
            </section>
        </body>
        </html>