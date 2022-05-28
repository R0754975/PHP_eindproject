<?php
    use imdmedia\Feed\Post;
    use imdmedia\Auth\Security;
    use imdmedia\Auth\User;
    use imdmedia\Data\Follow;
    use imdmedia\Data\Report;

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

    $posts = Post::getPage($page);
    
    if(isset($_GET['Account'])){
        $user = $_GET['Account'];
        $profileUser = User::getUserByUsername($user);

        if($profileUser['id'] == $_SESSION['user']['id']){
            $ownProfile = true;
        }
    }

    $followData = 0;
    $follow = "follow";
    if(isset($_SESSION['user']['id'])){
        $followCheck = Follow::checkFollow($_SESSION['user']['id'], $user = $profileUser['id']);
        if($followCheck === true) {
            $followData = 1;
            $follow = "unfollow";
        }
        else {
            $followData = 0;
            $follow = "follow";
        }
    }

    $reportData = 0;
    $report = "report";
    if(isset($_SESSION['user']['id'])){
        $reportCheck = Report::checkReport($_SESSION['user']['id'], $user = $profileUser['id']);
        if($reportCheck === true) {
            $reportData = 1;
            $report = "unreport";
        }
        else {
            $reportData = 0;
            $report = "report";
        }
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("inc/header.inc.php"); ?>
    <title>IMD Media Account</title>
</head>
<body>
    <?php include_once("inc/nav.inc.php"); ?>

    <div class="info">
        <div class="globalInfo">
            <div class="pic">
                <div>
                    <img class="userPic" src="<?php echo $profileUser['profile_pic'];?>">
                </div>
                <button class="changePic"></button>
            </div>
            <div class="bioInfo">
                <h1 class="profileUsername profile"><?php echo htmlspecialchars($profileUser['username']); ?></h1>
                <h3 class="profileEmail profile"><?php echo htmlspecialchars($profileUser['email']); ?></h3>
                <div class="bio profile">
                    <p class="bioInput"><?php echo htmlspecialchars($profileUser['bio']); ?></p>
                    <?php if(isset($ownProfile)): ?>
                        <button class="changeButton">Button</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="extraInfo">
            <section>
                <div>
                <a style="text-decoration: none;" href="#" id="followbtn" 
                data-following-User="<?php echo $_SESSION['user']['id'];?>" 
                data-followed-User="<?php echo $profileUser['id'];?>"
                data-follow="<?php echo $followData;?>"
                >
                <h2 id="followTxt"><?php echo $follow;?></h2>
                </a>
                </div>

                <div>
                <a style="text-decoration: none;" href="#" id="reportbtn" 
                data-reporting-User="<?php echo $_SESSION['user']['id'];?>" 
                data-reported-User="<?php echo $profileUser['id'];?>"
                data-report="<?php echo $reportData;?>"
                >
                <h2 id="reportTxt"><?php echo $report;?></h2>
                </a>
                </div>

                <div class="education">
                    <h2>Education</h2>
                    <ul>
                        <li><?php echo htmlspecialchars($profileUser['education']); ?></li>
                    </ul>
                </div>
                <div class="socialMedia">
                    <h2>Social Media</h2>
                    <div class="icons">
                        <a href="https://www.instagram.com/<?php echo $profileUser['ig']; ?>"><img src="https://res.cloudinary.com/dzhrxvqre/image/upload/v1652127860/IMDMedia_Pictures/instagramIcon.svg" alt="link to Instagram"></a>    
                        <a href="https://twitter.com/<?php echo $profileUser['tw']; ?>"><img src="https://res.cloudinary.com/dzhrxvqre/image/upload/v1652128151/IMDMedia_Pictures/TwitterIcon.svg" alt="link to Twitter"></a>    
                           
                    </div>
                </div>
            </section>
        </div>
    </div>
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


    <div class="socials">
        <div class="socialPic"></div>
        <button class="changeSocialPic userSession"></button>
    </div>

    <?php include_once("inc/footer.inc.php"); ?>
    <script type="module" src="main.js"></script>
    <script src="js/follow.js"></script>
    <script src="js/report.js"></script>
</body>
</html>