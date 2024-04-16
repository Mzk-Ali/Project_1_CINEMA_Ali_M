<?php


function list_defilement($type, $action, $titre_list, $requete_list, $requete_secondList){
    ?>
    <section class="list_defilement">
        <h2><?= $titre_list ?></h2>

        <?php
        if($type == "listFilmsGenre"){?>
            <div class="container_button_genre">
                <?php 
                foreach($requete_secondList->fetchAll() as $keys)
                {?>
                <a href="index.php?action=film_view&genre=<?=$keys["genre"]?>">
                    <div class="button_genre"><?=$keys["genre"]?></div>
                </a>
                <?php
                }
                ?>
            </div>
        <?php
        }
        else if($type == "listActeursperRole"){?>
            <div class="container_list_role">
                <form action="">
                    <select name="role" id="role">
                        <option value=""></option>
                        <option value="" selected hidden>Sélectionne le Role</option>
                        <?php
                            foreach($requete_secondList->fetchAll() as $keys) { ?>
                                <option value="<?=$keys["id_role"]?>"><?=$keys["nom_personnage"]?></option>
                        <?php }?>
                    </select>
                    <input class="" type="submit" name="submit" value="GO">
                </form>
            </div>
        <?php
        }
        ?>


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
                                <img src="
                                    <?php 
                                        if($type == "listFilms" || $type == "listFilmsGenre")
                                        {
                                            echo $keys["affiche_film"];
                                        }
                                        elseif($type == "listActeurs")
                                        {
                                            echo $keys["profil"];
                                        }
                                        elseif($type == "listRealisateurs")
                                        {
                                            echo $keys["profil"];
                                        }
                                     ?>
                                " alt="affiche film">
                            </div>
                            <div class="info_card">
                                <p><?php 
                                    if($type == "listFilms" || $type == "listFilmsGenre")
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
