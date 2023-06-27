<?php

    class Report {

    private $con, $username, $use;

    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
        $this->use = new Functions($con, $username);
        $this->url = new URL($con);
    }

    public function getReport($videoId) {

        $Q = mysqli_query($this->con, "SELECT * FROM video WHERE id='$videoId'");
        $R = mysqli_fetch_array($Q);

        if($R['isMovie'] = 1) {
            $film_serial = "Film";
        }else {
            $film_serial = "Odcinek serialu";
        }

        echo "  <div class='reportContainer category'>
                    <div class='linkReport linkError' data-toggle='modal' data-target='#linkError'>Film nie działa</div>";

            echo "<div class='linkReport linkReport' data-toggle='modal' data-target='#linkReport'>Zgłoś naruszenie</div>
                  <template id='showReport'>
                    <div class='modal fade' id='linkReport' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true' style='z-index: 1060;'>
                        <div class='modal-dialog modalReport' role='document'>
                            <div class='modal-content'>
                                <div class='reportContainerModal'>
                                    <form action='Report.php'>
                                    
                                        <input name='' type='text' placeholder='Imię'>
                                        <input name='' type='text' placeholder='Nazwisko'>
                                        <input name='' type='text' placeholder='Link do video'>
                                        <textarea name='' id='' placeholder='Opisz problem'></textarea>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                  </template>

                <script>
                    var temp = document.getElementById('showReport');
                    var clon = temp.content.cloneNode(true);
                    document.body.appendChild(clon);
                    temp.innerHTML = '';
                </script>";

        echo "</div>
              <template id='showLinkError'>
                <div class='modal fade' id='linkError' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true' style='z-index: 1060;'>
                    <div class='modal-dialog modalReport' role='document'>
                        <div class='modal-content'>

                            <div class='reportContainerModal'>
                                <div class='reportContainerText'>".$film_serial." nie działa? Powiadom nas o tym...</div>
                                <div class='g-recaptcha' data-sitekey='6Lc4HwMgAAAAAKsJfAZi3C0OkHsb-RndmRr4H7ZI'></div>
                                <button class='reportContainerButton' id='reportSimpleButton'>Zgłoś</button>
                            </div>

                            <div id='reportSimpleResult'></div>

                        </div>
                    </div>
                </div>
              </template>
              
            <script>
                var temp = document.getElementById('showLinkError');
                var clon = temp.content.cloneNode(true);
                document.body.appendChild(clon);
                temp.innerHTML = '';

                document.getElementById('reportSimpleButton').onclick = function() {
                    var videoId = ".$videoId.";
                    $.ajax({
                    url: 'sendReport.php',
                    method: 'POST',
                    data: {videoId:videoId},

                    success:function(data) {
                        $('#reportSimpleResult').text('Twoje zgłoszenie zostało przesłane');
                        $('#reportSimpleResult').css('display', 'flex');    
                    }
                    });
                };
            </script>";
    }

}
?>