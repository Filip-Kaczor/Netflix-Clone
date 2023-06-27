<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class SendEmail {

        private $con;

        public function __construct($con){
            $this->con = $con;
        }

        public function sendEmail($co, $username, $secureCode) {
            $Q = mysqli_query($this->con, "SELECT * FROM users WHERE username='$username'");
            $R = mysqli_fetch_array($Q);
            $id = $R['id'];
            $email = $R['email'];
        
            if($co == "VERIFY") {
                $subject = "Weryfikacja konta";
                $content = "Pozostał Ci jeszcze jeden krok, aby aktywować konto&nbsp;<a class='link' href=\"".$_SESSION['indexUrl']."\" style=\"text-decoration: none!important;color: white;font-weight: 700;\">FILMOVE.TV</a>. Kliknij poniższy przycisk, aby zweryfikować swój adres e-mail:";
                $button = "<a  href=\"".$_SESSION['indexUrl']."/activate/".$id."/".$secureCode."\" style=\"text-decoration: none!important;\">
                            <div class='buttonM border-radius-small' style=\"border-top-left-radius: 20px;border-top-right-radius: 5px;border-bottom-left-radius: 5px;border-bottom-right-radius: 20px;background-color: #ff512f;font-weight: 800;font-size: 20px;cursor: pointer;color: white;padding: 15px 40px;\">Aktywuj</div>
                            </a>";
                $bottom = "<div style=\"padding: 5px 10px;color: rgb(255, 81, 47,0.6);width: max-content;\">
                                <a href=\"".$_SESSION['indexUrl']."/activate/".$id."/".$secureCode."\" style=\"text-decoration: none!important;\">
                                    <div class='linkM' style=\"padding: 5px 10px;color: #ff512f;\">".$_SESSION['indexUrl']."/activate/".$id."/".$secureCode."</div>
                                </a>
                            </div>";
            }else if($co == "RESET") {
                $subject = "Reset hasła";
                $content = "Pozostał Ci ostatni krok, żeby zresetować hasło. Kliknij poniższy link i zresetuj hasło:&nbsp;";
                $button = "<a  href=\"".$_SESSION['indexUrl']."/reset/".$id."/".$secureCode."\" style=\"text-decoration: none!important;\">
                            <div class='buttonM border-radius-small' style=\"border-top-left-radius: 20px;border-top-right-radius: 5px;border-bottom-left-radius: 5px;border-bottom-right-radius: 20px;background-color: #ff512f;font-weight: 800;font-size: 20px;cursor: pointer;color: white;padding: 15px 40px;\">Zresetuj hasło</div>
                            </a>";
                $bottom = "<div style=\"padding: 5px 10px;color: rgb(255, 81, 47,0.6);width: max-content;\">
                                <a href=\"".$_SESSION['indexUrl']."/reset/".$id."/".$secureCode."\" style=\"text-decoration: none!important;\">
                                    <div class='linkM' style=\"padding: 5px 10px;color: #ff512f;\">".$_SESSION['indexUrl']."/reset/".$id."/".$secureCode."</div>
                                </a>
                            </div>"; 
            }else if($co == "NEW") {
                $subject = "Nowe hasło";
                $content = "Hasło do Twojego konta&nbsp;<a class='link' href=\"".$_SESSION['indexUrl']."\" style=\"text-decoration: none!important;color: white;font-weight: 700;\">FILMOVE.TV</a> zostało pomyślnie zmienione.";
                $button = "<a  href=\"".$_SESSION['indexUrl']."/login/back=/\" style=\"text-decoration: none!important;\">
                            <div class='buttonM border-radius-small' style=\"border-top-left-radius: 20px;border-top-right-radius: 5px;border-bottom-left-radius: 5px;border-bottom-right-radius: 20px;background-color: #ff512f;font-weight: 800;font-size: 20px;cursor: pointer;color: white;padding: 15px 40px;\">Zaloguj się</div>
                            </a>";
                $bottom = "<div style=\"padding: 5px 10px;color: rgb(255, 81, 47,0.6);width: max-content;\">
                                <a href=\"".$_SESSION['indexUrl']."/login/back=/\" style=\"text-decoration: none!important;\">
                                    <div class='linkM' style=\"padding: 5px 10px;color: #ff512f;\">".$_SESSION['indexUrl']."/login/back=/</div>
                                </a>
                            </div>";
            }else if($co == "HELLO") {
                $subject = "Filmove szaleństwo";
                $content = "Dzięki za utworzenie konta&nbsp;<a class='link' href=\"".$_SESSION['indexUrl']."\" style=\"text-decoration: none!important;color: white;font-weight: 700;\">FILMOVE.TV</a> to bardzo motywuje do dalszej pracy nad rozwojem strony - 19-latek, który tworzy tą stronę ;)";
                $button = "<a  href=\"".$_SESSION['indexUrl']."/login/back=/\" style=\"text-decoration: none!important;\">
                            <div class='buttonM border-radius-small' style=\"border-top-left-radius: 20px;border-top-right-radius: 5px;border-bottom-left-radius: 5px;border-bottom-right-radius: 20px;background-color: #ff512f;font-weight: 800;font-size: 20px;cursor: pointer;color: white;padding: 15px 40px;\">Oglądaj</div>
                            </a>";
                $bottom = "<div style=\"padding: 5px 10px;color: rgb(255, 81, 47,0.6);width: max-content;\">
                                <a href=\"".$_SESSION['indexUrl']."\" style=\"text-decoration: none!important;\">
                                    <div class='linkM' style=\"padding: 5px 10px;color: #ff512f;\">".$_SESSION['indexUrl']."/</div>
                                </a>
                            </div>";
            }else if($co == "PAYMENT") {
                $subject = "FILMOVE PREMIUM";
                $content = "Dzięki za zakup pakietu &nbsp;<a class='link' href=\"".$_SESSION['indexUrl']."\" style=\"text-decoration: none!important;color: white;font-weight: 700;\">FILMOVE PREMIUM</a> to bardzo motywuje do dalszej pracy nad rozwojem strony - 19-latek, który tworzy tą stronę ;)";
                $button = "<a  href=\"".$_SESSION['indexUrl']."/login/back=/\" style=\"text-decoration: none!important;\">
                            <div class='buttonM border-radius-small' style=\"border-top-left-radius: 20px;border-top-right-radius: 5px;border-bottom-left-radius: 5px;border-bottom-right-radius: 20px;background-color: #ff512f;font-weight: 800;font-size: 20px;cursor: pointer;color: white;padding: 15px 40px;\">Oglądaj</div>
                            </a>";
                $bottom = "<div style=\"padding: 5px 10px;color: rgb(255, 81, 47,0.6);width: max-content;\">
                                <a href=\"".$_SESSION['indexUrl']."\" style=\"text-decoration: none!important;\">
                                    <div class='linkM' style=\"padding: 5px 10px;color: #ff512f;\">".$_SESSION['indexUrl']."/</div>
                                </a>
                            </div>";
            }

            $body = "<div style=\"font-family: 'Exo 2', sans-serif;width: 100%;color: white;font-size: 17px;max-width: 650px;background-color: #121212;margin: 0px auto;padding: 60px 30px;border-top-left-radius: 40px;border-top-right-radius: 10px;border-bottom-left-radius: 10px;border-bottom-right-radius: 40px;\">
                        <div style=\"font-size: 26px;text-decoration: none;margin: auto;font-weight: 800;border: 3px solid #FF512F;padding: 14px 28px;border-top-left-radius: 20px;border-top-right-radius: 5px;border-bottom-left-radius: 5px;border-bottom-right-radius: 20px;width: fit-content;\"><a href=\"".$_SESSION['indexUrl']."\" style=\"text-decoration: none;color: #FF512F;\">FILMOVE.TV</a></div>
                    
                        <div style=\"border-top-left-radius: 20px;border-top-right-radius: 5px;border-bottom-left-radius: 5px;border-bottom-right-radius: 20px;margin: 30px;font-size: 22px;font-weight: 600;\"><div style=\"width: fit-content;margin: auto;color: white;\">".$subject."</div></div>
                        
                        <div style=\"padding: 0px 40px;\">

                            <div style=\"border-top-left-radius: 20px;border-top-right-radius: 5px;border-bottom-left-radius: 5px;border-bottom-right-radius: 20px;font-size: 22px;font-weight: 800;padding: 20px 40px;width: max-content;margin-bottom: 25px;background: rgba(22,22,22);color: white;\">Cześć, ".$username."!</div>
                        
                            <div class='contentM border-radius-small' style=\"border-top-left-radius: 20px;border-top-right-radius: 5px;border-bottom-left-radius: 5px;border-bottom-right-radius: 20px;background-color: rgba(22,22,22);padding: 40px;\">

                                <div>
                                    <div style=\"font-size: 19px;color: white;\">
                                        ".$content."
                                    </div>

                                    <div style=\"margin: 30px auto;width: fit-content;\">
                                        ".$button."
                                    </div>
                                </div>

                                <div style=\"color: white;\">
                                    <div style=\"color: white;\">Nie działa? Skopiuj poniższy link do swojej przeglądarki internetowej:</div>
                                    ".$bottom."
                                </div>

                                <div style=\"padding: 3px 0px 30px 0px;\">
                                    <div style=\"color: white;\">Miłego oglądania,</div>
                                    <div style=\"font-size: 20px;font-weight: bold;color: white;\">&nbsp;— Ekipa&nbsp;<a href=\"".$_SESSION['indexUrl']."\" style=\"text-decoration: none!important;color: white;\">filmove.tv</a>&nbsp;:)</div>
                                </div>

                            </div>

                        </div>
                        
                    </div>";

                    $mail = new PHPMailer(true);
                    $mail->CharSet = 'UTF-8';

                    try {
                        //Server settings
                        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->Host       = 'localhost';                     //Set the SMTP server to send through serwer2261825.home.pl
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                        $mail->Username   = 'no-reply@filmove.tv';                     //SMTP username
                        $mail->Password   = 'Naitachal1s24mail';                       //SMTP password
                        $mail->SMTPSecure = 465;            //Enable implicit TLS encryption
                        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
                        //Recipients
                        $mail->setFrom('no-reply@filmove.tv', 'FILMOVE.TV');
                        $mail->addAddress($email);     //Add a recipient
                        //$mail->addAddress('ellen@example.com');               //Name is optional
                        $mail->addReplyTo('no-reply@filmove.tv', 'Information');
                        //$mail->addCC('cc@example.com');
                        //$mail->addBCC('bcc@example.com');
        
                        //Attachments
                        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = $subject;
                        $mail->Body    = $body;
                        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
                        $mail->send();
                        //echo 'Message has been sent';
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
        }
        
    }
?>