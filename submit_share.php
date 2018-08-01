<?php
    session_start();
    
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
    $story_id = $_SESSION['id'];
    
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
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                <p>
                    Select a user to share with?
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
                <!--  <textarea name="content">Enter story here.</textarea>-->
                <!--<p>-->
                     <input type="Submit" name="share_story" value="Submit" />
                </p>
        </form>

    <?php
        if(isset($_POST['share_story'])){
           // $username = $_SESSION['username'];
        
//                    submit to stories table                   
                $stmt = $mysqli->prepare("insert into shares (user_to, user_from, story) values (?, ?, ?)");
                
                if(!$stmt){
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }
                 $selected_user = $_POST['users'];
                 echo $selected_user;
                $stmt->bind_param('sss', $selected_user, $_SESSION['username'], $story_id);
                $stmt->execute();
                
                $stmt->close();

                header("Location: home_page.php"); 
        }
    ?>
        </div> 
    </body>
    
</html>