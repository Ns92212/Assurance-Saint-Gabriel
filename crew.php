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

        .content-box {
            background: #fff;
            padding: 30px 40px;
            border: 1px solid #ddd;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-bottom: 40px;
            max-width: 900px;
            width: 100%;
            text-align: center;
        }

        .content-box h2 {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .team-list {
            list-style: none;
            padding: 0;
            margin: 0;
            text-align: left;
        }

        .team-list li {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #eee;
            padding: 8px 0;
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

        .content-box img {
            border-radius: 10px;
            margin-bottom: 20px;
            max-height: 300px;
            object-fit: cover;
            width: 100%;
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
        <div class="content-box">
            <h2>Notre équipe</h2>
            <p>Nous sommes là pour vous !</p>
            <ul class="team-list">
                <li>Assurances vie <span>David Andre</span></li>
                <li>Complémentaire Santé <span>Christian Bedos</span></li>
                <li>Activité professionnelle <span>Denise Bussot</span></li>
                <li>Automobile <span>Michel Debroise</span></li>
                <li>Cyber <span>Céline Enault-Pascreau</span></li>
                <li>Décès <span>Nathalie Desmarquest</span></li>
                <li>Habitation <span>Louis Villechalane</span></li>
            </ul>
        </div>

        <div class="content-box">
            <h2>Agence principale</h2>
            <p><strong>Adresse :</strong><br>21 rue de la lisette, 92220 Bagneux</p>
            <p><strong>Téléphone :</strong><br>01 46 09 98 91</p>
            <p><em>Disponibles pour vous, à tout moment</em></p>
        </div>

        <div class="content-box">
            <img src="assets/img/about.jpg" alt="Notre équipe">
            <h2>Des équipes performantes</h2>
            <p>Assureur mutualiste de l’économie solidaire, Saint-Gabriel met à la disposition de ses sociétaires une expertise, une capacité d’écoute et une volonté d’innovation reconnues.</p>
            <p class="mb-0">Nous vous garantissons que nous ferons <em>le meilleur</em> pour vous, quelle que soit la tâche à accomplir.</p>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
