<?php

/** Ce fichier va faire parti de notre API (Application Programming Interface ou Interface de programmation)
 * https://fr.wikipedia.org/wiki/Interface_de_programmation
 * 
 * Une API est un ensemble de programmes sur un serveur qui permet de délivrer de la données
 * sous une forme normalisée, sécurisée ou non.
 * 
 * En gros nos fichiers PHP sur le serveur ne sont plus là pour générer du HTML et donner une réponse à une requête HTTP classique
 * mais ils sont là pour fournir de la donnée à un autre programme qui doit simplement exploiter ces données.(pour un affichage par exemple)
 * 
 * Dans notre cas notre API va fournir des données sous la forme de données d'échanges standardisé en JSON
 * En gros notre API a pour vocation à aller chercher des données dans la base puis à fournir ces données sous la forme de chaine JSON
 * 
 * Ainsi nous allons pouvoir interoger cette API en Javascript pour que JS récupère des données et les affiches dans une page.
 * Cela va nous permettre de créer une application WEB sans recharger la page complètement. Seule les zones nécessaire seront rechargées avec les données reçues de l'API
 * 
 */ 

/** Chargement des librairies et dépendances */
require('../config/config.php');
require('../lib/bdd.php');
require('../models/message.php');

try
{
    // Notre API a besoin de se connecter à la base
    $dbh = dbConnexion();
    
    
    // Notre API va fournir une réponse
    $response = [];
    
    /* En fonction de la demande notre API va avoir plusieurs comportement*/
    if(array_key_exists('request',$_GET)){
        switch($_GET['request']) {
            case 'list' :
                $response = messageFindAll($dbh);
                break;
            case 'listlast' :
                if(array_key_exists('date',$_GET)) {
                    
                    $date = new DateTime($_GET['date']);
                    
                    //var_dump($date->format('d/m/Y H:i'));exit();
                    $response = messageFindLast($dbh,$date);
                }
                break;
             case 'save' :
                if(array_key_exists('message',$_POST) && $_POST['message'] != '')
                {
                    //on enregistre le message
                    $response = ['lastInsert'=>messageInsert($dbh,$_POST['user'], $_POST['message'])];
                }
                break;
        }
    }
    
    
    // On retourne la réponse
    header('Content-type: application/json');
    echo json_encode($response);
        
}
catch (PDOException $e) {
    echo "Erreur !: " . $e->getMessage() . "<br/>";
}