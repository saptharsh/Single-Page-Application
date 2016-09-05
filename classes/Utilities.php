<?php

    /**
     * Description of XSS
     * - Class handles all XSS attacks
     *
     * 
     */
    //error_reporting(error_reporting() & ~E_NOTICE);
    error_reporting(0);
    date_default_timezone_set("America/Chicago");

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

    }

?>
