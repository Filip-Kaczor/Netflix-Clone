<?php
    class AddComment {

        private $con,$username,$videoId,$text,$errorArray;

        public function __construct($con,$username,$videoId,$text) {
            $this->con = $con;
            $this->username = $username;
            $this->videoId = $videoId;
            $this->text = $text;
            $this->errorArray = array();
            $this->vulgarism = new Vulgarism();
            $this->comments = new Comments($con, $videoId, $username);
        }

        public function addComment() {
            $this->validateText($this->text);
        
            if(empty($this->errorArray) == true) {
                return $this->insertComment();
            }
            else {
                return false;
            }
        }

        private function insertComment() {
            $Q =mysqli_query($this->con, "SELECT * FROM users WHERE username='$this->username'");
            $R = mysqli_fetch_array($Q);
            $userId = $R['id'];
            $videoId = $this->videoId;
            $text = $this->vulgarism->hideVulgarism($this->text);
            $date = date("Y-m-d H:i:s");

            $Q = mysqli_query($this->con, "UPDATE video SET lastModify='$date' WHERE id='$videoId'");
            $Q = mysqli_query($this->con, "INSERT INTO comments VALUES ('', '', '$userId', '$videoId', '', '$text', '$date', '')");
            $id = mysqli_insert_id($this->con);
            $result = $this->comments->getComment($id,"","");
            return $result;
        }

        private function validateText($text) {
        
            if(strlen($text) > 300 || strlen($text) < 1) {
              array_push($this->errorArray, Constans::$commentStrlen);
              return;
            }
        
        }

    }
?>
