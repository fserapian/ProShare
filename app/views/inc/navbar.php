<nav id="navbar" class="green lighten-2">
    <div class="container">
        <div class="nav-wrapper">
            <!-- Logo -->
            <a href="<?php echo URLROOT; ?>" class="brand-logo"><i class="material-icons m-48 text-primary">layers</i><span class="text-primary">Pro</span>Share</a>
            <a href="#" data-target="mobile-nav" class="sidenav-trigger">
                <i class="material-icons">menu</i>
            </a>
            <ul class="right hide-on-med-and-down">
                <li>
                    <?php if (isset($_SESSION['user_id'])) : ?>
                        <div class="chip">
                            <!-- image de profil dans le navbar -->
                            <?php if ($_SESSION['user_image'] !== '') : ?>
                                <img src="<?php echo URLROOT; ?>/img/<?php echo $_SESSION['user_image'] ?>" alt="">
                            <?php endif; ?>
                            <?php echo $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name']; ?>
                        </div>
                    <?php endif; ?>
                </li>
                <li>
                    <a href="<?php echo URLROOT; ?>">Accueil</a>
                </li>
                <?php if (isset($_SESSION['user_id']) && $_SESSION['level'] == 3) : ?>
                    <li>
                        <a href="<?php echo URLROOT; ?>/users/admin">Gestion des utilisateurs</a>
                    </li>
                    <li>
                        <a href="<?php echo URLROOT; ?>/users/logout">Se déconnecter</a>
                    </li>
                <?php elseif (isset($_SESSION['user_id']) && $_SESSION['level'] !== 3) : ?>
                    <li>
                        <a href="<?php echo URLROOT; ?>/users/settings/<?php echo $_SESSION['user_id']; ?>">Paramètres du compte</a>
                    </li>
                    <li>
                        <a href="<?php echo URLROOT; ?>/users/logout">Se déconnecter</a>
                    </li>
                <?php else : ?>
                    <li>
                        <a href="<?php echo URLROOT; ?>/posts">Voir les projets</a>
                    </li>
                    <li>
                        <a href="<?php echo URLROOT; ?>/users/register">Créer un compte</a>
                    </li>
                    <li>
                        <a href="<?php echo URLROOT; ?>/users/login">Se connecter</a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="sidenav black" id="mobile-nav">
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <li>
                        <div class="user-view">
                            <div class="background">
                                <img id="sideImage" src="<?php echo URLROOT; ?>/img/<?php echo $_SESSION['user_image']; ?>" alt="" style="width: 100%; object-fit: contain">
                            </div>
                            <h4><?php echo $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name']; ?></h4>
                            <p><?php echo $_SESSION['user_email']; ?></p>
                        </div>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="<?php echo URLROOT; ?>">Accueil</a>
                </li>
                <li>
                    <a href="<?php echo URLROOT; ?>/pages/about">À propos</a>
                </li>
                <?php if (isset($_SESSION['user_id']) && $_SESSION['level'] == 3) : ?>
                    <li>
                        <a href="<?php echo URLROOT; ?>/users/admin/<?php echo $_SESSION['user_id']; ?>">Gestion des utilisateurs</a>
                    </li>
                <?php else : ?>
                    <li>
                        <a href="<?php echo URLROOT; ?>/users/settings/<?php echo $_SESSION['user_id']; ?>">Paramètres du compte</a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="<?php echo URLROOT; ?>/users/logout">Se déconnecter</a>
                </li>
            </ul>
        </div>
    </div>
</nav>