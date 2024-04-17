<?php 
session_start();
ob_start(); 
include "function.php";
$requete                = $requete_fichePersonne->fetch();
$requeteRealisateur     = $requete_infosRealisateur->fetchAll();
$requeteActeur          = $requete_infosActeur->fetchAll();
//var_dump($requete);?>


<section class="section_info_personne">
    <div class="personne_profil">
        <img src="<?= $requete["profil"];?>" alt="">
    </div>
    <div class="personne_info">
        <span>Métier                : <?php if($requeteRealisateur){echo " Realisateur ";} if($requeteActeur){echo " Acteur ";}?></span>
        <span>Date de Naissance     : <?php echo date('d-m-Y', strtotime($requete["date_naissance"]))?></span><br>
        <?php if($requeteRealisateur){?>
        <span>1ère Réalisation      : <?= $requeteRealisateur[0]["titre"]?></span>
        <span>Dernière Réalisation  : <?= end($requeteRealisateur)["titre"]?></span><br>
        <?php } ?>
        <?php if($requeteActeur){?>
        <span>1er film joué         : <?= $requeteActeur[0]["titre"]?></span>
        <span>Dernier film joué     : <?= end($requeteActeur)["titre"]?></span>
        <?php } ?>
    </div>
    <div class="icon_chiffre">
        <a href="index.php?action=modif_personne&id=<?=$requete["id"]?>">
            <div class="logo">
                <i class="ri-edit-box-line"></i>
            </div>
        </a>
        <div class="chiffre">
            <div class="chiffre_film">
                <span>Film réalisé<br><?=count($requeteRealisateur)?></span>
            </div>
            <div class="chiffre_acteur">
                <span>Acteur dans<br><?=count($requeteActeur)?> film</span>
            </div>
        </div>
    </div>
</section>

<?php
    list_defilement("listFilms", "film_fiche_view", "Films réalisés", $requete_listFilmsPerRealisateur, "defaut");
    list_defilement("listFilms", "film_fiche_view", "Filmographie/Role", $requete_listFilmsPerActeur, "defaut");
?>

<?php

$titre = $requete["personne"];
$titre_secondaire = $titre;
$contenu = ob_get_clean();
require_once "template.php";