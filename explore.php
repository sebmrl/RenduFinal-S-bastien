<?php
$bdd = new PDO('mysql:host=localhost;dbname=tweeter', 'root', '');

$post = $bdd->query('SELECT * FROM post ORDER BY post_datepubli DESC');

if(isset($_GET['barre']) AND !empty($_GET['barre']))
{
    $barre = htmlspecialchars($_GET['barre']);


    $post = $bdd->query('SELECT * FROM post WHERE post_titre LIKE "%'.$barre.'%" ORDER BY post_datepubli DESC');
    if($post->rowCount() == 0)
    {
        $post = $bdd->query('SELECT * FROM post WHERE CONCAT(post_titre, post_contenu) LIKE "%'.$barre.'%" ORDER BY post_datepubli DESC');
    }
}

?>




<DOCTYPE html>
<html>


    <head>
        <title> Accueil </title>
        <met charset="utf-8"></met>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    </head>



    <body>


        <div class="home">

            <header id="sidebar">
                <div class="hamburger" onclick="deroule()">
                    <div class="top"></div>
                    <div class="mid"></div>
                    <div class="bottom"></div>
                </div>

                <h1 class="logo">
                        <img src="Images/logosite.png" alt="Logo">
                        <span class="nav-item"> ChitChat </span>
                </h1>

                <nav>
                    <ul>
                        <li>
                            <a href="accueil.php">
                                <i class="fas fa-home"> </i>
                                <span class="nav-item"> Accueil </span>
                            </a>
                        </li>
                        <li>
                            <a href="voirpost.php">
                            <i class="fas fa-tasks"> </i>
                            <span class="nav-item"> Voir mes posts </span>
                            </a>
                        </li>
                        <li>
                            <a href="explore.php">
                                <i class="fas fa-search"> </i>
                                <span class="nav-item"> Rechercher </span>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="fas fa-user"> </i>
                                <span class="nav-item"> Profil </span>
                            </a>
                        </li>
                    </ul>
                </nav>

            </header>

        </div>



        <main>
            
            <form class="searchbar" method="GET">
                <input class="barre" type="search" name="barre" placeholder="Recherche...">
                <input class="recherche" type="submit" value="Valider">
            </form>

            <div class="contenu">

                <ul class="list_post">

                    <?php while($a = $post->fetch()) { ?>
                        <li class="post">
                            <h2 class="post_titre"> <?= $a['post_titre'] ?> </h2>
                            <p class="post_contenu"> <?= $a['post_contenu'] ?> </p>
                        </li>
                        <?php } ?>
                        <?php if($post->rowCount() == 0) { ?>
                            <p class="nopost"> Il n'y a aucun post pour le moment... </p>
                    <?php } ?>

                </ul>

            </div>

        </main>


        <script>
            function deroule() {
            document.getElementById('sidebar').classList.toggle("open-sidebar");
            }
        </script>


    </body>

</html>