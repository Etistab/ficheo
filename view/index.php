<?php
$title = 'Accueil';
ob_start();?>

<!-- Des liens en particulier dans le <head></head> ?? -->
<style>
#bloc{
  white-space: nowrap;
  overflow-y: hidden;
  overflow-x: visible;
  text-overflow: ellipsis;
  max-height: 300px;
  max-width: 600px;
  text-decoration: none;
  color: black ;
}
.lastSheet{
  text-decoration: none;
  color: black;
}
.lastSheet:hover{
  color: grey;
    text-decoration: none;
}

</style>
<?php
$files = ob_get_clean();
ob_start(); ?>

<section>
   <div class="container">
       <div id="demo" class="carousel slide" data-ride="carousel">

          <!-- Indicators -->
          <ul class="carousel-indicators">
            <li data-target="#demo" data-slide-to="0" class="active"></li>
            <li data-target="#demo" data-slide-to="1"></li>
            <li data-target="#demo" data-slide-to="2"></li>
          </ul>

          <!-- The slideshow -->
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="public/images/math.jpg" alt="Maths" width="1100" height="500" >
            </div>
            <div class="carousel-item">
              <img src="public/images/les_news.jpg" alt="Maths" width="1100" height="500">
            </div>
            <div class="carousel-item">
              <img src="public/images/epreuves.jpg" alt="Maths" width="1100" height="500">
            </div>
          </div>

          <!-- Left and right controls -->
          <a class="carousel-control-prev" href="#demo" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </a>
          <a class="carousel-control-next" href="#demo" data-slide="next">
            <span class="carousel-control-next-icon"></span>
          </a>

        </div>
   </div>
</section>

<br><br><br>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-4">
                <p class="text-center">
                    Ficheo est un site de partage de fiches de révision en ligne.
                    Tous les collégiens et lycéens peuvent venir ajouter leurs propres fiches et aussi regarder les fiches des
                    autres gratuitement.
                    Le site possède aussi une partie Quizz permettant de créer ses propres exercices et essayer les exercices des
                    autres membres.
                    N'hesitez pas à venir partager vos connaissances et aussi à valoriser les connaissances en mettant une
                    note sur leur fiche.<br/>
                    BONNE REVISION ! 🙂

                </p>
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-4">
                <img src="public/images/fiche.jpg" height="350" width="400">
            </div>
            <div class="col-sm-1"></div>
        </div>
    </div>
</section>

<br><br><br>

<section style="padding-top:20px;padding-bottom:20px; background-image:url(public/images/2.png)">
    <div class="container">
        <div class="row" >
            <div class="col-sm-5">
                <a href="<?php printLastSheet("college", true); ?>"><img src="public/images/chimie.jpg" class="cercle" class="img-responsive" alt="Cinque Terre" width="400" height="400"></a>
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-5" style="margin-top: 65px;" id="bloc">
                <h2>Derniere fiche Niveau College</h2>
                <p>
                    <?php printLastSheet("college"); ?><br>
                </p>
            </div>
        </div>
    </div>
</section>

<br><br><br>

<section class="container">
    <div class="row">
      <div class="col-sm-5"  style="margin-top: 65px;" id="bloc">
          <h2>Derniere fiche Niveau Lycée</h2>
          <p>
              <?php printLastSheet("lycee"); ?><br>
          </p>
      </div>
      <div class="col-sm-2"> </div>
      <div class="col-sm-5">
          <a href="<?php printLastSheet("lycee", true); ?>"><img src="public/images/math.jpg" class="cercle"  alt="Cinque Terre" width="400" height="400"></a>
      </div>
    </div>
</section>

<?php $content = ob_get_clean();

require('template.php'); ?>
