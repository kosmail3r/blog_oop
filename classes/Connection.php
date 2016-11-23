<?php
	class Connection {
		static public $conn;
		const DB_HOST = 'localhost';
		const DB_NAME = 'blog';
		const DB_USER = 'root';
		const DB_PASSWORD = '';

		static public function connect() {
			self::$conn = mysqli_connect(self::DB_HOST, self::DB_USER, self::DB_PASSWORD, self::DB_NAME);
			if (!self::$conn) {
				die ('Oops something happened');
			}
		}

		static public function
        makeQuery($sql, $isResultNeed = true) {
			$r = mysqli_query(self::$conn, $sql);
			if (!$isResultNeed) {
				return (mysqli_num_rows($r) > 0);
			}

			$result = [];
			while ($row = mysqli_fetch_assoc($r)) {
				$result[] = $row;
			}

			return $result;
		}

        static public function makeStr($sql) {
            $r = mysqli_query(self::$conn, $sql);
            $result= mysqli_fetch_row($r);
            return $result;
        }

        static public function addToDB($sql)
        {
            $result = mysqli_query(self::$conn, $sql);
            return $result;
        }
	}