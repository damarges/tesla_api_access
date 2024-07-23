<?php
/* QUELLE: https://github.com/timdorr/tesla-api/discussions/296 */
class Tesla
{

//Original by Stephan Groen https://github.com/stephangroen/tesla-php-client
//New OAuth by Ralf Naumann https://www.esherpa.ch

    protected $apiBaseUrl = "https://owner-api.teslamotors.com/api/1";
    protected $tokenUrl = 'https://owner-api.teslamotors.com/oauth/token';
    protected $tokenUrlNew = 'https://auth.tesla.com/oauth2/v3/token';
    protected $accessUrl = 'https://auth.tesla.com/oauth2/v3/authorize';
    protected $accessToken;
    protected $vehicleId = null;

    public function __construct(string $accessToken = null)
    {
        $this->accessToken = $accessToken;
    }

    public function setAccessToken(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function allData()
    {
        return $this->sendRequest('/vehicle_data')['response'];
    }
	//Funktioniert nicht mehr 2024-02-04
	/*
    public function vehicles()
    {
        return $this->sendRequest('/vehicles');
    }*/
	
	public function vehicles()
    {
        $params = [
            'orders' => "true"
        ];
        return $this->sendRequest('/products?orders=true');
    }

    public function vehicle()
    {
        return $this->sendRequest('')['response'];
    }

    public function setVehicleId(int $vehicleId)
    {
        $this->vehicleId = $vehicleId;
    }

    public function setClientId(string $clientId)
    {
        putenv('TESLA_CLIENT_ID=' . $clientId);
    }

    public function setClientSecret(string $clientSecret)
    {
        putenv('TESLA_CLIENT_SECRET=' . $clientSecret);
    }

    public function mobileEnabled()
    {
        return $this->sendRequest('/mobile_enabled')['response'];
    }

    public function chargeState()
    {
        return $this->sendRequest('/data_request/charge_state')['response'];
    }

    public function climateState()
    {
        return $this->sendRequest('/data_request/climate_state')['response'];
    }

    public function driveState()
    {
        return $this->sendRequest('/data_request/drive_state')['response'];
    }

    public function guiSettings()
    {
        return $this->sendRequest('/data_request/gui_settings')['response'];
    }

    public function vehicleState()
    {
        return $this->sendRequest('/data_request/vehicle_state')['response'];
    }

    public function vehicleConfig()
    {
        return $this->sendRequest('/data_request/vehicle_config')['response'];
    }

    public function wakeUp()
    {
        return $this->sendRequest('/wake_up', [], 'POST')['response'];
    }

    public function startSoftwareUpdate( int $seconds = 0 )
    {
        return $this->sendRequest('/command/schedule_software_update', [ 'offset_sec' => $seconds ], 'POST')['response'];
    }

    public function setValetMode(bool $active = false, int $pin = 0000)
    {
        $params = [
            'on' => $active,
            'pin' => $pin
        ];

        return $this->sendRequest('/command/set_valet_mode', $params, 'POST')['response'];
    }

    public function resetValetPin()
    {
        return $this->sendRequest('/command/reset_valet_pin', [], 'POST')['response'];
    }

    public function openChargePort()
    {
        return $this->sendRequest('/command/charge_port_door_open', [], 'POST')['response'];
    }

    public function setChargeLimitToStandard()
    {
        return $this->sendRequest('/command/charge_standard', [], 'POST')['response'];
    }

    public function setChargeLimitToMaxRange()
    {
        return $this->sendRequest('/command/charge_max_range', [], 'POST')['response'];
    }

    public function setChargeLimit(int $percent = 90)
    {
        $params = [
            'percent' => "$percent"
        ];
        return $this->sendRequest('/command/set_charge_limit', $params, 'POST')['response'];
    }

    public function startCharging()
    {
        return $this->sendRequest('/command/charge_start', [], 'POST')['response'];
    }

    public function stopCharging()
    {
        return $this->sendRequest('/command/charge_stop', [], 'POST')['response'];
    }

    public function flashLights()
    {
        return $this->sendRequest('/command/flash_lights', [], 'POST')['response'];
    }

    public function honkHorn()
    {
        return $this->sendRequest('/command/honk_horn', [], 'POST')['response'];
    }

    public function unlockDoors()
    {
        return $this->sendRequest('/command/door_unlock', [], 'POST')['response'];
    }

    public function lockDoors()
    {
        return $this->sendRequest('/command/door_lock', [], 'POST')['response'];
    }

    public function windowControl(string $state = 'close', int $lat = 0, int $lon = 0)
    {
        return $this->sendRequest('/command/window_control', [ 'command' => $state, 'lat' => $lat, 'lon' => $lon ], 'POST')['response'];
    }

    public function setTemperature(float $driverDegreesCelcius = 20.0, float $passengerDegreesCelcius = 20.0)
    {
        return $this->sendRequest('/command/set_temps?driver_temp=' . $driverDegreesCelcius . '&passenger_temp=' . $passengerDegreesCelcius, [], 'POST')['response'];
    }

    public function startHvac()
    {
        return $this->sendRequest('/command/auto_conditioning_start', [], 'POST')['response'];
    }

    public function stopHvac()
    {
        return $this->sendRequest('/command/auto_conditioning_stop', [], 'POST')['response'];
    }

    public function movePanoramicRoof(string $state = 'vent', int $percent = 50)
    {
        return $this->sendRequest('/command/sun_roof_control?state=' . $state . '&percent=' . $percent, [], 'POST')['response'];
    }

    public function remoteStart(string $password = '')
    {
        return $this->sendRequest('/command/remote_start_drive?password=' . $password, [], 'POST')['response'];
    }

    public function openTrunk()
    {
        return $this->sendRequest('/command/actuate_trunk', [ 'which_trunk' => 'rear' ], 'POST')['response'];
    }

    public function openFrunk()
    {
        return $this->sendRequest('/command/actuate_trunk', [ 'which_trunk' => 'front' ], 'POST')['response'];
    }

    public function setNavigation(string $location)
    {
        $params = [
            'type' => 'share_ext_content_raw',
            'value' => [
                'android.intent.extra.TEXT' => $location
            ],
            'locale' => 'en-US',
            'timestamp_ms' => time(),
        ];
        return $this->sendRequest('/command/navigation_request', $params, 'POST')['response'];
    }

    public function startSentry()
    {
        return $this->sendRequest('/command/set_sentry_mode', [ 'on' => True], 'POST')['response'];
    }

	public function stopSentry()
    {
        return $this->sendRequest('/command/set_sentry_mode', [ 'on' => False], 'POST')['response'];
    }
    
    public function setSeatHeater(int $heater = 0, int $level = 0)
    {
        return $this->sendRequest('/command/remote_seat_heater_request', ['heater' => $heater, 'level' => $level], 'POST')['response'];
    }
    
     public function setTemps(float $driver = 21.0, float $passenger = 21.0)
    {
        return $this->sendRequest('/command/set_temps', ['driver_temp' => $driver, 'passenger_temp' => $passenger], 'POST')['response'];
    }
    
    public function base64url_encode($data) { 
  		return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
	} 

    public function getAccessToken(string $username, string $password)
    {
###Step 0: Get ClientID & ClientSecret

    $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://pastebin.com/raw/pS7Z6yyP');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);
	$api = explode(PHP_EOL,$result);
	$id=explode('=',$api[0]);
	$secret=explode('=',$api[1]);
	$this->setClientId(trim($id[1]));
	$this->setClientSecret(trim($secret[1]));

###Step 1: Obtain the login page

    	$code_verifier = substr(hash('sha512', mt_rand()), 0, 86);
    	$state = $this->base64url_encode(substr(hash('sha256', mt_rand()), 0, 12));
	$code_challenge = $this->base64url_encode($code_verifier);
		
	$data =[
            'client_id' => 'ownerapi',
            'code_challenge' => $code_challenge,
            'code_challenge_method' => 'S256',
            'redirect_uri' => 'https://auth.tesla.com/void/callback',
            'response_type' => 'code',
            'scope' => 'openid email offline_access',
            'state' => $state,
        ];
        
	$GetUrl = $this->accessUrl.'?'.http_build_query ($data);
 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $GetUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HEADER, 1);
	    $apiResult = curl_exec($ch);
        /* API RESULT TO FILE FOR FURTHER TESTING */
        $serialized = serialize($apiResult);
        file_put_contents('apiresult.txt', $serialized);
        /* ENDE API TO FILE */
	    $header_len = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	    curl_close($ch);
		
		$header = substr($apiResult, 0, $header_len);
		$body = substr($apiResult, $header_len);
        
        $dom = new DomDocument();
		@ $dom->loadHTML($body);
		$child_elements = $dom->getElementsByTagName('input'); //DOMNodeList
		foreach( $child_elements as $h2 ) {
    		$hiddeninputs[$h2->getAttribute('name')] = $h2->getAttribute('value');
		}
		
        //Offenbar kommt von Tesla Cancel = 1, was aber nicht übernommen wird, da im weiteren Verlauf nochmal die Inputfelder mit leerem Cancel kommen. Ist das de Fehler?
        print_r($hiddeninputs);
        print_r($apiResult);

	    $headers = [];
		$output = rtrim($header);
		$data = explode("\n",$output);
		$headers['status'] = $data[0];
		array_shift($data);

		foreach($data as $part){
    		$middle = explode(":",$part,2);
    		if ( !isset($middle[1]) ) { $middle[1] = null; }
			$headers[trim($middle[0])] = trim($middle[1]);
		}
		
		if (isset($headers['Set-Cookie'])){
			$cookie = $headers['Set-Cookie'];
		} elseif (isset($headers['set-cookie'])){
			$cookie = $headers['set-cookie'];
		}
		



###Step 2: Obtain an authorization code

	$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $GetUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        $postData = array();
        foreach ($hiddeninputs as $inputKey => $inputValue) {
            $postData[$inputKey] = $inputValue;
        }
        $postData['identity'] = $username;
        $postData['credential'] = $password;

	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        $apiResult = curl_exec($ch);
                /* API RESULT TO FILE FOR FURTHER TESTING */
                $serialized = serialize($apiResult);
                file_put_contents('apiresult2.txt', $serialized);
                /* ENDE API TO FILE */
        curl_close($ch);
	$code= explode('&',explode('https://auth.tesla.com/void/callback?code=',$apiResult)[1])[0];
#print 'CODE'.$code;exit;


echo "Api2: "; print_r($apiResult); die();
		
###Step 3: Exchange authorization code for bearer token

	$ch = curl_init();
      	curl_setopt($ch, CURLOPT_URL, $this->tokenUrlNew);
      	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
     	curl_setopt($ch, CURLOPT_POST, true);
      	curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json'
      	]);
      	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'grant_type' => 'authorization_code',
        'client_id' => 'ownerapi',
        'code' => $code,
        'code_verifier' => $code_verifier,
        'redirect_uri' => 'https://auth.tesla.com/void/callback'
      	]));

      	$apiResult = curl_exec($ch);
                /* API RESULT TO FILE FOR FURTHER TESTING */
                $serialized = serialize($apiResult);
                file_put_contents('apiresult3.txt', $serialized);
                /* ENDE API TO FILE */
      	curl_close($ch);
      	$apiResultJson = json_decode($apiResult, true);
#print_r($apiResultJson);exit;

      	$BearerToken = $apiResultJson['access_token'];
      	$RefreshToken = $apiResultJson['refresh_token'];

      
###Step 4: Exchange bearer token for access token

	$ch = curl_init();
      	curl_setopt($ch, CURLOPT_URL, $this->tokenUrl);
      	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
      	curl_setopt($ch, CURLOPT_POST, true);
      	curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer '.$BearerToken,
        'Content-Type: application/json',
        'Accept: application/json'
      	]);
      	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
        'client_id' => getenv('TESLA_CLIENT_ID'),
        'client_secret' => getenv('TESLA_CLIENT_SECRET'),
      	]));

      	$apiResult = curl_exec($ch);
                /* API RESULT TO FILE FOR FURTHER TESTING */
                $serialized = serialize($apiResult);
                file_put_contents('apiresult4.txt', $serialized);
                /* ENDE API TO FILE */
      	curl_close($ch);
      
      	$apiResultJson = json_decode($apiResult, true);
      	$apiResultJson['refresh_token']=$RefreshToken;
#print_r($apiResultJson);exit;

	  	$this->accessToken = $apiResultJson['access_token'];

        return $apiResultJson;
    }

    public function refreshAccessToken(string $refreshToken)
    {
###Step 0: Get ClientID & ClientSecret

        $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://pastebin.com/raw/pS7Z6yyP');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);
	$api = explode(PHP_EOL,$result);
	$id=explode('=',$api[0]);
	$secret=explode('=',$api[1]);
	$this->setClientId(trim($id[1]));
	$this->setClientSecret(trim($secret[1]));

###Step 1: Exchange refresh_bearer_token for bearer token

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $this->tokenUrlNew);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, 30);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json'
      ]);
#print 'XX '.getenv('TESLA_CLIENT_ID');exit;
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'grant_type' => 'refresh_token',
        'client_id' => 'ownerapi',
        'client_secret' => getenv('TESLA_CLIENT_SECRET'),
        'refresh_token' => $refreshToken,
        'scope' => 'openid email offline_access'
      ]));

      $apiResult = curl_exec($ch);
      $apiResultJson = json_decode($apiResult, true);

      curl_close($ch);
#print_r($apiResult);exit;
	  
      $apiResultJson = json_decode($apiResult, true);
      $BearerToken = $apiResultJson['access_token'];
      $RefreshToken = $apiResultJson['refresh_token'];

      
###Step 2: Exchange bearer token for access token

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $this->tokenUrl);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, 30);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer '.$BearerToken,
        'Content-Type: application/json',
        'Accept: application/json'
      ]);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
        'client_id' => getenv('TESLA_CLIENT_ID'),
        'client_secret' => getenv('TESLA_CLIENT_SECRET'),
      ]));

      $apiResult = curl_exec($ch);
      curl_close($ch);
      
      $apiResultJson = json_decode($apiResult, true);
      $apiResultJson['refresh_token']=$RefreshToken;
#print_r($apiResultJson);exit;

	  $this->accessToken = $apiResultJson['access_token'];

        return $apiResultJson;
    }

    protected function sendRequest(string $endpoint, array $params = [], string $method = 'GET')
    {
        $ch = curl_init();

        if ($endpoint !== '/vehicles' && ! is_null($this->vehicleId)) {
            $endpoint = '/vehicles/' . $this->vehicleId . $endpoint;
        }
        //echo $this->apiBaseUrl . $endpoint;
        curl_setopt($ch, CURLOPT_URL, $this->apiBaseUrl . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Bearer ' . $this->accessToken
        ]);

        if ($method == 'POST' || $method == 'PUT' || $method == 'DELETE') {
            if ($method == 'POST') {
                curl_setopt($ch, CURLOPT_POST, true);
            }
            if (in_array($method, ['PUT', 'DELETE'])) {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        }

        $apiResult = curl_exec($ch);
        $headerInfo = curl_getinfo($ch);
        $apiResultJson = json_decode($apiResult, true);
        curl_close($ch);

        $result = [];
        if ($apiResult === false) {
            $result['errorcode'] = 0;
            $result['errormessage'] = curl_error($ch);

            //print $result['errormessage'].' api<br>';
        }

        if (! in_array($headerInfo['http_code'], ['200', '201', '204'])) {
            $result['errorcode'] = $headerInfo['http_code'];
            if (isset($apiResult)) {
                $result['errormessage'] = $apiResult;
            }

            //print $result['errormessage'].' header<br>';;
        }
		
        return $apiResultJson ?? $apiResult;
        
    }
}

###Examples:
###Get new access token
//$tesla = new Tesla();
//var_dump($tesla->getAccessToken("login", "password"));
###Refresh access token
//$tesla = new Tesla();
//var_dump($tesla->refreshAccessToken(string $refreshToken));
###Get Vehicles
//$tesla = new Tesla(string $accessToken);
//var_dump($tesla->vehicles());
###Send request to Vehicle
//$tesla = new Tesla(string $accessToken);
//$tesla->setVehicleId($vehicleid);
//$tesla->wakeUp();//Wait for vehicle to wake up and than:
//var_dump($tesla->allData());//Or:
//$tesla->flashLights();

?>