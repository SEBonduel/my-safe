<?php
namespace App\Controllers;

use App\Models\Secret;

class ApiController
{
    /**
     * Méthode pour lister les secrets (Verbe HTTP : GET)
     */
    public function index()
    {
        // 1. Connexion à la BDD (Comme d'habitude)
        $secretModel = new Secret();
        // 2. Récupération des données
        // ⚠ TRICHE PÉDAGOGIQUE :
        // Comme nous n'avons pas de navigateur, nous n'avons pas de cookie de session.
        // L'API ne sait pas qui nous sommes. Pour cet exercice d'intro,
        // on force l'affichage des secrets de l'utilisateur n°1.
        $secrets = $secretModel->getAllByUser(1);
        // 3. Nettoyage des données (Data Transformation)
        // On ne veut pas envoyer TOUT (ex: le mot de passe chiffré ne sert à rien à l'appli mobile).
        // On crée un tableau propre.
        $data = array_map(function ($secret) {
            return [
                'id' => $secret['id'],
                'titre' => $secret['title'],
                'login_asso' => $secret['login'], // On peut même renommer les clés si on veut !
                // On masque 'encrypted_password' par sécurité
            ];
        }, $secrets);
        // 4. Le Header "Carte d'Identité"
        // On dit au navigateur/client : "Attention, ce n'est pas du HTML, c'est du JSON !"
        header('Content-Type: application/json; charset=utf-8');
        // 5. Encodage et Envoi
        // json_encode transforme le tableau PHP en texte JSON
        echo json_encode([
            'status' => 'success',
            'nombre_resultats' => count($data),
            'donnees' => $data,
        ]);
        // 6. Arrêt immédiat
        // On s'assure que rien d'autre ne s'affiche après (pas de footer HTML, etc.)
        exit();
    }
}
