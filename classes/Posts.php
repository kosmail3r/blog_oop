<?php
	class Posts {
		static public function showAll() {
			$sql = "SELECT * FROM Posts ORDER BY created_at DESC";
            //$sql = "SELECT LEFT ('text', 300) ,'title', 'id', 'created_at'  FROM Posts ORDER BY created_at DESC";
			$rows = Connection::makeQuery($sql);

			foreach($rows as $row) {
				echo "<div class='post'>";
                echo "<div class='postTitle'>";
                echo $row['title'];
                echo "</div>";
                echo "<div class='postBody'>";
                echo substr($row['text'],0,300);
				echo "<a href='postcrud.php?id=" . $row['id'] . "'> Read more </a>";
                echo "</div>";
                echo "<div class='postOptions'>";
                echo "<a href='postcrud.php?edit=" . $row['id'] . "'> Edit </a>";
                echo "<a href='postcrud.php?delete=" . $row['id'] . "'> Delete </a>";
                echo "</div>";
				echo "</div>";
			}
		}

		static public function NewPost ($title, $text) {
            $sql = "INSERT INTO Posts (title, text, created_at) VALUES ('" . $title . "','" . $text . "', NOW() )";
            $result = Connection::addToDB($sql);
            if ($result){
                return true;
            } else {
                return false;
            }
        }

        static public function showById($id){
            $sql = "SELECT * FROM Posts WHERE id='" . $id . "'";
            $rows = Connection::makeQuery($sql);

            foreach ($rows as $row) {
                echo "<div class='post'>";
                echo "<div class='postTitle'><strong>";
                echo $row['title'];
                echo "</div></strong>";
                echo "<div class='postBody'>";
                echo $row['text'];
                echo "</div>";
                echo "</div>";
            }
        }


        public static function getById($id) {
            $sql = "SELECT * FROM Posts WHERE id='" . $id . "'";
            $rows = Connection::makeQuery($sql);
            $ress = $rows[0];
            return $ress;
        }

        public static function updatePost ($id, $title, $text) {
            $sql = "UPDATE `Posts` SET `title` = '". $title ."', `text` = '".$text."' WHERE `id` =" . $id;
            $result = Connection::addToDB($sql);
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
        static  public function deletePost($id) {
            $sql= "DELETE FROM `Posts` WHERE id =" . $id;
            $result = Connection::addToDB($sql);
            Comments::DeleteByPostId($id);
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
	}