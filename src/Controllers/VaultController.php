<?php

namespace Controllers;

use Models\Secret;

class VaultController
{
    private $secretModel;

    public function __construct($db)
    {
        $this->secretModel = new Secret($db);
    }

    // Récupérer tous les secrets de l'utilisateur
    public function getSecrets($user_id)
    {
        return $this->secretModel->getAll($user_id);
    }

    // Ajouter un secret
    public function addSecret($user_id, $title, $login, $password)
    {
        // Optionnel : valider les champs ici
        return $this->secretModel->add($user_id, $title, $login, $password);
    }

    // Supprimer un secret
    public function deleteSecret($id, $user_id)
    {
        return $this->secretModel->delete($id, $user_id);
    }
}
?>