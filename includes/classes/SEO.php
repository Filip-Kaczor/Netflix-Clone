<?php

class SEO {

    private $con, $username;

    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
        $this->url = new URL($this->con);
        $this->videoLink = new VideoLink($con, $username);
    }

    public function title($id){
        $Q = mysqli_query($this->con, "SELECT * FROM video WHERE id='$id'");
        $R = mysqli_fetch_array($Q);
        if($R['title'] != '') {
            return $R['title'];
        }
    }

    public function entitiyTitle($id){
        $Q = mysqli_query($this->con, "SELECT * FROM video WHERE id='$id'");
        $R = mysqli_fetch_array($Q);
        $entityId = $R['entityId'];

        $Q = mysqli_query($this->con, "SELECT * FROM entities WHERE id='$entityId'");
        $R = mysqli_fetch_array($Q);

        return $R['title'];
    }

    public function time_to_iso8601_duration($time) {
        $time = strtotime($time);

        $units = array(
            "Y" => 365*24*3600,
            "D" =>     24*3600,
            "H" =>        3600,
            "M" =>          60,
            "S" =>           1,
        );
    
        $str = "P";
        $istime = false;
    
        foreach ($units as $unitName => &$unit) {
            $quot  = intval($time / $unit);
            $time -= $quot * $unit;
            $unit  = $quot;
            if ($unit > 0) {
                if (!$istime && in_array($unitName, array("H", "M", "S"))) { // There may be a better way to do this
                    $str .= "T";
                    $istime = true;
                }
                $str .= strval($unit) . $unitName;
            }
        }
    
        return $str;
    }

    public function getPageId($url) {
        if(str_contains($url, '/video/')) {
            $urlId = strstr($url, 'video/');
            $urlId = str_replace("video/", "", $urlId);
            $urlId = strstr($urlId, '/', true);
            return $urlId;
        }else if(str_contains($url, '/kategoria/')) {
            $urlId = strstr($url, 'kategoria/');
            $urlId = str_replace("kategoria/", "", $urlId);
            $urlId = strstr($urlId, '/', true);
            return $urlId;
        }else if(str_contains($url, '/tag/')) {
            $urlId = strstr($url, 'tag/');
            $urlId = str_replace("tag/", "", $urlId);
            $urlId = strstr($urlId, '/', true);
            return $urlId;
        }else if(str_contains($url, '/serial/')) {
            $urlId = strstr($url, 'serial/');
            $urlId = str_replace("serial/", "", $urlId);
            $urlId = strstr($urlId, '/', true);
            return $urlId;
        }else {
            return "";
        }
    }

    public function getPageName($url) {
        if(str_contains($url, '/video/')) {
            $url = strstr($url, 'video/');
            $url = strstr($url, '/', true);
            return $url;
        }else if(str_contains($url, '/kategoria/')) {
            $url = strstr($url, 'kategoria/');
            $url = strstr($url, '/', true);
            return $url;
        }else if(str_contains($url, '/tag/')) {
            $url = strstr($url, 'tag/');
            $url = strstr($url, '/', true);
            return $url;
        }else if(str_contains($url, '/serial/')) {
            $url = strstr($url, 'serial/');
            $url = strstr($url, '/', true);
            return $url;
        }
        else if(str_contains($url, '/darmowe-seriale')) {
            $url = strstr($url, 'darmowe-seriale');
            return $url;
        }
        else if(str_contains($url, '/darmowe-filmy')) {
            $url = strstr($url, 'darmowe-filmy');
            return $url;
        }
        else if(str_contains($url, '/nowe')) {
            $url = strstr($url, 'nowe');
            return $url;
        }
        else if(str_contains($url, '/wszystkie-kategorie')) {
            $url = strstr($url, 'wszystkie-kategorie');
            return $url;
        }
        else if(str_contains($url, '/szukaj')) {
            $url = strstr($url, 'szukaj');
            return $url;
        }else {
            return "";
        }
    }

    public function getTitle($url) {
        $urlName = $this->getPageName($url);
        if($urlName == "video") {
            $urlId = $this->getPageId($url);
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE id='$urlId'");
            $R = mysqli_fetch_array($Q);
            $entityId = $R['entityId'];

            $Q2 = mysqli_query($this->con, "SELECT * FROM entities WHERE id='$entityId'");
            $R2 = mysqli_fetch_array($Q2);

            if($R['isMovie'] == 0) {
                $title = $R2['title']." s".$R['season']."e".$R['episode']." (".$R['releaseDate'].") sezon ".$R['season']." odcinek ".$R['episode']." - oglądaj za darmo - Filmove.tv";
            }else {
                $title = $R2['title']." (".$R['releaseDate'].") cały film - oglądaj za darmo - Filmove.tv";
            }
            return $title;
        }
        else if($urlName == "kategoria") {
            $urlId = $this->getPageId($url);
            $kategoriaQ = mysqli_query($this->con, "SELECT * FROM categories WHERE id='$urlId'");
            $kategoriaR = mysqli_fetch_array($kategoriaQ);
            return $kategoriaR['name']. " - filmy i seriale - oglądaj za darmo - Filmove.tv";
        }
        else if($urlName == "tag") {
            $urlId = $this->getPageId($url);
            $tagQ = mysqli_query($this->con, "SELECT * FROM tags WHERE id='$urlId'");
            $tagR = mysqli_fetch_array($tagQ);
            return $tagR['name']. " - filmy i seriale - oglądaj za darmo - Filmove.tv";
        }
        else if($urlName == "serial") {
            $urlId = $this->getPageId($url);
            $titleQ = mysqli_query($this->con, "SELECT * FROM entities WHERE id='$urlId'");
            $titleR = mysqli_fetch_array($titleQ);
            return $titleR['title']." (wszystkie odcinki) oglądaj za darmo - Filmove.tv";
        }
        else if($urlName == "darmowe-seriale") {
            return "Darmowe seriale online - Filmove.tv";
        }
        else if($urlName == "darmowe-filmy") {
            return "Darmowe filmy online - Filmove.tv";
        }
        else if($urlName == "nowe") {
            return "Nowe filmy i seriale online - Filmove.tv";
        }
        else if($urlName == "wszystkie-kategorie") {
            return "Wszystkie kategorie - Filmove.tv";
        }
        else if($urlName == "szukaj") {
            return "Szukaj darmowy film lub serial online - Filmove.tv";
        }
        else if($urlName == "") {
            return "Filmove.tv - oglądaj darmowe filmy i seriale online.";
        }
    }

    public function getDescription($url) {
        $urlName = $this->getPageName($url);
        if($urlName == "video") {
            $urlId = $this->getPageId($url);
            $videoQ = mysqli_query($this->con, "SELECT * FROM video WHERE id='$urlId'");
            $videoR = mysqli_fetch_array($videoQ);

            $title = $videoR['title'];
            $title = str_replace(array('"', "'"), '', $title );
            $releaseDate = $videoR['releaseDate'];
            $descLen = 140 - strlen($title) - strlen($releaseDate);

            $description = $videoR['description'];
            //$description = mb_substr($description, 0, $descLen);
            //$description = str_replace(array('"', "'"), '', $description);

            return $title." (".$releaseDate."): ".$description." - Filmove.tv";
        }
        else if($urlName == "kategoria") {
            $urlId = $this->getPageId($url);
            $kategoriaQ = mysqli_query($this->con, "SELECT * FROM categories WHERE id='$urlId'");
            $kategoriaR = mysqli_fetch_array($kategoriaQ);
            $kategoriaId = $kategoriaR['id'];
            $videoQ = mysqli_query($this->con, "SELECT * FROM video WHERE categoryId='$kategoriaId' GROUP BY entityId ORDER BY views DESC");
            $i=0;

            $return = $kategoriaR['name']. " - ";
            while(($videoR = mysqli_fetch_array($videoQ))&&$i<10) {
                if($i<9) {
                    $return .= $videoR['title'].", ";
                }else {
                    $return .= $videoR['title'];
                }
                $i++;
            }
            $return .= " - Filmove.tv";
            return $return;
        }
        else if($urlName == "tag") {
            $urlId = $this->getPageId($url);
            $tagQ = mysqli_query($this->con, "SELECT * FROM tags WHERE id='$urlId'");
            $tagR = mysqli_fetch_array($tagQ);
            $kategoriaId = $tagR['id'];
            $videoQ = mysqli_query($this->con, "SELECT * FROM video GROUP BY entityId ORDER BY views DESC");
            $i=0;

            $return = $tagR['name']. " film/serial - ";
            while(($videoR = mysqli_fetch_array($videoQ))&&$i<10) {
                $tags = $videoR['tagId'];
                $tags = explode(",", $tags);

                if($i<9) {
                    for($j=0;$j<count($tags); $j++) {
                        if($tags[$j] == $urlId) {
                            $return .= $videoR['title'].", ";
                            $i++;
                            break;
                        }
                    }
                }else {
                    for($j=0;$j<count($tags); $j++) {
                        if($tags[$j] == $urlId) {
                            $return .= $videoR['title'];
                            $i++;
                            break;
                        }
                    }
                }
            }
            $return .= " - Filmove.tv";
            return $return;
        }
        else if($urlName == "serial") {
            $urlId = $this->getPageId($url);
            $videoQ = mysqli_query($this->con, "SELECT * FROM video WHERE entityId='$urlId' ORDER BY season ASC LIMIT 1");
            $videoR = mysqli_fetch_array($videoQ);

            $title = $videoR['title'];
            $title = str_replace(array('"', "'"), '', $title );
            $releaseDate = $videoR['releaseDate'];
            $descLen = 140 - strlen($title) - strlen($releaseDate);

            $description = $videoR['description'];
            $description = mb_substr($description, 0, $descLen);
            $description = str_replace(array('"', "'"), '', $description);

            return $title." (".$releaseDate.") wszystkie sezony i odcinki - ".$description."... - Filmove.tv";
        }
        else if($urlName == "darmowe-seriale") {
            $videoQ = mysqli_query($this->con, "SELECT * FROM video WHERE isMovie='0' GROUP BY entityId ORDER BY views DESC");
            $i=0;
            $return = "Darmowe seriale - ";
            while(($videoR = mysqli_fetch_array($videoQ))&&$i<10) {
                if($i<9) {
                    $return .= $videoR['title'].", ";
                }else {
                    $return .= $videoR['title'];
                }
                $i++;
            }
            $return .= " - Filmove.tv";
            return $return;
        }
        else if($urlName == "darmowe-filmy") {
            $videoQ = mysqli_query($this->con, "SELECT * FROM video WHERE isMovie='1' GROUP BY entityId ORDER BY views DESC LIMIT 10");
            $i=0;
            $return = "Darmowe filmy - ";
            while(($videoR = mysqli_fetch_array($videoQ))&&$i<10) {
                if($i<9) {
                    $return .= $videoR['title'].", ";
                }else {
                    $return .= $videoR['title'];
                }
                $i++;
            }
            $return .= " - Filmove.tv";
            return $return;
        }
        else if($urlName == "wszystkie-kategorie") {
            return "Filmove.tv - Przeglądaj darmowe filmy i seriale";
        }
        else if($urlName == "szukaj") {
            return "Filmove.tv - Wyszukiwarka darmowych filmów lub seriali online";
        }
        else if($urlName == "") {
            return "Na stronie filmove.tv możesz obejrzeć ulubiony film lub serial za darmo, bez rejestracji/tworzenia konta.";
        }
    }

    public function getKeywords($url) {
        $urlName = $this->getPageName($url);
        if($urlName == "video") {
            $urlId = $this->getPageId($url);
            $titleQ = mysqli_query($this->con, "SELECT * FROM video WHERE id='$urlId'");
            $titleR = mysqli_fetch_array($titleQ);
            $tags = $titleR['tagId'];
            $tags = explode(",", $tags);

            $return = $titleR['title'].", ";
            for($i=0;$i<count($tags);$i++) {
                $tagsQ = mysqli_query($this->con, "SELECT * FROM tags WHERE id='$tags[$i]'");
                $tagsR = mysqli_fetch_array($tagsQ);
                $return .= $tagsR['name'].",";
            }
            return $return."darmowy,serial,film,online,dubbing,lektor,pl,polski,wszystkie,sezony,filmowe,filmove,filmove.tv,free";
        }
        else if($urlName == "kategoria") {
            $urlId = $this->getPageId($url);
            $kategoriaQ = mysqli_query($this->con, "SELECT * FROM categories WHERE id='$urlId'");
            $kategoriaR = mysqli_fetch_array($kategoriaQ);
            return $kategoriaR['name']."darmowy,serial,film,online,dubbing,lektor,pl,polski,wszystkie,sezony,filmowe,filmove,filmove.tv,free";
        }
        else if($urlName == "tag") {
            $urlId = $this->getPageId($url);
            $tagQ = mysqli_query($this->con, "SELECT * FROM tags WHERE id='$urlId'");
            $tagR = mysqli_fetch_array($tagQ);
            return $tagR['name']."darmowy,serial,film,online,dubbing,lektor,pl,polski,wszystkie,sezony,filmowe,filmove,filmove.tv,free";
        }
        else if($urlName == "serial") {
            $urlId = $this->getPageId($url);
            
            $titleQ = mysqli_query($this->con, "SELECT * FROM video WHERE entityId='$urlId' ORDER BY season ASC LIMIT 1");
            $titleR = mysqli_fetch_array($titleQ);
            $tags = $titleR['tagId'];
            $tags = explode(",", $tags);

            $return = $titleR['title'].", ";
            for($i=0;$i<count($tags);$i++) {
                $tagsQ = mysqli_query($this->con, "SELECT * FROM tags WHERE id='$tags[$i]'");
                $tagsR = mysqli_fetch_array($tagsQ);
                $return .= $tagsR['name'].",";
            }
            return $return."darmowy,serial,film,online,dubbing,lektor,pl,polski,wszystkie,sezony,filmowe,filmove,Filmove.tv,free";
        }
        else if($urlName == "darmowe-seriale") {
            return "darmowy,serial,online,dubbing,lektor,pl,polski,wszystkie,sezony,Filmove.tv,free";
        }
        else if($urlName == "darmowe-filmy") {
            return "darmowy,cały,film,online,dubbing,lektor,pl,polski,Filmove.tv,free";
        }
        else if($urlName == "wszystkie-kategorie") {
            return "darmowy,serial,online,dubbing,lektor,pl,polski,wszystkie,sezony,filmowe,filmove,Filmove.tv,free";
        }
        else if($urlName == "szukaj") {
            return "szukaj,film,serial,online,cały,lektor,dubbing,pl,polskiwy,szukiwarka,free";
        }
        else if($urlName == "") {
            return "darmowy,serial,film,online,dubbing,lektor,pl,polski,wszystkie,sezony,filmowe,filmove,Filmove.tv,free";
        }
    }

    public function getImage($url) {
        $urlName = $this->getPageName($url);
        if($urlName == "video") {
            $urlId = $this->getPageId($url);
            $titleQ = mysqli_query($this->con, "SELECT * FROM video WHERE id='$urlId'");
            $titleR = mysqli_fetch_array($titleQ);
            return $titleR['image'];
        }
        else if($urlName == "kategoria") {
            $urlId = $this->getPageId($url);
            $kategoriaQ = mysqli_query($this->con, "SELECT * FROM video WHERE categoryId='$urlId' ORDER BY rand() LIMIT 1");
            $kategoriaR = mysqli_fetch_array($kategoriaQ);
            return $kategoriaR['image'];
        }
        else if($urlName == "tag") {
            $tagQ = mysqli_query($this->con, "SELECT * FROM video ORDER BY rand() LIMIT 1");
            $tagR = mysqli_fetch_array($tagQ);
            return $tagR['image'];
        }
        else if($urlName == "serial") {
            $urlId = $this->getPageId($url);
            $titleQ = mysqli_query($this->con, "SELECT * FROM video WHERE entityId='$urlId' ORDER BY season ASC LIMIT 1");
            $titleR = mysqli_fetch_array($titleQ);
            return $titleR['image'];
        }
        else if($urlName == "darmowe-seriale") {
            $urlId = $this->getPageId($url);
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE isMovie='0' AND image!='' ORDER BY rand() LIMIT 1");
            $R = mysqli_fetch_array($Q);
            return $R['image'];
        }
        else if($urlName == "darmowe-filmy") {
            $urlId = $this->getPageId($url);
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE isMovie='1' AND image!='' ORDER BY rand() LIMIT 1");
            $R = mysqli_fetch_array($Q);
            return $R['image'];
        }
        else if($urlName == "wszystkie-kategorie") {
            $urlId = $this->getPageId($url);
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE image!='' ORDER BY rand() LIMIT 1");
            $R = mysqli_fetch_array($Q);
            return $R['image'];
        }
        else if($urlName == "szukaj") {
            $urlId = $this->getPageId($url);
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE image!='' ORDER BY rand() LIMIT 1");
            $R = mysqli_fetch_array($Q);
            return $R['image'];
        }
        else if($urlName == "") {
            return "assets/images/others/defaultVideoImage.png";
        }
    }

    public function getItemListElement($url) {
        $urlName = $this->getPageName($url);
        if($urlName == "video") {
            $urlId = $this->getPageId($url);
            
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE id='$urlId'");
            $R = mysqli_fetch_array($Q);
            $entityId = $R['entityId'];
            $addedBy = $R['addedBy'];
            $tagsId = $R['tagId'];
            $title = $R['title'];
            $views = $R['views'];
            $description = str_replace(array("'", "\""), "", $R['description']);
            $uploadDate = $R['uploadDate'];
            $duration = strtotime($R['duration']);
            $duration = "T".date('H', $duration)."H".date('i', $duration)."M".date('s', $duration)."S";//T12H30M5S

            $contentUrl = $this->videoLink->converter($R['videoLink']);
            $videoUrl = $this->url->getVideoHref($urlId);
            $imgUrl = $this->getImage($url);

            $userQ = mysqli_query($this->con, "SELECT * FROM users WHERE id='$addedBy'");
            $userR = mysqli_fetch_array($userQ);

            $username = $userR['username'];

            $userUrl = $this->url->getProfileHref($userR['id']);
            
            echo '<script type="application/ld+json">
                [{
                    "@context": "https://schema.org",
                    "@type": "VideoObject",
                    "url": "'.$videoUrl.'",
                    "name": "'.$title.' - Filmove.tv",
                    "description": "'.$title.' - Filmove.tv - '.$description.'",
                    "uploadDate": "'.$uploadDate.'",
                    "duration": "'.$duration.'",
                    "videoQuality": "1080p",
                    "thumbnailUrl": "'.$imgUrl.'",
                    "image": "'.$imgUrl.'",
                    "width": "1920",
                    "height": "1080",
                    "embedUrl": "'.$contentUrl.'",
                    "author": {
                        "@type": "Person",
                        "url": "'.$userUrl.'",
                        "additionalName": "'.$username.'",
                        "name": "'.$username.'"
                    }
                }]
                </script>';
        }
        else if($urlName == "kategoria") {
            $urlId = $this->getPageId($url);
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE image!='' AND categoryId='$urlId' GROUP BY entityId ORDER BY rand() LIMIT 15");

            echo '<script type="application/ld+json">
                    {
                        "@context": "https://schema.org",
                        "@type": "ItemList",
                        "itemListElement": [';
            $i=1;
            while($R = mysqli_fetch_array($Q)) {
                $id = $R['id'];
                $title = $R['title'];
                $releaseDate = $R['releaseDate'];
                $image = $R['image'];
                $url = $this->url->getVideoHref($id);
                if($i!=mysqli_num_rows($Q)) {
                    echo '{
                            "@type": "ListItem",
                            "position": "'.$i.'",
                            "item": {
                                "@type": "Movie",
                                "url": "https://filmove.tv/'.$url.'",
                                "name": "'.$title.'",
                                "image": "https://filmove.tv/'.$image.'",
                                "dateCreated": "'.$releaseDate.'"
                            }
                          },';
                }else {
                    echo '{
                            "@type": "ListItem",
                            "position": "'.$i.'",
                            "item": {
                                "@type": "Movie",
                                "url": "https://filmove.tv/'.$url.'",
                                "name": "'.$title.'",
                                "image": "https://filmove.tv/'.$image.'",
                                "dateCreated": "'.$releaseDate.'"
                            }
                          }';
                }
            $i++;
            }

            echo ']}
                 </script>';
        }
        else if($urlName == "tag") {
            $urlId = $this->getPageId($url);

            $tagQ = mysqli_query($this->con, "SELECT * FROM tags WHERE id='$urlId'");
            $tagR = mysqli_fetch_array($tagQ);
            $tagName = $tagR['name'];

            $query = mysqli_query($this->con, "SELECT * FROM video GROUP BY entityId");

            echo '<script type="application/ld+json">
                    {
                        "@context": "https://schema.org",
                        "@type": "ItemList",
                        "itemListElement": [';

            $ile = 0;
            $max = 0;
            while($row = mysqli_fetch_array($query) AND $ile<=10) {
                $tags = explode(",", $row['tagId']);

                $i=0;
                while($i<count($tags)) {
                    $tagNameQ = mysqli_query($this->con, "SELECT * FROM tags WHERE id='$tags[$i]'");
                    $tagNameR = mysqli_fetch_array($tagNameQ);

                    if($tagNameR['name'] == $tagName) {
                        $ile++;
                        break;
                    }
                    $i++;
                }
            }

            $max=$ile;
            if($max>10) {
                $max = 10;
            }
            $ile=1;

            $query = mysqli_query($this->con, "SELECT * FROM video GROUP BY entityId");
            while($row = mysqli_fetch_array($query) AND $ile<=$max) {
                $tags = explode(",", $row['tagId']);

                $i=0;
                while($i<count($tags)) {
                    $tagNameQ = mysqli_query($this->con, "SELECT * FROM tags WHERE id='$tags[$i]'");
                    $tagNameR = mysqli_fetch_array($tagNameQ);

                    if($tagNameR['name'] == $tagName) {
                        $id = $row['id'];
                        $title = $row['title'];
                        $releaseDate = $row['releaseDate'];
                        $image = $row['image'];
                        $addedBy = $row['addedBy'];
                        $url = $this->url->getVideoHref($id);

                        $userQ = mysqli_query($this->con, "SELECT * FROM users WHERE id='$addedBy'");
                        $userR = mysqli_fetch_array($userQ);

                        $username = $userR['username'];

                        if($ile<$max) {
                            echo '{
                                "@type": "ListItem",
                                "position": "'.$ile.'",
                                "item": {
                                    "@type": "Movie",
                                    "url": "https://filmove.tv/'.$url.'",
                                    "name": "'.$title.'",
                                    "image": "https://filmove.tv/'.$image.'",
                                    "dateCreated": "'.$releaseDate.'"
                                }
                              },';
                        }else {
                            echo '{
                                "@type": "ListItem",
                                "position": "'.$ile.'",
                                "item": {
                                    "@type": "Movie",
                                    "url": "https://filmove.tv/'.$url.'",
                                    "name": "'.$title.'",
                                    "image": "https://filmove.tv/'.$image.'",
                                    "dateCreated": "'.$releaseDate.'"
                                }
                              }';
                        }
                        $ile++;
                        break;
                    }
                    $i++;
                }

            }

            echo ']}
                 </script>';
            
        }
        else if($urlName == "serial") {
            $urlId = $this->getPageId($url);
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE entityId=$urlId ORDER BY (season AND episode) LIMIT 15");

            echo '<script type="application/ld+json">
                    {
                        "@context": "https://schema.org",
                        "@type": "ItemList",
                        "itemListElement": [';
            $i=1;
            while($R = mysqli_fetch_array($Q)) {
                $id = $R['id'];
                $title = $this->entitiyTitle($id)." - ".$this->title($R['id']);
                $releaseDate = $R['releaseDate'];
                $image = $R['image'];
                $url = $this->url->getVideoHref($id);
                if($i!=mysqli_num_rows($Q)) {
                    echo '{
                            "@type": "ListItem",
                            "position": "'.$i.'",
                            "item": {
                                "@type": "Movie",
                                "url": "https://filmove.tv/'.$url.'",
                                "name": "'.$title.'",
                                "image": "https://filmove.tv/'.$image.'",
                                "dateCreated": "'.$releaseDate.'"
                            }
                          },';
                }else {
                    echo '{
                            "@type": "ListItem",
                            "position": "'.$i.'",
                            "item": {
                                "@type": "Movie",
                                "url": "https://filmove.tv/'.$url.'",
                                "name": "'.$title.'",
                                "image": "https://filmove.tv/'.$image.'",
                                "dateCreated": "'.$releaseDate.'"
                            }
                          }';
                }
            $i++;
            }

            echo ']}
                 </script>';
        }
        else if($urlName == "darmowe-seriale") {
            $urlId = $this->getPageId($url);
            $Q1 = mysqli_query($this->con, "SELECT * FROM video WHERE image!='' AND isMovie=0 GROUP BY entityId ORDER BY rand() LIMIT 15");

            echo '<script type="application/ld+json">
                    {
                        "@context": "https://schema.org",
                        "@type": "ItemList",
                        "itemListElement": [';
            $i=1;
            while($R1 = mysqli_fetch_array($Q1)) {
                $Q = mysqli_query($this->con, "SELECT * FROM video WHERE entityId=$R1[entityId] ORDER BY releaseDate DESC LIMIT 1");
                $R = mysqli_fetch_array($Q);

                $id = $R['id'];
                $title = $this->entitiyTitle($R['id']);
                $releaseDate = $R['releaseDate'];
                $image = $R['image'];
                $url = $this->url->getSeriesHref($id);
                if($i!=mysqli_num_rows($Q)) {
                    echo '{
                            "@type": "ListItem",
                            "position": "'.$i.'",
                            "item": {
                                "@type": "Movie",
                                "url": "https://filmove.tv/'.$url.'",
                                "name": "'.$title.'",
                                "image": "https://filmove.tv/'.$image.'",
                                "dateCreated": "'.$releaseDate.'"
                            }
                          },';
                }else {
                    echo '{
                            "@type": "ListItem",
                            "position": "'.$i.'",
                            "item": {
                                "@type": "Movie",
                                "url": "https://filmove.tv/'.$url.'",
                                "name": "'.$title.'",
                                "image": "https://filmove.tv/'.$image.'",
                                "dateCreated": "'.$releaseDate.'"
                            }
                          }';
                }
            $i++;
            }

            echo ']}
                 </script>';
        }
        else if($urlName == "darmowe-filmy") {
            $urlId = $this->getPageId($url);
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE image!='' AND isMovie=1 GROUP BY entityId ORDER BY rand() desc LIMIT 15");

            echo '<script type="application/ld+json">
                    {
                        "@context": "https://schema.org",
                        "@type": "ItemList",
                        "itemListElement": [';
            $i=1;
            while($R = mysqli_fetch_array($Q)) {
                $id = $R['id'];
                $title = $R['title'];
                $releaseDate = $R['releaseDate'];
                $image = $R['image'];
                $url = $this->url->getVideoHref($id);
                if($i!=mysqli_num_rows($Q)) {
                    echo '{
                            "@type": "ListItem",
                            "position": "'.$i.'",
                            "item": {
                                "@type": "Movie",
                                "url": "https://filmove.tv/'.$url.'",
                                "name": "'.$title.'",
                                "image": "https://filmove.tv/'.$image.'",
                                "dateCreated": "'.$releaseDate.'"
                            }
                          },';
                }else {
                    echo '{
                            "@type": "ListItem",
                            "position": "'.$i.'",
                            "item": {
                                "@type": "Movie",
                                "url": "https://filmove.tv/'.$url.'",
                                "name": "'.$title.'",
                                "image": "https://filmove.tv/'.$image.'",
                                "dateCreated": "'.$releaseDate.'"
                            }
                          }';
                }
            $i++;
            }

            echo ']}
                 </script>';
        }
        else if($urlName == "nowe") {
            $urlId = $this->getPageId($url);
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE image!='' GROUP BY entityId ORDER BY uploadDate DESC LIMIT 15");

            echo '<script type="application/ld+json">
                    {
                        "@context": "https://schema.org",
                        "@type": "ItemList",
                        "itemListElement": [';
            $i=1;
            while($R = mysqli_fetch_array($Q)) {
                $id = $R['id'];
                $title = $this->entitiyTitle($R['id']);
                $releaseDate = $R['releaseDate'];
                $image = $R['image'];
                $url = $this->url->getVideoHref($id);
                if($i!=mysqli_num_rows($Q)) {
                    echo '{
                            "@type": "ListItem",
                            "position": "'.$i.'",
                            "item": {
                                "@type": "Movie",
                                "url": "'.$url.'",
                                "name": "'.$title.'",
                                "image": "'.$image.'",
                                "dateCreated": "'.$releaseDate.'"
                            }
                          },';
                }else {
                    echo '{
                            "@type": "ListItem",
                            "position": "'.$i.'",
                            "item": {
                                "@type": "Movie",
                                "url": "'.$url.'",
                                "name": "'.$title.'",
                                "image": "'.$image.'",
                                "dateCreated": "'.$releaseDate.'"
                            }
                          }';
                }
            $i++;
            }

            echo ']}
                 </script>';
        }
        else if($urlName == "wszystkie-kategorie") {
            $urlId = $this->getPageId($url);
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE image!='' GROUP BY entityId ORDER BY rand() desc LIMIT 15");

            echo '<script type="application/ld+json">
                    {
                        "@context": "https://schema.org",
                        "@type": "ItemList",
                        "itemListElement": [';
            $i=1;
            while($R = mysqli_fetch_array($Q)) {
                $id = $R['id'];
                $title = $this->entitiyTitle($R['id']);
                $releaseDate = $R['releaseDate'];
                $image = $R['image'];
                $url = $this->url->getVideoHref($id);
                if($i!=mysqli_num_rows($Q)) {
                    echo '{
                            "@type": "ListItem",
                            "position": "'.$i.'",
                            "item": {
                                "@type": "Movie",
                                "url": "'.$url.'",
                                "name": "'.$title.'",
                                "image": "'.$image.'",
                                "dateCreated": "'.$releaseDate.'"
                            }
                          },';
                }else {
                    echo '{
                            "@type": "ListItem",
                            "position": "'.$i.'",
                            "item": {
                                "@type": "Movie",
                                "url": "'.$url.'",
                                "name": "'.$title.'",
                                "image": "'.$image.'",
                                "dateCreated": "'.$releaseDate.'"
                            }
                          }';
                }
            $i++;
            }

            echo ']}
                 </script>';
        }
        else if($urlName == "szukaj") {
            $urlId = $this->getPageId($url);
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE image!='' GROUP BY entityId ORDER BY rand() LIMIT 15");

            echo '<script type="application/ld+json">
                    {
                        "@context": "https://schema.org",
                        "@type": "ItemList",
                        "itemListElement": [';
            $i=1;
            while($R = mysqli_fetch_array($Q)) {
                $id = $R['id'];
                $title = $R['title'];
                $releaseDate = $R['releaseDate'];
                $image = $R['image'];
                $url = $this->url->getVideoHref($id);
                if($i!=mysqli_num_rows($Q)) {
                    echo '{
                            "@type": "ListItem",
                            "position": "'.$i.'",
                            "item": {
                                "@type": "Movie",
                                "url": "'.$url.'",
                                "name": "'.$title.'",
                                "image": "'.$image.'",
                                "dateCreated": "'.$releaseDate.'"
                            }
                          },';
                }else {
                    echo '{
                            "@type": "ListItem",
                            "position": "'.$i.'",
                            "item": {
                                "@type": "Movie",
                                "url": "'.$url.'",
                                "name": "'.$title.'",
                                "image": "'.$image.'",
                                "dateCreated": "'.$releaseDate.'"
                            }
                          }';
                }
            $i++;
            }

            echo ']}
                 </script>';
        }
        else if($urlName == "") {
            return '<script type="application/ld+json">
                        {
                            "@context": "https://schema.org",
                            "@type": "BreadcrumbList",
                            "itemListElement": [{
                            "@type": "ListItem",
                            "position": 1,
                            "name": "Darmowe filmy",
                            "item": "https://filmove.tv/darmowe-filmy"
                            },{
                            "@type": "ListItem",
                            "position": 2,
                            "name": "Darmowe seriale",
                            "item": "https://filmove.tv/darmowe-seriale"
                            },{
                            "@type": "ListItem",
                            "position": 3,
                            "name": "Wszystkie kategorie",
                            "item": "https://filmove.tv/wszystkie-kategorie"
                            },{
                            "@type": "ListItem",
                            "position": 4,
                            "name": "Szukaj,
                            "item": "https://filmove.tv/szukaj"
                            }]
                        }
                    </script>';
        }
    }

    public function videoSEO($videoId) {
        $Q = mysqli_query($this->con, "SELECT * FROM video WHERE id='$videoId'");
        $R = mysqli_fetch_array($Q);
        $title = $this->entitiyTitle($R['id']);
        if($R['isMovie'] == 0) {
            $seo = "<h1 class='divHidden'>".$title." (".$R['releaseDate'].") Filmove.tv</h1>
                    <div class='divHidden'><h2>".$title." (".$R['releaseDate'].") cały serial online, Filmove.tv</h2></div>
                    <div class='divHidden'><h2>".$title." (".$R['releaseDate'].") - oglądaj za darmo online</h2></div>
                    <div class='divHidden'><h2>Jak oglądać za darmo, bez reklam ".$title." (".$R['releaseDate'].")</h2></div>
                    <div class='divHidden'><h2>".$title." (".$R['releaseDate'].") bez reklam, bez rejestracji</h2></div>
                    <div class='divHidden'><h2>".$title." CDA DUBBING/LEKTOR PL</div>";
        }else {
            $seo = "<h1 class='divHidden'>".$title." (".$R['releaseDate'].") Filmove.tv</h1>
                    <div class='divHidden'><h2>".$title." (".$R['releaseDate'].") cały film online, Filmove.tv</h2></div>
                    <div class='divHidden'><h2>".$title." (".$R['releaseDate'].") - oglądaj za darmo online</h2></div>
                    <div class='divHidden'><h2>Jak oglądać za darmo, bez reklam ".$title." (".$R['releaseDate'].")</h2></div>
                    <div class='divHidden'><h2>".$title." (".$R['releaseDate'].") bez reklam, bez rejestracji</h2></div>
                    <div class='divHidden'><h2>".$title." CDA DUBBING/LEKTOR PL</h2></div>";
        }
        return "<div>".$seo."</div>";
    }

}

?>