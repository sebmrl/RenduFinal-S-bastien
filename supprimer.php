<?php
$bdd = new PDO('mysql:host=localhost;dbname=tweeter', 'root', '');



if(isset($_GET['id']) AND !empty($_GET['id']))
{
    $suppr_id = htmlspecialchars($_GET['id']);

    $suppr = $bdd->prepare('DELETE FROM post WHERE post_id= ?');
    $suppr->execute(array($suppr_id));

    header('Location: voirpost.php');
}

?>