<?php
// --- Connexion à la base de données ---
$host = '******';
$db   = '******';
$user = '******';
$pass = '******';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    exit("Erreur de connexion à la base de données : " . htmlspecialchars($e->getMessage()));
}

// --- Vérification des champs requis ---
$required = ['id', 'mail', 'tel', 'adrs', 'mdp', 'nom', 'prenom', 'cp', 'ville'];
foreach ($required as $field) {
    if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
        exit("❌ Erreur : Le champ '$field' est obligatoire et ne peut pas être vide !");
    }
}

// --- Vérification des assurances ---
if (!isset($_POST['assurances']) || !is_array($_POST['assurances']) || empty($_POST['assurances'])) {
    exit("❌ Erreur : Veuillez sélectionner au moins une assurance !");
}

// --- Récupération des valeurs du formulaire ---
$id       = trim($_POST['id']);
$mail     = trim($_POST['mail']);
$tel      = trim($_POST['tel']);
$adrs     = trim($_POST['adrs']);
$mdp_raw  = $_POST['mdp'];
$nom      = trim($_POST['nom']);
$prenom   = trim($_POST['prenom']);
$cp       = trim($_POST['cp']);
$ville    = trim($_POST['ville']);
$assurances = $_POST['assurances']; // Tableau des IDs d'assurances

// --- Validations ---

// Identifiant (minimum 3 caractères)
if (strlen($id) < 3) {
    exit("❌ Erreur : L'identifiant doit contenir au moins 3 caractères !");
}

// Email
if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    exit("❌ Erreur : Adresse e-mail invalide !");
}

// Téléphone (10 chiffres uniquement)
if (!preg_match('/^[0-9]{10}$/', $tel)) {
    exit("❌ Erreur : Le numéro de téléphone doit contenir exactement 10 chiffres !");
}

// Code postal (5 chiffres uniquement)
if (!preg_match('/^[0-9]{5}$/', $cp)) {
    exit("❌ Erreur : Le code postal doit contenir exactement 5 chiffres !");
}

// Mot de passe (minimum 6 caractères)
if (strlen($mdp_raw) < 6) {
    exit("❌ Erreur : Le mot de passe doit contenir au moins 6 caractères !");
}

// --- Vérifier si l'email ou l'identifiant existe déjà ---
$check = $pdo->prepare("SELECT COUNT(*) FROM info WHERE mail = :mail OR id = :id");
$check->execute(['mail' => $mail, 'id' => $id]);
if ($check->fetchColumn() > 0) {
    exit("❌ Erreur : Cette adresse e-mail ou cet identifiant est déjà utilisé !");
}

// --- Préparation des assurances (format "1,3,5") ---
$id_contract = implode(',', array_map('intval', $assurances));

// --- Hash du mot de passe ---
$mdp_hache = password_hash($mdp_raw, PASSWORD_DEFAULT);

// --- Rôle par défaut : visiteur (id = 3 dans la table role) ---
$role_id = 3;

// --- Insertion dans la base ---
try {
    $sql = "INSERT INTO info (id, mail, tel, adrs, mdp, nom, prenom, cp, ville, role_id, id_contract)
            VALUES (:id, :mail, :tel, :adrs, :mdp, :nom, :prenom, :cp, :ville, :role_id, :id_contract)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'id' => $id,
        'mail' => $mail,
        'tel' => $tel,
        'adrs' => $adrs,
        'mdp' => $mdp_hache,
        'nom' => $nom,
        'prenom' => $prenom,
        'cp' => $cp,
        'ville' => $ville,
        'role_id' => $role_id,
        'id_contract' => $id_contract
    ]);

    // ✅ Redirection vers la page de connexion avec message de succès
    header("Location: connexion.php?success=inscription");
    exit();

} catch (PDOException $e) {
    exit("❌ Erreur lors de l'inscription : " . htmlspecialchars($e->getMessage()));
}
?>