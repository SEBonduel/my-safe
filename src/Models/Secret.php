<?php

Namespace Models;

use PDO;
use Crypto;


class Secret {

    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Ajouter un secret
 public function add($user_id, $title, $login, $password)
{
    $crypto = new Crypto($yourEncryptionKey); // Charge la clé depuis un fichier sécurisé
    $encryptedPassword = $crypto->encrypt($password);
    $stmt = $this->db->prepare("INSERT INTO secrets (user_id, title, login, password) VALUES (:user_id, :title, :login, :password)");
    return $stmt->execute([
        'user_id' => $user_id,
        'title' => $title,
        'login' => $login,
        'password' => $encryptedPassword
    ]);
}

    //Voir un secret par son ID
   public function getAll($user_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM secrets WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

// Supprimer un secret
    public function delete($id, $user_id)
    {
     $stmt = $this->db->prepare("DELETE FROM secrets WHERE id = :id AND user_id = :user_id");
     return $stmt->execute(['id' => $id, 'user_id' => $user_id]);
    }

}

?>