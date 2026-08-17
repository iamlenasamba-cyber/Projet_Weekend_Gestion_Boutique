<?php

class Database
{
    private static ?PDO $connexion = null;
    private function __construct() {}
    public static function getConnexion(): PDO
    {
        if (self::$connexion === null) {
            try {
                $db = "pgsql:host=localhost;port=5432;dbname=gestionboutique";
                self::$connexion = new PDO($db, 'lena', 'Sokhnadiouf6', [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);

            } catch (PDOException $e) {
                try {
                    $sqlPath = dirname(__DIR__, 2) . '/db/erp.db';
                    self::$connexion = new PDO("sqlite:" . $sqlPath, null, null, [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]);
                    self::$connexion->exec("PRAGMA foreign_keys = ON;");

                } catch (PDOException $ex) {
                    die("Erreur de connexion : " . $ex->getMessage());
                }
            }
        }

        return self::$connexion;
    }
}