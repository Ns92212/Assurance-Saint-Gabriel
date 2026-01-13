<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Assurances Saint Gabriel - Contact et informations" />
    <meta name="author" content="Assurances Saint Gabriel" />
    <title>Assurances Saint Gabriel</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />

    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>

    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,500,700,900" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700" rel="stylesheet" />

    <!-- Bootstrap -->
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

        .page-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 50px;
            padding-bottom: 50px;
        }

        .contact-container {
            background: #fff;
            padding: 30px 40px;
            border: 1px solid #ddd;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 700px;
            text-align: center;
        }

        .contact-container h2 {
            margin-bottom: 25px;
            font-weight: 700;
            color: #333;
        }

        .contact-container ul {
            text-align: left;
            margin-bottom: 30px;
            list-style: none;
            padding: 0;
        }

        .contact-container li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .contact-container a {
            color: #3498db;
            text-decoration: none;
        }

        .contact-container a:hover {
            text-decoration: underline;
        }

        .contact-container form {
            margin-top: 20px;
            text-align: left;
        }

        .contact-container input[type="text"],
        .contact-container input[type="email"],
        .contact-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .contact-container input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }

        .contact-container input[type="submit"]:hover {
            background-color: #2980b9;
        }

        footer {
            background: #222;
            color: #aaa;
            text-align: center;
            padding: 15px 0;
        }
    </style>
</head>
<body>

    <?php include('navbar.php'); ?>
    <!-- Contenu principal -->
    <div class="page-content">
        <div class="contact-container">
            <h2>Contactez nos agences</h2>

            <ul>
                <li><strong>Agence de Bagneux :</strong> <a href="https://www.google.com/maps?q=21+rue+de+la+Lisette,+92220+Bagneux" target="_blank">21 rue de la Lisette, 92220 Bagneux</a></li>
                <li><strong>Agence de Bailleul :</strong> <a href="https://www.google.com/maps?q=240+Rue+de+Lille,+59270+Bailleul" target="_blank">240 Rue de Lille, 59270 Bailleul</a></li>
                <li><strong>Agence de Granville :</strong> <a href="https://www.google.com/maps?q=4+place+Cambernon,+50400+Granville" target="_blank">4 place Cambernon, 50400 Granville</a></li>
                <li><strong>Agence de Montigny :</strong> <a href="https://www.google.com/maps?q=2+rue+de+la+Montagne,+45170+Montigny" target="_blank">2 rue de la Montagne, 45170 Montigny</a></li>
                <li><strong>Agence de Saint Jean de Vedas :</strong> <a href="https://www.google.com/maps?q=31+avenue+Georges+Clemenceau,+34400+Saint+Jean+de+Vedas" target="_blank">31 avenue Georges Clemenceau, 34400 Saint Jean de Vedas</a></li>
                <li><strong>Agence de Maillezais :</strong> <a href="https://www.google.com/maps?q=39+rue+du+Grand+Port,+85440+Maillezais" target="_blank">39 rue du Grand Port, 85440 Maillezais</a></li>
                <li><strong>Agence de Frangy :</strong> <a href="https://www.google.com/maps?q=72+rue+Haute,+74270+Frangy" target="_blank">72 rue Haute, 74270 Frangy</a></li>
            </ul>

            <form action="send_message.php" method="post">
                <label for="email">Votre email :</label>
                <input type="email" id="email" name="email" placeholder="Votre adresse email" required>

                <label for="tel">Votre numéro de téléphone :</label>
                <input type="text" id="tel" name="tel" placeholder="Votre numéro (facultatif)">

                <label for="message">Votre message :</label>
                <input type="text" id="message" name="message" placeholder="Votre message" required>

                <input type="submit" value="Envoyer">
            </form>

            <p style="margin-top:20px; font-size:14px; color:#555;">
                <strong>Pour nous appeler :</strong> 01 46 57 61 22
            </p>
        </div>
    </div>

   <?php include('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
