<!DOCTYPE html>
<html lang="fr">
    <head>
        <title><?= $title; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="public/css/style2.css">
        <script>
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
        <?= $files; ?>
    </head>
    <body>
        <?= messagesHeader(); ?>
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container">
                    <a class="navbar-brand" href="index.php">
                        <img src="public/images/logo1.png" alt="logo Ficheo" style="width: 150px">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                          <li class="nav-item active">
                            <a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>
                          </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Fiche
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="index.php?page=sheetsMenu">Tout</a>
                                    <a class="dropdown-item" href="index.php?page=sheetsMenu&rech=college">College</a>
                                    <a class="dropdown-item" href="index.php?page=sheetsMenu&rech=lycee">Lycée</a>
                                    <?php
                                    if(!empty($_SESSION['pseudo'])) {
                                        ?>
                                        <a class="dropdown-item" href="index.php?page=createSheet">Créer une fiche</a>
                                        <?php
                                    }
                                    ?>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="index.php?page=quizMenu">Quizz</a>
                                    <?php
                                    if(!empty($_SESSION['pseudo'])) {
                                        ?>
                                        <a class="dropdown-item" href="index.php?page=createQuiz">Créer un quizz</a>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </li>
                        </ul>
                        <?php
                        if(empty($_SESSION['pseudo'])) {
                            ?>
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#Connexion">
                                        Connexion
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#Inscription" style="margin-left : 10px;">
                                        Inscription
                                    </button>
                                </li>
                            </ul>
                            <?php
                        }
                        else {
                            ?>
                            <span class="navbar-text" >
                                <div class="row">
                                    <div class="col-sm-5" style="width:60px;height:60px;">
                                        <a href="index.php?page=user"><img src="<?= getGravatar($_SESSION['pseudo']) ?>" alt="Photo de profil"></a>
                                    </div>
                                    <div class="col-sm-7">
                                        <?= $_SESSION['pseudo'] ?>
                                        <?php
                                        if(!numberOfNotifications($_SESSION['id']) == 0){
                                        ?>
                                            <a href="index.php?page=user&section=notifs"><span class="badge badge-pill badge-danger"><?= numberOfNotifications($_SESSION['id']) ?></span></a>
                                        <?php } ?>
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                Profil
                                            </button>
                                            <div class="dropdown-menu">
                                                <a  class="dropdown-item" href="index.php?page=user"><div class="bouton_profil">Profil</div></a>
                                                <a  class="dropdown-item" href="index.php?page=user&section=param"><div class="bouton_profil">Paramètres</div></a>
                                                <a  class="dropdown-item" href="index.php?page=user&section=notifs">
                                                    <div class="bouton_profil">Notifications
                                                <?php
                                                if(!numberOfNotifications($_SESSION['id']) == 0)
                                                    echo '<span class="badge badge-pill badge-danger">'.numberOfNotifications($_SESSION['id']).'</span>';
                                                ?>
                                                    </div>
                                                </a>

                                                <?php

                                                if($_SESSION['type'] == 'admin'){
                                                    echo '<a  class="dropdown-item" href="index.php?page=user&section=admin"><div class="bouton_profil">Administration</div></a>';
                                                }

                                                ?>

                                                <div class="dropdown-divider"></div>
                                                <a  class="dropdown-item" href="index.php?page=disconnect"><div class="bouton_profil">Deconnexion</div></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="progress" style="margin-top:5px;margin-left:-10px;width:170px;" data-toggle="tooltip" title="<?= getUserInfo('experience') ?> / <?= calcXpForNextLevel(getUserInfo('experience')) ?>">
                                    <div class="progress-bar progress-bar-striped " style="width:<?= convertXpToPercent(getUserInfo('experience')) ?>%; " ></div>
                                </div>
                            </span>
                            <?php
                            }
                        ?>
                    </div>
                </div>
            </nav>
                <div class="modal fade" id="Connexion">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title" style="padding-left : 35%;">Connexion</h4>

                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form method="post" action="index.php?action=connexion">
                                    <label for="pseudo">Pseudo:</label><br>
                                    <input type="text" name="pseudo" id="pseudo" maxlength="12"
                                           placeholder="Maximum 12 caractères" required><br>
                                    <label for="password">Mot de passe:</label><br>
                                    <input type="password" name="password" id="password" maxlength="12"
                                           placeholder="Maximum 12 caractères" required><br><br>
                                    <input type="submit" class="btn btn-dark" value="Se connecter">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal"
                                            data-target="#forgetPassword" style="margin-left : 10px;">
                                        Mot de passe oublié ?
                                    </button>
                                </form>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer"><p style="margin-right: 30px; margin-top:15px;">Pas encore inscrit
                                    ? Faites-le maintenant! :)</p>
                                <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal"
                                        data-target="#Inscription" style="margin-left : 10px;">
                                    Inscription
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal fade" id="forgetPassword">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Un oubli ?</h4>

                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                Entre l'email avec lequel tu t'es inscris sur Ficheo pour que nous puissions te renvoyer un mot de passe !<br><br>
                                <form method="post" action="index.php?action=forgetPassword">
                                    <label for="pseudo">Email:</label><br>
                                    <input type="email" name="email" id="email" required><br><br>
                                    <input type="submit" class="btn btn-dark" value="Envoyer !">
                                </form>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer"><p style="margin-right: 30px; margin-top:15px;">Pas encore inscrit
                                    ? Faites-le maintenant! :)</p>
                                <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal"
                                        data-target="#Inscription" style="margin-left : 10px;">
                                    Inscription
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal fade" id="Inscription">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title" style="padding-left : 35%;">Inscription</h4>

                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form method="post" action="index.php?action=inscription" class="mx-auto">

                                    <label for="pseudo">Pseudo:</label><br>
                                    <input type="text" name="pseudo" id="pseudo" maxlength="12" minlength="3"
                                           placeholder="Maximum 12 caractères" required><br>
                                    <label for="password">Mot de passe:</label><br>
                                    <input type="password" name="password" id="password" maxlength="12" minlength="3"
                                           placeholder="Maximum 12 caractères" required><br>
                                    <label for="confirm_password">Confirmation du mot de passe:</label><br>
                                    <input type="password" name="confirm_password" id="confirm_password" maxlength="12"
                                           minlength="3" placeholder="Maximum 12 caractères" required><br>
                                    <label for="email">E-mail:</label><br>
                                    <input type="email" name="email" id="email" required><br>
                                    <br>
                                    <input type="submit" class="btn btn-dark" value="S'inscrire">
                                </form>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer"><p style="margin-right: 30px; margin-top:15px;">Déjà inscrit ?
                                    Connectez-vous maintenant! :) </p>
                                <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal"
                                        data-target="#Connexion">
                                    Connexion
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
        </header>
        <main>
            <?= $content; ?>
        </main>
        <br><br>
        <footer class="mainfooter style_footer" role="contentinfo">
  <div class="container"> <br>
    <div class="row">

    <div class="col-sm-4"></div>
    <div class="col-sm-4">
      <div class="footer-title">
        <h3 align="center">Nous contacter</h3><hr>
      </div>
    </div>
    <div class="col-sm-4"></div>
    </div>
    <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6 reseaux_sociaux" align="center" >
      <a  href="https://twitter.com/Ficheo2" target="_blank" ><img src="public/images/twitter.png" class="img_footer" /></a>
      <a href="https://www.facebook.com/Ficheo-2035224430032793/" target="_blank" ><img src="public/images/facebook.png" class="img_footer"  /></a>
      <a href="https://plus.google.com/u/0/101388764957066062178" target="_blank"><img src="public/images/google.png" class="img_footer" /></a>
      <a  href="mailto:contact.ficheo@gmail.com" target="_blank" ><img src="public/images/mail.png" class="img_footer"  /></a>
    </div>
      <div class="col-sm-3"></div>


    </div>
    <div class="row">
      <div class="col-sm-12">
        <a href="view/sitemap.xml" target="_blank">Site map </a><br>
        Site réalisé dans le cadre d'un projet annuel de première année a <a href="https://www.esgi.fr/">l'ESGI</a>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-10">
        <p>© 2018 Tout droits réservés à Ficheo</p>
      </div>
      <div class="col-sm-2">
        <a  href="#">Retourner en haut ↑</a>
      </div>

      </div>
    </div>
  </div>

</footer>
    </body>
</html>
