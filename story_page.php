<?php
    session_start();
    $id = '';
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }else {
        echo "couldn't get it.";
        //header("Location: news_site.php");
        //exit;
    }
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
                        $msg = '<a href="#default" class="username_header"> '.htmlentities($_SESSION['username']). '</a>
                        <a href="submit_story.php">Add Story</a>
                         <a href="logout.php">Log Out</a> ';
                        echo $msg;
                        
                    } else{
                        $msg = '<a href="user_login.php"> Log In </a>
                                <a href="create_user.php"> Sign Up </a>';
                        echo $msg;
                    }
                  ?>
                </div>
             </div>
        <div class="content">
            <?php
                require 'database.php';
                $sql = "SELECT * from stories where id='$id'";
                $res = $mysqli->query($sql);
                
                $story = $res->fetch_assoc();
                
                $title = $story['title'];
                $author = $story['author'];
                $content = $story['content'];
                $link = $story['link'];
                $id = $story['id'];
                
                $msg = '<div class="story_page"> ';
                $msg .= '<h1 class="title_story_view">'.htmlentities($title).'</h1>';
                $msg .= '<a href="'.$link.'">'.htmlentities($link).'</a>';
                $msg .= '<p class="story_view_content">'.htmlentities($content).'</p>';
                $msg .= '<h2 class="story_view_author">'.htmlentities($author).'</h2>';
                
                $msg .= '</div>';
                echo $msg;
                
                 
            ?>
        </div> 
    </body>
    
</html>
