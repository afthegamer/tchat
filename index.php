<?php
/** Chargement des librairies et dépendances */
require('config/config.php');
require('lib/bdd.php');
require('models/message.php');

try
{
    //Connexion
    $dbh = dbConnexion();
    
    //On récupère les messages
    $messages = messageFindAll($dbh);
    
    include('views/index.phtml');
}
catch (PDOException $e) {
    echo "Erreur !: " . $e->getMessage() . "<br/>";
}