<?php
    class URL {

        private $con;

        public function __construct($con){
            $this->con = $con;
        }

        public function getVideoHref($id) {
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE id='$id'");
            $R = mysqli_fetch_array($Q);
            $entityId = $R['entityId'];

            $Q2 = mysqli_query($this->con, "SELECT * FROM entities WHERE id='$entityId'");
            $R2 = mysqli_fetch_array($Q2);
            if($R['isMovie']==1) {
                return "video/".$id."/".$this->usunZnakiSpecjalne_zamienNaUtf8($R2['title'])."-".$R['releaseDate'];
            }else {
                return "video/".$id."/".$this->usunZnakiSpecjalne_zamienNaUtf8($R2['title'])."-sezon-".$R['season']."-odcinek-".$R['episode']."-".$R['releaseDate'];
            }
        }

        public function getSeriesHref($id) {
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE id='$id'");
            $R = mysqli_fetch_array($Q);
            $entityId = $R['entityId'];
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE entityId='$entityId' ORDER BY releaseDate ASC LIMIT 1");
            $R = mysqli_fetch_array($Q);

            $Q2 = mysqli_query($this->con, "SELECT * FROM entities WHERE id='$entityId'");
            $R2 = mysqli_fetch_array($Q2);
            return "serial/".$R['entityId']."/".str_replace(" ", "-", $this->usunZnakiSpecjalne_zamienNaUtf8($R2['title']))."-".$R['releaseDate'];
        }

        public function getTagHref($id) {
            $Q = mysqli_query($this->con, "SELECT * FROM tags WHERE id='$id'");
            $R = mysqli_fetch_array($Q);
            return "tag/".$id."/".str_replace(" ", "-", $this->usunZnakiSpecjalne_zamienNaUtf8($R['name']));
        }

        public function getCategoryHref($id) {
            $Q = mysqli_query($this->con, "SELECT * FROM categories WHERE id='$id'");
            $R = mysqli_fetch_array($Q);
            return "kategoria/".$id."/".str_replace(" ", "-", $this->usunZnakiSpecjalne_zamienNaUtf8($R['name']));
        }

        public function getLikedHref($username) {
            $Q = mysqli_query($this->con, "SELECT * FROM users WHERE username='$username'");
            $R = mysqli_fetch_array($Q);
            $username = $this->convertAccentsAndSpecialToNormal($R['username']);
            return "twoja-lista/".str_replace(" ", "-", $username);
        }

        public function getProfileHref($id) {
            $Q = mysqli_query($this->con, "SELECT * FROM users WHERE id='$id'");
            $R = mysqli_fetch_array($Q);
            $username = $this->convertAccentsAndSpecialToNormal($R['username']);
            return "profil/".$id."/".str_replace(" ", "-", $username);
        }

        public function getVerifyHref($username) {
            $username = $this->convertAccentsAndSpecialToNormal($username);
            return "verify/".str_replace(" ", "-", $username);
        }

        public function myUrlEncode($string) {
            $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
            $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]", "~", "`");
            return str_replace($entities, $replacements, urlencode($string));
        }

        public function getLoginBackPageUrlConvert($url) {
            //$url = str_replace($_SESSION["indexUrl"]."/login/back=", "", $url);
            if(str_contains($url, "userId_") && str_contains($url, "_tempPw_")) {
                return $_SESSION["indexUrl"];//reset password
            }else {
                $url = trim(substr($url, strpos($url, '/back=') + 6));
                return $url;
            }
        }

        public function getActivateUserId($url) {
            $url = explode("/", $url);
            return $url;
        }

        public function usunZnakiSpecjalne_zamienNaUtf8($doZamiany) {
            $tt = $this->convertAccentsAndSpecialToNormal($doZamiany);
            $tt = str_replace(" ", "-", $tt);
            $tt = str_replace(array("!", "<", ">", ";", "{", "}", "@", "#", "%", "$", "^", "&", "*", "=", "+", "\\", "|", "/", "*", "+", "_", '"', "'", "\"", "!", "(", ")", "[", "]", ":", ",", ".", "?", "~", "`"), "", $tt);
            $tt = filter_var($tt, FILTER_SANITIZE_URL);
            return $tt;
        }
        
        private function convertAccentsAndSpecialToNormal($string) {
            $table = array(
                'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Ă'=>'A', 'Ā'=>'A', 'Ą'=>'A', 'Æ'=>'A', 'Ǽ'=>'A',
                'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'ă'=>'a', 'ā'=>'a', 'ą'=>'a', 'æ'=>'a', 'ǽ'=>'a',
        
                'Þ'=>'B', 'þ'=>'b', 'ß'=>'Ss',
        
                'Ç'=>'C', 'Č'=>'C', 'Ć'=>'C', 'Ĉ'=>'C', 'Ċ'=>'C',
                'ç'=>'c', 'č'=>'c', 'ć'=>'c', 'ĉ'=>'c', 'ċ'=>'c',
        
                'Đ'=>'Dj', 'Ď'=>'D',
                'đ'=>'dj', 'ď'=>'d',
        
                'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ĕ'=>'E', 'Ē'=>'E', 'Ę'=>'E', 'Ė'=>'E',
                'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ĕ'=>'e', 'ē'=>'e', 'ę'=>'e', 'ė'=>'e',
        
                'Ĝ'=>'G', 'Ğ'=>'G', 'Ġ'=>'G', 'Ģ'=>'G',
                'ĝ'=>'g', 'ğ'=>'g', 'ġ'=>'g', 'ģ'=>'g',
        
                'Ĥ'=>'H', 'Ħ'=>'H',
                'ĥ'=>'h', 'ħ'=>'h',
        
                'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'İ'=>'I', 'Ĩ'=>'I', 'Ī'=>'I', 'Ĭ'=>'I', 'Į'=>'I',
                'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'į'=>'i', 'ĩ'=>'i', 'ī'=>'i', 'ĭ'=>'i', 'ı'=>'i',
        
                'Ĵ'=>'J',
                'ĵ'=>'j',
        
                'Ķ'=>'K',
                'ķ'=>'k', 'ĸ'=>'k',
        
                'Ĺ'=>'L', 'Ļ'=>'L', 'Ľ'=>'L', 'Ŀ'=>'L', 'Ł'=>'L',
                'ĺ'=>'l', 'ļ'=>'l', 'ľ'=>'l', 'ŀ'=>'l', 'ł'=>'l',
        
                'Ñ'=>'N', 'Ń'=>'N', 'Ň'=>'N', 'Ņ'=>'N', 'Ŋ'=>'N',
                'ñ'=>'n', 'ń'=>'n', 'ň'=>'n', 'ņ'=>'n', 'ŋ'=>'n', 'ŉ'=>'n',
        
                'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ō'=>'O', 'Ŏ'=>'O', 'Ő'=>'O', 'Œ'=>'O',
                'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ō'=>'o', 'ŏ'=>'o', 'ő'=>'o', 'œ'=>'o', 'ð'=>'o',
        
                'Ŕ'=>'R', 'Ř'=>'R',
                'ŕ'=>'r', 'ř'=>'r', 'ŗ'=>'r',
        
                'Š'=>'S', 'Ŝ'=>'S', 'Ś'=>'S', 'Ş'=>'S',
                'š'=>'s', 'ŝ'=>'s', 'ś'=>'s', 'ş'=>'s',
        
                'Ŧ'=>'T', 'Ţ'=>'T', 'Ť'=>'T',
                'ŧ'=>'t', 'ţ'=>'t', 'ť'=>'t',
        
                'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ũ'=>'U', 'Ū'=>'U', 'Ŭ'=>'U', 'Ů'=>'U', 'Ű'=>'U', 'Ų'=>'U',
                'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ũ'=>'u', 'ū'=>'u', 'ŭ'=>'u', 'ů'=>'u', 'ű'=>'u', 'ų'=>'u',
        
                'Ŵ'=>'W', 'Ẁ'=>'W', 'Ẃ'=>'W', 'Ẅ'=>'W',
                'ŵ'=>'w', 'ẁ'=>'w', 'ẃ'=>'w', 'ẅ'=>'w',
        
                'Ý'=>'Y', 'Ÿ'=>'Y', 'Ŷ'=>'Y',
                'ý'=>'y', 'ÿ'=>'y', 'ŷ'=>'y',
        
                'Ž'=>'Z', 'Ź'=>'Z', 'Ż'=>'Z',
                'ž'=>'z', 'ź'=>'z', 'ż'=>'z',
        
                '“'=>'"', '”'=>'"', '‘'=>"'", '’'=>"'", '•'=>'-', '…'=>'...', '—'=>'-', '–'=>'-', '¿'=>'?', '¡'=>'!', '°'=>' degrees ',
                '¼'=>' 1/4 ', '½'=>' 1/2 ', '¾'=>' 3/4 ', '⅓'=>' 1/3 ', '⅔'=>' 2/3 ', '⅛'=>' 1/8 ', '⅜'=>' 3/8 ', '⅝'=>' 5/8 ', '⅞'=>' 7/8 ',
                '÷'=>' divided by ', '×'=>' times ', '±'=>' plus-minus ', '√'=>' square root ', '∞'=>' infinity ',
                '≈'=>' almost equal to ', '≠'=>' not equal to ', '≡'=>' identical to ', '≤'=>' less than or equal to ', '≥'=>' greater than or equal to ',
                '←'=>' left ', '→'=>' right ', '↑'=>' up ', '↓'=>' down ', '↔'=>' left and right ', '↕'=>' up and down ',
                '℅'=>' care of ', '℮' => ' estimated ',
                'Ω'=>' ohm ',
                '♀'=>' female ', '♂'=>' male ',
                '©'=>' Copyright ', '®'=>' Registered ', '™' =>' Trademark ',
            );
        
            $string = strtr($string, $table);
            // Currency symbols: £¤¥€  - we dont bother with them for now
            $string = preg_replace("/[^\x9\xA\xD\x20-\x7F]/u", "", $string);
        
            return $string;
        }

    }
?>