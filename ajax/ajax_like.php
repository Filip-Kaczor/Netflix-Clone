<?php
    require_once("includeAjax.php");

    function isInArray($id, $array) {
        if(in_array($id, $array)) {
            return true;
        }
        return false;
    }

    function removeArrayElement($id, $array) {
        $key = array_search($id, $array);
        array_splice($array, $key, 1);
        $string = implode(",", $array);
        return $string;
    }

    if(isset($_POST['co'])&&isset($_POST['id'])) {
        $co = $_POST['co'];
        $id = $_POST['id'];
        $userQ = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
        $userR = mysqli_fetch_array($userQ);

        $likedComments = $userR['liked_comments'];
        $dislikedComments = $userR['disliked_comments'];

        $likedCommentsArray = explode(",", $likedComments);
        $dislikedCommentsArray = explode(",", $dislikedComments);

        $liked = false;
        $disliked = false;
        if(isInArray($id, $likedCommentsArray)) {
            $liked = true;
        }else if(isInArray($id, $dislikedCommentsArray)) {
            $disliked = true;
        }

        $commentQ = mysqli_query($con, "SELECT * FROM comments WHERE id='$id'");
        $commentR = mysqli_fetch_array($commentQ);
        $rate = $commentR['rate'];

        if($co == "like_comment") {

            if($liked) {

                $string = removeArrayElement($id, $likedCommentsArray);
                $Q = mysqli_query($con, "UPDATE users SET liked_comments='$string' WHERE username='$userLoggedIn'");

                $rate = $rate - 1;
                $return = "normal";

            }else if($disliked) {

                $string = removeArrayElement($id, $dislikedCommentsArray);
                $Q = mysqli_query($con, "UPDATE users SET disliked_comments='$string' WHERE username='$userLoggedIn'");

                if($likedComments == NULL) {
                    $string = $id;
                }else {
                    $string = $likedComments.",".$id;
                }
                $Q = mysqli_query($con, "UPDATE users SET liked_comments='$string' WHERE username='$userLoggedIn'");

                $rate = $rate + 2;
                $return = "toggle";

            }else {

                if($likedComments == NULL) {
                    $string = $id;
                }else {
                    $string = $likedComments.",".$id;
                }
                $Q = mysqli_query($con, "UPDATE users SET liked_comments='$string' WHERE username='$userLoggedIn'");

                $rate = $rate + 1;
                $return = "like";
            }

        }else if($co == "dislike_comment") {
            
            if($disliked) {

                $string = removeArrayElement($id, $dislikedCommentsArray);
                $Q = mysqli_query($con, "UPDATE users SET disliked_comments='$string' WHERE username='$userLoggedIn'");

                $rate = $rate + 1;
                $return = "normal";

            }else if($liked) {

                $string = removeArrayElement($id, $likedCommentsArray);
                $Q = mysqli_query($con, "UPDATE users SET liked_comments='$string' WHERE username='$userLoggedIn'");

                if($dislikedComments == NULL) {
                    $string = $id;
                }else {
                    $string = $dislikedComments.",".$id;
                }
                $Q = mysqli_query($con, "UPDATE users SET disliked_comments='$string' WHERE username='$userLoggedIn'");

                $rate = $rate - 2;
                $return = "toggle";

            }else {

                if($dislikedComments == NULL) {
                    $string = $id;
                }else {
                    $string = $dislikedComments.",".$id;
                }
                $Q = mysqli_query($con, "UPDATE users SET disliked_comments='$string' WHERE username='$userLoggedIn'");

                $rate = $rate - 1;
                $return = "dislike";
            }

        }

        $Q = mysqli_query($con, "UPDATE comments SET rate='$rate' WHERE id='$id'");
        echo $return;
    }

?>