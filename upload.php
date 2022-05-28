<?php
use imdmedia\Feed\Post;
use imdmedia\Auth\Security;

 require __DIR__ . '/vendor/autoload.php';
 include_once("inc/functions.inc.php");
boot(); 
Security::onlyLoggedInUsers();

if (isset($_SESSION['user'])) {
    if (isset($_POST['submit'])) {
        try {
            $user = $_SESSION['user'];
            $username = $user['username'];
            $userid = $user['id'];
            $title = $_POST['title'];
            $tags = $_POST['tags'];
            $file = $_FILES['file'];
            $description = $_POST['description'];
            $post = new Post();
            $post->setTitle($title);
            $post->setUserid($userid);
            $post->setFile($file);
            $post->setUsername($username);
            $post->setTags($tags);
            $post->upload();
            $post->save();
            header("Location: ./index.php?uploadsuccess");
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }
    }
}else{
    header("Location: login.php");
}

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
<?php include_once("inc/nav.inc.php"); ?>
                <?php if (isset($error)) : ?>
				<div class="formError">
					<p>
						<?php echo $error;?>
					</p>
				</div>
				<?php endif; ?>
    <form class="postForm" action="" method="POST" enctype="multipart/form-data">
        <input class="fileInput" type="file" name="file">
        <label for="Title">Title</label>
        <input type="text" name="title" placeholder="e.g. Rebrand for Thomas More">
        <label for="Description">Description</label>
        <input type="text" name="description" placeholder="e.g. I wanted to create a logo that was more playful and easy to market. The colors have I chosen are orange and purple because I like their meaning and it fits nice with the already existing Thomas More more. Any feedback will be much appreciated!!!!!">
        <label for="Tags">Tags</label>
        <input type="text" name="tags" placeholder="tag1, tag2, tag3">
        <button type="submit" name="submit">UPLOAD</button>
    </form>
</body>
</html>