<?php 
session_start();
ob_start();?>


<section class="add">
    <h2>Fenêtre d'ajout</h1>
    <a href="index.php?action=add_personne_view"><div class="container_add">Ajout Personne</div></a>
    <a href="index.php?action=add_film_view"><div class="container_add">Ajout Film</div></a>
</section>

<?php

$titre = "";
// $titre_secondaire = "Liste des films";
$alert_message  = $alert_message;
$alert_type     = $alert_type;
$contenu = ob_get_clean();
require_once "template.php";