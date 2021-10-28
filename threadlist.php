<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
    #ques {
        min-height: 433px;
    }
    </style>
    <title>iDiscuss - Coding Forum</title>
</head>

<body>

    <?php include "partials/_dbconnect.php";?>
    <?php include "partials/_header.php";?>
    <?php
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE category_id=$id";
    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($result)){
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];
        // $thread_user_id = $row['thread_user_id'];
        // $sql2 = "SELECT `user_email` FROM `users` WHERE `sno` = $thread_user_id";
        //     $result2 = mysqli_query($conn,$sql2);
        //     $row2 = mysqli_fetch_assoc($result2);
        //     $posted_by = $row2['user_email'];

    }
    
    ?>
    <?php
    $showAlert=false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method=='POST'){
        //Insert into db
        $th_title = $_POST['title'];
        $th_desc = $_POST['desc'];
        $sno = $_POST['sno'];
        $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
    $result = mysqli_query($conn,$sql);
    $showAlert = true;
    if ($showAlert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success! </strong> Your thread has been added successfully! Please wait till comunity to respond.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
              </div>';
    }
    }
    ?>





    <!-- Categories starts here -->
    <div class="container my-3" id="ques">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname?> forum</h1>
            <p class="lead"><?php echo $catdesc?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum. No Spam / Advertising / Self-promote in the forums is not allowed. Do not
                post
                copyright-in fringing material. Do not post "Offensive" posts, links or images. Do not cross post
                questions.
                Remain respectful of other members at all times.
            </p>
            <p>
                <!-- Posted by:<em><?php echo "$posted_by"?></em> -->
            </p>
        </div>
    </div>
    <?php
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
  echo'<div class="container">
        <h1>Start a Discussion.</h1>
        <form action="'. $_SERVER["REQUEST_URI"]. '" method="post">
    <div class="form-group">
        <label for="exampleInputEmail1">Problem Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="title"
            placeholder="problem">
        <small id="emailHelp" class="form-text text-muted">Keep your title as short and crisp as
            possible.</small>
    </div>
    <input type="hidden" name="sno" value="'. $_SESSION["sno"]. '">
    <div class="form-group">
        <label for="exampleFormControlTextarea1">Ellaborate your concern</label>
        <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-success">Submit</button>
    </form>
    </div>';
    }
    else {
    echo'
    <div class="container">
    <h1>Start a Discussion.</h1>
    <p class="lead"> You are not logged in. Please login to able to start a Discussion.</p> </div>
    ';
    }
    ?>
    <div class="container my-4" id="ques">
        <h1>Browse Questions</h1>
        <?php
            $id = $_GET['catid'];
            $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
            $result = mysqli_query($conn,$sql);
            $noResult=true;
            while($row = mysqli_fetch_assoc($result)){
                $noResult=false;
            $id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc']; 
            $threads_time = $row['timestamp']; 
            $thread_user_id = $row['thread_user_id'];  
            $user_id = $row['thread_user_id'];     
            $sql2 = "SELECT `user_email` FROM `users` WHERE `sno` = $user_id";
            $result2 = mysqli_query($conn,$sql2);
            $row2 = mysqli_fetch_assoc($result2);


            
        

    
            echo '<div class="media my-3">
                <img class="mr-3" src="/img/defaultuser.png" width="54px" alt="Generic placeholder image">
                <div class="media-body">
                <h5 class="mt-0"><a class="text-dark" href="thread.php?threadid=' . $id . '">'. $title .'</a></h5>
                '. $desc .
            '</div>' . 
                '<p class="font-weight-bold my-0"> Asked by: ' . $row2['user_email'] . ' at ' . $threads_time . '</p>'.
                   
            '</div>';

            }

            if ($noResult) {
                echo '<div class="jumbotron jumbotron-fluid">
                <div class="container">
                  <p class="display-4 ">No Threads Found</p>
                  <p class="lead">Be the first person to add question.</p>
                </div>
              </div>';
            }
    
        ?>





    </div>

    <?php include "partials/_footer.php";?>











    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>