<?php
session_start();

// Connexion à la base
$host = '******';
$db   = '******';
$user = '******';
$pass = '******';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Erreur de connexion à la base : " . $e->getMessage());
}

// Vérification que le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: connexion.php");
    exit;
}

// Vérification des champs
if (!isset($_POST['id']) || !isset($_POST['mdp'])) {
    header("Location: connexion.php?error=missing");
    exit;
}

$identifiant = trim($_POST['id']);
$motdepasse = $_POST['mdp'];

// Requête pour récupérer toutes les infos utilisateur
$stmt = $pdo->prepare("
    SELECT i.ids, i.id, i.nom, i.prenom, i.mail, i.tel, i.adrs, i.cp, i.ville, i.mdp, i.role_id, r.libelle as role_libelle
    FROM info i
    LEFT JOIN role r ON i.role_id = r.id
    WHERE i.id = :id
");
$stmt->execute(['id' => $identifiant]);

$user = $stmt->fetch();

// Vérification de l'utilisateur
if (!$user) {
    header("Location: connexion.php?error=invalid");
    exit;
}

// Vérification du mot de passe
if (!password_verify($motdepasse, $user['mdp'])) {
    header("Location: connexion.php?error=invalid");
    exit;
}

// ✅ Connexion réussie : stockage dans la session
$_SESSION['user'] = [
    'ids' => $user['ids'],
    'id' => $user['id'],
    'nom' => $user['nom'],
    'prenom' => $user['prenom'],
    'mail' => $user['mail'],
    'tel' => $user['tel'],
    'adrs' => $user['adrs'],
    'cp' => $user['cp'],
    'ville' => $user['ville'],
    'role_id' => $user['role_id'],
    'role_libelle' => $user['role_libelle']
];

// Redirection selon le rôle
switch ($user['role_id']) {
    case 1: // Administrateur
        header("Location: admin.php");
        break;
    case 2: // Collaborateur
        header("Location: collaborateur.php");
        break;
    case 3: // Client/Visiteur
    default:
        header("Location: interface.php");
        break;
}
exit;
?>