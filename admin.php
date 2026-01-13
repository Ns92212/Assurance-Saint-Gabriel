<?php
session_start();

// Vérifier si l'utilisateur est connecté et est admin (role_id = 1)
if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 1) {
    header("Location: connexion.php");
    exit();
}

// Connexion à la base de données
$host = '******';
$db   = '******';
$user = '******';
$pass = '******';

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

// Gestion des actions
$message = '';
$error = '';

// Modification d'un utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier_user'])) {
    $user_ids = intval($_POST['user_ids']);
    $id = trim($_POST['id']);
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $mail = trim($_POST['mail']);
    $tel = trim($_POST['tel']);
    $adrs = trim($_POST['adrs']);
    $cp = trim($_POST['cp']);
    $ville = trim($_POST['ville']);
    $role_id = intval($_POST['role_id']);
    
    // Récupération des assurances sélectionnées
    $id_contract = '';
    if (isset($_POST['assurances']) && is_array($_POST['assurances']) && !empty($_POST['assurances'])) {
        $id_contract = implode(',', $_POST['assurances']);
    }
    
    try {
        $stmt = $pdo->prepare("
            UPDATE info 
            SET id = :id, nom = :nom, prenom = :prenom, mail = :mail, tel = :tel, 
                adrs = :adrs, cp = :cp, ville = :ville, role_id = :role_id, id_contract = :id_contract
            WHERE ids = :ids
        ");
        $stmt->execute([
            'id' => $id,
            'nom' => $nom,
            'prenom' => $prenom,
            'mail' => $mail,
            'tel' => $tel,
            'adrs' => $adrs,
            'cp' => $cp,
            'ville' => $ville,
            'role_id' => $role_id,
            'id_contract' => $id_contract,
            'ids' => $user_ids
        ]);
        $message = "Utilisateur modifié avec succès !";
        
        // Recharger la session si c'est l'admin qui se modifie lui-même
        if ($user_ids == $_SESSION['user']['ids']) {
            $_SESSION['user']['id'] = $id;
            $_SESSION['user']['nom'] = $nom;
            $_SESSION['user']['prenom'] = $prenom;
            $_SESSION['user']['mail'] = $mail;
            $_SESSION['user']['tel'] = $tel;
            $_SESSION['user']['adrs'] = $adrs;
            $_SESSION['user']['cp'] = $cp;
            $_SESSION['user']['ville'] = $ville;
            $_SESSION['user']['role_id'] = $role_id;
        }
    } catch (PDOException $e) {
        $error = "Erreur lors de la modification : " . $e->getMessage();
    }
}

// Suppression d'un utilisateur
if (isset($_GET['delete_user'])) {
    $ids = intval($_GET['delete_user']);
    
    // Empêcher l'admin de se supprimer lui-même
    if ($ids == $_SESSION['user']['ids']) {
        $error = "Vous ne pouvez pas supprimer votre propre compte !";
    } else {
        try {
            $stmt = $pdo->prepare("DELETE FROM info WHERE ids = :ids");
            $stmt->execute(['ids' => $ids]);
            $message = "Utilisateur supprimé avec succès !";
        } catch (PDOException $e) {
            $error = "Erreur lors de la suppression : " . $e->getMessage();
        }
    }
}

// Suppression d'une actualité
if (isset($_GET['delete_actu'])) {
    $id_actu = intval($_GET['delete_actu']);
    try {
        $stmt = $pdo->prepare("DELETE FROM actualites WHERE id = :id");
        $stmt->execute(['id' => $id_actu]);
        $message = "Actualité supprimée avec succès !";
    } catch (PDOException $e) {
        $error = "Erreur lors de la suppression : " . $e->getMessage();
    }
}

// Ajout d'une actualité
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_actualite'])) {
    $titre = trim($_POST['titre']);
    $texte = trim($_POST['texte']);
    $image = trim($_POST['image']);
    
    if (!empty($titre) && !empty($texte)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO actualites (titre, texte, photo, date_publication) VALUES (:titre, :texte, :photo, NOW())");
            $stmt->execute([
                'titre' => $titre,
                'texte' => $texte,
                'photo' => $image
            ]);
            $message = "Actualité ajoutée avec succès !";
        } catch (PDOException $e) {
            $error = "Erreur lors de l'ajout : " . $e->getMessage();
        }
    } else {
        $error = "Le titre et le texte sont obligatoires !";
    }
}

// Récupération de tous les rôles
$roles = $pdo->query("SELECT id, libelle FROM role ORDER BY id")->fetchAll();

// Récupération de toutes les assurances disponibles
$assurances = $pdo->query("SELECT id_contrat, nom_assurance FROM contrat ORDER BY nom_assurance")->fetchAll();

// Récupération de tous les utilisateurs avec leur rôle
$users = $pdo->query("
    SELECT i.ids, i.id, i.nom, i.prenom, i.mail, i.tel, i.adrs, i.cp, i.ville, i.role_id, i.id_contract, r.libelle as role_libelle
    FROM info i
    LEFT JOIN role r ON i.role_id = r.id
    ORDER BY i.ids DESC
")->fetchAll();

// Récupération de toutes les actualités
$actualites = $pdo->query("
    SELECT * FROM actualites 
    ORDER BY date_publication DESC
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Administration - Assurances Saint Gabriel</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,500,700,900" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Raleway', sans-serif;
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .admin-container {
            flex: 1;
            max-width: 1400px;
            margin: 20px auto;
            padding: 0 15px;
            width: 100%;
        }

        .admin-header {
            background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .admin-header h1 {
            margin: 0 0 10px 0;
            font-size: clamp(20px, 5vw, 32px);
        }

        .admin-header p {
            margin: 0;
            opacity: 0.9;
            font-size: clamp(12px, 3vw, 14px);
        }

        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
            font-size: 14px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .section {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .section h2 {
            margin: 0 0 20px 0;
            color: #333;
            font-size: clamp(18px, 4vw, 24px);
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
        }

        .section h3 {
            font-size: clamp(16px, 3.5vw, 20px);
        }

        /* Stats Grid - Responsive */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            padding: 20px 15px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
        }

        .stat-card .number {
            font-size: clamp(28px, 6vw, 42px);
            font-weight: bold;
            color: #3498db;
            margin-bottom: 8px;
        }

        .stat-card .label {
            color: #666;
            font-size: clamp(11px, 2.5vw, 14px);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Table Responsive */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin: 0 -20px;
            padding: 0 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            min-width: 800px;
        }

        table th {
            background: #3498db;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            white-space: nowrap;
        }

        table td {
            padding: 12px 8px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 13px;
        }

        table tr:hover {
            background: #f8f9fa;
        }

        /* User Cards pour mobile */
        .user-cards {
            display: none;
        }

        .user-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 4px solid #3498db;
        }

        .user-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .user-card-title {
            flex: 1;
        }

        .user-card-title h4 {
            margin: 0 0 5px 0;
            font-size: 16px;
            color: #333;
        }

        .user-card-title p {
            margin: 0;
            font-size: 13px;
            color: #666;
        }

        .user-card-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 10px;
            margin-bottom: 12px;
            font-size: 13px;
        }

        .user-card-info-item {
            display: flex;
            flex-direction: column;
        }

        .user-card-info-item strong {
            color: #666;
            font-size: 11px;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .user-card-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-admin {
            background: #dc3545;
            color: white;
        }

        .badge-collab {
            background: #ffc107;
            color: #333;
        }

        .badge-visiteur {
            background: #6c757d;
            color: white;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            transition: 0.3s;
            white-space: nowrap;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-primary {
            background: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background: #2980b9;
        }

        .btn-warning {
            background: #f39c12;
            color: white;
        }

        .btn-warning:hover {
            background: #e67e22;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            font-family: inherit;
        }

        .checkbox-group {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 15px;
            background: #f8f9fa;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            padding: 8px;
            margin-bottom: 5px;
            border-radius: 4px;
            transition: 0.2s;
        }

        .checkbox-item:hover {
            background: #e9ecef;
        }

        .checkbox-item input[type="checkbox"] {
            width: auto;
            margin-right: 10px;
            cursor: pointer;
        }

        .checkbox-item label {
            margin: 0;
            cursor: pointer;
            flex: 1;
            font-size: 14px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .actualite-item {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 15px;
            border-left: 4px solid #3498db;
        }

        .actualite-item h4 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 18px;
        }

        .actualite-item .date {
            color: #666;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .actualite-item p {
            margin: 0 0 15px 0;
            color: #555;
            line-height: 1.6;
        }

        /* Modal Responsive */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            animation: fadeIn 0.3s;
            padding: 15px;
            overflow-y: auto;
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            padding: 20px;
            max-width: 700px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            animation: slideUp 0.3s;
            margin: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-header h3 {
            margin: 0;
            color: #333;
            font-size: clamp(16px, 4vw, 20px);
        }

        .close-modal {
            font-size: 28px;
            cursor: pointer;
            color: #999;
            transition: 0.3s;
            line-height: 1;
        }

        .close-modal:hover {
            color: #333;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { 
                opacity: 0;
                transform: translateY(30px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Media Queries */
        @media (max-width: 768px) {
            .admin-container {
                padding: 0 10px;
                margin: 15px auto;
            }

            .admin-header {
                padding: 15px;
            }

            .section {
                padding: 15px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .stat-card {
                padding: 15px 10px;
            }

            /* Masquer le tableau et afficher les cartes sur mobile */
            .table-responsive {
                display: none;
            }

            .user-cards {
                display: block;
            }

            .modal {
                padding: 10px;
            }

            .modal-content {
                padding: 15px;
            }

            .btn {
                padding: 8px 12px;
                font-size: 12px;
            }

            .user-card-actions {
                flex-direction: column;
            }

            .user-card-actions .btn {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .form-actions .btn {
                width: 100%;
            }

            .actualite-item {
                padding: 15px;
            }
        }

        /* Amélioration du scroll horizontal sur mobile */
        @media (max-width: 768px) {
            .table-responsive::-webkit-scrollbar {
                height: 8px;
            }

            .table-responsive::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }

            .table-responsive::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 10px;
            }

            .table-responsive::-webkit-scrollbar-thumb:hover {
                background: #555;
            }
        }
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>

    <div class="admin-container">
        <div class="admin-header">
            <h1><i class="fas fa-user-shield"></i> Panneau d'administration</h1>
            <p>Bienvenue, <?= htmlspecialchars($_SESSION['user']['prenom']) ?> <?= htmlspecialchars($_SESSION['user']['nom']) ?></p>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- Statistiques -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="number"><?= count($users) ?></div>
                <div class="label">Utilisateurs</div>
            </div>
            <div class="stat-card">
                <div class="number"><?= count($actualites) ?></div>
                <div class="label">Actualités</div>
            </div>
            <div class="stat-card">
                <div class="number"><?= count(array_filter($users, fn($u) => $u['role_libelle'] === 'Admin')) ?></div>
                <div class="label">Admins</div>
            </div>
            <div class="stat-card">
                <div class="number"><?= count(array_filter($users, fn($u) => $u['role_libelle'] === 'Collaborateur')) ?></div>
                <div class="label">Collaborateurs</div>
            </div>
        </div>

        <!-- Gestion des utilisateurs -->
        <div class="section" id="users">
            <h2><i class="fas fa-users"></i> Gestion des utilisateurs</h2>
            
            <!-- Version tableau (desktop) -->
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Identifiant</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Ville</th>
                            <th>Rôle</th>
                            <th>Assurances</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                            <?php
                            // Récupérer les noms des assurances de l'utilisateur
                            $user_assurances = '';
                            if (!empty($u['id_contract'])) {
                                $contract_ids = array_map('trim', explode(',', $u['id_contract']));
                                $placeholders = implode(',', array_fill(0, count($contract_ids), '?'));
                                $assur_query = $pdo->prepare("SELECT nom_assurance FROM contrat WHERE id_contrat IN ($placeholders)");
                                $assur_query->execute($contract_ids);
                                $assur_names = $assur_query->fetchAll(PDO::FETCH_COLUMN);
                                $user_assurances = !empty($assur_names) ? implode(', ', $assur_names) : 'Aucune';
                            } else {
                                $user_assurances = 'Aucune';
                            }
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($u['ids']) ?></td>
                                <td><strong><?= htmlspecialchars($u['id']) ?></strong></td>
                                <td><?= htmlspecialchars($u['nom']) ?></td>
                                <td><?= htmlspecialchars($u['prenom']) ?></td>
                                <td><?= htmlspecialchars($u['mail']) ?></td>
                                <td><?= htmlspecialchars($u['tel']) ?></td>
                                <td><?= htmlspecialchars($u['ville']) ?></td>
                                <td>
                                    <?php if ($u['role_libelle'] === 'Admin'): ?>
                                        <span class="badge badge-admin">Admin</span>
                                    <?php elseif ($u['role_libelle'] === 'Collaborateur'): ?>
                                        <span class="badge badge-collab">Collab</span>
                                    <?php else: ?>
                                        <span class="badge badge-visiteur">Client</span>
                                    <?php endif; ?>
                                </td>
                                <td style="font-size: 12px; color: #666;">
                                    <?= htmlspecialchars($user_assurances) ?>
                                </td>
                                <td>
                                    <button class="btn btn-warning" onclick="openEditUserModal(<?= htmlspecialchars(json_encode($u)) ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <?php if ($u['ids'] != $_SESSION['user']['ids']): ?>
                                        <a href="?delete_user=<?= $u['ids'] ?>" 
                                           class="btn btn-danger" 
                                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Version cartes (mobile) -->
            <div class="user-cards">
                <?php foreach ($users as $u): ?>
                    <?php
                    // Récupérer les noms des assurances de l'utilisateur
                    $user_assurances = '';
                    if (!empty($u['id_contract'])) {
                        $contract_ids = array_map('trim', explode(',', $u['id_contract']));
                        $placeholders = implode(',', array_fill(0, count($contract_ids), '?'));
                        $assur_query = $pdo->prepare("SELECT nom_assurance FROM contrat WHERE id_contrat IN ($placeholders)");
                        $assur_query->execute($contract_ids);
                        $assur_names = $assur_query->fetchAll(PDO::FETCH_COLUMN);
                        $user_assurances = !empty($assur_names) ? implode(', ', $assur_names) : 'Aucune';
                    } else {
                        $user_assurances = 'Aucune';
                    }
                    ?>
                    <div class="user-card">
                        <div class="user-card-header">
                            <div class="user-card-title">
                                <h4><?= htmlspecialchars($u['prenom']) ?> <?= htmlspecialchars($u['nom']) ?></h4>
                                <p><?= htmlspecialchars($u['id']) ?></p>
                            </div>
                            <?php if ($u['role_libelle'] === 'Admin'): ?>
                                <span class="badge badge-admin">Admin</span>
                            <?php elseif ($u['role_libelle'] === 'Collaborateur'): ?>
                                <span class="badge badge-collab">Collab</span>
                            <?php else: ?>
                                <span class="badge badge-visiteur">Visiteur</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="user-card-info">
                            <div class="user-card-info-item">
                                <strong>Email</strong>
                                <span><?= htmlspecialchars($u['mail']) ?></span>
                            </div>
                            <div class="user-card-info-item">
                                <strong>Téléphone</strong>
                                <span><?= htmlspecialchars($u['tel']) ?></span>
                            </div>
                            <div class="user-card-info-item">
                                <strong>Ville</strong>
                                <span><?= htmlspecialchars($u['ville']) ?> (<?= htmlspecialchars($u['cp']) ?>)</span>
                            </div>
                            <div class="user-card-info-item">
                                <strong>Assurances</strong>
                                <span><?= htmlspecialchars($user_assurances) ?></span>
                            </div>
                        </div>
                        
                        <div class="user-card-actions">
                            <button class="btn btn-warning" onclick="openEditUserModal(<?= htmlspecialchars(json_encode($u)) ?>)">
                                <i class="fas fa-edit"></i> Modifier
                            </button>
                            <?php if ($u['ids'] != $_SESSION['user']['ids']): ?>
                                <a href="?delete_user=<?= $u['ids'] ?>" 
                                   class="btn btn-danger" 
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                    <i class="fas fa-trash"></i> Supprimer
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Gestion des actualités -->
        <div class="section" id="actualites">
            <h2><i class="fas fa-newspaper"></i> Gestion des actualités</h2>
            
            <!-- Formulaire d'ajout -->
            <form method="post" style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                <h3 style="margin-top: 0; color: #333;">Ajouter une actualité</h3>
                
                <div class="form-group">
                    <label for="titre">Titre *</label>
                    <input type="text" id="titre" name="titre" required>
                </div>

                <div class="form-group">
                    <label for="texte">Contenu *</label>
                    <textarea id="texte" name="texte" required></textarea>
                </div>

                <div class="form-group">
                    <label for="image">URL de l'image (optionnel)</label>
                    <input type="text" id="image" name="image" placeholder="https://example.com/image.jpg">
                </div>

                <button type="submit" name="add_actualite" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Ajouter l'actualité
                </button>
            </form>

            <!-- Liste des actualités -->
            <h3 style="margin-bottom: 20px; color: #333;">Actualités existantes</h3>
            <?php if (empty($actualites)): ?>
                <p style="color: #999; text-align: center; padding: 40px;">Aucune actualité pour le moment.</p>
            <?php else: ?>
                <?php foreach ($actualites as $actu): ?>
                    <div class="actualite-item">
                        <h4><?= htmlspecialchars($actu['titre']) ?></h4>
                        <div class="date">
                            <i class="fas fa-calendar"></i> 
                            <?= date('d/m/Y à H:i', strtotime($actu['date_publication'])) ?>
                        </div>
                        <p><?= nl2br(htmlspecialchars($actu['texte'])) ?></p>
                        <?php if (!empty($actu['photo'])): ?>
                            <p style="color: #666; font-size: 13px;">
                                <i class="fas fa-image"></i> Image : 
                                <a href="<?= htmlspecialchars($actu['photo']) ?>" target="_blank" style="color: #3498db;">
                                    Voir l'image
                                </a>
                            </p>
                        <?php endif; ?>
                        <a href="?delete_actu=<?= $actu['id'] ?>" 
                           class="btn btn-danger" 
                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette actualité ?')">
                            <i class="fas fa-trash"></i> Supprimer
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal de modification utilisateur -->
    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-edit"></i> Modifier l'utilisateur</h3>
                <span class="close-modal" onclick="closeEditUserModal()">&times;</span>
            </div>
            
            <form method="POST" action="">
                <input type="hidden" name="user_ids" id="edit_user_ids">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_id">Identifiant *</label>
                        <input type="text" id="edit_id" name="id" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_role">Rôle *</label>
                        <select id="edit_role" name="role_id" required>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role['id'] ?>"><?= htmlspecialchars($role['libelle']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_nom">Nom *</label>
                        <input type="text" id="edit_nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_prenom">Prénom *</label>
                        <input type="text" id="edit_prenom" name="prenom" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_mail">Email *</label>
                    <input type="email" id="edit_mail" name="mail" required>
                </div>

                <div class="form-group">
                    <label for="edit_tel">Téléphone *</label>
                    <input type="text" id="edit_tel" name="tel" required>
                </div>

                <div class="form-group">
                    <label for="edit_adrs">Adresse *</label>
                    <input type="text" id="edit_adrs" name="adrs" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_cp">Code Postal *</label>
                        <input type="text" id="edit_cp" name="cp" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_ville">Ville *</label>
                        <input type="text" id="edit_ville" name="ville" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Assurances</label>
                    <div class="checkbox-group" id="assurances_container">
                        <?php foreach ($assurances as $assurance): ?>
                            <div class="checkbox-item">
                                <input type="checkbox" 
                                       id="assurance_<?= $assurance['id_contrat'] ?>" 
                                       name="assurances[]" 
                                       value="<?= $assurance['id_contrat'] ?>">
                                <label for="assurance_<?= $assurance['id_contrat'] ?>">
                                    <?= htmlspecialchars($assurance['nom_assurance']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <small style="color: #666; margin-top: 5px; display: block;">
                        <i class="fas fa-info-circle"></i> Sélectionnez les assurances attribuées à cet utilisateur
                    </small>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn" onclick="closeEditUserModal()" style="background: #95a5a6; color: white;">
                        Annuler
                    </button>
                    <button type="submit" name="modifier_user" class="btn btn-primary">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script>
        function openEditUserModal(user) {
            document.getElementById('edit_user_ids').value = user.ids;
            document.getElementById('edit_id').value = user.id;
            document.getElementById('edit_nom').value = user.nom;
            document.getElementById('edit_prenom').value = user.prenom;
            document.getElementById('edit_mail').value = user.mail;
            document.getElementById('edit_tel').value = user.tel;
            document.getElementById('edit_adrs').value = user.adrs;
            document.getElementById('edit_cp').value = user.cp;
            document.getElementById('edit_ville').value = user.ville;
            document.getElementById('edit_role').value = user.role_id;
            
            // Décocher toutes les cases
            document.querySelectorAll('#assurances_container input[type="checkbox"]').forEach(cb => {
                cb.checked = false;
            });
            
            // Cocher les assurances de l'utilisateur
            if (user.id_contract) {
                const userContracts = user.id_contract.split(',').map(id => id.trim());
                userContracts.forEach(contractId => {
                    const checkbox = document.getElementById('assurance_' + contractId);
                    if (checkbox) {
                        checkbox.checked = true;
                    }
                });
            }
            
            document.getElementById('editUserModal').classList.add('active');
        }

        function closeEditUserModal() {
            document.getElementById('editUserModal').classList.remove('active');
        }

        // Fermer le modal en cliquant en dehors
        window.onclick = function(event) {
            const modal = document.getElementById('editUserModal');
            if (event.target === modal) {
                closeEditUserModal();
            }
        }
    </script>
</body>
</html>