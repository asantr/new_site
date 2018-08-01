<?php
    session_start();
    if(isset($_POST['token'])){
        
        $_SESSION['posted_token'] = $_POST['token'];
    }
    if(!(isset($_SESSION['username']))){
        header("Location: news_site.php");
        exit;
    }
    if(isset($_POST['id'])){
        $_SESSION['id'] = $_POST['id'];
    }
    $id = $_SESSION['id'];
    //
    //echo '<p>'.$id.'</p>';
    //echo '<p>'.$_SESSION['token'].'end </p>';
    //echo '<p>'.$_POST['token'].'end </p>';
    //
    //echo '<p>'.strlen($_SESSION['token']).'</p>';
    //echo '<p>'.strlen($_POST['token']).'end</p>';
    if(!(hash_equals($_SESSION['token'], $_SESSION['posted_token']))){
    	//echo "matching"; 
        die("Request forgery detected");
    }
    
    require 'database.php';
    $sql = "SELECT * from comments where id='$id'";
    $res = $mysqli->query($sql);
    
    $comment = $res->fetch_assoc();
    
    $author = $comment['author'];
    $content = $comment['content'];
    $id = $comment['id'];
    $story = $comment['story'];
?>

<!DOCTYPE html>
<html lang='en'>
    <head>
        <title>
            News Site
        </title>
        
        <link rel="stylesheet" type="text/css" href="module_3_group.css" />
    </head>
    <body>
        <!--            idea for header came from https://www.w3schools.com/howto/howto_css_responsive_header.asp       -->
        <div class="header">
                <a href="#default" class="logo">News Site</a>
                <div class="header-right">
                  <a class="active" href="news_site.php">Home</a>
                  <?php
                    if(isset($_SESSION['username'])){
                        $msg = '<a href="home_page.php" class="username_header"> '.htmlentities($_SESSION['username']). '</a>
                        <a href="submit_story.php">Add Story</a>
                        <a href="logout.php">Log Out</a> ';
                        echo ($msg);
                        
                    } else{
                        $msg = '<a href="user_login.php"> Log In </a>
                                <a href="create_user.php"> Sign Up </a>';
                        echo ($msg);
                    }
                  ?>
                </div>
             </div>
        <div class="content">
           <!--        form for editing comments    -->
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                  <textarea name="comment_content"><?php echo $content ?></textarea>
                <p>
                    <input type="hidden" name="comment" value="<?php echo $id ?>"/>
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>"/>
                    <input type="Submit" name="submit_comment" value="Update Comment" />
                </p>
            </form>
            <form action="delete.php" method="POST">
                        <input type="Submit" name="delete_comment" value="Delete Comment" />
                        <input type="hidden" name="comment" value="<?php echo $id ?>"/>
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>"/>
                        
            </form>
            
            <?php
                if(isset($_POST['submit_comment'])){
                   $username = $_SESSION['username'];
                   
                   if(isset($_POST['comment_content'])){
                       $content = $_POST['comment_content'];
                       
                       echo $content;
                       $stmt = $mysqli->prepare("UPDATE comments SET author='$username', content='$content', story=$story WHERE id=$id");
                       if(!$stmt){
                           printf("Query Prep Failed: %s\n", $mysqli->error);
                           exit;
                       }
                       
                       $stmt->execute();
                       
                       $stmt->close();
                       ob_start();
                       //header("Refresh:0");
                       
                   }
               }                   
            ?>
        </div> 
    </body>
    
</html>
