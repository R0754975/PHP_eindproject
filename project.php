<?php
 include_once("bootstrap.php");
 include_once("inc/functions.inc.php");
Security::onlyLoggedInUsers();
if (isset($_POST['submit'])) {
    if(isset($_SESSION['user'])){
    try {    
    $user = $_SESSION['user']->getAll();
    $username = $user['username'];   
    $userid = $user['id']; 
    $title = $_POST['title'];
    $file = $_FILES['file'];
    $post = new Post();
    $post->setTitle($title);
    $post->setUserid($userid);
    $post->setFile($file);
    $post->setUsername($username);
    $post->upload();
    $post->save();
    header("Location: http://localhost:8888/PHP_eindproject/index.php?uploadsuccess");

    }
    catch ( Throwable $e) {
        $error = $e->getMessage();
      }
    }
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
                <?php if( isset($error) ) : ?>
				<div class="formError">
					<p>
						<?php echo $error;?>
					</p>
				</div>
				<?php endif; ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="the title of your project">
        <input type="file" name="file">
        <button type="submit" name="submit">UPLOAD</button>
    </form>
</body>
</html>