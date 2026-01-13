# 🛡️ Assurances Saint Gabriel (ASG)

Application web de gestion d'assurances développée en PHP natif. Ce projet permet la gestion des contrats, des clients et des collaborateurs via des interfaces dédiées et sécurisées.

## 📋 Contexte

Projet réalisé dans le cadre d'une refonte numérique pour les **Assurances Saint Gabriel**. L'application remplace un site vitrine statique par une solution dynamique permettant :
* L'inscription et la connexion des assurés.
* La gestion de portefeuille pour les collaborateurs.
* Une administration complète (utilisateurs, actualités).

## 🛠 Technologies utilisées

* **Backend :** PHP 8 (Procédural)
* **Base de données :** MySQL
* **Frontend :** HTML5, CSS3, JavaScript
* **Framework CSS :** Bootstrap 5
* **Sécurité :** `.htaccess`, `password_hash`, requêtes préparées (PDO)

## 📂 Structure du projet

L'architecture du projet est organisée de manière fonctionnelle à la racine :

### 🔹 Cœur de l'application
* `index.php` : Page d'accueil (Actualités et Présentation).
* `config_db.php` : Configuration et connexion à la base de données (Sécurisé).
* `navbar.php` : Menu de navigation dynamique (s'adapte selon le rôle connecté).
* `footer.php` : Pied de page commun.
* `logout.php` : Script de déconnexion.
* `.htaccess` : Sécurisation du serveur et protection des fichiers sensibles.

### 🔹 Pages Publiques (Vitrine)
* `about.php` : Présentation des activités.
* `products.php` : Liste des contrats d'assurance disponibles.
* `crew.php` : Présentation de l'équipe.
* `contact.php` : Formulaire de contact.
* `mentions-legales.php` : Informations juridiques.

### 🔹 Espaces Connectés
* **Admin** (`admin.php`) : Gestion globale des utilisateurs et des actualités.
* **Collaborateur** (`collaborateur.php`) : Gestion des clients ayant souscrit aux assurances gérées par le collaborateur.
* **Client** (`interface.php`) : Espace personnel de l'assuré (visu contrats, modif profil).

### 🔹 Authentification
* `inscription.php` : Formulaire de création de compte (avec validation JS).
* `connexion.php` : Formulaire d'identification.
* `verif.php` : Script de traitement de l'inscription.

## 🚀 Installation locale

1.  **Cloner le dépôt :**
    ```bash
    git clone [https://github.com/TON_NOM_UTILISATEUR/Assurances-Saint-Gabriel.git](https://github.com/TON_NOM_UTILISATEUR/Assurances-Saint-Gabriel.git)
    ```

2.  **Base de données :**
    * Créer une base de données (ex: `asg_project`).
    * Importer le fichier SQL (si disponible) ou créer les tables `info` (utilisateurs), `contrat`, `actualites`, `role`.

3.  **Configuration :**
    * Ouvrir `config_db.php`.
    * Modifier les identifiants (`$host`, `$db`, `$user`, `$pass`) avec vos paramètres locaux.

4.  **Lancement :**
    * Placer le dossier dans votre serveur local (WAMP/XAMPP/MAMP).
    * Accéder via `http://localhost/Assurances-Saint-Gabriel`.

## 🔐 Gestion des Rôles

Le système gère 3 niveaux d'accès via la table `role` :
1.  **Administrateur** (ID 1) : Accès total.
2.  **Collaborateur** (ID 2) : Accès restreint à ses propres clients.
3.  **Client** (ID 3) : Accès à son profil personnel.

---
*Projet réalisé à des fins pédagogiques.*
