<?php
session_start();

// Vérifier si l'utilisateur est connecté et est collaborateur (role_id = 2)
if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 2) {
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
$collaborateur_id = $_SESSION['user']['ids'];

// Modification des informations d'un client
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier_client'])) {
    $client_ids = intval($_POST['client_ids']);
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $mail = trim($_POST['mail']);
    $tel = trim($_POST['tel']);
    $adrs = trim($_POST['adrs']);
    $cp = trim($_POST['cp']);
    $ville = trim($_POST['ville']);
    
    // Vérifier que ce client a au moins une assurance en commun avec le collaborateur
    $collab_info = $pdo->prepare("SELECT id_contract FROM info WHERE ids = :collab_id");
    $collab_info->execute(['collab_id' => $collaborateur_id]);
    $collab_data = $collab_info->fetch();
    
    $has_permission = false;
    
    if ($collab_data && !empty($collab_data['id_contract'])) {
        $collab_contracts = array_map('trim', explode(',', $collab_data['id_contract']));
        
        $client_info = $pdo->prepare("SELECT id_contract FROM info WHERE ids = :client_id");
        $client_info->execute(['client_id' => $client_ids]);
        $client_data = $client_info->fetch();
        
        if ($client_data && !empty($client_data['id_contract'])) {
            $client_contracts = array_map('trim', explode(',', $client_data['id_contract']));
            $assurances_communes = array_intersect($collab_contracts, $client_contracts);
            
            if (!empty($assurances_communes)) {
                $has_permission = true;
            }
        }
    }
    
    if ($has_permission) {
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
                'ids' => $client_ids
            ]);
            $message = "Informations du client mises à jour avec succès !";
        } catch (PDOException $e) {
            $error = "Erreur lors de la mise à jour : " . $e->getMessage();
        }
    } else {
        $error = "Vous n'avez pas l'autorisation de modifier ce client (aucune assurance en commun).";
    }
}

// Récupération des assurances du collaborateur (depuis son id_contract)
$collab_info = $pdo->prepare("SELECT id_contract FROM info WHERE ids = :collab_id");
$collab_info->execute(['collab_id' => $collaborateur_id]);
$collab_data = $collab_info->fetch();

$mes_assurances = [];
$collab_contract_ids = [];

if ($collab_data && !empty($collab_data['id_contract'])) {
    $collab_contract_ids = array_map('trim', explode(',', $collab_data['id_contract']));
    $placeholders = implode(',', array_fill(0, count($collab_contract_ids), '?'));
    
    $assurances_query = $pdo->prepare("
        SELECT id_contrat as id, nom_assurance as assurance_nom
        FROM contrat
        WHERE id_contrat IN ($placeholders)
        ORDER BY nom_assurance
    ");
    $assurances_query->execute($collab_contract_ids);
    $mes_assurances = $assurances_query->fetchAll();
}

// Récupération de TOUS les clients avec role_id = 3
$clients_query = $pdo->prepare("
    SELECT 
        i.ids, i.id, i.nom, i.prenom, i.mail, i.tel, i.adrs, i.cp, i.ville, i.id_contract
    FROM info i
    WHERE i.role_id = 3
    ORDER BY i.nom, i.prenom
");
$clients_query->execute();
$clients_data = $clients_query->fetchAll();

// Filtrer les clients qui ont au moins une assurance en commun avec le collaborateur
$mes_clients = [];
foreach ($clients_data as $client) {
    // Si le collaborateur n'a pas d'assurances, on ne peut pas gérer de clients
    if (empty($collab_contract_ids)) {
        break;
    }
    
    // Si le client n'a pas d'assurances, on passe
    if (empty($client['id_contract'])) {
        continue;
    }
    
    $client_contract_ids = array_map('trim', explode(',', $client['id_contract']));
    
    // Vérifier s'il y a au moins une assurance en commun
    $assurances_communes = array_intersect($collab_contract_ids, $client_contract_ids);
    
    if (!empty($assurances_communes)) {
        // Enrichir les données du client
        $client['assurances'] = 'Aucune';
        $client['nb_contrats'] = count($client_contract_ids);
        
        // Récupérer les noms des assurances du client
        $placeholders = implode(',', array_fill(0, count($client_contract_ids), '?'));
        $assurances_client = $pdo->prepare("
            SELECT nom_assurance 
            FROM contrat 
            WHERE id_contrat IN ($placeholders)
        ");
        $assurances_client->execute($client_contract_ids);
        $assurances_names = $assurances_client->fetchAll(PDO::FETCH_COLUMN);
        
        if (!empty($assurances_names)) {
            $client['assurances'] = implode(', ', $assurances_names);
        }
        
        $mes_clients[] = $client;
    }
}

// Statistiques
$stats = [
    'nb_clients' => count($mes_clients),
    'nb_assurances' => count($mes_assurances),
    'nb_contrats' => 0
];

foreach ($mes_clients as $client) {
    $stats['nb_contrats'] += $client['nb_contrats'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Espace Collaborateur - Assurances Saint Gabriel</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,500,700,900" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            font-family: 'Raleway', sans-serif;
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .collab-container {
            flex: 1;
            max-width: 1400px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .collab-header {
            background: linear-gradient(135deg, #1b4f72 0%, #2874a6 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .collab-header h1 {
            margin: 0 0 10px 0;
            font-size: 32px;
        }

        .collab-header p {
            margin: 0;
            opacity: 0.9;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
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
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .section h2 {
            margin: 0 0 20px 0;
            color: #333;
            font-size: 24px;
            border-bottom: 3px solid #1b4f72;
            padding-bottom: 10px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
        }

        .stat-card .number {
            font-size: 42px;
            font-weight: bold;
            color: #1b4f72;
            margin-bottom: 10px;
        }

        .stat-card .label {
            color: #666;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .assurances-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }

        .assurance-badge {
            background: #1b4f72;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th {
            background: #1b4f72;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: 600;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
        }

        table tr:hover {
            background: #f8f9fa;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }

        .btn-primary {
            background: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background: #2980b9;
        }

        .btn-warning {
            background: #1b4f72;
            color: white;
        }

        .btn-warning:hover {
            background: #16425c;
        }

        /* Modal */
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
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            padding: 30px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            animation: slideUp 0.3s;
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
        }

        .close-modal {
            font-size: 28px;
            cursor: pointer;
            color: #999;
            transition: 0.3s;
        }

        .close-modal:hover {
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .client-info {
            font-size: 13px;
            color: #666;
        }

        .overflow-scroll {
            overflow-x: auto;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { 
                opacity: 0;
                transform: translateY(50px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            table {
                font-size: 12px;
            }

            table th,
            table td {
                padding: 8px 5px;
            }
        }
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>

    <div class="collab-container">
        <div class="collab-header">
            <h1><i class="fas fa-briefcase"></i> Espace Collaborateur</h1>
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

        <div class="stats-grid">
            <div class="stat-card">
                <div class="number"><?= $stats['nb_clients'] ?></div>
                <div class="label">Mes Clients</div>
            </div>
            <div class="stat-card">
                <div class="number"><?= $stats['nb_contrats'] ?></div>
                <div class="label">Contrats Actifs</div>
            </div>
            <div class="stat-card">
                <div class="number"><?= $stats['nb_assurances'] ?></div>
                <div class="label">Types d'Assurances</div>
            </div>
        </div>

        <div class="section" id="assurances">
            <h2><i class="fas fa-shield-alt"></i> Mes Assurances</h2>
            <?php if (count($mes_assurances) === 0): ?>
                <p style="color: #999; text-align: center; padding: 40px;">
                    Aucune assurance n'est assignée à votre profil.
                </p>
            <?php elseif (count($mes_assurances) === 1): ?>
                <p style="color: #666; margin-bottom: 15px;">
                    <i class="fas fa-info-circle"></i> Vous gérez uniquement l'assurance suivante :
                </p>
                <div class="assurances-list">
                    <?php foreach ($mes_assurances as $assurance): ?>
                        <div class="assurance-badge">
                            <i class="fas fa-check-circle"></i> <?= htmlspecialchars($assurance['assurance_nom']) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="color: #666; margin-bottom: 15px;">
                    <i class="fas fa-info-circle"></i> Vous gérez les assurances suivantes :
                </p>
                <div class="assurances-list">
                    <?php foreach ($mes_assurances as $assurance): ?>
                        <div class="assurance-badge">
                            <i class="fas fa-check-circle"></i> <?= htmlspecialchars($assurance['assurance_nom']) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="section" id="clients">
            <h2><i class="fas fa-users"></i> Gestion de mes Clients</h2>
            
            <?php if (empty($mes_clients)): ?>
                <p style="color: #999; text-align: center; padding: 40px;">
                    <i class="fas fa-info-circle"></i> Aucun client n'a d'assurance en commun avec vous.
                </p>
            <?php else: ?>
                <div class="overflow-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Ville</th>
                                <th>Assurances</th>
                                <th>Nb Contrats</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($mes_clients as $client): ?>
                                <tr>
                                    <td><?= htmlspecialchars($client['ids']) ?></td>
                                    <td><strong><?= htmlspecialchars($client['nom']) ?></strong></td>
                                    <td><?= htmlspecialchars($client['prenom']) ?></td>
                                    <td><?= htmlspecialchars($client['mail']) ?></td>
                                    <td><?= htmlspecialchars($client['tel']) ?></td>
                                    <td><?= htmlspecialchars($client['ville']) ?></td>
                                    <td>
                                        <span class="client-info">
                                            <?= htmlspecialchars($client['assurances']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span style="background: #3498db; color: white; padding: 4px 10px; border-radius: 12px; font-size: 12px;">
                                            <?= $client['nb_contrats'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning" onclick="openEditModal(<?= htmlspecialchars(json_encode($client)) ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-edit"></i> Modifier les informations du client</h3>
                <span class="close-modal" onclick="closeEditModal()">&times;</span>
            </div>
            
            <form method="POST" action="">
                <input type="hidden" name="client_ids" id="edit_client_ids">
                
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

                <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                    <button type="button" class="btn" onclick="closeEditModal()" style="background: #95a5a6; color: white;">
                        Annuler
                    </button>
                    <button type="submit" name="modifier_client" class="btn btn-primary">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script>
        function openEditModal(client) {
            document.getElementById('edit_client_ids').value = client.ids;
            document.getElementById('edit_nom').value = client.nom;
            document.getElementById('edit_prenom').value = client.prenom;
            document.getElementById('edit_mail').value = client.mail;
            document.getElementById('edit_tel').value = client.tel;
            document.getElementById('edit_adrs').value = client.adrs;
            document.getElementById('edit_cp').value = client.cp;
            document.getElementById('edit_ville').value = client.ville;
            
            document.getElementById('editModal').classList.add('active');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
        }

        // Fermer le modal en cliquant en dehors
        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target === modal) {
                closeEditModal();
            }
        }
    </script>
</body>
</html>