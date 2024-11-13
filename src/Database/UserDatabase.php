<?php

namespace App\Database;

use App\Models\User;
use PDO;

class UserDatabase
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    /**
     * Récupère un utilisateur par son nom d'utilisateur.
     *
     * @param string $username Le nom d'utilisateur à rechercher.
     * @return User|null L'utilisateur trouvé ou null si aucun utilisateur n'existe avec ce nom d'utilisateur.
     */
    public function getUserByUsername(string $username): ?User
    {
        $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new User(
                $result['id'],
                $result['username'],
                $result['password']
            );
        }

        return null;
    }

}
