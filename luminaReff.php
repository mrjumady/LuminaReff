<?php

/* 
* HARAM UNTUK DIJUAL LAGI
* Created By: Jumady (https://web.facebook.com/dyvretz/)
*/

error_reporting(0);
date_default_timezone_set("Asia/Jakarta");

$colors = new Colors();
echo "---------- [".$colors->getColoredString("AUTO REFF LUMINA - BOT BY: JUMADY", "green")."] ----------".PHP_EOL.PHP_EOL;

inputRefferal:
$codeReff = input("[ ".date('H:i:s')." ] -> ".$colors->getColoredString("Kode Refferal  ", "green"));
if(empty($codeReff)) {
    goto inputRefferal;
} else {
    $codeReff = strtoupper($codeReff);
}

totalReff:
$totalReff = input("[ ".date('H:i:s')." ] -> ".$colors->getColoredString("Jumlah Refferal", "green"));
if(empty($totalReff)) {
    goto inputRefferal;
} else {
    echo PHP_EOL;
}

for ($ia=1; $ia <= $totalReff; $ia++) {
    echo "-------------------- ".$colors->getColoredString("REFFERAL KE $ia", "green")." ----------------------".PHP_EOL;
    tryRegister:
    /* RANDOM EMAIL DLL */
    $nama = get_between(nama(), '{"name":"', '",');
    $username = get_between(nama(), '"username":"', '",');
    $email = $username."@gmail.com";
    $nomorHP = rand(10000000, 999999999);
    $randDeviceIdentifier = RandomDeviceIdentifier(16);
    /* END  RANDOM EMAIL DLL */

    echo "[ ".date('H:i:s')." ] -> ".$colors->getColoredString("Mendaftar Dengan Nama $nama", "green").PHP_EOL;
    $data = '{"email":"'.$email.'","password":"jumady21","phone_number":"852'.$nomorHP.'"}';
    $contentLenght = strlen($data);
    $headers = [
        "Host: api.lumina.mba",
        "app-version-code: 24", 
        "app-version-name: 2.3.2", 
        "app-id: mba.lumina", 
        "device-identifier-type: SSAID", 
        "device-identifier: ".$randDeviceIdentifier, 
        "app-file-dir: /data/user/0/mba.lumina/files", 
        "device-manufacturer: Xiaomi", 
        "device-model: M2010J19CG", 
        "device-api-level: 30", 
        "device-android-version: 11", 
        "platform: android", 
        "content-type: application/json; charset=UTF-8", 
        "content-length: ".$contentLenght, 
        "accept-encoding: gzip", 
        "user-agent: okhttp/4.9.3"
    ];

    $register = curl("https://api.lumina.mba/mobile/users/register/", $data, $headers);
    $error = get_between($register[1], '{"error_message":"', '",');
    $token = get_between($register[1], '"token":"', '",');
    if ($token) {
        $headers = [
            "Host: api.lumina.mba", 
            "app-version-code: 24", 
            "app-version-name: 2.3.2", 
            "app-id: mba.lumina", 
            "device-identifier-type: SSAID", 
            "device-identifier: ".$randDeviceIdentifier, 
            "app-file-dir: /data/user/0/mba.lumina/files", 
            "device-manufacturer: Xiaomi", 
            "device-model: M2010J19CG", 
            "device-api-level: 30", 
            "device-android-version: 11", 
            "platform: android",
            "authorization: Token ".$token, 
            "accept-encoding: gzip", 
            "user-agent: okhttp/4.9.3"
        ];
        $getProfileCard = curlget("https://api.lumina.mba/mobile/workers/profile-cards/", null, $headers);
        $profileCard = get_between($getProfileCard[1], '{"id":"', '",');
        if ($profileCard) {
            $data = '{"birth_date":"1996-03-09T00:00:00.000002Z","full_name":"'.$nama.'","gender":"male","profile_card_id":"'.$profileCard.'","referral_code":"'.$codeReff.'","register_references":["d79b9acd-f962-4e4d-82b8-c1756e0f2cff"]}';
            $contentLenght = strlen($data);
            $headers = [
                "app-version-code: 24",
                "app-version-name: 2.3.2", 
                "app-id: mba.lumina", 
                "device-identifier-type: SSAID", 
                "device-identifier: ".$randDeviceIdentifier, 
                "app-file-dir: /data/user/0/mba.lumina/files", 
                "device-manufacturer: Xiaomi", 
                "device-model: M2010J19CG", 
                "device-api-level: 30", 
                "device-android-version: 11",
                "platform: android", 
                "authorization: Token ".$token, 
                "content-type: application/json; charset=UTF-8",
                "content-length: ".$contentLenght, 
                "accept-encoding: gzip", 
                "user-agent: okhttp/4.9.3"
            ];
            $isiData = curl("https://api.lumina.mba/mobile/workers/biodata/", $data, $headers);
            $anuSukses = get_between($isiData[1], '{"gender":"', '",');
            if ($anuSukses) {
                echo "[ ".date('H:i:s')." ] -> ".$colors->getColoredString("Sukse Ngereff $codeReff", "green").PHP_EOL;
            } else {
                echo "[ ".date('H:i:s')." ] -> Gagal, Alasan: ".$colors->getColoredString("Gagal Ngereff $codereff", "red").PHP_EOL;
                goto tryRegister;
            }
        } else {
            echo "[ ".date('H:i:s')." ] -> Gagal, Alasan: ".$colors->getColoredString("Gagal Get Profile Card id", "red").PHP_EOL;
            goto tryRegister;
        }
    } else if($error === "Kamu terkena batasan") {
        echo "[ ".date('H:i:s')." ] -> Gagal, Alasan: ".$colors->getColoredString($error, "red").PHP_EOL;
        goto tryRegister;
    } else {
        echo "[ ".date('H:i:s')." ] -> Gagal, Alasan: ".$colors->getColoredString("gatau juga gweh kenapa", "red").PHP_EOL;
	goto tryRegister;
    }

}

function input($text) {
    echo $text.": ";
    $a = trim(fgets(STDIN));
    return $a;
}


function get_between($string, $start, $end) 
    {
        $string = " ".$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return "";
        $ini += strlen($start);
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
    }


function nama() {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.namefake.com/indonesian-indonesia");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$ex = curl_exec($ch);
	return $ex;
}

function RandomDeviceIdentifier($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function curl($url, $post = 0, $httpheader = 0, $proxy = 0){ // url, postdata, http headers, proxy, uagent
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        if($post){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        if($httpheader){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
        }
        if($proxy){
            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
            // curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        }
        curl_setopt($ch, CURLOPT_HEADER, true);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch);
        if(!$httpcode) return "Curl Error : ".curl_error($ch); else{
            $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
            $body = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
            curl_close($ch);
            return array($header, $body);
        }
    }


function curlget($url,$post,$headers) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    $headers == null ? curl_setopt($ch, CURLOPT_POST, 1) : curl_setopt($ch, CURLOPT_HTTPGET, 1);
	if ($headers !== null) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	$result = curl_exec($ch);
	$header = substr($result, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	$body = substr($result, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
	$cookies = array()
;	foreach($matches[1] as $item) {
	  parse_str($item, $cookie);
	  $cookies = array_merge($cookies, $cookie);
	}
	return array (
	$header,
	$body,
	$cookies
	);
}


class Colors {
    private $foreground_colors = array();
    private $background_colors = array();

    public function __construct() {
        // Set up shell colors
        $this->foreground_colors['black'] = '0;30';
        $this->foreground_colors['dark_gray'] = '1;30';
        $this->foreground_colors['blue'] = '0;34';
        $this->foreground_colors['light_blue'] = '1;34';
        $this->foreground_colors['green'] = '0;32';
        $this->foreground_colors['light_green'] = '1;32';
        $this->foreground_colors['cyan'] = '0;36';
        $this->foreground_colors['light_cyan'] = '1;36';
        $this->foreground_colors['red'] = '0;31';
        $this->foreground_colors['light_red'] = '1;31';
        $this->foreground_colors['purple'] = '0;35';
        $this->foreground_colors['light_purple'] = '1;35';
        $this->foreground_colors['brown'] = '0;33';
        $this->foreground_colors['yellow'] = '1;33';
        $this->foreground_colors['light_gray'] = '0;37';
        $this->foreground_colors['white'] = '1;37';

        $this->background_colors['black'] = '40';
        $this->background_colors['red'] = '41';
        $this->background_colors['green'] = '42';
        $this->background_colors['yellow'] = '43';
        $this->background_colors['blue'] = '44';
        $this->background_colors['magenta'] = '45';
        $this->background_colors['cyan'] = '46';
        $this->background_colors['light_gray'] = '47';
    }

    // Returns colored string
    public function getColoredString($string, $foreground_color = null, $background_color = null) {
        $colored_string = "";

        // Check if given foreground color found
        if (isset($this->foreground_colors[$foreground_color])) {
            $colored_string .= "\033[" . $this->foreground_colors[$foreground_color] . "m";
        }
        // Check if given background color found
        if (isset($this->background_colors[$background_color])) {
            $colored_string .= "\033[" . $this->background_colors[$background_color] . "m";
        }

        // Add string and end coloring
        $colored_string .=  $string . "\033[0m";

        return $colored_string;
    }

    // Returns all foreground color names
    public function getForegroundColors() {
        return array_keys($this->foreground_colors);
    }

    // Returns all background color names
    public function getBackgroundColors() {
        return array_keys($this->background_colors);
    }
}
