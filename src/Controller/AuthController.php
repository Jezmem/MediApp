<?php

namespace App\Controller;

use App\Database\UserDatabase;

class AuthController extends AbstractController
{
    private UserDatabase $userDatabase;

    public function __construct()
    {
        $this->userDatabase = new UserDatabase();
    }

    /**
     * Affiche la page de connexion.
     */
    public function loginPage(): string
    {
        return $this->render('connexion/login.php');
    }

    /**
     * Gère la tentative de connexion de l'utilisateur.
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userDatabase->getUserByUsername($username);

            if ($user && password_verify($password, $user->getPassword())) {
                var_dump("tes dedans");
                session_start();
                $_SESSION['user_id'] = $user->getId();

                $this->redirectToUrl('/dashboard');
            } else {
                $error = "Identifiant ou mot de passe incorrect";
                echo $this->render('connexion/login.php', ['error' => $error]);
            }
        }
    }

    /**
     * Déconnecte l'utilisateur et détruit la session.
     */
    public function logout(): void
    {
        session_start();
        session_unset();
        session_destroy();

        $this->redirectToUrl('/');
    }
}
