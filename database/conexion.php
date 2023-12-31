<?php

    class conexion{
        private $server;
        private $username;
        private $passowrd;
        private $database;

        public function __construct($server="localhost", $database="bdgenericos",$username="root", $passowrd="admin"){
            $this->server = $server;
            $this->database = $database;
            $this->username = $username;
            $this->passowrd = $passowrd;
        }
        public function conectar(){
            try{
                $connection = new PDO("mysql:host=". $this->server.";
                dbname=".$this->database,$this->username,$this->passowrd);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $connection;
            }catch(Exception $e){
                    echo "Error: " . $e->getMessage();
                    return null;
            }
        }

    }

?>