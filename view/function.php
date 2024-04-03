<?php


function list_defilement($type, $action, $titre_list, $requete_list){
    ?>
    <section class="list_defilement">
        <h2><?= $titre_list ?></h2>
        <div class="container_titre_list">
            <div class="left_button list_button">
                <i class="ri-arrow-left-s-line"></i>
            </div>
            <div class="container_list">
                <?php
                foreach($requete_list->fetchAll() as $keys) { ?>
                    <a href="index.php?action=<?=$action?>&id=<?=$keys["id"]?>">
                        <div class="container_card">
                            <div class="img_card">
                                <img src="https://fr.web.img5.acsta.net/c_310_420/medias/nmedia/18/65/88/40/18895516.jpg" alt="affiche film">
                            </div>
                            <div class="info_card">
                                <p><?php 
                                    if($type == "listFilms")
                                    {
                                        echo $keys["titre"];
                                    }
                                    elseif($type == "listActeurs")
                                    {
                                        echo $keys["personne"]." / ".$keys["nom_personnage"];
                                    }
                                    elseif($type == "listRealisateurs")
                                    {
                                        echo $keys["personne"];
                                    }
                                 ?></p>
                            </div>
                        </div>
                    </a>
                <?php }?>
            </div>
            <div class="right_button list_button">
                <i class="ri-arrow-right-s-line"></i>
            </div>
        </div>
        </section>

<?php
}

