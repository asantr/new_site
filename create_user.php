<!-- TODO: check token
    if token succeeds they shouldn't have this option-->

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
<!--                  header for the correct options if the user is logged in -->
                  <?php
                    session_start();
                    if(isset($_SESSION['username'])){
                        $msg = '<a href="home_page.php" class="username_header"> '.htmlentities($_SESSION['username']) . '</a>
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
        
<!--        form for creating a user    -->
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
            <p>
                <label for="username_input">Username:</label>
                <input type="text" name="username" id="username_input" />
             </p>
             <p>
                <label for="password_input">Password:</label>
                <input type="text"  name="password" id="password_input" />
             </p>
             <p>
                <label for="password_input_confirm">Confirm Password:</label>
                <input type="text" name="password_confirm" id="password_input_confirm" />
             </p>
      
            <p>
                 <input type="Submit" name="create_user" value="Submit" />
            </p>
        </form>
        
        <?php
            require 'database.php';
            
            if(isset($_POST['create_user'])){
                
                $desired_username = $_POST['username'];
                $desired_password = $_POST['password'];
                $confirm_password = $_POST['password_confirm'];
                
                if(strcmp($desired_password, $confirm_password) == 0){
//                    if the passwords match then we hash and submit to users table
                    $desired_password = password_hash($desired_password, PASSWORD_DEFAULT);
                    $stmt = $mysqli->prepare("insert into users (username, password) values (?, ?)");
                    if(!$stmt){
                        printf("Query Prep Failed: %s\n", $mysqli->error);
                        exit;
                    }
                    
                    $stmt->bind_param('ss', $desired_username, $desired_password);
                    
                    $stmt->execute();
                    
                    $stmt->close();
                    
                } else {
                    $msg = "<p>Password do not match </p>";
                    echo $msg;        
                }
                
            }
        ?>
        </div> 
    </body>
    
</html>
