<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Charte graphique - Assurances Saint Gabriel</title>
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
            padding: 50px 20px;
            max-width: 1100px;
            margin: 0 auto;
            width: 100%;
        }

        .charte-container {
            background: white;
            padding: 40px 50px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .charte-container h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 32px;
            border-bottom: 3px solid #3498db;
            padding-bottom: 15px;
        }

        .charte-container .subtitle {
            color: #999;
            font-size: 16px;
            margin-bottom: 40px;
        }

        .charte-container h2 {
            color: #3498db;
            margin-top: 40px;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .charte-container p {
            color: #666;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: 0.3s;
        }

        .back-btn:hover {
            background: #2980b9;
        }

        /* Section logo */
        .logo-section {
            text-align: center;
            padding: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            margin: 30px 0;
        }

        .logo-section h3 {
            color: white;
            font-size: 48px;
            font-weight: 900;
            margin: 0;
            letter-spacing: 2px;
        }

        .logo-description {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        /* Couleurs */
        .colors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .color-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .color-sample {
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
        }

        .color-info {
            padding: 15px;
            background: white;
            text-align: center;
        }

        .color-info h4 {
            margin: 0 0 8px 0;
            color: #333;
        }

        .color-info p {
            margin: 5px 0;
            font-size: 13px;
            color: #666;
        }

        /* Typographie */
        .typo-sample {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 12px;
            margin: 20px 0;
            border-left: 4px solid #3498db;
        }

        .typo-sample h3 {
            margin-top: 0;
            color: #333;
        }

        .font-raleway {
            font-family: 'Raleway', sans-serif;
        }

        .font-lora {
            font-family: 'Lora', serif;
        }

        .font-sample-large {
            font-size: 48px;
            font-weight: 700;
            margin: 20px 0;
        }

        .font-weights {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }

        .weight-item {
            flex: 1;
            min-width: 150px;
        }

        .weight-item span {
            display: block;
            font-size: 24px;
            margin-bottom: 5px;
        }

        .weight-item small {
            color: #999;
            font-size: 12px;
        }

        /* Icônes */
        .icons-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .icon-item {
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            transition: 0.3s;
        }

        .icon-item:hover {
            background: #e9ecef;
            transform: translateY(-3px);
        }

        .icon-item i {
            font-size: 36px;
            color: #3498db;
            margin-bottom: 10px;
        }

        .icon-item p {
            margin: 0;
            font-size: 12px;
            color: #666;
        }

        /* Boutons */
        .buttons-demo {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin: 30px 0;
        }

        .demo-btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary-demo {
            background: #3498db;
            color: white;
        }

        .btn-primary-demo:hover {
            background: #2980b9;
        }

        .btn-success-demo {
            background: #27ae60;
            color: white;
        }

        .btn-success-demo:hover {
            background: #229954;
        }

        .btn-danger-demo {
            background: #e74c3c;
            color: white;
        }

        .btn-danger-demo:hover {
            background: #c0392b;
        }

        .btn-secondary-demo {
            background: #95a5a6;
            color: white;
        }

        .btn-secondary-demo:hover {
            background: #7f8c8d;
        }

        footer {
            background: #222;
            color: #aaa;
            text-align: center;
            padding: 20px 0;
            margin-top: 40px;
        }

        footer a {
            color: #3498db;
            text-decoration: none;
            margin: 0 15px;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <?php include('navbar.php'); ?>

    <!-- Contenu -->
    <div class="page-content">
        <a href="index.php" class="back-btn"><i class="fas fa-arrow-left"></i> Retour à l'accueil</a>
        
        <div class="charte-container">
            <h1><i class="fas fa-palette"></i> Charte graphique</h1>
            <p class="subtitle">Guide de style et identité visuelle d'Assurances Saint Gabriel</p>

            <!-- Logo -->
            <h2>Logo & Identité</h2>
            <div class="logo-section">
                <h3>ST GABRIEL</h3>
            </div>
            <div class="logo-description">
                <p><strong>Description :</strong> Le logo d'Assurances Saint Gabriel utilise une typographie en capitales avec un espacement des lettres pour transmettre confiance et solidité. Le fond dégradé (violet-bleu) évoque la modernité et l'innovation.</p>
                <p><strong>Usage :</strong> Le logo doit toujours être présenté avec un espace libre minimum autour de lui (équivalent à la hauteur de la lettre "G").</p>
            </div>

            <!-- Couleurs -->
            <h2>Palette de couleurs</h2>
            <p>Notre palette de couleurs reflète notre engagement envers la confiance, la sécurité et la modernité.</p>
            
            <div class="colors-grid">
                <div class="color-card">
                    <div class="color-sample" style="background-color: #3498db;">
                        Primaire
                    </div>
                    <div class="color-info">
                        <h4>Bleu Primaire</h4>
                        <p>HEX: #3498db</p>
                        <p>RGB: 52, 152, 219</p>
                        <p><strong>Usage :</strong> Boutons, liens, éléments principaux</p>
                    </div>
                </div>

                <div class="color-card">
                    <div class="color-sample" style="background-color: #2980b9;">
                        Secondaire
                    </div>
                    <div class="color-info">
                        <h4>Bleu Foncé</h4>
                        <p>HEX: #2980b9</p>
                        <p>RGB: 41, 128, 185</p>
                        <p><strong>Usage :</strong> Survol, variations</p>
                    </div>
                </div>

                <div class="color-card">
                    <div class="color-sample" style="background-color: #27ae60;">
                        Succès
                    </div>
                    <div class="color-info">
                        <h4>Vert Succès</h4>
                        <p>HEX: #27ae60</p>
                        <p>RGB: 39, 174, 96</p>
                        <p><strong>Usage :</strong> Confirmations, succès</p>
                    </div>
                </div>

                <div class="color-card">
                    <div class="color-sample" style="background-color: #e74c3c;">
                        Alerte
                    </div>
                    <div class="color-info">
                        <h4>Rouge Alerte</h4>
                        <p>HEX: #e74c3c</p>
                        <p>RGB: 231, 76, 60</p>
                        <p><strong>Usage :</strong> Erreurs, suppressions</p>
                    </div>
                </div>

                <div class="color-card">
                    <div class="color-sample" style="background-color: #222; color: white;">
                        Texte Principal
                    </div>
                    <div class="color-info">
                        <h4>Gris Foncé</h4>
                        <p>HEX: #222222</p>
                        <p>RGB: 34, 34, 34</p>
                        <p><strong>Usage :</strong> Textes, titres</p>
                    </div>
                </div>

                <div class="color-card">
                    <div class="color-sample" style="background-color: #f5f5f5; color: #333;">
                        Fond
                    </div>
                    <div class="color-info">
                        <h4>Gris Clair</h4>
                        <p>HEX: #f5f5f5</p>
                        <p>RGB: 245, 245, 245</p>
                        <p><strong>Usage :</strong> Arrière-plans</p>
                    </div>
                </div>
            </div>

            <!-- Typographie -->
            <h2>Typographie</h2>
            
            <div class="typo-sample">
                <h3 class="font-raleway">Raleway - Police principale</h3>
                <div class="font-sample-large font-raleway">
                    AaBbCc 123
                </div>
                <p><strong>Usage :</strong> Interface utilisateur, navigation, boutons, textes courants</p>
                <p><strong>Graisses disponibles :</strong></p>
                <div class="font-weights">
                    <div class="weight-item">
                        <span class="font-raleway" style="font-weight: 400;">Regular</span>
                        <small>Font-weight: 400</small>
                    </div>
                    <div class="weight-item">
                        <span class="font-raleway" style="font-weight: 500;">Medium</span>
                        <small>Font-weight: 500</small>
                    </div>
                    <div class="weight-item">
                        <span class="font-raleway" style="font-weight: 700;">Bold</span>
                        <small>Font-weight: 700</small>
                    </div>
                    <div class="weight-item">
                        <span class="font-raleway" style="font-weight: 900;">Black</span>
                        <small>Font-weight: 900</small>
                    </div>
                </div>
            </div>

            <div class="typo-sample">
                <h3 class="font-lora">Lora - Police secondaire</h3>
                <div class="font-sample-large font-lora">
                    AaBbCc 123
                </div>
                <p><strong>Usage :</strong> Citations, contenus éditoriaux, accents de style</p>
                <p><strong>Graisses disponibles :</strong></p>
                <div class="font-weights">
                    <div class="weight-item">
                        <span class="font-lora" style="font-weight: 400;">Regular</span>
                        <small>Font-weight: 400</small>
                    </div>
                    <div class="weight-item">
                        <span class="font-lora" style="font-weight: 700;">Bold</span>
                        <small>Font-weight: 700</small>
                    </div>
                </div>
            </div>

            <!-- Icônes -->
            <h2>Iconographie</h2>
            <p>Nous utilisons Font Awesome 5.15.3 pour notre iconographie. Voici quelques icônes couramment utilisées :</p>
            
            <div class="icons-grid">
                <div class="icon-item">
                    <i class="fas fa-car"></i>
                    <p>Auto</p>
                </div>
                <div class="icon-item">
                    <i class="fas fa-home"></i>
                    <p>Habitation</p>
                </div>
                <div class="icon-item">
                    <i class="fas fa-heartbeat"></i>
                    <p>Santé</p>
                </div>
                <div class="icon-item">
                    <i class="fas fa-shield-alt"></i>
                    <p>Protection</p>
                </div>
                <div class="icon-item">
                    <i class="fas fa-user"></i>
                    <p>Utilisateur</p>
                </div>
                <div class="icon-item">
                    <i class="fas fa-phone"></i>
                    <p>Contact</p>
                </div>
                <div class="icon-item">
                    <i class="fas fa-envelope"></i>
                    <p>Email</p>
                </div>
                <div class="icon-item">
                    <i class="fas fa-graduation-cap"></i>
                    <p>Scolaire</p>
                </div>
            </div>

            <!-- Boutons -->
            <h2>Boutons & Éléments interactifs</h2>
            <p>Nos boutons suivent un design cohérent avec des coins arrondis (8px) et des transitions douces (0.3s).</p>
            
            <div class="buttons-demo">
                <button class="demo-btn btn-primary-demo">Bouton Principal</button>
                <button class="demo-btn btn-success-demo">Bouton Succès</button>
                <button class="demo-btn btn-danger-demo">Bouton Danger</button>
                <button class="demo-btn btn-secondary-demo">Bouton Secondaire</button>
            </div>

            <p><strong>États des boutons :</strong></p>
            <ul>
                <li><strong>Normal :</strong> Couleur de base</li>
                <li><strong>Survol (hover) :</strong> Couleur légèrement plus foncée + légère élévation</li>
                <li><strong>Actif (active) :</strong> Couleur encore plus foncée</li>
                <li><strong>Désactivé (disabled) :</strong> Opacité à 50%, curseur non-cliquable</li>
            </ul>

            <!-- Espacement -->
            <h2>Espacement & Grille</h2>
            <p>Notre système d'espacement est basé sur des multiples de 4px pour garantir une cohérence visuelle :</p>
            <ul>
                <li><strong>Espacement XS :</strong> 4px - Entre icônes et textes</li>
                <li><strong>Espacement S :</strong> 8px - Entre éléments rapprochés</li>
                <li><strong>Espacement M :</strong> 16px - Espacement standard entre éléments</li>
                <li><strong>Espacement L :</strong> 24px - Entre sections</li>
                <li><strong>Espacement XL :</strong> 32px - Entre blocs majeurs</li>
                <li><strong>Espacement XXL :</strong> 48px+ - Sections principales</li>
            </ul>

            <!-- Ombres -->
            <h2>Ombres & Profondeur</h2>
            <p>Nous utilisons des ombres subtiles pour créer une hiérarchie visuelle :</p>
            <ul>
                <li><strong>Ombre légère :</strong> 0 2px 8px rgba(0,0,0,0.08) - Cartes au repos</li>
                <li><strong>Ombre moyenne :</strong> 0 4px 20px rgba(52,152,219,0.15) - Cartes survolées</li>
                <li><strong>Ombre forte :</strong> 0 10px 40px rgba(0,0,0,0.2) - Modales et popups</li>
            </ul>

            <!-- Principes de design -->
            <h2>Principes de design</h2>
            <div class="logo-description">
                <p><strong>1. Épuration</strong><br>
                Lignes fines, bords arrondis (12-20px), design non agressif pour transmettre professionnalisme et confiance.</p>

                <p><strong>2. Lisibilité</strong><br>
                Utilisation du "negative space" (espaces vides) pour améliorer la lecture et réduire la fatigue visuelle.</p>

                <p><strong>3. Hiérarchie visuelle</strong><br>
                Tailles de police, couleurs et espacements créent une hiérarchie claire guidant l'utilisateur.</p>

                <p><strong>4. Cohérence</strong><br>
                Tous les éléments suivent les mêmes règles : bordures, ombres, espacements, transitions.</p>

                <p><strong>5. Accessibilité</strong><br>
                Contrastes suffisants (WCAG AA), tailles de police lisibles (minimum 14px), zones cliquables suffisantes (minimum 44x44px).</p>
            </div>

            <!-- Applications -->
            <h2>Applications pratiques</h2>
            <p>Ces règles s'appliquent à tous les supports de communication d'Assurances Saint Gabriel :</p>
            <ul>
                <li>Site web et applications mobiles</li>
                <li>Documents administratifs et contrats</li>
                <li>Supports marketing (brochures, affiches)</li>
                <li>Signatures email</li>
                <li>Réseaux sociaux</li>
                <li>Vidéos et présentations</li>
            </ul>

            <div class="logo-description">
                <p><strong>Contact pour utilisation de la charte :</strong><br>
                Pour toute question concernant l'utilisation de cette charte graphique, contactez le service communication à <a href="mailto:communication@saintgabriel.fr">communication@saintgabriel.fr</a></p>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>