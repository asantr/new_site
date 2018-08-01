<!-- TODO: check token
    if token is correct send them to the main page. They don't need to log in again -->
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
<!--                  check if user is logged in to produce the correct options -->
                  <?php
                    session_start();
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
            <p> Please enter your credentials </p>
            <p>
                <label for="username_input">Username:</label>
                <input type="text" name="username" id="username_input" />
             </p>
             <p>
                <label for="password_input">Password:</label>
                <input type="text" name="password" id="password_input" />
             </p>
      
            <p>
                 <input type="Submit" name="login_user" value="Submit" />
            </p>
        </form>
        
        <?php
            require 'database.php';
            
            if(isset($_POST['login_user'])){
                
                $username = $_POST['username'];
                $password = $_POST['password'];
                
//              Would be cool: figure out why this query didn't work  
                //$stmt = $mysqli->prepare("select password from users where username=?");
                //if(!$stmt){
                //    printf("Query Prep Failed: %s\n", $mysqli->error);
                //    exit;
                //}
                //$stmt->bind_param('s', $username);
                //
                //$stmt->execute();
                //
                //$stmt->bind_result($pass_hash);
                
                $sql = "SELECT password from users where username='$username'";
                $res = $mysqli->query($sql);
                $passwords = $res->fetch_assoc();
                $pass_hash = $passwords['password'];
                
//                Check password 
                if (password_verify($password, $pass_hash)) {
//                    if correct password then create token and send back to main page. 
                    $_SESSION['username'] = $username;
                    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
                    header("Location: news_site.php");
                    exit;
                } else {
//                    if password is incorrect we let them resubmit
                    $msg = '<p> Invalid Password </p>';
                    echo $msg;
                }
                
            }
        ?>
        </div> 
    </body>
    
</html>
