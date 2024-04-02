<?php
class Database {
    private $host = "localhost"; // L'hôte de la base de données
    private $dbname = "siea_web"; // Le nom de la base de données
    private $user = "postgres"; // Votre nom d'utilisateur PostgreSQL
    private $pass = "root"; // Votre mot de passe PostgreSQL

    public function dbConnect() {
        try {
            $conn = new PDO("pgsql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            die("Échec de la connexion à la base de données : " . $e->getMessage());
        }
    }
}
?>
