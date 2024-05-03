<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" integrity="sha512-OQDNdI5rpnZ0BRhhJc+btbbtnxaj+LdQFeh0V9/igiEPDiWE2fG+ZsXl0JEH+bjXKPJ3zcXqNyP4/F/NegVdZg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="public/css/style.css">
    <title><?= $titre ?></title>
</head>
<body>
    <header class="header">
        <nav class="nav_container">
            <div class="nav_home">
                <a href="index.php?action=home_view">
                    <span class="nav_top">HOME</span>
                    <div class="nav_bottom">
                        <i class="ri-home-3-fill"></i>
                    </div>
                </a>
            </div>
            <div class="nav_menu">
                <ul class="nav_menu_list">
                    <li class="nav_item">
                        <a href="index.php?action=film_view&genre=Action">
                            <span class="nav_top">FILM</span>
                            <div class="nav_bottom">
                                <i class="ri-movie-2-fill"></i>
                            </div>
                        </a>
                    </li>
                    <li class="nav_item">
                        <a href="index.php?action=realisateur_view">
                            <span class="nav_top">REALISATEUR</span>
                            <div class="nav_bottom">
                                <i class="ri-movie-line"></i>
                            </div>
                        </a>
                    </li>
                    <li class="nav_item">
                        <a href="index.php?action=acteur_view">
                            <span class="nav_top">ACTEUR</span>
                            <div class="nav_bottom">
                                <i class="fa-solid fa-masks-theater"></i>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="nav_add">
                <a href="index.php?action=add_view">
                    <i class="ri-user-settings-fill"></i>
                </a>
            </div>
        </nav>

    </header>
    <main>
<!-- 
        <div id="dark_mode" class="mode_sun">
            <div class="img_sun"><i class="ri-sun-fill"></i></div>
            <div class="img_moon"><i class="ri-contrast-2-fill"></i></div>
            <div class="circle_mode"></div>
        </div> -->

        <h1><?= $titre ?></h1>
        <?= $contenu ?>



        <?php if(isset($_SESSION["alert_message"])) { ?>
        <div class="container_alert <?php 
            if($_SESSION["alert_type"] == "success"){echo "alert_validate";}
            elseif($_SESSION["alert_type"] == "warning"){echo "alert_warning";}
            elseif($_SESSION["alert_type"] == "error"){echo "alert_error";}
            else{echo "";}
            ?> none">
            <span class="logo_alert">
                <i class="ri-error-warning-fill"></i>
            </span>
            <span class="message_alert">
                <?php
                
                    echo $_SESSION["alert_message"];
                    unset($_SESSION["alert_message"]);
                ?>
            </span>
            <div class="close_btn_alert">
                <span class="close_btn">
                    <i class="ri-close-circle-fill"></i>
                </span>
            </div>
        </div>
        <?php  } ?>

    </main>

    <footer>
        <div class="container_footer">
            <div class="title_footer">
                <a href=""><p>WIKI</p>
                <p class="title_cine">CINE</p></a>
            </div>
            <div class="main_footer">
                <a href=""><p>Mentions Légales</p></a>
                <a href=""><p>Gestion des cookies</p></a>
                <a href=""><p>Plan du Site</p></a>
            </div>
            <div class="logo_footer">
                <a href=""><i class="ri-facebook-circle-fill"></i></a>
                <a href=""><i class="ri-instagram-fill"></i></a>
                <a href=""><i class="ri-twitter-x-fill"></i></a>
            </div>
        </div>
    </footer>
    
</body>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="public/js/main.js"></script>
</html>
