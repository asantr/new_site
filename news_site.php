<?php
    session_start();
    $username = '';
    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
    }
    unset($_SESSION['posted_token']);
?>
<!-- News Sites Main page -->
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
//                  check if user is logged in to give proper logout/create post or login/create user options
                    if(isset($_SESSION['username'])){
                        $msg = '<a href="home_page.php" class="username_header"> '.htmlentities($_SESSION['username']) . '</a>
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
//            query for all the stories that have been posted 
                $sql = "SELECT * from stories";
                $res = $mysqli->query($sql);
                while ($story = $res->fetch_assoc()) {
//                  grab all the necessary information for the current story in the loop
                    $title = $story['title'];
                    $author = $story['author'];
                    $content = $story['content'];
                    $link = $story['link'];
                    $id = $story['id'];
                    $time = $story['time'];
                    
//                    here we construct the div for each story. 
                    
                    $msg = '<div class="story_entry"> ';
                    if($author == $username){
                        //$msg .= '<a href="edit_comment.php?id='.$id.'">Edit/Delete</a>';
                        $msg .= '<form class="edit" action="edit_story.php" method="POST">
                                <input type="hidden" name="id" value="'.$id.'"/>
                                <input type="hidden" name="token" value="'.$_SESSION['token'].'"/>
                                <input type="Submit" class="right" name="edit_story" value="Edit/Delete" /></form> ';
                    }
                    //$msg .= '<h1><a class="story_title" href="story_page.php?id='.$id.'">'.$title.'</a></h1>';
                    $msg .= '<h1 class="story_title">'.$title.'</h1><h3 class="timestamp">'.htmlentities($time).'</h3>';
//                   TODO: change this to form for CSRF token
                    //if($author == $username){
                    //    $msg .= '<a href="edit_story.php?id='.$id.'">Edit/Delete</a>';
                    //}
                    
                    $msg .= '<a href="'.$link.'">'.htmlentities($link).'</a>';
                    $msg .= '<p class="story_content">'.htmlentities($content).'</p>';
                    $msg .= '<h2 class="story_author">'.htmlentities($author).'</h2>';
//                    TODO: change this to form for CSRF token
//                      WOULD BE COOL: To display how many comments there are
                    $msg .= '<a class="comment_link" href="view_comments.php?id='.htmlentities($id).'">Comments</a>';
                    $msg .= '</div>';
                    echo $msg;
                }
                
                 
            ?>
        </div> 
    </body>
    
</html>
