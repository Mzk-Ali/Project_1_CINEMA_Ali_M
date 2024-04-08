<?php 
session_start();
ob_start(); 
include "function.php";
$requete = $requete_ficheFilm->fetch();?>


<section class="section_info_film">
    <div class="film_img_note">
        <div class="affiche_film">
            <img src="<?php echo $requete["affiche_film"];?>" alt="Affiche du film">
        </div>
        <div class="note_film">
            <span>NOTE : <?php echo $requete["note"];?></span>
        </div>
    </div>
    <div class="film_info">
        <div class="info_logo">
            <div class="caracteristique">
                <span>Réalisé par : <?php echo $requete["personne"];?></span>
                <span>Sortie le : <?php echo $requete["date_sortie"]."  |   Durée : ".$requete["duree"]." minutes   |   ";
                                        foreach($requete_genre_film->fetchAll() as $keys){ 
                                            echo $keys["genre"]." ";
                                        }?></span>
            </div>
            <a href="index.php?action=modif_film&id=<?=$requete["id"]?>">
                <div class="logo">
                    <i class="ri-edit-box-line"></i>
                </div>
            </a>
        </div>
        <div class="film_synopsis">
            <span class="title_synopsis">Synopsis du FILM :</span>
            <span class="synopsis">
                <?php
                echo $requete["synopsis"];
                ?>
            </span>
        </div>
    </div>
</section>

<?php
    list_defilement("listActeurs", "personne_fiche_view", "Listes des Acteurs du film", $requete_listActeursThisFilm, "defaut");
?>

<?php

$titre = $requete["titre"];
$titre_secondaire = $titre;
$contenu = ob_get_clean();
require_once "template.php";