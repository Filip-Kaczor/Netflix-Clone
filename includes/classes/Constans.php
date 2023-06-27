<?php
  class Constans {

    //------------------------------REGISTER------------------------------------------
    public static $usernameInvalidCharacters = "Dostępne: litery, cyfry, '_', oraz '-'";
    public static $usernameTaken = "Ten login jest już zajęty";
    public static $usernameStrlen = "Twój login musi zawierać od 4 do 25 znaków";
    public static $emailTaken = "Istnieje konto o podanym adresie email";
    public static $emailInvalid = "Twój email jest niepoprawy";
    public static $emailsDonNoMatch = "Adresy email nie są identyczne";
    public static $passwordStrlen = "Twoje hasło musi zawierać od 5 do 30 znaków";
    public static $passwordInvalidCharacters = "Twoje hasło musi zawierać cyfry";
    public static $passwordsDoNoMatch = "Podane hasła nie są identyczne";

    //------------------------------LOGIN--------------------------------------------
    public static $loginFailed = "Niepoprawny login lub hasło";

    //------------------------------RESET PASSWORD--------------------------------------------
    public static $resetPassword = "Niepoprawny E-mail";

    //------------------------------NEW PASSWORD--------------------------------------------
    public static $newPassword = "Niepoprawne hasło";

    //-------------------------------VIDEO--------------------------------------------
    public static $commentStrlen = "Twój komentarz musi zawierać od 1 do 300 znaków";

    //-------------------------------VIDEO--------------------------------------------
    //videoLink
    public static $videoLink_Len = "Link do video jest zbyt krótki";
    public static $videoLink_Options = "Obecnie możesz dodać TYLKO linki z <a href='https://www.cda.pl/uploader'>cda.pl</a> lub <a href='https://mega.io'>mega.io</a>";
    public static $videoLink_Taken = "Istnieje film/serial o podanym linku";
    //title
    public static $title_Len = "Tytuł musi zawierać od 2 od 60 znaków";
    public static $title_form = "Tytuł musi zawierać litery";
    //description
    public static $description_Len = "Opis musi zawierać od 15 od 800 znaków";
    public static $description_form = "Opis musi zawierać litery";
    //youtube
    public static $youtube_Len = "Nieprawidłowy link youtube";
    public static $youtube = "Obecnie obsługujemy TYLKO zwiastuny z youtube";
    //releaseDate
    public static $releaseDate = "Wybierz rok premiery";
    //image
    public static $image = "Dostępne formaty zdjęcia to: jpg, png, jpeg";
    //categoryId
    public static $category = "Nie wybrano kategori";
    public static $tag = "Nie wybrano tagu";

  }
?>
