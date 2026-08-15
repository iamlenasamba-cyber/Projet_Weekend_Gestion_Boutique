<?php

class Database{
        private static ?Database $instance = null;
         private PDO $connexion;

            private function __construct()
            {
            $this->connexion = $this->connecter();
        }

    public static function getInstance(): Database{ 
             if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnexion(): PDO
    {
        return $this->connexion;
    }
      private function connecter(): PDO
     {
        try {
               $db = "pgsql:host=localhost;port=5432;dbname=gestionboutique";
            return new PDO($db, 'lena', 'Sokhnadiouf6', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);

            } catch (PDOException $e) {
                try {
                    $sqlPath = dirname(__DIR__, 2) . '/db/erp.db';
                    $pdo = new PDO("sqlite:" . $sqlPath, null, null, [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);


                $pdo->exec("PRAGMA foreign_keys = ON;");
                         return $pdo;

                    }
                
                    
                    
                    catch (PDOException $ex) {
                        die("Erreur de connexion : " . $ex->getMessage());
                    }
        }
    }
}