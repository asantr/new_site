<?php
    session_start();
    if(!(isset($_SESSION['username']))){
        header("Location: news_site.php");
    }
    require 'database.php';
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
<!--        check if user is logged in to create the perfect header for them          -->
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
        
<!--        form for submitting a story to our site  -->
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
            <p>
                <label for="title_input">Title:</label>
                <input type="text" name="title" id="title_input" />
             </p>
             <p>
                <label for="link_input">Link:</label>
                <input type="text" name="link" id="link_input" />
             </p>
            <input type="checkbox" name="private" >Private Story </input>
            
            <textarea name="content">Enter story here.</textarea>
            <p>
                 <input type="Submit" name="submit_story" value="Submit" />
            </p>
            <select name="users">
                <?php
                    $sql_two = "SELECT username from users";
                    $users = $mysqli->query($sql_two);
                    
                    if($users === false){
                        echo "failed";
                    }
                
                    while ($user = $users->fetch_assoc()) {
                        $option_username = $user['username'];
                        echo "<option value='".htmlentities($option_username)."'>".htmlentities($option_username)."</option>";
                    }
                ?>
            </select>
        </form>
        
        <?php
            require 'database.php';
            
            if(isset($_POST['submit_story'])){
                $username = $_SESSION['username'];
                $title = '';
                $link = '';
                $content = '';
//                they must at least have a title 
                if(isset($_POST['title'])){

                    $title = $_POST['title'];
                    
                    if(isset($_POST['link'])){
                        $link = $_POST['link'];
                    }
                    if(isset($_POST['content'])){
                        $content = $_POST['content'];
                    }

                    if(isset($_POST['private'])){
                        if(isset($_POST['users'])){
                            $selected_user = $_POST['users'];
                            $stmt = $mysqli->prepare("insert into private_stories (author, user_to, title, content, link) values (?, ?, ?, ?, ?)");
                            if(!$stmt){
                                printf("Query Prep Failed: %s\n", $mysqli->error);
                                exit;
                            }
                            $stmt->bind_param('sssss', $_SESSION['username'], $selected_user, $title, $content, $link);
                            
                            $stmt->execute();
                            
                            $stmt->close();
                        } else{
                            echo "<p> You must select a user for private stories </p>";
                        } 
                         
                    } else {
                          //                    submit to stories table                   
                        $stmt = $mysqli->prepare("insert into stories (author, title, content, link) values (?, ?, ?, ?)");
    
                        if(!$stmt){
                            printf("Query Prep Failed: %s\n", $mysqli->error);
                            exit;
                        }
                        
                        $stmt->bind_param('ssss', $_SESSION['username'], $title, $content, $link);
                        
                        $stmt->execute();
                        
                        $stmt->close();
                    
                    }  
                } else {
                     $msg = "<p>You must add a title for your story</p>";
                    echo $msg;
                }
                //ob_start();
                //header("Refresh:0");
            }
        ?>
        </div> 
    </body>
    
</html>
