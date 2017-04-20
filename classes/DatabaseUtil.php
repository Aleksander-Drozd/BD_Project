<?php

class DatabaseUtil{
    /** @var PDO */
    private static $connection;

    public static function connect(){
        $config = parse_ini_file('../php/databaseConfig.ini');

        try {
            self::$connection = new PDO("host={$config['host']};dbname={$config['dbName']}", $config['dbUser'], $config['dbPassword']);
            self::$connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            echo $e;
        }
    }

    public static function prepare($query){
        self::establishConnectionIfNecessary();

        return self::$connection -> prepare($query);
    }

    private static function establishConnectionIfNecessary(){
        if (self::$connection == null) {
            self::connect();
        }
    }
}