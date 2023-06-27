<?php
    include("config/config.php");
	require_once("includes/classes/Account.php");
	$account = new Account($con);

	//echo $account->sendEmail("NEW", "FiFiBogiem", NULL);

	//$date = date("Y-m-d H:i:s");
	//$Q = mysqli_query($con, "UPDATE video SET lastModify='$date'");
	$headline = "Weryfikacja konta";
	$username = "Fil43";
	$content = "Pozostał Ci jeszcze jeden krok, aby aktywować konto&nbsp;
				<a class='link' href=\"".$_SESSION['indexUrl']."\" style=\"text-decoration: none!important;color: white;font-weight: 700;\">FILMOVE.TV</a>. 
				Kliknij poniższy przycisk, aby zweryfikować swój adres e-mail:";
	$button = "<a  href=\"".$_SESSION['indexUrl']."/activate/".$id."/".$secureCode."\" style=\"text-decoration: none!important;\">
				<div class='buttonM border-radius-small' style=\"border-top-left-radius: 20px;border-top-right-radius: 5px;border-bottom-left-radius: 5px;border-bottom-right-radius: 20px;background-color: #ff512f;font-weight: 800;font-size: 20px;cursor: pointer;color: white;padding: 15px 40px;\">Aktywuj</div>
			   </a>";
	$bottom = "<div style=\"padding: 5px 10px;color: rgb(255, 81, 47,0.6);width: max-content;\">
					<a href=\"".$_SESSION['indexUrl']."/activate/".$id."/".$secureCode."\" style=\"text-decoration: none!important;\">
						<div class='linkM' style=\"padding: 5px 10px;color: #ff512f;\">".$_SESSION['indexUrl']."/activate/".$id."/".$secureCode."</div>
					</a>
				</div>"; 

	echo "<div style=\"font-family: 'Exo 2', sans-serif;width: 100%;color: white;font-size: 17px;max-width: 650px;box-shadow: rgb(0 0 0) 0px 10px 30px;background-color: #121212;margin: 20px auto 20px auto;padding: 60px 30px;border-top-left-radius: 40px;border-top-right-radius: 10px;border-bottom-left-radius: 10px;border-bottom-right-radius: 40px;\">
			<div style=\"font-size: 26px;text-decoration: none;margin: auto;font-weight: 800;border: 3px solid #FF512F;padding: 14px 28px;border-top-left-radius: 20px;border-top-right-radius: 5px;border-bottom-left-radius: 5px;border-bottom-right-radius: 20px;width: fit-content;\"><a href=\"".$_SESSION['indexUrl']."\" style=\"text-decoration: none;color: #FF512F;\">FILMOVE.TV</a></div>
		  
			<div style=\"border-top-left-radius: 20px;border-top-right-radius: 5px;border-bottom-left-radius: 5px;border-bottom-right-radius: 20px;margin: 40px;font-size: 22px;font-weight: 600;\"><div style=\"width: fit-content;margin: auto;\">".$headline."</div></div>
			
			<div style=\"padding: 0px 40px;\">

				<div style=\"border-top-left-radius: 20px;border-top-right-radius: 5px;border-bottom-left-radius: 5px;border-bottom-right-radius: 20px;font-size: 22px;font-weight: 800;padding: 20px 40px;width: max-content;margin-bottom: 25px;background-color: rgba(22,22,22);box-shadow: rgb(0 0 0 / 50%) 0px 5px 15px;\">Cześć, ".$username."!</div>
			
				<div class='contentM border-radius-small' style=\"border-top-left-radius: 20px;border-top-right-radius: 5px;border-bottom-left-radius: 5px;border-bottom-right-radius: 20px;background-color: rgba(22,22,22);box-shadow: rgb(0 0 0 / 50%) 0px 5px 15px;padding: 40px;\">

                                <div style=\"font-size: 19px;\">
                                	".$content."
                                </div>

                                <div style=\"margin: 60px auto;display: flex;justify-content: center;\">
                                	".$button."
                                </div>

                                <div>
									Nie działa? Skopiuj poniższy link do swojej przeglądarki internetowej:
                                	".$bottom."
                                </div>

                                <div style=\"padding: 50px 0px 30px 0px;\">
                                    <div>Miłego oglądania,</div>
                                    <div style=\"font-size: 20px;font-weight: bold;\">&nbsp;— Ekipa filmove.tv :)</div>
                                </div>

                            </div>

			</div>
			
		  </div>";


?>