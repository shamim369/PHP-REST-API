<?php

    include "Config.php";

    class DB{
            
        public static $localhost = DB_SERVER;
        public static $db_username = DB_USERNAME;
        public static $db_password = DB_PASSWORD;
        public static $db_database = DB_NAME;
        public static $options = array( PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' );
        
        private static $conn;

        // DATABASE CONNECTION
        public static function connection(){
            if (!isset(self::$conn)){
                try{
                    self::$conn = new PDO("mysql:host=" . self::$localhost . ";dbname=" . self::$db_database, self::$db_username, self::$db_password, self::$options);
                    self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    // echo "Connect Successfully. Host info: " . self::$conn->getAttribute(constant("PDO::ATTR_CONNECTION_STATUS"));
                } catch(PDOException $e){
                    die("ERROR: Could not connect. " . $e->getMessage());
                }
            }
            return self::$conn;
        }
        
        // PREPARED STATEMENT
        public static function prepare($sql){
            return self::connection()->prepare($sql);
        }
    }

    DB::connection();

?>
