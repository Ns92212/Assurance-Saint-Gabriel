<?php
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    /**
     * Affiche le formulaire de connexion
     */
    public function loginForm()
    {
        require __DIR__ . '/../views/connexion.php';
    }

    /**
     * Traite la connexion utilisateur
     */
    public function login()
    {
        // ⚠️ Ne pas faire session_start() ici (déjà fait dans index.php)
        
        $userModel = new User();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $password = trim($_POST['password']);

            $user = $userModel->login($id, $password);

            if ($user) {
                // ✅ Stocker TOUTES les infos dans $_SESSION['user']
                $_SESSION['user'] = [
                    'ids' => $user['ids'],
                    'id' => $user['id'],
                    'prenom' => $user['prenom'],
                    'nom' => $user['nom'],
                    'mail' => $user['mail'],
                    'role_id' => $user['role_id'],
                    'role_libelle' => $user['role_libelle'] // ⚠️ À récupérer depuis User.php
                ];

                // ✅ Redirection selon le rôle
                switch ($user['role_id']) {
                    case 1: // Admin
                        header("Location: index.php?page=admin");
                        break;
                    case 2: // Collaborateur
                        header("Location: index.php?page=collaborator");
                        break;
                    case 3: // Client
                        header("Location: index.php?page=interface");
                        break;
                    default:
                        header("Location: index.php?page=home");
                }
                exit;
            } else {
                $_SESSION['error'] = "Identifiant ou mot de passe incorrect.";
                header("Location: index.php?page=connexion");
                exit;
            }
        } else {
            $this->loginForm();
        }
    }

    /**
     * Déconnexion
     */
    public function logout()
    {
        // ⚠️ Pas besoin de session_start() ici non plus
        $_SESSION = [];
        session_destroy();
        header("Location: index.php?page=connexion");
        exit;
    }

    /**
     * Inscription d'un nouveau client
     */
    public function register()
    {
        $userModel = new User();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => trim($_POST['id']),
                'nom' => trim($_POST['nom']),
                'prenom' => trim($_POST['prenom']),
                'mail' => trim($_POST['mail']),
                'tel' => trim($_POST['tel']),
                'adrs' => trim($_POST['adrs']),
                'cp' => trim($_POST['cp']),
                'ville' => trim($_POST['ville']),
                'mdp' => password_hash(trim($_POST['mdp']), PASSWORD_DEFAULT), // ✅ Hash du MDP
                'id_contract' => null,
                'role_id' => 3, // ✅ Par défaut : client
                'id_collaborateur_responsable' => null // ✅ Sera assigné plus tard par un admin
            ];

            try {
                $userModel->createUser($data);

                $_SESSION['success'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                header("Location: index.php?page=connexion");
                exit;
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header("Location: index.php?page=inscription");
                exit;
            }
        } else {
            require __DIR__ . '/../views/inscription.php';
        }
    }
}