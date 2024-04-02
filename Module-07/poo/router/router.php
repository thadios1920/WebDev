<?php
require_once 'controllers/UserController.php';
require_once 'controllers/HomeController.php';

session_start();

// Point d'entrée de l'application
// Gestion des routes
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $userController = new UserController();
    $homeController = new HomeController();

    switch ($action) {
        case 'register':
            $userController->register();
            break;
        case 'login':
            $userController->login();
            break;
        case 'dashboard':
            $userController->dashboard();
            break;
        case 'update':
            $userController->update();
            break;
        case 'close':
            $userController->close();
            break;
        case 'logout':
            $userController->logout();
            break;
        default:
            $userController->index();
            break;
    }
} else {
    $homeController = new HomeController();
    $homeController->index();
}
?>
