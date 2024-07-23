<?php
require_once("Tesla.php");
require_once("config.php");

if( $_GET["pass"] != $pass ) { die("PW-Requiered"); };

$action = $_GET["action"];

$UserTesla = new UserTesla($tokenFile);

if ($action == "startCharge" )  {
    if (isset($_GET["chargeMethod"]) )  {
        $chargeMethod = $_GET["chargeMethod"];
    }

    $message = "<p>Ladevorgang Start!</p>";
   //echo $UserTeslaID;
    //var_dump($tesla->getAccessToken($teslaAccountMail, $teslaAccountPasswort));
    //print_r($tesla->vehicles());
    //echo "Tesla wird geweckt";
    
    $batteryLevel = $UserTesla->getBatteryLevel();
    if(!$batteryLevel)    {
        $message .= "<p>AkkuStand konnte nicht ermittelt werden!<p/>";
    }
    else {
        $message .= "<p>AkkuStand: " . $batteryLevel . " %!<p/>";
    }

    $kilometerStand = $UserTesla->getOdometerKm();
    if(!$kilometerStand)    {
        $message .= "kilometerStand konnte nicht ermittelt werden!<br/>";
    }
    else  {
        $message .= "<p>Kilometerstand: " . $kilometerStand . " km <p/>";
    } 

    /*if($kilometerStand && $batteryLevel) {
        $message = "Laden gestartet bei <br/>Kilometerstand: " . $kilometerStand . "km <br/>und AkkuStand: " . $chargeState . "%<br/>";
        echo $message;
        userMail("Laden gestartet", $message);
    } */
    $message .= "<p>Kofferraum und Ladeport (nur wenn AC) werden geöffnet</p>";
    $UserTesla->tesla->openChargePort();

    //Frunk öffnen (nur AC)
    if( $chargeMethod == "AC" ) {
        $UserTesla->tesla->openFrunk();
    }
    
    //SQL
    if( isset($kilometerStand) && isset($batteryLevel) )   {
        //Scheinen okay zu sein. In die DB
        $sql = "INSERT INTO `ladevorgaenge` (`kilometerstand`, `akkuStart`, `type` ) VALUES ('" . $kilometerStand . "', '" .$batteryLevel . "', '" .$chargeMethod . "' ); ";
        $sql = mysqli_query($db, $sql);
        if($sql)    {
            $message .= "Daten in MySQL gespeichert";
        }
        else    { 
            $message .= "FEHLER! Daten nicht in MySQL gespeichert";
        }
    }
    
    echo $message;
    userMail("Laden gestartet", $message);

}

if ($action == "chrisTestGetPercentage" )  {  
    $batteryLevel = $UserTesla->getBatteryLevel();
    if(!$batteryLevel)    {
        $message .= "FEHLER! Batterielevel kann nicht ermittelt werden.";
    }
    else {
        $message .= $batteryLevel;
    }

   
    echo $message;
    userMail("Chris Test aufgerufen auf Tesla API", $message);
	die();

}

elseif($action == "endCharge")  {
    $message = "<p>Ende des Ladevorgang gelogged!</p>";

    $batteryLevel = $UserTesla->getBatteryLevel();
    if(!$batteryLevel)    {
        $message .= "<p>FEHLER!  BatteryLevel konnte nicht ermittelt werden!</p>";
    }
    else    {
        $message .= "<p>Akkustand: " . $batteryLevel . " %</p>";
    }

    $EnergyAdded = $UserTesla->getLastChargeEnergyAdded();
    if(!$EnergyAdded)    {
        $message .= "<p>FEHLER! LadestromMenge konnte nicht ermittelt werden!<p/>";
    }
    else    {
        $message .= "<p>LadestromMenge: " . $EnergyAdded . " kWh</p>";
    }

    $kilometerStand = $UserTesla->getOdometerKm();

    $message .= "<p>Kofferraum wird geöffnet und Ladeport disconnected</p>";
    $UserTesla->tesla->openFrunk();
    $UserTesla->tesla->openChargePort();

    //MYSQL:
    //SQL
    //Prüfen, ob es mehr oder weniger als genau 1 aktiven Ladevorgang gibt
    $sql = "SELECT ladeID from ladevorgaenge WHERE active = 1";
    $sql = mysqli_query($db, $sql);
    $numrows = $sql->num_rows;

    if ( $numrows != 1 )  {
        //Gibt keinen aktiven Ladevorgang oder nicht genau 1
        $message .= "Keinen oder mehr als einen aktiven Ladevorgang gefunden, daher kein MYSQL-Save";
    }

    if( $batteryLevel && $EnergyAdded && $kilometerStand && $numrows == 1)   {
        //Scheinen okay zu sein. In die DB
        $sql = "UPDATE ladevorgaenge SET datumEnde = NOW(), akkuEnde = ". $batteryLevel . ", kWhAuto = ". $EnergyAdded . ", active = 0 WHERE active = 1  ORDER by ladeID DESC LIMIT 1 ";
        $sql = $db->query($sql);
        if($db->affected_rows == 1)    {
            $message .= "Daten in MySQL gespeichert";
        }
        else    { 
            $message .= "FEHLER! Daten nicht in MySQL gespeichert";
        }
    }
    


    echo $message;
    userMail("Laden beendet", $message);
}

elseif($action == "infoOnly")   {
    $message = "<p>Info only!</p>";

    $batteryLevel = $UserTesla->getBatteryLevel();
    if(!$batteryLevel)    {
        $message .= "<p>AkkuStand konnte nicht ermittelt werden!<p/>";
    }
    else {
        $message .= "<p>AkkuStand: " . $batteryLevel . " %!<p/>";
    }

    $kilometerStand = $UserTesla->getOdometerKm();
    if(!$kilometerStand)    {
        $message .= "kilometerStand konnte nicht ermittelt werden!<br/>";
    }
    else  {
        $message .= "<p>Kilometerstand: " . $kilometerStand . " km <p/>";
    } 

    $EnergyAdded = $UserTesla->getLastChargeEnergyAdded();
    if(!$EnergyAdded)    {
        $message .= "<p>FEHLER! LadestromMenge konnte nicht ermittelt werden!<p/>";
    }
    else    {
        $message .= "<p>LadestromMenge letzte Ladung: " . $EnergyAdded . " kWh</p>";
    }

    echo $message;
    print_r($UserTesla->showAllDataArray());
}

else    {
    echo "Action not defined<br/>";

}
 

function userMail($betreff, $nachricht)    {
    $absender = "damarges@gmx.de";

    $header  = "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html; charset=utf-8\r\n";

    $header .= "From: $absender\r\n";
    //$header .= "Reply-To: $antwortan\r\n";
    // $header .= "Cc: $cc\r\n";  // falls an CC gesendet werden soll
    $header .= "X-Mailer: PHP ". phpversion();

    $nachricht = "<html>
    <head>
        <title>HTML-E-Mail mit PHP erstellen</title>
    </head>

    <body>
    " . $nachricht . "
    </body>
    </html>
    ";
        
    // Verschicken
    mail("damarges@gmx", "Markus-Tesla: " . $betreff, $nachricht, $header);
}

class UserTesla {
    private $accessToken;
    //private $refreshToken;
    public $tesla; //Enthält Tesla-Objekt // Direkten Zugriff erlauben, damit man nicht für jede Klassenfunktion eine neue FUnktio nbauen muss. 
    private $vehicleId;
    private $allData = false; //Enthält alle Infos aus der JSON API

    public function __construct($tokenFile)
    {
        $this->loadTokensFromFile($tokenFile);
        $this->tesla = new Tesla( $this->accessToken );
		//print_r($this->tesla);
        $this->setUserTesla();
    }

    private function loadTokensFromFile($tokenFile) {
        //Tokens laden
        $json = file_get_contents($tokenFile);
        $tokendata = json_decode($json,true);
        $this->accessToken = $tokendata["access_token"];
    }

    private function setUserTesla()  {
        $vehicles = $this->tesla->vehicles();
		
        if(array_key_exists('error', $vehicles ) )    {
            die("Fehler bei Tesla-API-Access: " . $vehicles["error"]);
        }
        $UserTeslaID = $vehicles["response"][0]["id"];
        $this->vehicleId = $UserTeslaID;
        $this->tesla->setVehicleId($this->vehicleId);
    }

    private function wakeUp()   {
        for($i = 0; $i < 10; $i++) {
            $wakeUp = $this->tesla->wakeUp();
            if($wakeUp["state"] == "online") {
                //echo "Tesla ist online<br/>";
                return true;
                
            }
            else    {
                sleep(10);
                //echo "Tesla ist offline<br/>"; 
            }
            
        }
        //Tesla konnte nach X Schleifen nicht geweckt werden.
        echo "Tesla konnte nach $i Schleifen nicht geweckt werden.";
        return false;
    }

    private function getAllData()    {
        if($this->allData === false) { 
            $this->wakeUp();
            $daten = $this->tesla->allData();
            if( //array_key_exists("id",$daten) 
                is_array($daten)
                ) {
                //Daten erfolgreich geholt
                $this->allData = $daten;
                return true;
            }
            die("Tesla-Daten konnten nicht empfangen werden!");
            return false; 
        }
    }

    public function showAllDataArray()  {
        $this->getAllData();
        return $this->allData;
    }

    public function getBatteryLevel()   {
        $this->getAllData();

        $batteryLevel = $this->allData["charge_state"]["battery_level"];
        return $batteryLevel;
    }

    public function getLastChargeEnergyAdded()   {
        $this->getAllData();

        $energyAdded = floatval($this->allData["charge_state"]["charge_energy_added"]);
        return $energyAdded;
    }

    public function getOdometerKm()   {
        $this->getAllData();

        $kilometerstand = round($this->allData["vehicle_state"]["odometer"] * 1.60934);
        return $kilometerstand;
    }

}

echo "<a href=\"" . $_SERVER['PHP_SELF'] . "?pass=" . $pass . "&action=startCharge&chargeMethod=AC\">Laden starten (AC)</a><br/>";
echo "<a href=\"" . $_SERVER['PHP_SELF'] . "?pass=" . $pass . "&action=startCharge&chargeMethod=DC\">Laden starten (DC)</a><br/>";
echo "<a href=\"" . $_SERVER['PHP_SELF'] . "?pass=" . $pass . "&action=endCharge\">Laden beendet</a><br/>";
echo "<a href=\"" . $_SERVER['PHP_SELF'] . "?pass=" . $pass . "&action=infoOnly\">Nur Info zeigen</a><br/>";