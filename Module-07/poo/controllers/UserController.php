<?php
require_once 'models/User.php';

class UserController {
    public function register() {
       
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérifier le jeton CSRF
            functions\verifyCsrfToken();
    
            // Récupérer les données du formulaire
            $nom = functions\sanitizeInput($_POST['nom']);
            $prenom = functions\sanitizeInput($_POST['prenom']);
            $adresse = functions\sanitizeInput($_POST['adresse']);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
    
            // Valider le formulaire
            $errors = functions\validateRegistrationForm($nom, $prenom, $adresse, $email, $password, $confirmPassword);
    
            // Si des erreurs sont présentes, afficher le formulaire avec les erreurs
            if (!empty($errors)) {
                // Ajouter les erreurs au tableau de données pour les afficher dans le formulaire
                $data['errors'] = $errors;
                include_once 'vue/register.php';
            } else {
                // Appeler la fonction pour enregistrer l'utilisateur
                $error = registerUser($nom, $prenom, $adresse, $email, $password, $confirmPassword);
    
                // Si l'enregistrement est réussi, rediriger vers la page de connexion
                if ($error === true) {
                    header("Location: index.php?action=login");
                    exit();
                } else {
                    // En cas d'erreur, afficher le message d'erreur sur la page d'inscription
                    // Ajouter le message d'erreur au tableau de données pour l'afficher dans le formulaire
                    $data['error'] = $error;
                    include_once 'vue/register.php';
                }
            }
        } else {
            // Afficher le formulaire d'inscription si la requête n'est pas de type POST
            include_once 'vue/register.php';
        }
    }

    public function login() {
        echo "login";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérifier le jeton CSRF ici avant d'appeler loginUser
            functions\verifyCsrfToken();
    
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
    
            $error = loginUser($email, $password);
    
            if($error === true){
                header("Location: index.php?action=dashboard");
                exit();
            } else {
                include_once 'vue/login.php';
            }
        } else {
            include_once 'vue/login.php';
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            \functions\verifyCsrfToken();
    
            $id = $_SESSION['user_id'];
            $nom = functions\sanitizeInput($_POST['nom']);
            $prenom = functions\sanitizeInput($_POST['prenom']);
            $adresse = functions\sanitizeInput($_POST['adresse']);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
    
            $errors = functions\validateRegistrationForm($nom, $prenom, $adresse, $email, $password, $confirmPassword);
    
            if (!empty($errors)) {
                $data['errors'] = $errors;
                include_once 'vue/update.php';
            } else {
    
                $error = updateUserInfo($id, $nom, $prenom,$adresse, $email, $password, $confirmPassword);
    
                if ($error === true) {
                    header("Location: index.php?action=dashboard");
                    exit();
                } else {
                    include_once 'vue/update.php';
                }
            }
    
        } else {
            include_once 'templates/update.php';
        }
    }

    public function close() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_SESSION['user_id'];
    
            functions\verifyCsrfToken();
    
            closeAccount($id);
    
            session_destroy();
    
            header("Location: index.php");
            exit();
        }
    }

    public function logout() {
          // Détruire la session
    session_destroy();

    // Rediriger vers la page d'accueil
    header("Location: index.php");
    exit();
    }
}
?>
