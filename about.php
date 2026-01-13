<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Assurances Saint Gabriel - Nos activités et engagements" />
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
            padding: 60px 0;
        }

        .about-container {
            background: #fff;
            padding: 40px 50px;
            border: 1px solid #ddd;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 900px;
            max-width: 95%;
        }

        .about-container img {
            width: 100%;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .about-container h2 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 700;
            color: #333;
        }

        .about-container p {
            text-align: justify;
            color: #555;
            line-height: 1.6;
        }

        .about-container em {
            color: #3498db;
            font-style: normal;
            font-weight: 600;
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
        <div class="about-container">
            <img src="assets/img/about.jpg" alt="Assurances Saint Gabriel - À propos" />

            <h2>Nous sommes là pour vous</h2>

            <p><strong>Assurances Saint Gabriel</strong> est à vos côtés dans les bons comme dans les mauvais moments. 
            Forte d’une expertise reconnue, découlant de plus de soixante-quinze ans d’expérience, notre entreprise propose à ses clients des garanties et des services adaptés à leurs besoins, au meilleur coût.</p>

            <p>Nous accompagnons les particuliers, les professionnels et les institutions avec la même exigence : celle de la confiance, de la proximité et de la performance.</p>

            <p>Fidèles à nos valeurs, nous plaçons l’humain au cœur de notre métier, pour vous offrir la sérénité que vous méritez. 
            Avec Saint Gabriel, vous bénéficiez du meilleur pour vous sentir en sécurité, totalement <em>r-assurés</em> !</p>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
