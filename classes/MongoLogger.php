<?php


    class MongoLogger
    {
        /*
         * mongolab.com Mongodb connection:
          ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
          To connect using the shell:
          mongo ds061711.mongolab.com:61711/<DB Name> -u <dbuser> -p <dbpassword>
          To connect using a driver via the standard URI (what's this?):
          mongodb://<dbuser>:<dbpassword>@ds061711.mongolab.com:61711/<DB Name>
         */

        private $CONNECTION_URL = "mongodb://logger:logger@ds061711.mongolab.com:61711/logger";
        private $DB_NAME = "logger";
        private $COLLECTION = "HomeMadeFood";
        private $FILE_REQ;
        private $START_TIME_GMT, $START_TIME_LOCAL, $START_MICRO;
        private $END_TIME_GMT, $END_TIME_LOCAL, $END_MICRO;
        private $POST_REQ, $GET_REQ;
        private $TIME_ZONE_OFFSET;
        private $MESSAGE = "";
        private $ERROR = "";
        private $RESPONSE = "";
        private $LOGGER = false;

        /**
         * (Mongo Logger Constructor)<br/>
         * Constructor for MongoLogger class.
         * @param string $fileReq <p>
         * This is the file requested to create an object for mongo logger instance.
         * </p>
         * @param int $timeZoneOffSet [optional] <p>
         * Time zone offset is the time zone in which user is requesting from,
         * by default it is set to IST +05:30 (+19800). Assumming reqest is from
         * India
         * </p>
         */
        function __construct($fileReq, $timeZoneOffSet = 19800)
        {
            $this->FILE_REQ = $fileReq;
            $this->TIME_ZONE_OFFSET = $timeZoneOffSet;

            $this->START_TIME_GMT = gmdate('Y-m-d H:i:s');
            $this->START_TIME_LOCAL = gmdate('Y-m-d H:i:s', gmmktime() + $this->TIME_ZONE_OFFSET);
            $this->START_MICRO = microtime(true);

        }

        /**
         * setPostReq <br/>
         * Get the POST parameters that are requested by the user.
         * @param array $postReq <p>
         * This assigned for logging web service
         * </p>
         * @param string $headerText [optional] <p>
         * User can set his custom message, else "POST REQ DATA" will be added as
         * header text.
         * </p>
         */
        public function setPostReq($postReq, $headerText = 'POST REQ DATA: ')
        {
            $this->POST_REQ = $this->arrayToString($postReq, $headerText);

        }

        /**
         * setGetReq <br/>
         * Get the GET parameters that are requested by the user.
         * @param array $postReq <p>
         * This assigned for logging web service
         * </p>
         * @param string $headerText [optional] <p>
         * User can set his custom message, else "GET REQ DATA" will be added as
         * header text.
         * </p>
         */
        public function setGetReq($getReq, $headerText = 'GET REQ DATA: ')
        {
            $this->POST_REQ = $this->arrayToString($getReq, $headerText);

        }

        /**
         * info <br/>
         * Sets the info message for logging
         * @param string $message <p>
         * This string will be concatinated to the previously added message
         * </p>
         */
        public function arrayMultiLogger($array, $message)
        {
            $this->MESSAGE .= "\n" . $message . ": \t" . $this->multiArrayToString($array);
        }

        /**
         * info <br/>
         * Sets the info message for logging
         * @param string $message <p>
         * This string will be concatinated to the previously added message
         * </p>
         */
        public function info($message)
        {
            $this->MESSAGE .= "\n" . $message;

        }

        /**
         * error <br/>
         * Sets the info message for logging
         * @param string $message <p>
         * This string will be concatinated to the previously added error message
         * </p>
         */
        public function error($message)
        {
            $this->ERROR .= "\n" . $message;

        }

        /**
         * response <br/>
         * Sets the response string for logging
         * @param string $response <p>
         * This string will be concatinated to the previously added message
         * </p>
         */
        public function response($response)
        {
            $this->RESPONSE .= "\n" . $response;

        }

        private function scriptRanTime($macroEnd, $macroStart)
        {
            return (float) ($this->END_MICRO - $this->START_MICRO);

        }

        public function endLogger()
        {
            $this->END_TIME_GMT = gmdate('Y-m-d H:i:s');
            $this->END_TIME_LOCAL = gmdate('Y-m-d H:i:s', gmmktime() + $this->TIME_ZONE_OFFSET);
            $this->END_MICRO = microtime(true);

            if($this->LOGGER)
            {
                $connection = new MongoClient($this->CONNECTION_URL);
                $dbName = $this->DB_NAME;
                $db = $connection->$dbName;
                $collection = $db->createCollection($this->COLLECTION);

                $document = array(
                    "FileRequested" => $this->FILE_REQ,
                    "StartTimeGMT" => $this->START_TIME_GMT,
                    "StartTimeLocal" => $this->START_TIME_LOCAL,
                    "ScriptBeginMicro" => $this->START_MICRO,
                    "PostDataReq" => $this->POST_REQ,
                    "GetDataReq" => $this->GET_REQ,
                    "MessageText" => $this->MESSAGE,
                    "ErrorText" => $this->ERROR,
                    "ResponseText" => $this->RESPONSE,
                    "EndTimeGMT" => $this->END_TIME_GMT,
                    "EndTimeLocal" => $this->END_TIME_LOCAL,
                    "ScriptEndMicro" => $this->END_MICRO,
                    "ScriptRanTime" => $this->scriptRanTime($this->END_MICRO, $this->START_MICRO)
                );

                $collection->insert($document);
                $connection->close( );
            }

        }

        function __destruct()
        {
            //Destroys all values in this class
            foreach ($this as &$value)
            {
                $value = null;
            }

        }

        private function multiArrayToString($multiArray, $headerText = 'MultiArray')
        {
            return $headerText . "\n" . json_encode($multiArray);

        }

        private function arrayToString($array, $headerText = 'Array')
        {
            return $headerText . ": \n" . json_encode($array);

        }

    }

?>