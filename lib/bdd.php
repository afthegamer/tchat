<?php

/** Fonction qui retourne un objet de type PDO 
 * @param void
 * 
 * @return PDO objet de connexion PDO
*/
function dbConnexion() : PDO
{
    $dbh = new PDO(DB_DSN,DB_USER,DB_PASS);
    //On dit à PDO de nous envoyer une exception s'il n'arrive pas à se connecter ou s'il rencontre une erreur
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $dbh;
}



/** Execute une requête SQL et retourne un jeu d'enregistrement complet
 * @param PDO $dbh un objet PDO de connexion
 * @param string $sql la requête a executé
 * @param array $params tableau contenant les éléments à binder dans la requête
 * 
 * @return array jeu d'enregistrement
 */
function dbSelectAll(PDO $dbh , string $sql, array $params = []) : array
{
    /* 1. Preparer une requête */
    $sth = $dbh->prepare($sql);
  
    /* 2. Executer la requête */
    $sth->execute($params);
    
    /* 3. On récupère le jeu d'enregistrement */
    return $sth->fetchAll(PDO::FETCH_ASSOC);
}

/** Execute une requête SQL et retourne une ligne du jeu d'enregistrement
 * @param PDO $dbh un objet PDO de connexion
 * @param string $sql la requête a executé
 * @param array $params tableau contenant les éléments à binder dans la requête
 * 
 * @return array jeu d'enregistrement
 */
function dbSelectOne(PDO $dbh , string $sql, array $params = []) : array
{
    /* 1. Preparer une requête */
    $sth = $dbh->prepare($sql);
  
    /* 2. Executer la requête */
    $sth->execute($params);
    
    /* 3. On récupère le jeu d'enregistrement */
    return $sth->fetch(PDO::FETCH_ASSOC);
}


/** Execute une requête SQL type INSERT ou UPDATE
 * @param PDO $dbh un objet PDO de connexion
 * @param string $sql la requête a executé
 * @param array $params tableau contenant les éléments à binder dans la requête
 * 
 * @return array jeu d'enregistrement
 */
function dbExecute(PDO $dbh , string $sql, array $params = []) : int
{
    /* 1. Preparer une requête */
    $sth = $dbh->prepare($sql);
  
    /* 2. Executer la requête */
    if($sth->execute($params))
        return $dbh->lastInsertId();
    else
        return false;
}

/** Fonction qui permet rapidement d'afficher tous les noms des colonnes d'une table
 * 
 * @param string $table le nom de la table
 * @param PDO $dbh l'objet PDO de connexion à la base de données
 * 
 * @return string une chaine de caractère du nom des colonne de $table séparés par des virgules
 */
function getColumnName(PDO $dbh, string $table) : string
{
    $q = $dbh->prepare("DESCRIBE ".$table);
    $q->execute();
    $table_fields = $q->fetchAll(PDO::FETCH_COLUMN);
    $stringFields = '';
    foreach($table_fields as $field)
        $stringFields .= $field.',';

    return $stringFields;
}
