<?php
namespace App\Database;
require_once '../config/config.php';


final readonly class Database
{

    public static function getInstance(): \PDO
    {
        try {
            $user = getenv('DB_USERNAME');
            $pass = getenv('DB_PASSWORD');
            $dbName = getenv('DB_NAME');
            $dbHost = getenv('DB_HOST');
            $connexion = new \PDO("mysql:host=$dbHost;dbname=$dbName;charset=UTF8", $user, $pass);
        } catch (\Exception $exception) {
            echo 'Erreur lors de la connexion à la base de données. : ' . $exception->getMessage();
            exit;
        }

        return $connexion;
    }
}