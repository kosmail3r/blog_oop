<?php

/**
 * Created by PhpStorm.
 * User: weagl
 * Date: 23.11.2016
 * Time: 0:05
 */
class Comments
{
    static public function NewComment($id, $name, $email, $text)
    {
        $sql = "INSERT INTO Comments (post_id, name, email, text, created_at) VALUES ('" . $id . "','" . $name . "','" . $email . "','" . $text . "', NOW() )";
        $result = Connection::addToDB($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    static public function getComentsCount($id)
    {
        $sql = "SELECT COUNT('name') FROM Comments WHERE post_id='" . $id . "'";
        $rows = Connection::makeStr($sql);
        $result = array_shift($rows);
        return $result;
    }

    static public function showAllByPostId($id)
    {
        $sql = "SELECT * FROM Comments WHERE post_id='" . $id . "'";
        $rows = Connection::makeQuery($sql);
        if (empty($rows)) {
            echo "Comments are empty...";
        }
        echo "<div class='commentsCount'>Comments <strong>(" . Comments::getComentsCount($id) . ")</strong></div>";
        foreach ($rows as $row) {
            echo "<div class='container'><div class='row commentpost'>";
            echo "<div class='col-lg-2 col-md-2'>";
            echo "<img src='img/author.png' alt=''>";
            echo "</div><div class='col-lg-8 col-md-8 '>";
            echo "<div class='commentInfo'>";
            echo $row['name'] . "   " . $row['email'];
            echo "</div>";
            echo "<div class='commentText'>";
            echo $row['text'];
            echo "";
            echo "";
            echo "</div></div></div></div>";
        }
        echo "</div>";
    }

    public static function DeleteByPostId ($id) {
        $sql= "DELETE FROM `Comments` WHERE post_id =" . $id;
        $result = Connection::addToDB($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}