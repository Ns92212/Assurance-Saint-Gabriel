<?php
session_start();

// Vérifier si l'utilisateur est connecté et est client (role_id = 3)
if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 3) {
    header("Location: connexion.php");
    exit();
}

// Connexion à la base de données
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
    exit("Erreur de connexion : " . htmlspecialchars($e->getMessage()));
}

$message = '';
$error = '';
$client_id = $_SESSION['user']['ids'];

// Modification des informations du client
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier_infos'])) {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $mail = trim($_POST['mail']);
    $tel = trim($_POST['tel']);
    $adrs = trim($_POST['adrs']);
    $cp = trim($_POST['cp']);
    $ville = trim($_POST['ville']);
    
    try {
        $stmt = $pdo->prepare("
            UPDATE info 
            SET nom = :nom, prenom = :prenom, mail = :mail, tel = :tel, adrs = :adrs, cp = :cp, ville = :ville
            WHERE ids = :ids
        ");
        $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'mail' => $mail,
            'tel' => $tel,
            'adrs' => $adrs,
            'cp' => $cp,
            'ville' => $ville,
            'ids' => $client_id
        ]);
        
        // Mettre à jour la session
        $_SESSION['user']['nom'] = $nom;
        $_SESSION['user']['prenom'] = $prenom;
        $_SESSION['user']['mail'] = $mail;
        $_SESSION['user']['tel'] = $tel;
        $_SESSION['user']['adrs'] = $adrs;
        $_SESSION['user']['cp'] = $cp;
        $_SESSION['user']['ville'] = $ville;
        
        $message = "Vos informations ont été mises à jour avec succès !";
    } catch (PDOException $e) {
        $error = "Erreur lors de la mise à jour : " . $e->getMessage();
    }
}

// Modification du mot de passe
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier_mdp'])) {
    $ancien_mdp = $_POST['ancien_mdp'];
    $nouveau_mdp = $_POST['nouveau_mdp'];
    $confirmer_mdp = $_POST['confirmer_mdp'];
    
    // Récupérer le mot de passe actuel
    $stmt = $pdo->prepare("SELECT mdp FROM info WHERE ids = :ids");
    $stmt->execute(['ids' => $client_id]);
    $user_data = $stmt->fetch();
    
    if (password_verify($ancien_mdp, $user_data['mdp'])) {
        if ($nouveau_mdp === $confirmer_mdp) {
            if (strlen($nouveau_mdp) >= 6) {
                $hashed_password = password_hash($nouveau_mdp, PASSWORD_DEFAULT);
                $update = $pdo->prepare("UPDATE info SET mdp = :mdp WHERE ids = :ids");
                $update->execute(['mdp' => $hashed_password, 'ids' => $client_id]);
                $message = "Votre mot de passe a été modifié avec succès !";
            } else {
                $error = "Le nouveau mot de passe doit contenir au moins 6 caractères.";
            }
        } else {
            $error = "Les mots de passe ne correspondent pas.";
        }
    } else {
        $error = "L'ancien mot de passe est incorrect.";
    }
}

// Récupération des informations du client
$client_query = $pdo->prepare("
    SELECT ids, id, nom, prenom, mail, tel, adrs, cp, ville, id_contract, id_collaborateur_responsable
    FROM info
    WHERE ids = :client_id
");
$client_query->execute(['client_id' => $client_id]);
$client_info = $client_query->fetch();

// Récupération des assurances du client
$mes_assurances = [];
$nb_contrats = 0;
if (!empty($client_info['id_contract'])) {
    $contract_ids = explode(',', $client_info['id_contract']);
    $nb_contrats = count($contract_ids);
    $placeholders = implode(',', array_fill(0, count($contract_ids), '?'));
    
    $assurances_query = $pdo->prepare("
        SELECT id_contrat, nom_assurance, type_contrat
        FROM contrat
        WHERE id_contrat IN ($placeholders)
        ORDER BY nom_assurance
    ");
    $assurances_query->execute($contract_ids);
    $mes_assurances = $assurances_query->fetchAll();
}

// Récupération des informations du collaborateur responsable
$collaborateur_info = null;
if (!empty($client_info['id_collaborateur_responsable'])) {
    $collab_query = $pdo->prepare("
        SELECT nom, prenom, mail, tel
        FROM info
        WHERE ids = :collab_id
    ");
    $collab_query->execute(['collab_id' => $client_info['id_collaborateur_responsable']]);
    $collaborateur_info = $collab_query->fetch();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Mon Espace Client - Assurances Saint Gabriel</title>
    <link rel="