<?php
// Connexion à la base pour récupérer les assurances
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
    $assurances = $pdo->query("SELECT id_contrat, nom_assurance FROM contrat ORDER BY nom_assurance")->fetchAll();
} catch (PDOException $e) {
    $assurances = [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Inscription - Assurances Saint Gabriel" />
    <title>Inscription - Assurances Saint Gabriel</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,500,700,900" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            font-family: 'Raleway', sans-serif;
            background-color: #f5f5f5;
        }

        .page-content {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 50px 15px;
            min-height: calc(100vh - 200px);
        }

        .form-box {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 30px 40px;
            max-width: 700px;
            width: 100%;
        }

        .form-box h2 {
            margin-top: 0;
            color: #333;
            text-align: center;
            margin-bottom: 25px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .form-group label .required {
            color: #dc3545;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 14px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #3498db;
        }

        input.error {
            border-color: #dc3545;
        }

        .checkbox-group {
            max-height: 180px;
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
            font-weight: normal;
        }

        .btn-primary {
            background-color: #3498db;
            border: none;
            border-radius: 6px;
            padding: 14px 20px;
            color: white;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .error-message {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
            display: none;
        }

        .text-center {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }

        .text-center a {
            color: #3498db;
            text-decoration: none;
            font-weight: 600;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        .info-text {
            color: #666;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        @media (max-width: 768px) {
            .page-content {
                padding: 25px 10px;
            }

            .form-box {
                padding: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>

    <div class="page-content">
        <div class="form-box">
            <h2><i class="fas fa-user-plus"></i> Créer un compte</h2>
            <form action="verif.php" method="post" id="inscriptionForm">
                
                <div class="form-group">
                    <label for="id">Identifiant de connexion <span class="required">*</span></label>
                    <input type="text" id="id" name="id" required minlength="3">
                    <span class="error-message" id="error-id">L'identifiant doit contenir au moins 3 caractères</span>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="nom">Nom <span class="required">*</span></label>
                        <input type="text" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom <span class="required">*</span></label>
                        <input type="text" id="prenom" name="prenom" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="mail">Email <span class="required">*</span></label>
                    <input type="email" id="mail" name="mail" required>
                    <span class="error-message" id="error-mail">Veuillez entrer une adresse email valide</span>
                </div>

                <div class="form-group">
                    <label for="tel">Téléphone <span class="required">*</span></label>
                    <input type="tel" id="tel" name="tel" required pattern="[0-9]{10}" maxlength="10">
                    <span class="info-text"><i class="fas fa-info-circle"></i> 10 chiffres (ex: 0612345678)</span>
                    <span class="error-message" id="error-tel">Le numéro de téléphone doit contenir 10 chiffres</span>
                </div>

                <div class="form-group">
                    <label for="adrs">Adresse <span class="required">*</span></label>
                    <input type="text" id="adrs" name="adrs" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="cp">Code postal <span class="required">*</span></label>
                        <input type="text" id="cp" name="cp" required pattern="[0-9]{5}" maxlength="5">
                        <span class="error-message" id="error-cp">Le code postal doit contenir 5 chiffres</span>
                    </div>
                    <div class="form-group">
                        <label for="ville">Ville <span class="required">*</span></label>
                        <input type="text" id="ville" name="ville" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="mdp">Mot de passe <span class="required">*</span></label>
                    <input type="password" id="mdp" name="mdp" required minlength="6">
                    <span class="info-text"><i class="fas fa-info-circle"></i> Minimum 6 caractères</span>
                    <span class="error-message" id="error-mdp">Le mot de passe doit contenir au moins 6 caractères</span>
                </div>

                <div class="form-group">
                    <label>Assurances souhaitées <span class="required">*</span></label>
                    <div class="checkbox-group">
                        <?php if (empty($assurances)): ?>
                            <p style="color: #999; margin: 0;">Aucune assurance disponible</p>
                        <?php else: ?>
                            <?php foreach ($assurances as $assurance): ?>
                                <div class="checkbox-item">
                                    <input type="checkbox" 
                                           id="assurance_<?= $assurance['id_contrat'] ?>" 
                                           name="assurances[]" 
                                           value="<?= $assurance['id_contrat'] ?>">
                                    <label for="assurance_<?= $assurance['id_contrat'] ?>">
                                        <i class="fas fa-shield-alt" style="color: #3498db; margin-right: 5px;"></i>
                                        <?= htmlspecialchars($assurance['nom_assurance']) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <span class="info-text"><i class="fas fa-info-circle"></i> Sélectionnez au moins une assurance</span>
                    <span class="error-message" id="error-assurances">Veuillez sélectionner au moins une assurance</span>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fas fa-user-plus"></i> S'inscrire
                </button>
            </form>

            <p class="text-center">
                Déjà inscrit ? <a href="connexion.php">Se connecter</a>
            </p>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script>
        // Validation en temps réel
        const form = document.getElementById('inscriptionForm');
        
        // Validation du téléphone (uniquement des chiffres)
        document.getElementById('tel').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            validateField(this, this.value.length === 10, 'error-tel');
        });

        // Validation du code postal (uniquement des chiffres)
        document.getElementById('cp').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            validateField(this, this.value.length === 5, 'error-cp');
        });

        // Validation de l'email
        document.getElementById('mail').addEventListener('blur', function(e) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            validateField(this, emailRegex.test(this.value), 'error-mail');
        });

        // Validation du mot de passe
        document.getElementById('mdp').addEventListener('input', function(e) {
            validateField(this, this.value.length >= 6, 'error-mdp');
        });

        // Validation de l'identifiant
        document.getElementById('id').addEventListener('input', function(e) {
            validateField(this, this.value.length >= 3, 'error-id');
        });

        function validateField(field, isValid, errorId) {
            const errorMsg = document.getElementById(errorId);
            if (isValid) {
                field.classList.remove('error');
                if (errorMsg) errorMsg.style.display = 'none';
            } else {
                field.classList.add('error');
                if (errorMsg) errorMsg.style.display = 'block';
            }
        }

        // Validation à la soumission
        form.addEventListener('submit', function(e) {
            let isValid = true;

            // Vérifier si au moins une assurance est cochée
            const checkboxes = document.querySelectorAll('input[name="assurances[]"]');
            const atLeastOneChecked = Array.from(checkboxes).some(cb => cb.checked);
            
            if (!atLeastOneChecked) {
                e.preventDefault();
                document.getElementById('error-assurances').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('error-assurances').style.display = 'none';
            }

            // Vérifier le téléphone
            const tel = document.getElementById('tel');
            if (tel.value.length !== 10) {
                e.preventDefault();
                validateField(tel, false, 'error-tel');
                isValid = false;
            }

            // Vérifier le code postal
            const cp = document.getElementById('cp');
            if (cp.value.length !== 5) {
                e.preventDefault();
                validateField(cp, false, 'error-cp');
                isValid = false;
            }

            // Vérifier le mot de passe
            const mdp = document.getElementById('mdp');
            if (mdp.value.length < 6) {
                e.preventDefault();
                validateField(mdp, false, 'error-mdp');
                isValid = false;
            }

            // Vérifier l'identifiant
            const id = document.getElementById('id');
            if (id.value.length < 3) {
                e.preventDefault();
                validateField(id, false, 'error-id');
                isValid = false;
            }

            if (!isValid) {
                alert('Veuillez corriger les erreurs dans le formulaire.');
            }
        });
    </script>
</body>
</html>