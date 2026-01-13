<?php
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
    // En cas d'erreur, on initialise un tableau vide
    $actualites = [];
}

// Récupération de toutes les actualités
try {
    $actualites = $pdo->query("
        SELECT * FROM actualites 
        ORDER BY date_publication DESC
    ")->fetchAll();
} catch (PDOException $e) {
    $actualites = [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Assurances Saint Gabriel - Votre partenaire de confiance" />
    <meta name="author" content="" />
    <title>Assurances Saint Gabriel</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,500,700,900" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700" rel="stylesheet" />
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
        }

        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .content-box {
            background: #fff;
            padding: 30px 40px;
            border: 1px solid #ddd;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
        }

        .content-box h2 {
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }

        .content-box p {
            margin-bottom: 20px;
            color: #666;
            line-height: 1.6;
        }

        .content-box img {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #3498db;
            border: none;
            border-radius: 6px;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        /* Section actualités */
        .actualites-section {
            max-width: 1200px;
            margin: 60px auto;
            padding: 0 15px;
        }

        .actualites-section h2 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 40px;
            color: #333;
            font-weight: bold;
        }

        .actualites-wrapper {
            overflow: hidden;
            width: 100%;
        }

        .actualites-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 30px;
        }

        .actualite-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            min-width: 0;
            display: none;
        }

        .actualite-card.active {
            display: block;
        }

        .actualite-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }

        .actualite-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .actualite-card-content {
            padding: 20px;
        }

        .actualite-card h3 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 20px;
        }

        .actualite-date {
            color: #999;
            font-size: 13px;
            margin-bottom: 12px;
        }

        .actualite-card p {
            color: #666;
            line-height: 1.6;
            margin: 0;
        }

        .no-actualites {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .pagination-btn {
            background: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .pagination-btn:hover:not(:disabled) {
            background: #2980b9;
            transform: translateY(-2px);
        }

        .pagination-btn:disabled {
            background: #bdc3c7;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .pagination-info {
            font-size: 16px;
            color: #333;
            font-weight: 500;
            padding: 10px 20px;
            background: #ecf0f1;
            border-radius: 6px;
        }

        .page-dots {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .page-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #bdc3c7;
            cursor: pointer;
            transition: 0.3s;
        }

        .page-dot.active {
            background: #3498db;
            transform: scale(1.3);
        }

        .page-dot:hover {
            background: #7f8c8d;
        }

        footer {
            background: #222;
            color: #aaa;
            padding: 25px 0;
            text-align: center;
        }

        footer p {
            margin: 0 0 10px 0;
        }

        footer a {
            color: #3498db;
            text-decoration: none;
            margin: 0 15px;
            transition: color 0.3s;
        }

        footer a:hover {
            color: #5dade2;
            text-decoration: underline;
        }

        /* MEDIA QUERIES RESPONSIVE */
        
        /* Tablettes */
        @media (max-width: 992px) {
            .actualites-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }

            .actualites-section h2 {
                font-size: 28px;
                margin-bottom: 30px;
            }

            .content-grid {
                gap: 15px;
            }

            .content-box {
                padding: 25px 30px;
            }
        }

        /* Mobile */
        @media (max-width: 768px) {
            .page-content {
                padding: 30px 10px;
            }

            .content-grid {
                grid-template-columns: 1fr;
                gap: 15px;
                margin-bottom: 30px;
            }

            .content-box {
                padding: 20px 25px;
            }

            .content-box h2 {
                font-size: 22px;
            }

            .content-box p {
                font-size: 15px;
            }

            .actualites-section {
                margin: 40px auto;
                padding: 0 10px;
            }

            .actualites-section h2 {
                font-size: 24px;
                margin-bottom: 25px;
            }

            .actualites-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .actualite-card img {
                height: 180px;
            }

            .actualite-card h3 {
                font-size: 18px;
            }

            .actualite-card-content {
                padding: 15px;
            }

            .pagination-container {
                gap: 10px;
                padding: 0 10px;
            }

            .pagination-btn {
                padding: 8px 15px;
                font-size: 13px;
            }

            .pagination-info {
                font-size: 14px;
                padding: 8px 15px;
            }

            .page-dots {
                gap: 8px;
            }

            .page-dot {
                width: 10px;
                height: 10px;
            }

            footer {
                padding: 20px 15px;
                font-size: 14px;
            }

            footer a {
                display: block;
                margin: 10px 0;
            }
        }

        /* Très petits écrans */
        @media (max-width: 480px) {
            .actualites-section h2 {
                font-size: 20px;
            }

            .content-box h2 {
                font-size: 20px;
            }

            .content-box p {
                font-size: 14px;
            }

            .btn-primary {
                padding: 8px 16px;
                font-size: 14px;
            }

            .actualite-card img {
                height: 150px;
            }

            .actualite-card h3 {
                font-size: 16px;
            }

            .actualite-card p {
                font-size: 14px;
            }

            .pagination-btn {
                padding: 8px 12px;
                font-size: 12px;
            }

            .pagination-btn i {
                display: none;
            }

            .pagination-info {
                font-size: 13px;
                padding: 6px 12px;
            }
        }

        /* Mode paysage mobile */
        @media (max-width: 768px) and (orientation: landscape) {
            .actualites-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .actualite-card img {
                height: 150px;
            }
        }
    </style>
</head>
<body>

    <?php include('navbar.php'); ?>

    <div class="page-content">
        <div class="content-grid">
            <div class="content-box">
                <h2>Assurances Saint Gabriel</h2>
                <p>Nous sommes là pour vous, à vos côtés, dans les mauvais comme dans les bons moments de votre vie.</p>
            </div>

            <div class="content-box">
                <img src="assets/img/intro.jpg" class="img-fluid rounded mb-3" alt="Intro">
                <h2>Saint Gabriel</h2>
                <p>Les Assurances Saint Gabriel sont l'assureur de l'économie solidaire, la mutuelle de tous ceux qui s'engagent : associations, ONG à but humanitaire et caritatif, organismes sanitaires et sociaux, enseignement, institutions.</p>
                <a href="products.php" class="btn-primary">Il est temps d'adhérer !</a>
            </div>

            <div class="content-box">
                <h2>À vos côtés</h2>
                <p>Assureur mutualiste de l'économie solidaire, Saint-Gabriel met à la disposition de ses sociétaires une expertise, une capacité d'écoute et une volonté d'innovation reconnues.<br><br>
                Parce que notre but est d'être là dans tous les moments clés de votre vie, notre panel d'assurances couvre tous les aléas et tous les biens que vous souhaitez, de façon évolutive et dans le respect de nos valeurs.</p>
            </div>
        </div>

        <div class="actualites-section">
            <h2><i class="fas fa-newspaper"></i> Nos actualités</h2>
            
            <?php if (empty($actualites)): ?>
                <div class="no-actualites">
                    <i class="fas fa-info-circle" style="font-size: 48px; color: #ccc; margin-bottom: 20px;"></i>
                    <p>Aucune actualité pour le moment. Revenez bientôt !</p>
                </div>
            <?php else: ?>
                <div class="actualites-grid" id="actualitesGrid">
                    <?php foreach ($actualites as $index => $actu): ?>
                        <div class="actualite-card <?= $index < 3 ? 'active' : '' ?>" data-index="<?= $index ?>">
                            <?php if (!empty($actu['photo'])): ?>
                                <img src="<?= htmlspecialchars($actu['photo']) ?>" alt="<?= htmlspecialchars($actu['titre']) ?>">
                            <?php else: ?>
                                <img src="assets/img/intro.jpg" alt="<?= htmlspecialchars($actu['titre']) ?>">
                            <?php endif; ?>
                            
                            <div class="actualite-card-content">
                                <h3><?= htmlspecialchars($actu['titre']) ?></h3>
                                <div class="actualite-date">
                                    <i class="fas fa-calendar"></i> <?= date('d/m/Y', strtotime($actu['date_publication'])) ?>
                                </div>
                                <p><?= nl2br(htmlspecialchars(substr($actu['texte'], 0, 150))) ?><?= strlen($actu['texte']) > 150 ? '...' : '' ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if (count($actualites) > 1): ?>
                    <div class="pagination-container">
                        <button class="pagination-btn" id="prevBtn" onclick="changePage(-1)">
                            <i class="fas fa-chevron-left"></i> <span>Précédent</span>
                        </button>

                        <div class="page-dots" id="pageDots"></div>

                        <div class="pagination-info">
                            <span id="currentPage">1</span> / <span id="totalPages"></span>
                        </div>

                        <button class="pagination-btn" id="nextBtn" onclick="changePage(1)">
                            <span>Suivant</span> <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                    <script>
                        let ITEMS_PER_PAGE = 3;
                        const cards = document.querySelectorAll('.actualite-card');
                        const totalItems = cards.length;
                        let totalPages = Math.ceil(totalItems / ITEMS_PER_PAGE);
                        let currentPage = 1;

                        // Fonction pour détecter la taille de l'écran et ajuster le nombre d'items
                        function updateItemsPerPage() {
                            const width = window.innerWidth;
                            
                            if (width <= 768) {
                                ITEMS_PER_PAGE = 1; // Mobile: 1 carte par page
                            } else if (width <= 992) {
                                ITEMS_PER_PAGE = 2; // Tablette: 2 cartes par page
                            } else {
                                ITEMS_PER_PAGE = 3; // Desktop: 3 cartes par page
                            }
                            
                            totalPages = Math.ceil(totalItems / ITEMS_PER_PAGE);
                            
                            // Réinitialiser à la première page si nécessaire
                            if (currentPage > totalPages) {
                                currentPage = totalPages;
                            }
                            
                            // Recréer les dots
                            document.getElementById('pageDots').innerHTML = '';
                            createPageDots();
                            
                            // Mettre à jour l'affichage
                            document.getElementById('totalPages').textContent = totalPages;
                            goToPage(currentPage);
                        }

                        // Initialisation
                        updateItemsPerPage();

                        // Écouter le redimensionnement de la fenêtre
                        let resizeTimer;
                        window.addEventListener('resize', function() {
                            clearTimeout(resizeTimer);
                            resizeTimer = setTimeout(function() {
                                updateItemsPerPage();
                            }, 250);
                        });

                        function createPageDots() {
                            const dotsContainer = document.getElementById('pageDots');
                            for (let i = 1; i <= totalPages; i++) {
                                const dot = document.createElement('div');
                                dot.className = 'page-dot' + (i === currentPage ? ' active' : '');
                                dot.onclick = () => goToPage(i);
                                dotsContainer.appendChild(dot);
                            }
                        }

                        function changePage(direction) {
                            const newPage = currentPage + direction;
                            if (newPage >= 1 && newPage <= totalPages) {
                                goToPage(newPage);
                            }
                        }

                        function goToPage(page) {
                            currentPage = page;
                            
                            // Cacher toutes les cartes
                            cards.forEach(card => card.classList.remove('active'));
                            
                            // Afficher les cartes de la page actuelle
                            const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
                            const endIndex = startIndex + ITEMS_PER_PAGE;
                            
                            for (let i = startIndex; i < endIndex && i < totalItems; i++) {
                                cards[i].classList.add('active');
                            }
                            
                            updatePagination();
                            
                            // Scroll vers le haut des actualités (sauf au chargement initial)
                            if (page !== 1 || currentPage !== 1) {
                                document.querySelector('.actualites-section').scrollIntoView({ 
                                    behavior: 'smooth',
                                    block: 'start'
                                });
                            }
                        }

                        function updatePagination() {
                            // Mettre à jour le numéro de page
                            document.getElementById('currentPage').textContent = currentPage;
                            
                            // Activer/désactiver les boutons
                            document.getElementById('prevBtn').disabled = currentPage === 1;
                            document.getElementById('nextBtn').disabled = currentPage === totalPages;
                            
                            // Mettre à jour les dots
                            const dots = document.querySelectorAll('.page-dot');
                            dots.forEach((dot, index) => {
                                dot.classList.toggle('active', index + 1 === currentPage);
                            });
                        }
                    </script>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>