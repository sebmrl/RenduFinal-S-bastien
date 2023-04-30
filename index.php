<?php

$bdd = new PDO('mysql:host=localhost;dbname=tweeter', 'root', '');


if(isset($_POST['forminscription']))
{
    $membre_pseudo = htmlspecialchars($_POST['pseudo']);
    $membre_mail = htmlspecialchars($_POST['mail']);
    $membre_conf_mail = htmlspecialchars($_POST['conf_mail']);
    $membre_mdp = sha1($_POST['mdp']);
    $membre_conf_mdp = sha1($_POST['conf_mdp']);
    $pseudolenght = strlen($membre_pseudo);

    if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['conf_mail']) AND !empty($_POST['mdp']) AND !empty($_POST['conf_mdp']))
    {
        if($pseudolenght <= 255)
        {
            if($membre_mail == $membre_conf_mail)
            {
                if(filter_var($membre_mail, FILTER_VALIDATE_EMAIL))
                {
                    $reqmail = $bdd->prepare("SELECT * FROM membres WHERE membre_mail = ?");
                    $reqmail->execute(array($membre_mail));
                    $mailexist = $reqmail->rowCount();
                    if($mailexist == 0)
                    {
                        if($membre_mdp == $membre_conf_mdp)
                        {
                            $insertmbr = $bdd->prepare("INSERT INTO membres(membre_pseudo, membre_mail, membre_mdp) VALUES(?,?,?)");
                            $insertmbr->execute(array($membre_pseudo, $membre_mail, $membre_mdp));
                            $erreur = "Votre compte a bien été créé !";
                            header('Location: accueil.php');
                            exit;
                        }
                        else
                        {
                            $erreur = "Vos mos de passe ne correspondent pas !"; 
                        }
                    }
                    else
                    {
                        $erreur = "Adresse mail déjà utilisée !";
                    }
                }
                else
                {
                    $erreur = "Votre adresse mail n'est pas valide !";
                }
            }
            else
            {
                $erreur = "Vos adresses mail ne correspondent pas !";
            }
        }
        else
        {
            $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
            }
    }
    
    else
    {
        $erreur = 'Tous les champs doivent être complétés !';
    }
}

?>


<html>
    <head>
        <title> TUTO PHP </title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    </head>

    <body>
        <div>
            <br/>
            <h2> Inscription</h2>
            <br /><br/><br/>
            <form method="POST" action ="" enctype="multipart/form-data">
                <div class="row">

                    <div class="col">
                        <label for="pseudo"> Pseudo : </label>
                        <input type="texte" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo[''])) {echo $pseudo;} ?>" />
                    </div>
                    
                    <div class="row">
                        
                        <div class="col-6">
                            <label for="mail"> Mail : </label>
                            <input type="email" placeholder="Votre mail" id="mail" name="mail" value="<?php if(isset($pseudo[''])) {echo $mail;} ?>" />
                        </div>

                        <div class="col-6">
                            <label for="conf_mail"> Confirmation du mail : </label>
                            <input type="email" placeholder="Confirmez votre mail" id="conf_mail" name="conf_mail" value="<?php if(isset($pseudo[''])) {echo $conf_mail;} ?>" />
                        </div>

                    </div>

                        
                    <div class="row">
                        <div class="col-6">
                            <label for="mdp"> Mot de passe : </label>
                            <input type="password" placeholder="Mot de passe" id="mdp" name="mdp" />
                        </div>

                        <div class="col">
                            <label for="conf_mdp"> Confirmation du mot de passe : </label>
                            <input type="password" placeholder="Confirmez votre mdp" id="conf_mdp" name="conf_mdp"/>
                        </div>

                    </div>

                    <div class="col">
                        <br/>
                        <input type="submit" name="forminscription" value="Je m'inscris" />
                    </div>

                </div>
                <br/>

                
            </form>
            <?php
                if (isset($erreur))
                {
                    echo '<font color="white">' .$erreur."</font>";
                }
            ?>

        </div>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>


    </body>


</html>