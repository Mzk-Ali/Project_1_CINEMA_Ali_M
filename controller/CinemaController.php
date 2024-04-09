<?php

namespace Controller;
use Model\Connect;

class CinemaController {

/* ----------------------------------------  --------------------------------------------------- */

    // Execution et recuperation donnée par requête
    public function exec_recovery($requete){
        // Connexion à la base de données voulu
        $pdo = Connect::seConnecter();
        // Execute la requête voulu
        $requete_recovery = $pdo->query("$requete");
        return $requete_recovery;
    }

    // Execution et modification par requête
    public function exec_modif($requete){
        // Connexion à la base de données voulu
        $pdo = Connect::seConnecter();
        // Execute la requête voulu
        $pdo->query("$requete");
    }
/* --------------------------------------------------------------------------------------------- */


/* ----------------------------------------  --------------------------------------------------- */
    // Liste Film
    public function listFilms($filtre, $genre) {
        $requete = "
            SELECT titre, date_sortie, affiche_film, film.id_film AS id
            FROM film
            ";
        if($genre != "defaut")
        {
            $requete .= '
                INNER JOIN gestion_genre
                ON film.id_film = gestion_genre.id_film
                INNER JOIN genre
                ON gestion_genre.id_genre = genre.id_genre
                WHERE genre.genre = "'.$genre.'"';
        }
        if($filtre != "defaut")
        {
            $requete .= "ORDER BY ".$filtre." DESC";
        }
        $requete_recovery = $this->exec_recovery($requete);
        return $requete_recovery;
    }

    // Liste Personne
    public function listPersonne(){
        $requete = "
                SELECT CONCAT(nom, ' ',prenom) AS personne, personne.id_personne
                FROM personne
                ";
        $requete_recovery = $this->exec_recovery($requete);
        return $requete_recovery;
    }

    // Liste Realisateur
    public function listRealisateurs($filtre) {
        $requete = "SELECT ";
        if($filtre != "defaut"){
            $requete .= "$filtre AS filtre, ";
        }
         
        $requete .= "CONCAT(nom, ' ',prenom) AS personne, realisateur.id_personne AS id, realisateur.id_realisateur AS id_realisateur, profil
            FROM film
            INNER JOIN realisateur
            ON film.id_realisateur = realisateur.id_realisateur
            INNER JOIN personne
            ON realisateur.id_personne = personne.id_personne
            GROUP BY film.id_realisateur
            ";
        if($filtre != "defaut")
        {
            $requete .= "ORDER BY ".$filtre." DESC";
        }
        $requete_recovery = $this->exec_recovery($requete);
        return $requete_recovery;
    }

    // Liste Acteur
    public function listActeurs() {
        $requete = "
            SELECT CONCAT(nom, ' ',prenom) AS personne, acteur.id_personne AS id, profil
            FROM acteur, personne
            WHERE acteur.id_personne = personne.id_personne
            ";
        $requete_recovery = $this->exec_recovery($requete);
        return $requete_recovery;
    }


    // Liste de tous les genres de film
    public function listGenre(){
        $requete = "
            SELECT *
            FROM genre
            ";
        $requete_recovery = $this->exec_recovery($requete);
        return $requete_recovery;
    }


    // Liste Acteur selon l'id d'un film
    public function listActeursAndRoleperFilm($id) {
        $requete = "
            SELECT CONCAT(nom, ' ',prenom) AS personne, nom_personnage, acteur.id_personne AS id, profil
            FROM contrat
            INNER JOIN acteur
            ON contrat.id_acteur = acteur.id_acteur
            INNER JOIN personne
            ON acteur.id_personne = personne.id_personne
            INNER JOIN role
            ON contrat.id_role = role.id_role
            WHERE id_film = $id";
        $requete_recovery = $this->exec_recovery($requete);
        return $requete_recovery;
    }

    // Fiche Film
    public function ficheFilm($id){ //DATE_FORMAT(SEC_TO_TIME(duree*60), '%H:%i') AS duree
        $requete = "
            SELECT titre, affiche_film, note, synopsis, date_sortie, duree, CONCAT(nom, ' ',prenom) AS personne, film.id_film AS id
            FROM film
            INNER JOIN realisateur
            ON film.id_realisateur = realisateur.id_realisateur
            INNER JOIN personne
            ON realisateur.id_personne = personne.id_personne
            WHERE film.id_film = $id";
        
        $requete_recovery = $this->exec_recovery($requete);
        return $requete_recovery;
    }

    // Genre Film
    public function genreFilm($id){
        $requete = "
            SELECT genre.genre
            FROM gestion_genre, genre
            WHERE gestion_genre.id_genre = genre.id_genre
            AND gestion_genre.id_film = $id";
        $requete_recovery = $this->exec_recovery($requete);
        return $requete_recovery;
    }



    // Fiche Personne
    public function fichePersonne($id) {
        $requete = "
            SELECT CONCAT(nom, ' ',prenom) AS personne, sexe,  date_naissance, profil, personne.id_personne AS id
            FROM personne
            WHERE personne.id_personne = $id";
        $requete_recovery = $this->exec_recovery($requete);
        return $requete_recovery;
    }

    // Filmographie en tant que réalisateur
    public function listFilmsPerRealisateur($id){
        $requete = "
            SELECT titre, affiche_film, film.id_film AS id
            FROM film
            INNER JOIN realisateur
            ON film.id_realisateur = realisateur.id_realisateur
            INNER JOIN personne
            ON realisateur.id_personne = personne.id_personne
            WHERE realisateur.id_personne = $id";
        $requete_recovery = $this->exec_recovery($requete);
        return $requete_recovery;
    }

    // Filmographie en tant qu'acteur
    public function listFilmsPerActeur($id){
        $requete = "
            SELECT titre, affiche_film, film.id_film AS id
            FROM film
            INNER JOIN contrat
            ON film.id_film = contrat.id_film
            INNER JOIN acteur
            ON contrat.id_acteur = acteur.id_acteur
            INNER JOIN personne
            ON acteur.id_personne = personne.id_personne
            WHERE personne.id_personne = $id";
        $requete_recovery = $this->exec_recovery($requete);
        return $requete_recovery;
    }





    public function modifFilm_requete($id){
        if(isset($_POST['submit']))
        {
            $id_realisateur = filter_input(INPUT_POST, "personne", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $titre          = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $date_sortie    = filter_input(INPUT_POST, "date_sortie", FILTER_DEFAULT);
            $duree          = filter_input(INPUT_POST, "duree", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $synopsis       = filter_input(INPUT_POST, "synopsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $affiche_film   = filter_input(INPUT_POST, "affiche_film", FILTER_SANITIZE_URL);
            
            if(filter_var($id_realisateur, FILTER_VALIDATE_INT)){
                $requeteRealisateur = "
                            UPDATE film, realisateur
                            SET film.id_realisateur = realisateur.id_realisateur
                            WHERE realisateur.id_personne = $id_realisateur
                            AND film.id_film = $id
                            ";
                
                $this->exec_modif($requeteRealisateur);
            }
            
            if(filter_var($duree, FILTER_VALIDATE_INT)){
                $requete = "
                            UPDATE film
                            SET titre = '$titre', 
                            date_sortie = '$date_sortie',
                            duree = '$duree',
                            synopsis = '$synopsis',
                            affiche_film = '$affiche_film'
                            WHERE film.id_film = $id
                            ";

                $this->exec_modif($requete);
            }

            $this->viewFicheFilm($id);
        }

        if(isset($_POST['delete'])){
            $requete_delete = "
                                DELETE FROM 'film'
                                WHERE film.id_film = $id
                                ";

            $this->exec_modif($requete_delete);
            $this->viewHome();
        }
    }

    public function modifPersonne_requete($id){
        if(isset($_POST['submit']))
        {
            $nom            = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prenom         = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sexe           = filter_input(INPUT_POST, "sexe", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $date_naissance = filter_input(INPUT_POST, "date_naissance", FILTER_DEFAULT);
            $profil         = filter_input(INPUT_POST, "profil", FILTER_SANITIZE_URL);
            
            $requete = "
                        UPDATE personne
                        SET nom = '$nom', 
                        prenom = '$prenom',
                        sexe = '$sexe',
                        date_naissance = '$date_naissance',
                        profil = '$profil'
                        WHERE personne.id_personne = $id
                        ";
            $this->exec_modif($requete);

            $this->viewFichePersonne($id);
        }

        // if(isset($_POST['delete'])){
        //     $requete_delete = "
        //                         DELETE FROM 'film'
        //                         WHERE film.id_film = $id
        //                         ";

        //     $this->exec_modif($requete_delete);
        //     $this->viewHome();
        // }
    }

    public function addPersonne(){
        if(isset($_POST['submit']))
        {
            $nom            = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prenom         = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sexe           = filter_input(INPUT_POST, "sexe", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $date_naissance = filter_input(INPUT_POST, "date_naissance", FILTER_DEFAULT);
            $profil         = filter_input(INPUT_POST, "profil", FILTER_SANITIZE_URL);

            $requete = "
                INSERT INTO personne (nom, prenom, sexe, date_naissance, profil)
                VALUES ('$nom', '$prenom', '$sexe', '$date_naissance', '$profil')
                ";
            $this->exec_modif($requete);

            $this->viewAdd();
        }
    }








    public function addFilm(){
        if(isset($_POST['submit']))
        {
            $id_personne    = filter_input(INPUT_POST, "personne", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $titre          = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $date_sortie    = filter_input(INPUT_POST, "date_sortie", FILTER_DEFAULT);
            $duree          = filter_input(INPUT_POST, "duree", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $synopsis       = filter_input(INPUT_POST, "synopsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $affiche_film   = filter_input(INPUT_POST, "affiche_film", FILTER_SANITIZE_URL);
            $id_genre       = filter_input(INPUT_POST, "genre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            if(filter_var($id_personne, FILTER_VALIDATE_INT) && filter_var($duree, FILTER_VALIDATE_INT) && filter_var($id_genre, FILTER_VALIDATE_INT)){
                $pdo = Connect::seConnecter();
                $requeteRealisateur1 = "
                        INSERT INTO realisateur (id_personne)
                        SELECT '$id_personne'
                        WHERE NOT EXISTS (SELECT * FROM realisateur WHERE realisateur.id_personne = $id_personne);
                        ";
                $this->exec_modif($requeteRealisateur1);
                    
                $realisateurID =  $pdo->lastInsertId();
                var_dump($realisateurID);

                $requete = "
                        INSERT INTO film (id_realisateur, titre, date_sortie, duree, synopsis, affiche_film)
                        SELECT ($realisateurID, '$titre', '$date_sortie', '$duree', '$synopsis', '$affiche_film')
                        WHERE NOT EXISTS (SELECT * FROM film WHERE film.titre = $titre);
                        ";
                              
                $requeteGenre = "
                        INSERT INTO gestion_genre (id_film, id_genre)
                        VALUES ((SELECT id_film FROM film WHERE film.titre = '$titre'), $id_genre)
                        ";
                            
                
                $this->exec_modif($requete);
                // $this->exec_modif($requeteGenre);

            }
            $this->viewAdd();



            
        }
    }
/* --------------------------------------------------------------------------------------------- */



/* ----------------------------------------  --------------------------------------------------- */

    // Fonction qui retourne toutes les réponses de requête utiles pour la vue HOME
    public function viewHome() {
        // Liste des films 
        $requete_listFilms                  = $this->listFilms("defaut", "defaut");
        // Liste des Réalisateurs
        $requete_listRealisateurs           = $this->listRealisateurs("defaut");
        // Liste des Acteurs
        $requete_listActeurs                = $this->listActeurs();
        require "view/viewHome.php";
    }


    // Fonction qui retourne toutes les réponses de requête utiles pour la vue FILM
    public function viewFilm($genre) {
        // Liste des films selon la base de données SQL
        $requete_listFilms                  = $this->listFilms("defaut", "defaut");
        // Liste des films selon la note
        $requete_listFilmsPerNote           = $this->listFilms("note", "defaut");
        // Liste des films selon la date de sortie
        $requete_listFilmsPerDateSortie     = $this->listFilms("date_sortie", "defaut");
        // Liste des films selon la durée
        $requete_listFilmsPerDuree          = $this->listFilms("duree", "defaut");
        // Liste des films selon la durée
        $requete_listFilmsPerGenre          = $this->listFilms("duree", $genre);
        // Liste de tous les genres de film
        $requete_listGenre                  = $this->listGenre();
        require "view/viewFilm.php";
    }


    // Fonction qui retourne toutes les réponses de requête utiles pour la vue REALISATEUR
    public function viewRealisateur() {
        // Liste des réalisateurs selon la base de données SQL
        $requete_listRealisateurs           = $this->listRealisateurs("defaut");
        // Liste des réalisateurs selon le nombre de film
        $requete_listRealisateursPerNbr     = $this->listRealisateurs("COUNT(id_film)");
        // Liste des réalisateurs selon la note
        $requete_listRealisateursPerNote    = $this->listRealisateurs("AVG(note)");
        require "view/viewRealisateur.php";
    }

    // Fonction qui retourne toutes les réponses de requête utiles pour la vue ACTEUR
    public function viewActeur(){
        // Liste des Acteurs
        $requete_listActeurs                = $this->listActeurs();
        require "view/viewActeur.php";
    }

    public function viewAdd(){
        require "view/viewAdd.php";
    }

    public function viewAddPersonne(){
        require "view/viewAddPersonne.php";
    }

    public function viewAddFilm(){
        // Liste des realisateurs contenu dans la base de données pour le choix du réalisateur lors de la modification
        $requete_listPersonne           = $this->listPersonne();
        // 
        $requete_listGenre              = $this->listGenre();
        require "view/viewAddFilm.php";
    }


    // Fonction qui retourne toutes les réponses de requête utiles pour l'affichage de la Fiche d'un Film
    public function viewFicheFilm($id) {
        // Ensemble des informations du film
        $requete_ficheFilm = $this->ficheFilm($id);
        // Liste des genres selon l'id du film
        $requete_genre_film = $this->genreFilm($id);
        // Liste des Acteurs et leur role dans le film selon l'id du film
        $requete_listActeursThisFilm = $this->listActeursAndRoleperFilm($id);
        require "view/ficheFilm.php";
    }


    // Fonction qui retourne toutes les réponses de requête utiles pour l'affichage de la Fiche d'une Personne
    public function viewFichePersonne($id) {
        // Ensemble des informations d'une Personne selon son id
        $requete_fichePersonne = $this->fichePersonne($id);
        // Liste des films réalisés par un réalisateur selon son id
        $requete_listFilmsPerRealisateur = $this->listFilmsPerRealisateur($id);
        // Liste des films dont un acteur est présent selon son id
        $requete_listFilmsPerActeur = $this->listFilmsPerActeur($id);
        require "view/fichePersonne.php";
    }
    

    // Fonction qui retourne toutes les réponses de requête utiles pour l'affichage de la Modification d'un film
    public function viewModifFilm($id){
        // Liste des realisateurs contenu dans la base de données pour le choix du réalisateur lors de la modification
        $requete_listRealisateurs = $this->listRealisateurs("defaut");
        // Ensemble des données d'un film selon l'id
        $requete_ficheFilm = $this->ficheFilm($id);
        require "view/filmModif.php";
    }


    // Fonction qui retourne toutes les réponses de requête utiles pour l'affichage de la Modification d'une Personne
    public function viewModifPersonne($id){
        // Ensemble des informations d'une Personne selon son id
        $requete_fichePersonne = $this->fichePersonne($id);
        require "view/personneModif.php";
    }


    public function ModifFilm($id){
        $this->modifFilm_requete($id);
    }

    public function ModifPersonne($id){
        $this->modifPersonne_requete($id);
    }
}