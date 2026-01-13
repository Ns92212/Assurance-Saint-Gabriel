# 🛡️ Assurances Saint Gabriel (ASG)

Plateforme web de gestion et de souscription d'assurances réalisée dans le cadre d'une refonte numérique complète. Ce projet transforme un site vitrine statique en une application dynamique, sécurisée et maintenable.

## 📋 Contexte du projet

Suite à la fusion de plusieurs entités et au rachat par un groupe suisse, les **Assurances Saint Gabriel** (Bagneux, France) modernisent leur système d'information. L'objectif est de digitaliser la relation client et de sécuriser les données sensibles conformément aux normes actuelles (RGPD, Sécurité Web).

## 🚀 Fonctionnalités Clés

Le projet est construit autour de 4 rôles utilisateurs distincts :

### 👤 Espace Public & Visiteur
* **Vitrine :** Présentation de l'entreprise et des valeurs.
* **Catalogue :** Consultation dynamique des types de contrats disponibles (Auto, Habitation, Santé, etc.).
* **Actualités :** Système de news géré par l'administration.
* **Inscription :** Création de compte sécurisée avec vérification des données (JS & PHP).

### 🔐 Espace Client (Assuré)
* **Tableau de bord :** Vue d'ensemble des contrats souscrits.
* **Gestion de profil :** Modification des coordonnées (Adresse, Téléphone, etc.).
* **Sécurité :** Modification du mot de passe et identification de son conseiller attitré.

### 💼 Espace Collaborateur
* **Gestion de portefeuille :** Accès restreint uniquement aux clients possédant des contrats gérés par le collaborateur (Logique de permission stricte).
* **Modification Client :** Mise à jour des informations des assurés.
* **Statistiques :** Vue globale sur le nombre de clients et contrats gérés.

### 🛠️ Espace Administrateur
* **Gestion des Utilisateurs :** CRUD complet (Créer, Lire, Mettre à jour, Supprimer) sur les comptes.
* **Gestion des Actualités :** Publication et suppression d'articles.
* **Supervision :** Vue globale sur l'ensemble du système.

## 💻 Stack Technique

* **Langage Backend :** PHP 8 (Architecture MVC / Orientée Objet).
* **Base de données :** MySQL (PDO, Requêtes préparées).
* **Frontend :** HTML5, CSS3, JavaScript (Validation formulaires).
* **Framework CSS :** Bootstrap 5 (Responsive Design).
* **Sécurité :**
    * Hachage des mots de passe (`password_hash`).
    * Protection contre les injections SQL (`prepare`/`execute`).
    * Protection XSS (`htmlspecialchars`).
    * Gestion des sessions et redirection par rôles.

## 🗂️ Structure du projet (MVC)

Le projet suit une organisation logique pour faciliter la maintenance :

```text
/
├── config/          # Configuration BDD sécurisée
├── controllers/     # Logique de traitement (Auth, User)
├── models/          # Interactions avec la base de données
├── views/           # Interfaces utilisateurs (Admin, Client, etc.)
├── assets/          # CSS, JS, Images
└── index.php        # Routeur principal
