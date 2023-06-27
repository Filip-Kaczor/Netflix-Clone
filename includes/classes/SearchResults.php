<?php

    class SearchResults {

        private $con, $username, $use;

        public function __construct($con, $username){
            $this->con = $con;
            $this->username = $username;
            $this->slide = new Slide($con, $username);
            $this->use = new Functions($con, $username);
            $this->url = new URL($con);
        }

        public function getResults($query) {
            $resultsQ = mysqli_query($this->con, "$query");
            while($R = mysqli_fetch_array($resultsQ)) {

                $id = $R['id'];
                $query = mysqli_query($this->con, "SELECT * FROM video WHERE entityId='$id'");
                $row = mysqli_fetch_array($query);

                $this->slide->getSlide($id, $row['isMovie'], NULL, 'src', NULL);//id,isMovie,N,src,Season
            }
        }

    }
?>
