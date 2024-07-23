<?php
header('Content-type: text/plain; charset=utf-8');
/*Datei refreshed die Tokens über die Tesla-API
Tipp von User aus TFF-Forum
*/
//echo "TEst";
$tokenFile = "token_data.json";

//1. Schritt: Vorhandene Daten aus dem File lesen
$json = file_get_contents($tokenFile);
$tokendata = json_decode($json,true);
//echo "Alter Token:<br/>";
//print_r($tokendata);

//2. Schritt: Vergleichen, ob der Tokenrefresh nötig ist (<2h vor Ablauf)
$now = new DateTime('now');
$tokenexpiry = date_create_from_format(DateTime::ATOM, $tokendata["expiry_date"]);
$diff = $tokenexpiry->getTimestamp() - $now->getTimestamp();
//echo "Token läuft ab in ". $diff . " Sekunden<br/>";


if ($diff < 7200)   {
    //Kleiner als 2h - also Refresh
    //echo "Token erneuern<br/>";

    $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://auth.tesla.com/oauth2/v3/token');

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Bearer ' . $tokendata["refresh_token"]
        ));

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( array('grant_type' => 'refresh_token', 'client_id' => 'ownerapi', 'refresh_token' => $tokendata["refresh_token"], 'scope' => 'openid email offline_access') ) );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);

        curl_close($ch);

    //echo "Response:<br/>";
    //print_r($response);


    //3. Schritt: Neuen Token in Datei schreiben
    $tokendata = json_decode($response,true);

    //Prüfen ob Tokendata kam
    if( array_key_exists("refresh_token", $tokendata) )   {
        //Erstellt ein Datumsobjekt, das der Ablaufzeit des Tokens entspricht, indem es now + Ablauf in Sekunden addiert.
        //Anschließend werden die neuen Daten in das Token_File geschrieben
        $tokenexpiry = date_add( new DateTime('now'), new DateInterval('PT' . $tokendata["expires_in"] . 'S') );
        $tokendata["expiry_date"] = $tokenexpiry->format(DateTime::ATOM);
        $newTokenData = json_encode($tokendata);
        file_put_contents($tokenFile, $newTokenData);
        //echo "Neuer Token:<br/>";
        //print_r($tokendata);
    }
    else    {
        echo "Fehler bei Tesla-Cron: Keine validen Tokendaten empfangen";
    }
   
}





