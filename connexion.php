<?php
session_start();

// Si déjà connecté, rediriger
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role_id'] == 1) {
        header("Location: admin.php");
    } else {
        header("Location: interface.php");
    }
    exit();
}

// Récupérer le message d'erreur si présent
$error_message = '';
if (isset($_GET['error'])) {
    if ($_GET['error'] == 'invalid') {
        $error_message = "Identifiant ou mot de passe incorrect.";
    } elseif ($_GET['error'] == 'missing') {
        $error_message = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Connexion - Assurances Saint Gabriel</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,500,700,900" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />

    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f5f5f5;
            font-family: 'Raleway', sans-serif;
        }

        /* conteneur général après la navbar */
        .page-content {
            flex: 1;
            display: flex;
            justify-content: center;   /* centre horizontal */
            align-items: center;       /* centre vertical */
        }

        .form-container {
            background: #fff;
            padding: 30px 40px;
            border: 1px solid #ddd;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
            width: 320px;
        }

        .form-container h2 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #333;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
            font-size: 14px;
            text-align: left;
        }

        .form-container form {
            margin-bottom: 15px;
        }

        .form-container label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            text-align: left;
        }

        .form-container input[type="text"],
        .form-container input[type="password"],
        .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
            box-sizing: border-box;
        }

        .form-container input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: 0.3s;
            font-weight: bold;
        }

        .form-container input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .inscription-btn {
            background-color: #2ecc71;
        }

        .inscription-btn:hover {
            background-color: #27ae60;
        }

        .separator {
            margin: 20px 0;
            color: #999;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <?php include('navbar.php'); ?>

    <!-- Contenu centré -->
    <div class="page-content">
        <div class="form-container">
            <h2>Connexion</h2>

            <?php if ($error_message): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>

            <form action="client.php" method="post">
                <label for="id">Identifiant :</label>
                <input type="text" id="id" name="id" required autocomplete="username">

                <label for="mdp">Mot de passe :</label>
                <input type="password" id="mdp" name="mdp" required autocomplete="current-password">

                <input type="submit" value="Connexion">
            </form>

            <div class="separator">ou</div>

            <form action="inscription.php" method="get">
                <input type="submit" value="Créer un compte" class="inscription-btn">
            </form>
        </div>
    </div>

    <?php include('footer.php'); ?>

</body>
</html>