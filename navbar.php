<?php
// Récupérer la page actuelle
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav" style="background-color: #1b4f72;">
    <div class="container">
        <!-- Logo mobile -->
        <a class="navbar-brand text-uppercase fw-bold d-lg-none" href="index.php">
            <img src="assets/favicon.png" alt="ASG" style="height:35px; margin-right:10px;">
            St GABRIEL
        </a>
        
        <!-- Bouton toggle mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto">
                
                <!-- Logo desktop avec nom à gauche -->
                <li class="nav-item px-lg-4 d-none d-lg-block">
                    <a class="nav-link d-flex align-items-center" href="index.php" style="gap: 15px;">
                        <span class="brand-name text-uppercase fw-bold" style="font-size: 1.2rem; letter-spacing: 1px;">
                            Assurances Saint Gabriel
                        </span>
                        <img src="assets/favicon.png" alt="ASG Logo" style="height:50px;">
                    </a>
                </li>

                <!-- Menu principal -->
                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase <?= $current_page === 'index' ? 'active' : '' ?>" 
                       href="index.php">Accueil</a>
                </li>
                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase <?= $current_page === 'about' ? 'active' : '' ?>" 
                       href="about.php">Nos activités</a>
                </li>
                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase <?= $current_page === 'products' ? 'active' : '' ?>" 
                       href="products.php">Nos contrats</a>
                </li>
                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase <?= $current_page === 'crew' ? 'active' : '' ?>" 
                       href="crew.php">Nos équipes</a>
                </li>
                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase <?= $current_page === 'contact' ? 'active' : '' ?>" 
                       href="contact.php">Nous contacter</a>
                </li>

                <!-- Menu utilisateur (adapté au rôle) -->
                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item dropdown px-lg-4">
                        <a class="nav-link dropdown-toggle text-uppercase user-menu" href="#" id="userDropdown" 
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle"></i> 
                            <span class="user-name">Mon compte</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <!-- En-tête du menu avec info utilisateur -->
                            <li class="dropdown-header">
                                <div class="user-info">
                                    <i class="fas fa-user-circle fa-2x"></i>
                                    <div>
                                        <strong><?= htmlspecialchars($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']) ?></strong>
                                        <small class="d-block text-muted">
                                            <?php
                                            switch($_SESSION['user']['role_id']) {
                                                case 1: echo '<span class="badge-role admin">Administrateur</span>'; break;
                                                case 2: echo '<span class="badge-role collab">Collaborateur</span>'; break;
                                                case 3: echo '<span class="badge-role client">Client</span>'; break;
                                                default: echo '<span class="badge-role">Utilisateur</span>';
                                            }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>

                            <?php if ($_SESSION['user']['role_id'] == 1): ?>
                                <!-- Menu Admin -->
                                <li>
                                    <a class="dropdown-item <?= $current_page === 'admin' ? 'active-page' : '' ?>" href="admin.php">
                                        <i class="fas fa-user-shield"></i> Panneau d'administration
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="admin.php#users">
                                        <i class="fas fa-users"></i> Gestion utilisateurs
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="admin.php#actualites">
                                        <i class="fas fa-newspaper"></i> Gestion actualités
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="interface.php">
                                        <i class="fas fa-eye"></i> Vue client
                                    </a>
                                </li>

                            <?php elseif ($_SESSION['user']['role_id'] == 2): ?>
                                <!-- Menu Collaborateur -->
                                <li>
                                    <a class="dropdown-item <?= $current_page === 'collaborateur' ? 'active-page' : '' ?>" href="collaborateur.php">
                                        <i class="fas fa-briefcase"></i> Mon espace collaborateur
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="collaborateur.php#clients">
                                        <i class="fas fa-users"></i> Mes clients
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="collaborateur.php#contrats">
                                        <i class="fas fa-file-contract"></i> Contrats en cours
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="collaborateur.php#stats">
                                        <i class="fas fa-chart-line"></i> Statistiques
                                    </a>
                                </li>

                            <?php elseif ($_SESSION['user']['role_id'] == 3): ?>
                                <!-- Menu Client -->
                                <li>
                                    <a class="dropdown-item <?= $current_page === 'interface' ? 'active-page' : '' ?>" href="interface.php">
                                        <i class="fas fa-home"></i> Mon espace personnel
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="interface.php#contrats">
                                        <i class="fas fa-file-contract"></i> Mes contrats
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="interface.php#sinistres">
                                        <i class="fas fa-exclamation-triangle"></i> Déclarer un sinistre
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="interface.php#documents">
                                        <i class="fas fa-folder"></i> Mes documents
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="interface.php#profil">
                                        <i class="fas fa-user-edit"></i> Mon profil
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <li><hr class="dropdown-divider"></li>
                            
                            <li>
                                <a class="dropdown-item text-danger logout-btn" href="logout.php" onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?')">
                                    <i class="fas fa-sign-out-alt"></i> Se déconnecter
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <!-- Non connecté -->
                    <li class="nav-item px-lg-4">
                        <a class="nav-link text-uppercase btn-connexion" href="connexion.php">
                            <i class="fas fa-sign-in-alt"></i> Se connecter
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<style>
    /* Style pour le lien actif dans la navbar principale */
    .navbar-nav .nav-link.active {
        border-bottom: 3px solid #5dade2;
        font-weight: bold;
    }

    /* Style du logo et nom de marque */
    .brand-name {
        color: white;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        transition: all 0.3s ease;
    }

    .brand-name:hover {
        color: #5dade2;
        text-shadow: 2px 2px 8px rgba(93, 173, 226, 0.5);
    }

    /* Style du menu utilisateur */
    .user-menu {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        padding: 8px 16px !important;
        transition: all 0.3s ease;
    }

    .user-menu:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }

    .user-menu .user-name {
        font-weight: 600;
    }

    /* Bouton connexion pour non-connectés */
    .btn-connexion {
        background: #3498db;
        border-radius: 8px;
        padding: 8px 20px !important;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-connexion:hover {
        background: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    /* Style dropdown amélioré */
    .dropdown-menu {
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        border: none;
        padding: 0;
        min-width: 280px;
        margin-top: 10px;
    }

    /* En-tête du dropdown */
    .dropdown-header {
        background: linear-gradient(135deg, #1b4f72 0%, #2874a6 100%);
        color: white;
        padding: 20px;
        border-radius: 12px 12px 0 0;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-info i {
        font-size: 2em;
    }

    .user-info strong {
        font-size: 16px;
        display: block;
        margin-bottom: 5px;
    }

    /* Badges de rôle */
    .badge-role {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-role.admin {
        background: #e74c3c;
        color: white;
    }

    .badge-role.collab {
        background: #f39c12;
        color: white;
    }

    .badge-role.client {
        background: #27ae60;
        color: white;
    }

    /* Items du dropdown */
    .dropdown-item {
        padding: 12px 20px;
        transition: all 0.2s ease;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .dropdown-item i {
        width: 20px;
        text-align: center;
        opacity: 0.7;
    }

    .dropdown-item:hover {
        background: linear-gradient(90deg, #3498db 0%, #2980b9 100%);
        color: white;
        padding-left: 25px;
    }

    .dropdown-item:hover i {
        opacity: 1;
    }

    .dropdown-item.active-page {
        background: #ecf0f1;
        font-weight: 600;
        border-left: 4px solid #3498db;
    }

    /* Bouton déconnexion */
    .logout-btn {
        font-weight: 600;
    }

    .logout-btn:hover {
        background: linear-gradient(90deg, #e74c3c 0%, #c0392b 100%) !important;
    }

    /* Divider */
    .dropdown-divider {
        margin: 8px 0;
        border-color: rgba(0,0,0,0.08);
    }

    /* Animation d'ouverture du dropdown */
    .dropdown-menu {
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 991px) {
        .dropdown-menu {
            min-width: 100%;
        }

        .user-menu {
            justify-content: center;
            margin: 10px 0;
        }
        
        .btn-connexion {
            justify-content: center;
            margin: 10px 0;
        }
    }
</style>