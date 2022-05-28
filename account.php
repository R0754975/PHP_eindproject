<?php
    use imdmedia\Feed\Post;
    use imdmedia\Auth\Security;
    use imdmedia\Auth\User;
    use imdmedia\Data\Follow;
    use imdmedia\Data\Report;
    use imdmedia\Feed\Like;
    
    require __DIR__ . '/vendor/autoload.php';
    
    session_start();
    $auth = Security::checkLoggedIn();
    Security::onlyLoggedInUsers();

    //add search function
    if(isset($_GET['search'])){
        header("Location: index.php?search=" . $_GET['search']);
    }

    if(isset($_GET['Account'])){
        $user = $_GET['Account'];
        
        $profileUser = User::getUserByUsername($user);
        $posts = Post::getAllUserPosts($profileUser['id']);

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
                </div>
            </div>
        </div>
        <div class="extraInfo">
            <section>
                <div>
                <a style="text-decoration: none;" href="#" id="followbtn" 
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
                        <a href="https://www.instagram.com/<?php echo htmlspecialchars($profileUser['ig']); ?>"><img src="https://res.cloudinary.com/dzhrxvqre/image/upload/v1652127860/IMDMedia_Pictures/instagramIcon.svg" alt="link to Instagram"></a>    
                        <a href="https://twitter.com/<?php echo htmlspecialchars($profileUser['tw']); ?>"><img src="https://res.cloudinary.com/dzhrxvqre/image/upload/v1652128151/IMDMedia_Pictures/TwitterIcon.svg" alt="link to Twitter"></a>    
                           
                    </div>
                </div>
            </section>
        </div>
    </div>
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


    <div class="socials">
        <div class="socialPic"></div>
        <button class="changeSocialPic userSession"></button>
    </div>

    <script type="module" src="./js/sass.js"></script>
    <script type="module" src="main.js"></script>
    <script src="js/follow.js"></script>
    <script src="js/report.js"></script>
    <script src="js/like.js"></script>
</body>
</html>