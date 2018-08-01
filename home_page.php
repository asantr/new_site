<?php
    session_start();
    if(!(isset($_SESSION['username']))){
        header("Location: news_site.php");
        exit;
    }
    $username = $_SESSION['username'];
?>
<!-- Page for viewing story content and the comments of each story -->
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
<!--           heck for if the user is logged in       -->
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
                <div class="shares">
                    <h4> Shared With You </h4>
                    <?php
                        require 'database.php';
                        $sql = "SELECT * from shares where user_to='$username'";
                        $res = $mysqli->query($sql);
                        
                        $share = $res->fetch_assoc();
                        
                        $user_from = $share['user_from'];
                        $story_id = $share['story'];
                        $time = $share['time'];
                        
                        $msg = '<div class="share_page"> ';
                        $msg .= '<h1 class="share_view">From: '.htmlentities($user_from).'</h1>';
                        $msg .= '<p class="share_time">'.htmlentities($time).'</p>';
                        
                        
                        $sql_two = "SELECT * from stories where id='$story_id'";
                        $res = $mysqli->query($sql_two);
                        
                        while($story = $res->fetch_assoc()){
                            $title = $story['title'];
                            $author = $story['author'];
                            $content = $story['content'];
                            $link = $story['link'];
                            $id = $story['id'];
                            
                            $msg = '<div class="share_story_page"> ';
                            $msg .= '<h1 class="title_story_view">'.htmlentities($title).'</h1>';
                            $msg .= '<a href="'.$link.'">'.htmlentities($link).'</a>';
                            $msg .= '<p class="story_view_content">'.htmlentities($content).'</p>';
                            $msg .= '<h2 class="story_view_author">'.htmlentities($author).'</h2>';
                            
                            $msg .= '</div>';
                            echo $msg;
                        }
                                               
                    ?>
                </div>
                <div class="private_stories">
                    <h3> Private Stories</h3>
                    <?php
                        require 'database.php';
                        $sql = "SELECT * from private_stories where user_to='$username'";
                        $res = $mysqli->query($sql);
                        
                        while($story = $res->fetch_assoc()){
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
                            
                            $sql_two = "SELECT * from private_comments where story='$id'";
                            $comments = $mysqli->query($sql_two);
                            
                            if($comments === false){
                                echo "failed";
                            }
                        
                            while ($comment = $comments->fetch_assoc()) {
                                $author = $comment['author'];
                                $content = $comment['content'];
                                $id = $comment['id'];
                                
                                $msg = '<div class="comment_entry"> ';
                                //$msg .= '<h1><a class="story_title" href="story_page.php?id='.$id.'">'.$title.'</a></h1>';
                                $msg .= '<p class="comment_content">'.htmlentities($content).'</p>';
                                $msg .= '<h2 class="comment_author">'.htmlentities($author).'</h2>';
                               
                                
                                $msg .= '</div>';
                                echo $msg;
                            }
                           
                            if(isset($_SESSION['username'])){
                                $msg = '<form class="comment" action="'.htmlentities($_SERVER['PHP_SELF']).'" method="POST">
                                  <textarea name="comment">Enter comment here.</textarea>
                                <p>
                                    <input type="hidden" name="id" value="'.$id.'"/>
                                     <input type="Submit" name="submit_comment" value="Submit" />
                                </p>
                                </form>';
                                echo $msg;
                            }
                        }
                        $sql = "SELECT * from private_stories where author='$username'";
                        $res = $mysqli->query($sql);
                        
                        while($story = $res->fetch_assoc()){
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
                            
                            $sql_two = "SELECT * from private_comments where story='$id'";
                            $comments = $mysqli->query($sql_two);
                            
                            if($comments === false){
                                echo "failed";
                            }
                        
                            while ($comment = $comments->fetch_assoc()) {
                                $author = $comment['author'];
                                $content = $comment['content'];
                                $id = $comment['id'];
                                
                                $msg = '<div class="comment_entry"> ';
                                //$msg .= '<h1><a class="story_title" href="story_page.php?id='.$id.'">'.$title.'</a></h1>';
                                $msg .= '<p class="comment_content">'.htmlentities($content).'</p>';
                                $msg .= '<h2 class="comment_author">'.htmlentities($author).'</h2>';
                               
                                
                                $msg .= '</div>';
                                echo $msg;
                            }
                           
                            if(isset($_SESSION['username'])){
                                $msg = '<form class="comment" action="'.htmlentities($_SERVER['PHP_SELF']).'" method="POST">
                                  <textarea name="comment">Enter comment here.</textarea>
                                <p>
                                    <input type="hidden" name="id" value="'.$id.'"/>
                                     <input type="Submit" name="submit_comment" value="Submit" />
                                </p>
                                </form>';
                                echo $msg;
                            }
                        }

                    ?>
                    
                    <?php
                        require 'database.php';
                        
                        if(isset($_POST['submit_comment'])){
                           // $username = $_SESSION['username'];
                            $comment = '';
                            $comment_id = $_POST['id'];
                            
                            
                            if(isset($_POST['comment'])){
                                echo "here";
                                $comment = $_POST['comment'];
              //                    submit to stories table                   
                                $stmt = $mysqli->prepare("insert into private_comments (story, author, content) values (?, ?, ?)");
                                
                                if(!$stmt){
                                    printf("Query Prep Failed: %s\n", $mysqli->error);
                                    exit;
                                }
                                
                                
                                $stmt->bind_param('sss', $comment_id, $_SESSION['username'], $comment);
                                $stmt->execute();
                                
                                $stmt->close();
        
                               header("Refresh:0"); 
                            }
                        }
                    ?>
                </div>
            </div>  
    </body>
</html>
