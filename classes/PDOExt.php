<?php

    class PDOExt extends PDO
    {

        private $link, $dbType, $dbHost, $dbName, $dbUser, $dbPass;
        private $errorMessage;

        public function __construct()
        {
            $this->dbHost = "127.0.0.1";
            $this->dbName = "homemadefood";
            $this->dbUser = "root";
            $this->dbPass = "root";
            $this->dbType = "mysql";
            $this->port = "3306";
            
            try
            {
                $this->link = parent::__construct("$this->dbType:host=$this->dbHost;port=$this->port;dbname=$this->dbName", $this->dbUser, $this->dbPass, array(PDO::ATTR_PERSISTENT => FALSE));
            }
            catch (PDOException $exc)
            {
                echo $this->errorMessage = $exc;
            }

        }

        public function __destruct()
        {
            /*
             * Destructor
             *
             * Closes the connection to the database
             * @return null
             */

            if ($this->link != null)
                $this->link = null;

        }

    }

?>