# Projet Cinema
_Il s'agit du 2eme projet en PHP chez ELAN Formation_

![forthebadge](https://forthebadge.com/images/badges/made-with-php.svg)
![forthebadge](https://forthebadge.com/images/badges/uses-html.svg)
![forthebadge](https://forthebadge.com/images/badges/uses-css.svg)
![forthebadge](https://forthebadge.com/images/badges/uses-js.svg)
![forthebadge](https://forthebadge.com/images/badges/uses-git.svg)


Le projet CINEMA est un site WEB responsive qui liste les films avec leur réalisateur et leurs acteurs, avec la possiblité d'accéder aux fiches infos, de pouvoir les modifier ou d'en ajouter.


<img width="75%" alt="image" src="https://github.com/Mzk-Ali/Cinema_project_AM/assets/161448982/9f3c6f62-fc2f-464b-bd9b-e93fa139867d">
<img width="25%" alt="image" src="https://github.com/Mzk-Ali/Project_1_CINEMA_Ali_M/assets/161448982/47a7f3c4-1994-4f26-a4ce-effafc1d124e">


## Pour commencer


### Pré-requis

Pour commencer le projet, il est requis d'avoir

- Editeur de code (VS Code)
- Environnement de développement (Laragon)

### Installation

Tout d'abord, télécharger le projet dans le dossier C:\laragon\www

Ensuite, il faut mettre en place la base de données :
- Vous trouverez le fichier SQL dans le dossier Model
- Ouvrir le logiciel laragon, cliquer sur Démarer puis sur Base de données.
- Charger le fichier SQL puis l'éxécuter

Votre base de donnée est mise en place

## Démarrage

Pour lancer votre projet :
- Sur votre navigateur web, aller sur l'url suivant : http://localhost/cinema_project_AM/index.php?action=home_view

## Construction du projet

### Modélisation Conceptuelle de Donnée

<img width="500" alt="image" src="https://github.com/Mzk-Ali/Project_1_CINEMA_Ali_M/assets/161448982/e2c039aa-df2a-4814-b1e7-d836cad8af81">
<img width="500" alt="image" src="https://github.com/Mzk-Ali/Project_1_CINEMA_Ali_M/assets/161448982/8a479f13-2979-4e9e-b664-4bc300080b9f">


### Design : MockUp

Utilisation de figma pour la création de mockup.

![image](https://github.com/Mzk-Ali/Project_1_CINEMA_Ali_M/assets/161448982/a7c8898a-2e17-437e-aee2-8a8799e3c337)

### Arborescence du projet

Pour le Design Pattern du projet, nous avons utilisé l'architecture MVC (Modèle-Vue-Controller) permettant l'agencement du code.

- Controller
  - CinemaController.php
  - AddCinemaController.php
  - ModifCinemaController.php
- Model
  - Connect.php
- Public
  - CSS
    - style.css
  - JS
    - main.js
- View
  - _Ensemble des vues du site_
- index.php


## Fabriqué avec

* [Looping](https://www.looping-mcd.fr/) - Modelisation Conceptuelle de Données
* [Figma](https://www.figma.com/fr-fr/) - Outil de design à interface collaborative

* [RemixIcon](https://remixicon.com/) - Open-Source Icon Library (front-end)
* [VS Code](https://code.visualstudio.com/) - Editeur de textes
* [Laragon](https://laragon.org/index.html) - Environnement de développement


## Versions

**Dernière version stable**

## Auteurs

* **Ali MARZAK** _alias_ [@Ali-Mzk](https://github.com/Mzk-Ali)

## License

Ce projet n'est pas sous license.
