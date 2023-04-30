<?php
$bdd = new PDO('mysql:host=localhost;dbname=tweeter', 'root', '');


$query = $bdd->query('SELECT * FROM post ORDER BY post_datepubli DESC LIMIT 1');
$last = $query->fetch(PDO::FETCH_ASSOC);



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



if(isset($_POST['tweet_titre'], $_POST['tweet_contenu']))
{
    if(!empty($_POST['tweet_titre']) AND !empty($_POST['tweet_contenu']))
    {
        $tweet_titre = htmlspecialchars($_POST['tweet_titre']);
        $tweet_contenu = htmlspecialchars($_POST['tweet_contenu']);
        $tweet_tag = htmlspecialchars($_POST['tag1']);
        

        $ins = $bdd->prepare('INSERT INTO post(post_titre, post_contenu, post_datepubli, post_tag) VALUES(?,?,NOW(),?)');
        $ins->execute(array($tweet_titre, $tweet_contenu, $tweet_tag));

        $message = 'Votre article a bien été posté.';
        header('Location: accueil.php');
    }
    else
    {
        $message = "Veuillez remplir tous les champs !";
    }
}

?>



<DOCTYPE html>
<html>


<head>
    <title> Accueil </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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



    <input type="button" class="btn btn-primary" name="suppr" value="Poster" data-bs-toggle="modal" data-bs-target="#exampleModal">

<!-- ----------------------------------------------------------------------------------------------------------------------------------  -->


    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog" id="modal_dialog">

            <div class="modal-content" id="modal_content">

                <div class="modal-header" id="modal_header">
                    <h2> Poster un article </h2>
                </div>

                    <div class="modal-body" id="modal_body">
                        <form method="POST">
                            <input type="text" name="tweet_titre" placeholder="Titre" class="titre_input">
                            <textarea name="tweet_contenu" placeholder="Contenu du tweet" maxlength=500 class="contenu_input"></textarea>
                            <div id="tag">
                                <label for="choix">Choisissez un Tag :</label>
                                    <select id="choix" name="tag1">
                                        <option name="Vert" value="Humour">Humour</option>
                                        <option value="Publicité">Publicité</option>
                                        <option value="Art">Art</option>
                                        <option value="Clash">Clash</option>
                                        <option value="Gaming">Gaming</option>
                                        <option value="Digital">Digital</option>
                                        <option value="News">News</option>
                                        <option value="Nouveautés">Nouveautés</option>
                                        <option value="Musique">Musique</option>
                                        <option value="Autre">Autre</option>
                                    </select>
                            </div>
                            
                            <input type="submit" value="Envoyer l'article"/>
                            <?php if(isset($message)) {echo $message;} ?>
                        </form>
                        
                    </div>

                </div>
            
            </div>
        
        </div>
        
    </div>

<!-- modal -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>





<!-- scroll -->
    <script>
        function deroule() {
        document.getElementById('sidebar').classList.toggle("open-sidebar");
        }
    </script>




</body>


</html>