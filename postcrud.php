<?php
/**
 * Created by PhpStorm.
 * User: weagl
 * Date: 22.11.2016
 * Time: 23:17
 */


session_start();
include('functions.php');
Connection::connect();
if (!empty($_GET['id'])) {
    $id = intval($_GET['id']);
}
if (!empty($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $postData = Posts::getById($id);
}
if (!empty($_GET['delete'])) {
    $id = intval($_GET['delete']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Post page</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">


    <!--[if lt IE 9]>
    <script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div class="container">


    <div class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Go to start</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">

                    <li class="active">

                    </li>
                    <li class="active">

                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">


                </ul>
            </div>
        </div>
    </div>

    <div class="jumbotron">
        <?php
        if (!empty($_GET['edit'])) {
            if (!empty($_POST)) {

                if (!empty($_POST['title'])) {
                    $title = mysqli_real_escape_string(Connection::$conn, $_POST['title']);
                }
                if (!empty($_POST['text'])) {
                    $text = mysqli_real_escape_string(Connection::$conn, $_POST['text']);
                }

                $result = Posts::updatePost($id, $title, $text);
                if ($result) {
                    $postData = Posts::getById($id);
                    echo "<span class='label label-success'>Post was succesfully updated.</span>";
                }
            }
            $name = $postData['title'];
            $desc = $postData['text'];
            echo <<<EDIT
        <form method="post">
            <label for="field">
                <p>Edit post $name</p>
            </label>
            <p>Post's title</p>
            <p><input type="text" name="title" value='$name'></p>
            <p>Post's text</p>
            <p><textarea rows="5" cols="60" name="text" id="field">$desc</textarea></p>        
            <input type="submit" value="Update data">
EDIT;
        } elseif (!empty($_GET['delete'])) {
            $result = Posts::deletePost($id);
            if ($result) {
                echo "<span class='label label-success'>Post was succesfully deleted.</span>";
            }
        } elseif (!empty($_GET['id'])) {
            Posts::showById($id);
            echo "</div>
        <div class='jumbotron'>";

            if (!empty($_POST)) {
                if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['text'])) {
                    $name = mysqli_real_escape_string(Connection::$conn, $_POST['name']);
                    $email = mysqli_real_escape_string(Connection::$conn, $_POST['email']);
                    $text = mysqli_real_escape_string(Connection::$conn, $_POST['text']);
                    $result = Comments::NewComment($id, $name, $email, $text);
                    if ($result) {
                        echo "<span class='label label-success'>Comment was succesfully added.</span>";
                    } else {
                        echo "<span class='label label-warning'>Something go wrong. Comment wasn't added.</span>";
                }
                } else {
                    echo "<span class='label label-warning'>Comment wasn't added. May be some of fields are empty!</span>";
                }
            }
            echo <<<COMMENT

        <form name="contact_form" method="post" onsubmit="return validate_form ( );">
            <div class="addComment">
                <label id="add">
                    <p>Add a comment</p>
                </label> <br/>
                <label id="req">
                    <p>Fields marked as <span id="atn">*</span> are required</p>
                </label>
                <p>Name : <span id="atn">*</span> <input type="text" name="name"></p>
                <p>Email : <span id="atn">*</span> <input type="text" name="email"></p>
                <p>Comment <span id="atn">*</span></p>
                <p><textarea rows="4" cols="30" name="text""></textarea></p>
                <input type="submit" name="send" value="Send comment">
            </div>
        </form>
        <div class='comments'>
COMMENT;
            Comments::showAllByPostId($id);
        } else {
            if (!empty($_POST)) {
                if (!empty($_POST['title']) && !empty($_POST['text'])) {
                    $title = mysqli_real_escape_string(Connection::$conn, $_POST['title']);
                    $text = mysqli_real_escape_string(Connection::$conn, $_POST['text']);
                }
                $result = Posts::NewPost($title, $text);
                if ($result) {
                    echo "<span class='label label-success'>Post was succesfully created.</span>";
                }
            }

            echo <<<POSTCREATE
        <form method="post">
            <label for="title">
                <p>Post's title</p>
            </label>
            <p><input type="text" name="title">
                <label for="text">
            <p>Post's text</p>
            </label>
            <p><textarea rows="5" cols="60" name="text" id="field"></textarea></p>
            <input type="submit" value="Create post">
        </form>
    </div>
POSTCREATE;
        }
        ?>
    </div>
</div>


<!--Bootstrap core JavaScript
                    ================================================== -->
<!--Placed at the end of the document so the pages load faster-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="js.js"></script>
</body>
</html>


