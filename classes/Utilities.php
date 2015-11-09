<?php

    /**
     * Description of XSS
     * - Class handles all XSS attacks
     *
     * @author raviraja
     */
    //error_reporting(error_reporting() & ~E_NOTICE);
    error_reporting(0);
    date_default_timezone_set("Asia/Kolkata");

    class Utilities
    {

        public function clean($string)
        {
            $string = mysql_escape_string($string);
            $string = strip_tags($string);
            return $string;

        }

        public function cleanAmp($string)
        {
            return str_replace("&", " &amp; ", $string);

        }

        public function removeNull($string)
        {
            return (is_null($string) || empty($string)) ? '' : $string;

        }

        public function getRandomNumber($length)
        {
            $characters = "1234567890";
            $string = "";

            for ($p = 0; $p < $length; $p++)
            {
                $string .= $characters[rand(0, strlen($characters))];
            }
            return $string;

        }

        public function genRandomString($length)
        {
            $characters = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $string = "";

            for ($p = 0; $p < $length; $p++)
            {
                $string .= $characters[rand(0, strlen($characters))];
            }
            return $string;

        }

        public function genRandomStringWithSplChar($length)
        {
            $characters = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#`~$%^&*()-_+=[]{}\;:'<>?/.,,|";
            $string = "";

            for ($p = 0; $p < $length; $p++)
            {
                $string .= $characters[rand(0, strlen($characters))];
            }
            return $string;

        }

        public function encrypt($strngToEnc)
        {
            $key = "iSurprisO&Raviraja&Krishna";
            return md5(sha1($key . $strngToEnc));

        }

        public function timeAgo($dateStr)
        {
            $date1_ms = strtotime($dateStr);
            $date2_ms = strtotime(gmdate('Y-m-d H:i:s'));
            $difference_ms = $date2_ms - $date1_ms;
            $difference_msRAw = $date2_ms - $date1_ms;
            $seconds = floor($difference_ms % 60);
            $difference_ms = $difference_ms / 60;
            $minutes = floor($difference_ms % 60);
            $difference_ms = $difference_ms / 60;
            $hours = floor($difference_ms % 24);
            $days = floor($difference_ms / 24);

            if ($difference_ms > 0)
            {
                if ($days == 0)
                {
                    if ($hours == 0)
                    {
                        return ($minutes == 0) ? $seconds . ' sec ago' : $minutes . ' min(s) ago';
                    }
                    else
                    {
                        return $hours . ' hr(s) ago';
                    }
                }
                else
                {
                    return $days . ' day(s) ago';
                }
            }
            else
            {
                return "Just Now"; //return "$date2_ms - $date1_ms = $difference_msRAw ago";
            }

        }

        public function URlReqPost($url, $requestData = array())
        {
            /*
             * $url - URL to request
             * $requestData - array('field1' => 'some date','field2' => 'some other data')
             */

            $ch = curl_init();
            $curlConfig = array(CURLOPT_URL => $url, CURLOPT_POST => true, CURLOPT_RETURNTRANSFER => true, CURLOPT_POSTFIELDS => $requestData, CURLOPT_SSL_VERIFYPEER => false);
            curl_setopt_array($ch, $curlConfig);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;

        }

        public function URlReqGet($url, $requestData = array())
        {
            /*
             * $url - URL to request
             * $requestData - array('field1' => 'some date','field2' => 'some other data')
             */

            $ch = curl_init();
            $curlConfig = array(CURLOPT_URL => $url, CURLOPT_POST => false, CURLOPT_RETURNTRANSFER => true, CURLOPT_POSTFIELDS => $requestData, CURLOPT_SSL_VERIFYPEER => false);
            curl_setopt_array($ch, $curlConfig);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;

        }

        public function URlReqEncodePost($url, $requestData)
        {

            $ch = curl_init();
            $strPostBuilder = http_build_query($requestData);

            $curlConfig = array(CURLOPT_URL => $url,
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
                CURLOPT_BINARYTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_POSTFIELDS => $strPostBuilder);

            curl_setopt_array($ch, $curlConfig);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;

        }

        public function URlReqEncodeGet($url, $requestData)
        {

            $ch = curl_init();
            $strPostBuilder = http_build_query($requestData);

            $curlConfig = array(CURLOPT_URL => $url,
                CURLOPT_POST => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
                CURLOPT_BINARYTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_POSTFIELDS => $strPostBuilder);

            curl_setopt_array($ch, $curlConfig);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;

        }

        public function makeCall($number, $msgBody)
        {
            $requestData = array("api_key" => "533696c3", "api_secret" => "0c8aa63d", "to" => "$number", "text" => "$msgBody. I repeate, $msgBody. thank you", "voice" => "female", "lg" => "en-gb");
            $jsonResp = postURlReqEncode("https://rest.nexmo.com/tts/json", $requestData);
            $responseArray = json_decode($jsonResp);

            return ($requestData['status'] == 0) ? TRUE : FALSE;

        }

        public function sendSMSMoryaas($number, $msgBody)
        {
            $number = trim($number);
            $number = str_replace('+', '', $number);
            $number = (strlen($number) == 10) ? '91' . $number : $number;
            //$isIndia = (substr($number, 0, 2) == '91') ? 1 : 0;

            $msgBodyUnencoded = "$msgBody";
            $msgBodyEnc = urlencode($msgBodyUnencoded);

            $finalURL = "http://www.smszone.in/sendsms.asp?page=SendSmsBulk&username=919930263002&password=FB35&number=$number&message=$msgBody";
            $response = file_get_contents($finalURL);

            return (!strcmp($response, "SUCCESS")) ? TRUE : FALSE;
        }

        public function sendSMS($number, $msgBody)
        {
            $number = trim($number);
            $number = str_replace('+', '', $number);
            $number = (strlen($number) == 10) ? '91' . $number : $number;
            //$isIndia = (substr($number, 0, 2) == '91') ? 1 : 0;

            $msgBodyUnencoded = "BlueFlock : " . $msgBody . " .";
            $msgBodyEnc = urlencode($msgBodyUnencoded);

            $finalURL = "http://api.mvaayoo.com/mvaayooapi/MessageCompose?user=junaid.m@grene.in:greneapple&senderID=BLUFLK&receipientno=$number&dcs=0&msgtxt=$msgBodyEnc&state=4";
            $smsStatus = file_get_contents($finalURL);
            $smsSentStatus = ($sms_mode == 1) ? stripos($smsStatus, 'Status=0') : stripos($smsStatus, 'MessageId');

            return (isset($smsSentStatus) && $smsSentStatus == 0) ? TRUE : FALSE;

        }

        public function hexrgb($hexstr)
        {
            $int = hexdec($hexstr);
            $r = (0xFF & ($int >> 0x10)) / 255;
            $g = (0xFF & ($int >> 0x8)) / 255;
            $b = (0xFF & $int) / 255;

            return round($r, 3) . "," . round($g, 3) . "," . round($b, 3);

        }

        public function replaceDefault($data)
        {
            return (strlen($data) == 0 || $data == NULL) ? -1 : $data;

        }

        public function replaceDefaultCountryCode($data)
        {
            return (strlen($data) == 0 || $data == NULL) ? '+91' : $data;
        }

        public function replaceDefaultDate($data)
        {
            return (strlen($data) == 0 || $data == NULL) ? '1970-01-01' : $data;

        }

        public function replaceToday($data)
        {
            return (strlen($data) == 0 || $data == NULL) ? date('Y-m-d') : $data;

        }

        public function isNumber($data)
        {
            if (strlen($data) == 0 || $data == NULL)
            {
                return 0;
            }
            else
            {
                return (is_numeric($data)) ? $data : 0;
            }

        }

        public function replaceDefaultDateTime($data)
        {
            return (strlen($data) == 0 || $data == NULL) ? '1970-01-01 00:00:00' : $data;

        }

        public function replaceZero($data)
        {
            return (strlen($data) == 0 || $data == NULL) ? 0 : $data;

        }

        public function roundPrecTwo($data)
        {
            return (strlen($data) == 0 || $data == NULL) ? 0 : round($data, 4);

        }

        public function purifyPh($data)
        {
            return str_replace(array('-', '+', ')', '(', ' '), '', trim($data));

        }

        public function replaceNow($data = '')
        {
            return (strlen($data) == 0 || $data == NULL) ? gmdate('Y-m-d H:i:s') : $data;

        }

        public function replaceOne($data)
        {
            return (strlen($data) == 0 || $data == NULL) ? 1 : $data;

        }

        public function convertToLocalTime($dateStr, $offset)
        {
            return date('Y-m-d H:i:s', (strtotime($dateStr) + $offset));

        }

        function dateTimeMicroSec($format = 'Y-m-d H:i:s.u', $utimestamp = null)
        {
            if (is_null($utimestamp))
            {
                $utimestamp = microtime(true);
            }

            $timestamp = floor($utimestamp);
            $milliseconds = round(($utimestamp - $timestamp) * 1000000);

            return date(preg_replace('`(?<!\\\\)u`', $milliseconds, $format), $timestamp);

        }

        public function removeSlashes($data)
        {
            return stripslashes($data);

        }

        public function addSpacesBetweenChars($string)
        {
            return implode(' ', str_split($string));

        }

        public function sendEmail($to, $subject, $text, $html)
        {

            require $_SERVER['DOCUMENT_ROOT'] . '/HomeMadeFood/classes/PHPMailer-master/class.phpmailer.php';
            include $_SERVER['DOCUMENT_ROOT'] . '/HomeMadeFood/classes/PHPMailer-master/class.smtp.php';

            $mail = new PHPMailer();
            $body = eregi_replace("[\]", '', $html);

            $mail->IsSMTP();
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->Host = 'retail.smtp.com';
            $mail->Port = '2525';
            $mail->Username = 'angel@blueflock.com';
            $mail->Password = 'greneapple';

            $mail->SetFrom($mail->Username, 'BlueFlock.com');
            $mail->Subject = $subject;
            $mail->AltBody = $text;
            $mail->MsgHTML($body);

            $address = $to;
            $mail->AddAddress($address, "$to");

            return (!$mail->Send()) ? 'FALSE' : 'TRUE';

        }

        public function sendAndroidNotification($registrationIdsArray, $messageData)
        {
            $apiKey = "AIzaSyDzjJcvIvQ4dj8Vo7p-8wgbsMqWDRZnv9s"; //Production app key...

            $headers = array("Content-Type:" . "application/json", "Authorization:" . "key=" . $apiKey);
            $data = array('data' => $messageData, 'registration_ids' => $registrationIdsArray);

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_URL, "https://android.googleapis.com/gcm/send");
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

            $response = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($response, true);

            return ($response['success'] >= 1) ? TRUE : FALSE;

        }

        public function sendIOSNotification($deviceToken, $message, $badgeCount)
        {
            $passphrase = '';
            $badgeCount = ($badgeCount == 0) ? 1 : $badgeCount;

            ////////////////////////////////////////////////////////////////////////////////
            $ctx = stream_context_create();
            $pathToCEM = '/home/www/blueflock.com/bluehawk_v42/Classes/AppStore.pem';
            stream_context_set_option($ctx, 'ssl', 'local_cert', $pathToCEM);
            stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

            // Open a connection to the APNS server...
            //$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
            $fp = stream_socket_client('sslv3://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

            if (!$fp)
                exit("Failed to connect: $err $errstr" . PHP_EOL);

            //echo 'Connected to APNS' . PHP_EOL;

            $body['aps'] = array('alert' => $message, 'sound' => 'default', 'badge' => (int) $badgeCount, 'content-available' => (int) 1);
            $payload = json_encode($body);
            $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
            $result = fwrite($fp, $msg, strlen($msg));
            fclose($fp);

            sendIOSDevNotification($deviceToken, $message, $badgeCount);

            return (!$result) ? FALSE : TRUE;

        }

        public function sendBBNotification($pushId, $message)
        {

            $appid = '4044-617k006Dm95M8830rrrm46r9h11944964h2'; // APP ID provided by RIM
            $password = 'MarkM58C'; // Password provided by RIM
            $appport = 4044; // Application device port
            $addresses = '';

            try
            {
                $deliverbefore = gmdate('Y-m-d\TH:i:s\Z', strtotime('+1 minute')); //Deliver before timestamp
                // An array of address must be in PIN format or "push_all";
                $addresstosendto[] = $pushId;
                foreach ($addresstosendto as $value)
                {
                    $addresses .= '<address address-value="' . $value . '" />';
                }

                // create a new cURL resource
                $err = false;
                $ch = curl_init();
                $messageid = microtime(true);

                $data = '--asdwewe. "\r\n" .Content-Type: application/xml; charset=UTF-8' . "\r\n\r\n" .
                        '<?xml version="1.0"?>
                    <!DOCTYPE pap PUBLIC "-//WAPFORUM//DTD PAP 2.1//EN" "http://www.openmobilealliance.org/tech/DTD/pap_2.1.dtd">
                    <pap>
                    <push-message push-id="' . $messageid . '" deliver-before-timestamp="' . $deliverbefore . '" source-reference="' . $appid . '">'
                        . $addresses .
                        '<quality-of-service delivery-method="unconfirmed"/>
                    </push-message>
                    </pap>' . "\r\n" .
                        '--asdwewe' . "\r\n" .
                        'Content-Type: text/plain' . "\r\n" .
                        //'Content-Encoding: binary'. "\r\n" .
                        'Push-Message-ID: ' . $messageid . "\r\n\r\n" .
                        stripslashes($message) . "\r\n" .
                        '--asdwewe--' . "\r\n";

                // set URL and other appropriate options
                curl_setopt($ch, CURLOPT_URL, "https://pushapi.eval.blackberry.com/mss/PD_pushRequest");
                curl_setopt($ch, CURLOPT_PORT, 443);
                curl_setopt($ch, CURLOPT_SSLVERSION, 3);
                curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "\cacert.pem");
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_USERAGENT, "My BB Push Server\1.0");
                curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($ch, CURLOPT_USERPWD, $appid . ':' . $password);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $__extra_Headers = array(
                    "Content-Type: multipart/related; boundary=asdwewe; type=application/xml",
                    "Accept: text/html, image/gif, image/jpeg, *; q=.2, */*; q=.2",
                    "Connection: keep-alive",
                    "X-Rim-Push-Dest-Port: " . $appport,
                    "X-RIM-PUSH-ID: " . $messageid,
                    "X-RIM-Push-Reliability-Mode: APPLICATION"
                );
                curl_setopt($ch, CURLOPT_HTTPHEADER, $__extra_Headers);


                // grab URL and pass it to the browser
                $xmldata = curl_exec($ch);
                if ($xmldata === false)
                {
                    $xmlRespStr = 'Error pada CURL : ' . curl_error($ch) . "\n";
                }
                else
                {
                    $xmlRespStr = 'Operasi push berhasil' . "\n";
                }


                // close cURL resource, and free up system resources
                curl_close($ch);

                //Start parsing response into XML data that we can read and output
                $p = xml_parser_create();
                xml_parse_into_struct($p, $xmldata, $vals);
                $errorcode = xml_get_error_code($p);
                if ($errorcode > 0)
                {
                    $errorcodeStr = xml_error_string($errorcode) . "\n";
                    $err = true;
                }
                xml_parser_free($p);

                if (!$err && $vals[1]['tag'] == 'PUSH-RESPONSE')
                {
                    $response = 'PUSH-ID: ' . $vals[1]['attributes']['PUSH-ID'] . "<br \>\n" . 'REPLY-TIME: ' . $vals[1]['attributes']['REPLY-TIME'] . "<br \>\n" . 'Response CODE: ' . $vals[2]['attributes']['CODE'] . "<br \>\n" . 'Response DESC: ' . $vals[2]['attributes']['DESC'] . "<br \> \n";
                    return TRUE;
                }
                else
                {
                    $response = '<p>An error has occured</p>' . "\n" . 'Error CODE: ' . $vals[1]['attributes']['CODE'] . "<br \>\n" . 'Error DESC: ' . $vals[1]['attributes']['DESC'] . "<br \>\n";
                    return FALSE;
                }
            }
            catch (Exception $e)
            {
                $exception = $e->getMessage();
                return FALSE;
            }

            return FALSE;

        }

        public function sendWindowsNotification($urlToSend, $message)
        {
            $sendToast = $textMessage = $message;

            // Create the toast message...
            $toastMessage = "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
                    "<wp:Notification xmlns:wp=\"WPNotification\">" .
                    "<wp:Toast>" .
                    "<wp:Text1>" . "$sendToast" . "</wp:Text1>" .
                    "</wp:Toast>" .
                    "</wp:Notification>";

            // Create request to send
            $r = curl_init();
            curl_setopt($r, CURLOPT_URL, $urlToSend);
            curl_setopt($r, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($r, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HEADER, true);

            // add headers...
            $httpHeaders = array('Content-type: text/xml; charset=utf-8', 'X-WindowsPhone-Target: toast',
                'Accept: application/*', 'X-NotificationClass: 2', 'Content-Length:' . strlen($toastMessage));
            curl_setopt($r, CURLOPT_HTTPHEADER, $httpHeaders);

            // add message
            curl_setopt($r, CURLOPT_POSTFIELDS, $toastMessage);

            // execute request
            $output = curl_exec($r);
            curl_close($r);

            return TRUE;

        }

    }

?>
