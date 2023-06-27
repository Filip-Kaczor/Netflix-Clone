<?php

    class getVideo {

        private $con, $username;

        public function __construct($con, $username){
            $this->con = $con;
            $this->username = $username;
            $this->iframe = new Iframe($con, $username);
            $this->user = new User($con, $username);
            $this->ads = new Ads($con, $username);
            $this->use = new Functions($con, $username);

        }

        public function getVideo($id) {
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE id='$id'");
            $R = mysqli_fetch_array($Q);
            $image = $R['image'];
    
            $user = $this->username;
            $userQ = mysqli_query($this->con, "SELECT * FROM users WHERE username='$user'");
            $userR = mysqli_fetch_array($userQ);
            $premium = $userR['premium'];
    
            if($this->user->isPremium()) {
                return "<div class='topVideoContainer'>".$this->iframe->getIframe($id)."</div>";
            }else {
                return "<div class='topVideoContainer'>

                            <div id='videoContainer'>

                                <video id='videoplayback' class='videoplayback'>
                                    <source src='assets/video/videoplayback.mp4' type='video/mp4'>
                                </video>
        
                                <div class='playVideoButtonContainer'>
                                    <button id='playVideoButton' class='playVideoButton' onclick='playVid()' type='button'><i class='fa-solid fa-circle-play'></i></button>
                                </div>
        
                                ".$this->ads->getAdsVideo($this->username)."
        
                                <div id='addsDuration' class='addsDuration'></div>
                            
                            </div>

                            ".$this->use->getLoading("videoLoading", "Chwilka...")."

                        </div>
                        
                        <script>
    
                            function playVid() { 
                                console.log('play');
                                $('#playVideoButton').fadeToggle('slow',function(){
                                    $(this).css({'visibility':'hidden',display:'block'}).slideUp();
                                    $(this).remove();
                                    document.getElementById('videoplayback').play();
                                    document.getElementById('videoplayback').style.display = 'block';
                                    document.getElementById('premiumVideoShow').style.display = 'block';
    
                                    var videoDuration =  document.getElementById('videoplayback')
                                    var duration = videoDuration.duration;
                                    var minutes = Math.floor(duration / 60);
                                    var seconds = parseInt(duration%60);
    
                                    var video = document.getElementById('videoplayback');
                                    video.addEventListener('timeupdate', updateCountdown);
    
                                    function updateCountdown() {
                                        var timeSpan = document.querySelector('#addsDuration span');
                                        timeSpan.innerText = parseInt(video.duration - video.currentTime);
                                    }
        
                                    var text = 'Reklama zniknie za <span>';
                                    text = text + seconds + '</span> sekund';
                                    $('#addsDuration').html(text);
                                    $('#addsDuration').css('right','0px');
                                });
                            }                    
    
                            document.getElementById('videoplayback').addEventListener('ended', myHandler, false);
                            var id = ".$id.";
                            function myHandler(e) {
                                $.ajax({
                                    url: 'ajax/ajax_load_video.php',
                                    method: 'POST',
                                    data: {id:id},
                    
                                    beforeSend: function(data) {
                                        $('#videoContainer').fadeToggle('fast', function() {
                                            $('#videoContainer').children().detach().remove();
                                            $('#videoLoading').fadeToggle('slow');
                                        });
                                    },

                                    success:function(data) {
                                        setTimeout(function() {
                                            $('#videoContainer').html(data);
                                        }, 1000);
                                    },

                                    error: function() {
                                        console.log('error');
                                        alert('Video ajax error... try again ;)');
                                    },

                                    complete: function(data) {
                                        $('#videoContainer').fadeToggle('slow', function() {
                                            $('#videoLoading').fadeToggle('fast', function() {
                                                $('#videoContainer').children().detach().remove();
                                            });
                                        });
                                    }

                                    });
                            }
                        </script>";
            }
        }

    }

?>