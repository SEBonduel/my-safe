# README.md
Bienvenue sur le projet My Safe

## Membres du projet
- Youcef

## Description
Application web PHP native, architecture MVC stricte, coffre-fort sécurisé pour secrets et mots de passe.

## Installation
1. Cloner le dépôt dans `c:/laragon/www/`.
2. Configurer le VirtualHost pour pointer sur le dossier `public`.
3. Générer la clé de chiffrement dans `config/secret.key`.
4. Importer la structure de la base de données.

## Utilisation
- Accéder à `http://my-safe.test/register` pour s’inscrire.
- Accéder à `http://my-safe.test/login` pour se connecter.

## Sécurité
- Mots de passe hachés (Argon2id).
- Secrets chiffrés (AES-256-GCM).
- Sessions blindées (HttpOnly, SameSite=Strict).

---