<?php
    session_start();
    
    //echo '<p>'.$_SESSION['token'].'end </p>';
    //echo '<p>'.$_POST['token'].'end </p>';
    //
    //echo '<p>'.strlen($_SESSION['token']).'</p>';
    //echo '<p>'.strlen($_POST['token']).'end</p>';
    
    if(isset($_POST['token'])){
        $_SESSION['posted_token'] = $_POST['token'];
    }
    
    if(!(hash_equals($_SESSION['token'], $_SESSION['posted_token']))){
    	//echo "matching"; 
        die("Request forgery detected");
    }
    
    if(!(isset($_SESSION['username']))){
        header("Location: news_site.php");
        exit;
    }
    if(isset($_GET['id'])){
        $_SESSION['id'] = $_GET['id'];
    }
    $id = $_SESSION['id'];
    
    require 'database.php';
    $sql = "SELECT * from stories where id='$id'";
    $res = $mysqli->query($sql);
    
    $story = $res->fetch_assoc();
    
    $title = $story['title'];
    $author = $story['author'];
    $content = $story['content'];
    $link = $story['link'];
      
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
           <!--        form for signing in     -->
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                <p>
                    <label for="title_input">Title</label>
                    <input type="text" name="title" id="title_input" value="<?php echo htmlentities($title) ?>"/>
                 </p>
                 <p>
                    <label for="link_input">Link:</label>
                    <input type="text" name="link" id="link_input" value="<?php echo htmlentities($link) ?>"/>
                 </p>
                  <textarea name="content"><?php echo  htmlentities($content) ?></textarea>
                <p>
                    <input type="hidden" name="story" value="<?php echo $id ?>"/>
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>"/>
                     <input type="Submit" name="submit_story" value="Update Story" />
                     
                </p>
            </form>
            <form action="delete.php" method="POST">
                        <input type="Submit" name="delete_story" value="Delete Story" />
                        <input type="hidden" name="story" value="<?php echo $id ?>"/>
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>"/>
                        
            </form>
            
            <?php
                if(isset($_POST['submit_story'])){
                    $username = $_SESSION['username'];
                    $title = '';
                    $link = '';
                    $content = '';
                    
                    if(isset($_POST['title'])){
                        $title = $_POST['title'];
                        
                        if(isset($_POST['link'])){
                            $link = $_POST['link'];
                        }
                        if(isset($_POST['content'])){
                            $content = $_POST['content'];
                        }
                        
                        $stmt = $mysqli->prepare("UPDATE stories SET author='$author', title='$title', content='$content', link='$link' WHERE id=$id LIMIT 1");
                        if(!$stmt){
                            printf("Query Prep Failed: %s\n", $mysqli->error);
                            exit;
                        }
                        
                        $stmt->execute();
                        
                        $stmt->close();
                        
                        
                    } else {
                        echo "<p>You must add a title for your story</p>";
                    }
                    ob_start();
                    header("Refresh:0");
                    
                }
            ?>
        </div> 
    </body>
    
</html>
