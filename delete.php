<?php
  session_start();
  if(isset($_POST['token'])){
      $_SESSION['posted_token'] = $_POST['token'];
  }
    if(!(hash_equals($_SESSION['token'], $_SESSION['posted_token']))){
    	
        die("Request forgery detected");
    }
    if(!(isset($_SESSION['username']))){
      header("Location: news_site.php");
      exit;
    }
//    we use the same form for deleteing a story and a comment so here we set the table
//    name and the id of the item that should be deleted.
    if(isset($_POST['story'])){

         $_SESSION['id_to_delete']= $_POST['story'];
         $_SESSION['table'] = 'stories';
    }
    if(isset($_POST['comment'])){

         $_SESSION['id_to_delete']= $_POST['comment'];
         $_SESSION['table'] = 'comments';
    }
    $id_to_delete = $_SESSION['id_to_delete'];
    $table = $_SESSION['table'];
?>
<!DOCTYPE html>
  <html lang='en'>
    <head>
      <title>
        Delete Files
      </title>

      <link rel="stylesheet" type="text/css" href="module_3_group.css" />
    </head>
    <body>
      <!--            idea for header came from https://www.w3schools.com/howto/howto_css_responsive_header.asp       -->
        <div class="header">
                <a href="#default" class="logo">News Site</a>
                <div class="header-right">
                  <a class="active" href="news_site.php">Home</a>
<!--                  check if logged in to create the correct header-->
                  <?php
                    if(isset($_SESSION['username'])){
                        $msg = '<a href="home_page.php" class="username_header"> '.htmlentities($_SESSION['username']). '</a>
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
  <!--        form to make sure someone wants to actually delete something  -->
            <form enctype="multipart/form-data" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                <p>
                  Are you sure you would like to delete?
                </p>
                <p>
                    <input type="submit" name="yes" value="Yes" />
                    <input type="submit" name="no" value="No" />
                </p>
            </form>
        </div>
    </body>
  </html>


<?php
    require 'database.php';
    $username = $_SESSION['username'];
    if(isset($_POST['yes'])){
        
        if($table == 'stories'){
            $sql = "delete from comments where story=$id_to_delete";
            $res = $mysqli->query($sql);
        }
      
        $sql = "delete from $table where id=$id_to_delete";
        $res = $mysqli->query($sql);

        //unset the vars to make sure we don't get a mixup later
        unset($_SESSION['table']);
        unset($_SESSION['id_to_delete']);
        
        header("Location: news_site.php");
        exit;
    }
    elseif(isset($_POST['no'])){
        header("Location: news_site.php");
        exit;
    }
?>