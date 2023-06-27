<?php
    class Vulgarism {

        public function __construct() {
            
        }

        public function cenzura($tekst){
            /* ALL RIGHTS RESERVED */
            /* by www.majdan.eu */
            $przeklenstwa = array('bit(h|ch)', '(ch|h)(w|.w)(d|.d)(p|.p)', '(|o)cip', '(|o)(ch|h)uj(|a)', '(|do|na|po|do|prze|przy|roz|u|w|wy|za|z|matkojeb)jeb(|a|c|i|n|y)', '(|do|od|o|s|wy|za)pieprz(|e|n|on|a|y)', '(|do|na|naw|od|pod|po|prze|przy|roz|spie|roz|poroz|s|u|w|za|wy)pierd(a|o)', 'fu(ck|k)', '(|u)dup', '(|po|s|w|za)(ku|q)rw(i|y)', 'k(ó|u)rw', 'k(ó|u)tas', '(|po|wy)rucha', 'motherfucker', 'piczk', '(|w)pi(z|ź)d');
     
            $count = count($przeklenstwa)-1;
            for ($i=0; $i<=$count; $i++) {
                    $przeklenstwa[$i] = '@ '.$przeklenstwa[$i].'([^ ]+)?@i ';
            }
     
            return substr(preg_replace( $przeklenstwa, '#cenzura#', ' '.$tekst ), 1);
        }

        public function hideVulgarism($string) {
            $array = array('chuj','chuja', 'chujek', 'chuju', 'chujem', 'chujnia', 'chujowizna' ,'ochujeć' ,'ochujec', 'wychujać', 'wychujac' ,
                        'chujowy', 'chujowa', 'chujowe', 'cipa', 'cipę', 'cipe', 'cipą',
                        'cipie', 'cwel', 'cwela', 'cwelu', 'cwelom', 'cwelą', 'cwelowi', 
                        'dojebac', 'dojebie', 'dojebał', 'dojebal','dojebać', 
                        'dojebała', 'dojebala', 'dojebałem', 'dojebalem', 'dojebałam',
                        'dojebalam', 'dojebię', 'dojebie', 'dopieprzać', 'dopieprzac',
                        'dopierdalać', 'dopierdalac', 'dopierdala', 'dopierdalał',
                        'dopierdalal', 'dopierdalała', 'dopierdalala', 'dopierdoli',
                        'dopierdolił', 'dopierdolil', 'dopierdolę', 'dopierdole', 'dopierdoli',
                        'dopierdalający', 'dopierdalajacy', 'dopierdolić', 'dopierdolic',
                        'dupa', 'dupie', 'dupą', 'dupcia', 'dupeczka', 'dupy', 'dupe', 'fiut', 'fiutem', 'fiutami', 'fiucie', 'huj',
                        'hujek', 'hujnia', 'huja', 'huje', 'hujem', 'huju', 'jebać', 'jebac',
                        'jebał', 'jebal', 'jebie', 'jebią', 'jebia', 'jebak', 'jebaka', 'jebal', 'jebnięty',
                        'jebał', 'jebany', 'jebane', 'jebanka', 'jebanko', 'jebankiem',
                        'jebanymi', 'jebana', 'jebanym', 'jebanej', 'jebaną', 'jebana',
                        'jebani', 'jebanych', 'jebanymi', 'jebcie', 'jebiący', 'jebiacy',
                        'jebiąca', 'jebiaca', 'jebiącego', 'jebiacego', 'jebiącej', 'jebiacej',
                        'jebia', 'jebią', 'jebie', 'jebię', 'jebliwy', 'jebnąć', 'jebnac',
                        'jebnąc', 'jebnać', 'jebnął', 'jebnal', 'jebną', 'jebna', 'jebnęła',
                        'jebnela', 'jebnie', 'jebnij', 'jebut', 'koorwa', 'kórwa', 'kurestwo',
                        'kurew', 'kurewski', 'kurewska', 'kurewskiej', 'kurewską', 'kurewska', 'kurewka',
                        'kurewsko', 'kurewstwo', 'kurwa', 'kurwaa', 'kurwami', 'kurwą', 'kurwe',
                        'kurwę', 'kurwie', 'kurwiska', 'kurwo', 'kurwy', 'kurwach', 'kurwami',
                        'kurewski', 'kurwiarz', 'kurwiący', 'kurwica', 'kurwić', 'kurwic',
                        'kurwidołek', 'kurwik', 'kurwiki', 'kurwiszcze', 'kurwiszon',
                        'kurwiszona', 'kurwiszonem', 'kurwiszony', 'kutas', 'kutasa', 'kutasie',
                        'kutasem', 'kutasy', 'kutasów', 'kutasow', 'kutasach', 'kutasami',
                        'matkojebca', 'matkojebcy', 'matkojebcą', 'matkojebca', 'matkojebcami',
                        'matkojebcach', 'nabarłożyć', 'najebać', 'najebac', 'najebał',
                        'najebal', 'najebała', 'najebala', 'najebane', 'najebany', 'najebaną',
                        'najebana', 'najebie', 'najebią', 'najebia', 'naopierdalać',
                        'naopierdalac', 'naopierdalał', 'naopierdalal', 'naopierdalała',
                        'naopierdalala', 'naopierdalała', 'napierdalać', 'napierdalac',
                        'napierdalający', 'napierdalajacy', 'napierdolić', 'napierdolic',
                        'nawpierdalać', 'nawpierdalac', 'nawpierdalał', 'nawpierdalal',
                        'nawpierdalała', 'nawpierdalala', 'obsrywać', 'oczojebne' , 'obsrywac', 'obsrywający',
                        'obsrywajacy', 'odpieprzać', 'odpieprzac', 'odpieprzy', 'odpieprzył',
                        'odpieprzyl', 'odpieprzyła', 'odpieprzyla', 'odpierdalać',
                        'odpierdalac', 'odpierdol', 'odpierdolił', 'odpierdolil',
                        'odpierdoliła', 'odpierdolila', 'odpierdoli', 'odpierdalający',
                        'odpierdalajacy', 'odpierdalająca', 'odpierdalajaca', 'odpierdolić',
                        'odpierdolic', 'odpierdoli', 'odpierdolił', 'opieprzający',
                        'opierdalać', 'opierdalac', 'opierdala', 'opierdalający',
                        'opierdalajacy', 'opierdol', 'opierdolić', 'opierdolic', 'opierdoli',
                        'opierdolą', 'opierdola', 'piczka', 'pieprznięty', 'pieprzniety',
                        'pieprzony', 'pierdel', 'pierdlu', 'pierdolą', 'pierdola', 'pierdolący',
                        'pierdolacy', 'pierdoląca', 'pierdolaca', 'pierdol', 'pierdole',
                        'pierdolenie', 'pierdoleniem', 'pierdoleniu', 'pierdolę', 'pierdolec',
                        'pierdola', 'pierdolą', 'pierdolić', 'pierdolicie', 'pierdolic',
                        'pierdolił', 'pierdolil', 'pierdoliła', 'pierdolila', 'pierdoli',
                        'pierdolnięty', 'pierdolniety', 'pierdolisz', 'pierdolnąć',
                        'pierdolnac', 'pierdolnął', 'pierdolnal', 'pierdolnęła', 'pierdolnela',
                        'pierdolnie', 'pierdolnięty', 'pierdolnij', 'pierdolnik', 'pierdolona',
                        'pierdolone', 'pierdolony', 'pierdołki', 'pierdzący', 'pierdzieć',
                        'pierdziec', 'pizda', 'pizdą', 'pizde', 'pizdę', 'piździe', 'pizdzie',
                        'pizdnąć', 'pizdnac', 'pizdu', 'podpierdalać', 'podpierdalac',
                        'podpierdala', 'podpierdalający', 'podpierdalajacy', 'podpierdolić',
                        'podpierdolic', 'podpierdoli', 'pojeb', 'pojeba', 'pojebami',
                        'pojebani', 'pojebanego', 'pojebanemu', 'pojebani', 'pojebany',
                        'pojebanych', 'pojebanym', 'pojebanymi', 'pojebem', 'pojebać',
                        'pojebac', 'pojebalo', 'popierdala', 'popierdalac', 'popierdalać',
                        'popierdolić', 'popierdolic', 'popierdoli', 'popierdolonego',
                        'popierdolonemu', 'popierdolonym', 'popierdolone', 'popierdoleni',
                        'popierdolony', 'porozpierdalać', 'porozpierdala', 'porozpierdalac',
                        'poruchac', 'poruchać', 'przejebać', 'przejebane', 'przejebac',
                        'przyjebali', 'przepierdalać', 'przepierdalac', 'przepierdala',
                        'przepierdalający', 'przepierdalajacy', 'przepierdalająca',
                        'przepierdalajaca', 'przepierdolić', 'przepierdolic', 'przyjebać',
                        'przyjebac', 'przyjebie', 'przyjebała', 'przyjebala', 'przyjebał',
                        'przyjebal', 'przypieprzać', 'przypieprzac', 'przypieprzający',
                        'przypieprzajacy', 'przypieprzająca', 'przypieprzajaca',
                        'przypierdalać', 'przypierdalac', 'przypierdala', 'przypierdoli',
                        'przypierdalający', 'przypierdalajacy', 'przypierdolić',
                        'przypierdolic', 'qrwa', 'rozjebać', 'rozjebac', 'rozjebie',
                        'rozjebała', 'rozjebią', 'rozpierdalać', 'rozpierdalac', 'rozpierdala',
                        'rozpierdolić', 'rozpierdolic', 'rozpierdole', 'rozpierdoli',
                        'rozpierducha', 'skurwić', 'skurwiel', 'skurwiela', 'skurwielem',
                        'skurwielu', 'skurwysyn', 'skurwysynów', 'skurwysynow', 'skurwysyna',
                        'skurwysynem', 'skurwysynu', 'skurwysyny', 'skurwysyński',
                        'skurwysynski', 'skurwysyństwo', 'skurwysynstwo', 'spieprzać',
                        'spieprzac', 'spieprza', 'spieprzaj', 'spieprzajcie', 'spieprzają',
                        'spieprzaja', 'spieprzający', 'spieprzajacy', 'spieprzająca',
                        'spieprzajaca', 'spierdalać', 'spierdalac', 'spierdala', 'spierdalał',
                        'spierdalała', 'spierdalal', 'spierdalalcie', 'spierdalala',
                        'spierdalający', 'spierdalajacy', 'spierdolić', 'spierdolic',
                        'spierdoli', 'spierdoliła', 'spierdoliło', 'spierdolą', 'spierdola',
                        'srać', 'srac', 'srający', 'srajacy', 'srając', 'srajac', 'sraj',
                        'sukinsyn', 'sukinsyny', 'sukinsynom', 'sukinsynowi', 'sukinsynów',
                        'sukinsynow', 'śmierdziel', 'udupić', 'ujebać', 'ujebac', 'ujebał',
                        'ujebal', 'ujebana', 'ujebany', 'ujebie', 'ujebała', 'ujebala',
                        'upierdalać', 'upierdalac', 'upierdala', 'upierdoli', 'upierdolić',
                        'upierdolic', 'upierdoli', 'upierdolą', 'upierdola', 'upierdoleni',
                        'wjebać', 'wjebac', 'wjebie', 'wjebią', 'wjebia', 'wjebiemy',
                        'wjebiecie', 'wkurwiać', 'wkurwiac', 'wkurwi', 'wkurwia', 'wkurwiał',
                        'wkurwial', 'wkurwiający', 'wkurwiajacy', 'wkurwiająca', 'wkurwiajaca',
                        'wkurwić', 'wkurwic', 'wkurwi', 'wkurwiacie', 'wkurwiają', 'wkurwiali',
                        'wkurwią', 'wkurwia', 'wkurwimy', 'wkurwicie', 'wkurwiacie', 'wkurwić',
                        'wkurwic', 'wkurwia', 'wpierdalać', 'wpierdalac', 'wpierdalający',
                        'wpierdalajacy', 'wpierdol', 'wpierdolić', 'wpierdolic', 'wpizdu',
                        'wyjebać', 'wyjebac', 'wyjebali', 'wyjebał', 'wyjebac', 'wyjebała',
                        'wyjebały', 'wyjebie', 'wyjebią', 'wyjebia', 'wyjebiesz', 'wyjebie',
                        'wyjebiecie', 'wyjebiemy', 'wypieprzać', 'wypieprzac', 'wypieprza',
                        'wypieprzał', 'wypieprzal', 'wypieprzała', 'wypieprzala', 'wypieprzy',
                        'wypieprzyła', 'wypieprzyla', 'wypieprzył', 'wypieprzyl', 'wypierdal',
                        'wypierdalać', 'wypierdalac', 'wypierdala', 'wypierdalaj',
                        'wypierdalał', 'wypierdalal', 'wypierdalała', 'wypierdalala',
                        'wypierdalać', 'wypierdolić', 'wypierdolic', 'wypierdoli',
                        'wypierdolimy', 'wypierdolicie', 'wypierdolą', 'wypierdola',
                        'wypierdolili', 'wypierdolił', 'wypierdolil', 'wypierdoliła',
                        'wypierdolila', 'zajebać', 'zajebac', 'zajebie', 'zajebią', 'zajebia',
                        'zajebiał', 'zajebial', 'zajebała', 'zajebiala', 'zajebali', 'zajebana', 'zajebania', 'odjebad', 'odjebana',
                        'zajebani', 'zajebane', 'zajebany', 'zajebanych', 'zajebanym',
                        'zajebanymi', 'zajebiste', 'zajebisty', 'zajebistych', 'zajebista',
                        'zajebistym', 'zajebistymi', 'zajebiście', 'zajebiscie', 'zapieprzyć',
                        'zapieprzyc', 'zapieprzy', 'zapieprzył', 'zapieprzyl', 'zapieprzyła',
                        'zapieprzyla', 'zapieprzą', 'zapieprza', 'zapieprzy', 'zapieprzymy',
                        'zapieprzycie', 'zapieprzysz', 'zapierdala', 'zapierdalać',
                        'zapierdalac', 'zapierdalaja', 'zapierdalał', 'zapierdalaj',
                        'zapierdalajcie', 'zapierdalała', 'zapierdalala', 'zapierdalali',
                        'zapierdalający', 'zapierdalajacy', 'zapierdolić', 'zapierdolic',
                        'zapierdoli', 'zapierdolił', 'zapierdolil', 'zapierdoliła',
                        'zapierdolila', 'zapierdolą', 'zapierdola', 'zapierniczać',
                        'zapierniczający', 'zasrać', 'zasranym', 'zasrywać', 'zasrywający',
                        'zesrywać', 'zesrywający', 'zjebać', 'zjebac', 'zjebał', 'zjebal',
                        'zjebała', 'zjebala', 'zjebana', 'zjebią', 'zjebali', 'zjeby');

            $stringArray = explode(" ", $string);

            for($i=0;$i<count($stringArray);$i++) {
                if(in_array($stringArray[$i], $array)) {
                    $wordArray = str_split($stringArray[$i], 1);
                    for($j=0;$j<count($wordArray);$j++) {
                        if($j != 0 && $j != 1) {
                            $wordArray[$j] = "*";
                        }
                    }
                    $wordString = implode("", $wordArray);
                    $stringArray[$i] = $wordString;
                }
            }
            $string = implode(" ", $stringArray);
            return $string;
        }

    }
?>