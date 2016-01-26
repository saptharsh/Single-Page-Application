<?php

    class Logger
    {

        private $LOGGER = TRUE;
        private $LOGGER_STRING = "";
        private $RESET_ALL = "\033[0m";

        /*
         * Text Color codes...
         */
        private $DEFAULT_FOREGROUND = "\033[39m";
        private $BLACK = "\033[30m";
        private $RED = "\033[31m";
        private $GREEN = "\033[32m";
        private $YELLOW = "\033[33m";
        private $BLUE = "\033[34m";
        private $MAGENTA = "\033[35m";
        private $CYAN = "\033[36m";
        private $LIGHT_GRAY = "\033[37m";
        private $DARK_GRAY = "\033[90m";
        private $LIGHT_RED = "\033[91m";
        private $LIGHT_GREEN = "\033[92m";
        private $LIGHT_YELLOW = "\033[93m";
        private $LIGHT_BLUE = "\033[94m";
        private $LIGHT_MAGENTA = "\033[95m";
        private $LIGHT_CYAN = "\033[96m";
        private $WHITE = "\033[97m";

        /*
         * BG Color codes...
         */
        private $DEFAULT_BACKGROUND = "\033[49m";
        private $BG_BLACK = "\033[40m";
        private $BG_RED = "\033[41m";
        private $BG_GREEN = "\033[42m";
        private $BG_YELLOW = "\033[43m";
        private $BG_BLUE = "\033[44m";
        private $BG_MAGENTA = "\033[45m";
        private $BG_CYAN = "\033[46m";
        private $BG_LIGHT_GRAY = "\033[47m";
        private $BG_DARK_GRAY = "\033[100m";
        private $BG_LIGHT_RED = "\033[101m";
        private $BG_LIGHT_GREEN = "\033[102m";
        private $BG_LIGHT_YELLOW = "\033[103m";
        private $BG_LIGHT_BLUE = "\033[104m";
        private $BG_LIGHT_MAGENTA = "\033[105m";
        private $BG_LIGHT_CYAN = "\033[106m";
        private $BG_WHITE = "\033[107m";

        /*
         * Styling...
         */
        private $BOLD = "\033[1m";
        private $DIM = "\033[2m";
        private $UNDER_LINE = "\033[4m";
        private $BLINK = "\033[5m";
        private $INVERT = "\033[7m";
        private $HIDDEN = "\033[8m";

        /*
         * Rest Styling...
         */
        private $RESET_BOLD = "\033[21m";
        private $RESET_DIM = "\033[22m";
        private $RESET_UNDER_LINE = "\033[24m";
        private $RESET_BLINK = "\033[25m";
        private $RESET_INVERT = "\033[27m";
        private $RESET_HIDDEN = "\033[28m";

        /*
         * Default timezone offset...
         */
        private $timeZoneOffset = 19800;
        private $scriptBeginTime = 0;

        function __construct($fileReq)
        {
            /* -----------------------------------
             * Esc charectors:  \e OR \033  OR \x1B
             * echo "\033[96m\033[0m";
             */

            $this->LOGGER_STRING = "";
            $this->beginLogger($fileReq);

        }

        private function beginLogger($fileReq, $char = '*', $pageWidth = 80, $timeZoneOffSet = 19800)
        {
            $this->scriptBeginTime = microtime(true);
            $this->LOGGER_STRING .= "\n" . $this->LIGHT_CYAN;
            $this->LOGGER_STRING .= str_repeat($char, $pageWidth);
            $this->timeZoneOffset = $timeZoneOffSet;

            $this->LOGGER_STRING .= $this->RESET_ALL;
            $this->LOGGER_STRING .= $this->LIGHT_GRAY . "\n$fileReq: " . gmdate('Y-m-d H:i:s') . " - " . gmdate('Y-m-d H:i:s', gmmktime() + $this->timeZoneOffset);
            $this->LOGGER_STRING .= $this->RESET_ALL . "\n";

        }

        public function arrayLogger($array, $headerText = '')
        {
            $this->LOGGER_STRING .= $this->LIGHT_BLUE;
            $this->LOGGER_STRING .= (strlen($headerText) > 0) ? "\n" . $this->UNDER_LINE . $headerText . $this->RESET_UNDER_LINE . ":\n" : "";

            foreach ($array as $key => $value)
            {
                $this->LOGGER_STRING .= "   " . $key . ": " . $value . "\n";
            }

            $this->LOGGER_STRING .= $this->RESET_ALL . "\n";

        }

        public function arrayMultiLogger($array, $headerText = '')
        {
            $this->LOGGER_STRING .= $this->LIGHT_BLUE;
            $this->LOGGER_STRING .= (strlen($headerText) > 0) ? "\n" . $this->UNDER_LINE . $headerText . $this->RESET_UNDER_LINE . ":\n" : "";

            foreach ($array as $dataArray)
            {
                foreach ($dataArray as $key => $value)
                {
                    $this->LOGGER_STRING .= "   " . $key . ": " . $value . "\n";
                }
            }

            $this->LOGGER_STRING .= $this->RESET_ALL . "\n";

        }

        public function info($string)
        {
            $this->LOGGER_STRING .= $this->DEFAULT_FOREGROUND . $string . $this->RESET_ALL . "\n";

        }

        public function error($string)
        {
            $debug = array_shift(debug_backtrace());
            $this->LOGGER_STRING .= $this->LIGHT_RED . basename($debug['file']) . " (" . $debug['line'] . "): " . $string . $this->RESET_ALL . "\n";

        }

        public function warning($string)
        {
            $debug = array_shift(debug_backtrace());
            $this->LOGGER_STRING .= $this->LIGHT_YELLOW . basename($debug['file']) . " (" . $debug['line'] . "): " . $string . $this->RESET_ALL . "\n";

        }

        public function debug($string)
        {
            $debug = array_shift(debug_backtrace());
            $this->LOGGER_STRING .= $this->BLUE . basename($debug['file']) . " (" . $debug['line'] . "): " . $string . $this->RESET_ALL . "\n";

        }

        public function verbose($string)
        {
            $this->LOGGER_STRING .= $this->LIGHT_GRAY . $string . $this->RESET_ALL . "\n";

        }

        public function green($string)
        {
            $this->LOGGER_STRING .= $this->LIGHT_GREEN . $string . $this->RESET_ALL . "\n";

        }

        public function blink($string)
        {
            $this->LOGGER_STRING .= $this->BLINK . $string . $this->RESET_ALL . "\n";

        }

        public function bold($string)
        {
            $this->LOGGER_STRING .= $this->BOLD . $string . $this->RESET_ALL . "\n";

        }

        public function underLine($string)
        {
            $this->LOGGER_STRING .= $this->UNDER_LINE . $string . $this->RESET_ALL . "\n";

        }

        public function custom($string, $color = array(), $style = array())
        {
            foreach ($color as $code)
            {
                $this->LOGGER_STRING .= $code;
            }

            foreach ($style as $code)
            {
                $this->LOGGER_STRING .= $code;
            }

            $this->LOGGER_STRING .= $string;
            $this->LOGGER_STRING .= $this->RESET_ALL . "\n";

        }

        public function getLoggerString()
        {
            return $this->LOGGER_STRING;

        }

        public function endLogger()
        {
            $this->LOGGER_STRING .= $this->LIGHT_GRAY . "End at (" . $this->RESET_ALL . $this->BLUE . "" . round((microtime(true) - $this->scriptBeginTime), 4) . $this->RESET_ALL . $this->LIGHT_GRAY . "): " . gmdate('Y-m-d H:i:s') . " - " . gmdate('Y-m-d H:i:s', gmmktime() + $this->timeZoneOffset) . "\n";

            if ($this->LOGGER)
            {
                //$myFile = "/home/phabltqu/public_html/iSurpriseO/logger/iSurpriseO." . gmdate('Ymd') . ".log";
                
                $myFile = $_SERVER['DOCUMENT_ROOT']."/HomeMadeFood/ws/logger/hiwinErp." . gmdate('Ymd') . ".log";
                //echo $this->LOGGER_STRING;
                $fh = fopen($myFile, 'a') or die("can't open file");
                fwrite($fh, $this->LOGGER_STRING);
                fclose($fh);
            }

        }

        function __destruct()
        {
            unset($this->LOGGER_STRING);

        }

    }

?>