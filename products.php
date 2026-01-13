<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Assurances Saint Gabriel</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,500,700,900" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700" rel="stylesheet" />
    <!-- Bootstrap core CSS -->
    <link href="css/styles.css" rel="stylesheet" />

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f5f5f5;
            font-family: 'Raleway', sans-serif;
        }

        .page-content {
            flex: 1;
            padding: 40px 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .product-box {
            background: #fff;
            padding: 30px 40px;
            border: 1px solid #ddd;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-bottom: 40px;
            max-width: 900px;
            text-align: center;
        }

        .product-box img {
            border-radius: 10px;
            margin-bottom: 20px;
            max-height: 300px;
            object-fit: cover;
        }

        .product-box h2 {
            font-weight: bold;
            margin-bottom: 15px;
        }

        .product-box p {
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: #3498db;
            border: none;
            border-radius: 6px;
            padding: 10px 20px;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        footer {
            background: #222;
            color: #bbb;
            padding: 15px 0;
            text-align: center;
        }
    </style>
</head>
<body>

    <?php include('navbar.php'); ?>

    <!-- Contenu -->
    <div class="page-content">
        <div class="product-box">
            <img src="assets/img/products-01.jpg" alt="Produits">
            <h2>Assurances vie, santé, auto, habitation...</h2>
            <p>Nous sommes là pour prévenir et assurer vos biens, votre famille, et vous-même.</p>
        </div>

        <div class="product-box">
            <img src="assets/img/products-02.jpg" alt="Assurance solidaire">
            <h2>Assurance solidaire</h2>
            <p>Nos tarifs sont des plus accessibles. Assureur mutualiste de l’économie solidaire, Saint-Gabriel met à la disposition de ses sociétaires une expertise, une capacité d’écoute et une volonté d’innovation reconnues.</p>
        </div>

        <div class="product-box">
            <img src="assets/img/products-03.jpg" alt="Expertise">
            <h2>Plus de 75 ans d'expertise</h2>
            <p>Forte d’une expertise reconnue découlant de plus de soixante quinze ans d’amélioration et d’enrichissement de ses savoir-faire, elle propose à ces institutions, à leurs salariés et à leurs bénévoles des garanties, des services d’assurances et un accompagnement adaptés à leur mission, au meilleur coût.</p>
        </div>

        <div class="product-box">
            <h2>Espace client</h2>
            <form action="connexion.php" method="post">
                <input type="submit" value="Connexion à votre compte" class="btn btn-primary" name="compte_client">
            </form>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
