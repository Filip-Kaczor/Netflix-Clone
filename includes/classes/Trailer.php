<?php
    class Trailer {

        private $con, $username, $use;

        public function __construct($con, $username){
            $this->con = $con;
            $this->username = $username;
            $this->use = new Functions($con, $username);
            $this->url = new URL($con);
        }

        public function createTrailer($entityId){
            $entityId = $this->getTrailer($entityId);
        }

        public function createSeries($entityId){
            if($entityId != null) {
                $entityId = $this->getSeries($entityId);
            }
        }

        public function getTrailer($entityId){

            if($entityId == NULL) {
                $Q = mysqli_query($this->con, "SELECT * FROM video WHERE youtube!='' GROUP BY entityId ORDER BY rand() LIMIT 1");
                $R = mysqli_fetch_array($Q);
                $entityId = $R['entityId'];
            }

            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE entityId='$entityId' GROUP BY (season AND episode) ASC");
            $R = mysqli_fetch_array($Q);

            $id =$R['id'];
            $title = $R['title']." (".$R['releaseDate'].") - oglądaj online za darmo";

            $tags = explode(",", $R['tagId']);

            $tagQ = mysqli_query($this->con, "SELECT * FROM tags WHERE id=''");
            for($i=0;$i<count($tags); $i++) {
                $tagQ = mysqli_query($this->con, "SELECT * FROM tags WHERE id='$tags[$i]'");
                $tagR = mysqli_fetch_array($tagQ);

                ${"tag" . $i} = "<a href='".$this->url->getTagHref($tags[$i])."'><div class='tag'>".$tagR['name']."</div></a>";
            }

            $this->use->entitiesInUse($R['entityId']);
            
            echo "<div class='trailerContainer'>
                    <div class='shadow'></div>
                    <div class='trailerAll'>
                        <div class='trailerInfo'>
                            <div class='trailerName'>".$this->use->getEntitiyTitle($id)."</div>
                            <div class='trailerCategory'><a class='linkHoverEffect' href='".$this->url->getCategoryHref($R['categoryId'])."'>".$this->use->getCategory($R['categoryId'])."</a></div>
                        </div>
                        

                        <div class='trailerOption'>
                            ".$this->use->getVideoTrailerPlay($id)."
                            <div onclick='showModalVideo(".$id.")'><div class='button1 cursorPointer'><i class='fa-solid fa-circle-info'></i>&nbsp;&nbsp;Informacje</div></div>
                        </div>

                    </div>
                    
                    <div id='videoSelectDiv'></div>

                    <script>

                    function load() {
                        if ($(window).width() >= 1200) {
                            console.log('youtube');

                            $('#videoSelectDiv').html(\"<iframe src='' title='".$title."' id='videoSelect' name='youtubePreviewSrc' frameborder='0' allow='autoplay'></iframe>\");

                            var youtube = '//www.youtube.com/embed/".$this->use->getYoutubeFromVideo($id)."?autoplay=1&mute=1&controls=0&loop=1&showinfo=0&playlist=".$this->use->getYoutubeFromVideo($id)."';
                            document.getElementsByName('youtubePreviewSrc')[0].src = youtube;

                        }else {
                            console.log('obrazek');
                            $('#videoSelectDiv').html(\"<img id='imageSelect' src='".$R['image']."' alt='".$this->use->getEntitiyTitle($id)."'>\");
                        }
                    }

                    window.onload = load;

                    </script>
                 </div>";

        }

    }
?>