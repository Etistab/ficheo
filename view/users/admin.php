<?php
$title = 'Espace membre';
ob_start();?>
<script src="public/js/alert.js"></script>
<script src="public/js/ajax.js"></script>
<?php
$files = ob_get_clean();
ob_start(); ?>

            <div class="col-sm-6">
                <div class="container">
                  <br>
                    <div id="accordion" class="accordion">
                        <div class="card mb-0">
                            <div class="card-header collapsed" data-toggle="collapse" href="#collapseOne">
                                <a class="card-title">
                                    Nouvelles Fiches à accepter
                                </a>
                            </div>
                            <div id="collapseOne" class="card-body collapse" data-parent="#accordion" >
                                <p>
                                    <?php printInactiveSheets(); ?>
                                </p>
                            </div>
                            <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                <a class="card-title">
                                    Nouveaux Quizz à accepter
                                </a>
                            </div>
                            <div id="collapseTwo" class="card-body collapse" data-parent="#accordion" >
                                <p>
                                    <?php printInactiveQuiz(); ?>
                                </p>
                            </div>
                            <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                <a class="card-title">
                                    Modifications des Quizz à accepter
                                </a>
                            </div>
                            <div id="collapseThree" class="card-body collapse" data-parent="#accordion" >
                                <p>
                                    <?php printModifQuiz(); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <br>
                    <p>
                    </p>

                    <a href="index.php?page=user&section=admin&action=usersModif" class="btn btn-secondary"> <h4> Gérer les Utilisateurs  </h4> </a><br><br>
                    <a href="index.php?page=user&section=admin&action=reports" class="btn btn-secondary"><h4>Gérer les signalements</h4></a>
                    <br><br>
                </div>
            </div>

            <div class="col-sm-3">
                <br>
                <p><b>
                        Nombre de pages consultées : <span id="numberOfViews"><?= getTotalViews(); ?></span><br>
                        <a onclick="alert_delete('index.php?page=user&section=admin&action=resetViews')">Réinitialiser</a>
                    </b></p>

                <a href="index.php?page=user&section=admin&action=mail" id="newsletter" style="margin-top: 9%;"> <h4> Envoyer un mail </h4> </a><br><br>
                <a href="index.php?page=user&section=admin&action=quizModif" class="btn btn-primary"> <h4> Administration des quiz  </h4> </a><br><br>
                <a href="index.php?page=user&section=admin&action=sheetsModif" class="btn btn-primary"> <h4> Administration des fiches  </h4> </a><br><br>
            </div>

<?php $body = ob_get_clean();
require ("view/users/template.php");
?>
